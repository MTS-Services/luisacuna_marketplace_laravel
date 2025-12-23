<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\Order;
use App\Models\User;
use App\Enums\PaymentStatus;
use App\Enums\TransactionStatus;
use App\Enums\OrderStatus;
use App\Jobs\SyncPaymentDataJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Cache;

class PaymentObserverTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Order $order;
    protected Payment $payment;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->order = Order::factory()->create([
            'user_id' => $this->user->id,
            'status' => OrderStatus::PENDING_PAYMENT,
        ]);
    }

    /** @test */
    public function it_dispatches_job_when_payment_status_changes_to_completed()
    {
        Queue::fake();

        $payment = Payment::factory()->create([
            'user_id' => $this->user->id,
            'order_id' => $this->order->id,
            'status' => PaymentStatus::PENDING,
        ]);

        $payment->update(['status' => PaymentStatus::COMPLETED]);

        Queue::assertPushed(SyncPaymentDataJob::class, function ($job) use ($payment) {
            return $job->payment->id === $payment->id;
        });
    }

    /** @test */
    public function it_creates_transaction_when_payment_is_completed()
    {
        $payment = Payment::factory()->create([
            'user_id' => $this->user->id,
            'order_id' => $this->order->id,
            'status' => PaymentStatus::PENDING,
        ]);

        $this->assertDatabaseMissing('transactions', [
            'source_id' => $payment->id,
            'source_type' => Payment::class,
        ]);

        // Simulate the job running
        $payment->update(['status' => PaymentStatus::COMPLETED]);

        // Process the job
        SyncPaymentDataJob::dispatch($payment);

        $this->assertDatabaseHas('transactions', [
            'source_id' => $payment->id,
            'source_type' => Payment::class,
            'status' => TransactionStatus::PAID->value,
        ]);
    }

    /** @test */
    public function it_updates_order_status_when_payment_is_completed()
    {
        $payment = Payment::factory()->create([
            'user_id' => $this->user->id,
            'order_id' => $this->order->id,
            'status' => PaymentStatus::PENDING,
        ]);

        $payment->update(['status' => PaymentStatus::COMPLETED]);

        // Process the job
        SyncPaymentDataJob::dispatch($payment);

        $this->order->refresh();
        $this->assertEquals(OrderStatus::PAID, $this->order->status);
    }

    /** @test */
    public function it_prevents_duplicate_transaction_creation()
    {
        $payment = Payment::factory()->create([
            'user_id' => $this->user->id,
            'order_id' => $this->order->id,
            'status' => PaymentStatus::PENDING,
        ]);

        // Create initial transaction
        Transaction::factory()->create([
            'user_id' => $this->user->id,
            'order_id' => $this->order->id,
            'source_id' => $payment->id,
            'source_type' => Payment::class,
            'status' => TransactionStatus::PENDING,
        ]);

        $payment->update(['status' => PaymentStatus::COMPLETED]);

        // Process the job multiple times
        SyncPaymentDataJob::dispatch($payment);
        SyncPaymentDataJob::dispatch($payment);

        // Should only have one transaction
        $transactionCount = Transaction::where('source_id', $payment->id)
            ->where('source_type', Payment::class)
            ->count();

        $this->assertEquals(1, $transactionCount);
    }

    /** @test */
    public function it_uses_cache_lock_for_idempotency()
    {
        Cache::flush();

        $payment = Payment::factory()->create([
            'user_id' => $this->user->id,
            'order_id' => $this->order->id,
            'status' => PaymentStatus::PENDING,
        ]);

        $lockKey = "payment:sync:{$payment->id}:" . PaymentStatus::COMPLETED->value;

        // First update should acquire lock
        $payment->update(['status' => PaymentStatus::COMPLETED]);
        $this->assertTrue(Cache::has($lockKey));

        // Second immediate update should be blocked
        $payment->update(['status' => PaymentStatus::COMPLETED]);

        // Lock should still exist
        $this->assertTrue(Cache::has($lockKey));
    }

    /** @test */
    public function it_does_not_update_terminal_order_status()
    {
        $this->order->update(['status' => OrderStatus::COMPLETED]);

        $payment = Payment::factory()->create([
            'user_id' => $this->user->id,
            'order_id' => $this->order->id,
            'status' => PaymentStatus::PENDING,
        ]);

        $payment->update(['status' => PaymentStatus::REFUNDED]);
        SyncPaymentDataJob::dispatch($payment);

        $this->order->refresh();

        // Order status should remain COMPLETED
        $this->assertEquals(OrderStatus::COMPLETED, $this->order->status);
    }

    /** @test */
    public function it_handles_failed_payment_correctly()
    {
        $payment = Payment::factory()->create([
            'user_id' => $this->user->id,
            'order_id' => $this->order->id,
            'status' => PaymentStatus::PENDING,
        ]);

        $payment->update([
            'status' => PaymentStatus::FAILED,
            'notes' => 'Insufficient funds',
        ]);

        SyncPaymentDataJob::dispatch($payment);

        // Check transaction
        $this->assertDatabaseHas('transactions', [
            'source_id' => $payment->id,
            'source_type' => Payment::class,
            'status' => TransactionStatus::FAILED->value,
        ]);

        // Check order
        $this->order->refresh();
        $this->assertEquals(OrderStatus::FAILED, $this->order->status);
    }

    /** @test */
    public function it_does_not_trigger_on_non_status_changes()
    {
        Queue::fake();

        $payment = Payment::factory()->create([
            'user_id' => $this->user->id,
            'order_id' => $this->order->id,
            'status' => PaymentStatus::COMPLETED,
        ]);

        // Update non-status field
        $payment->update(['notes' => 'Some notes']);

        Queue::assertNotPushed(SyncPaymentDataJob::class);
    }
}
