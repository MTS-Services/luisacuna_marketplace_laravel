<?php

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\OrderStateMachine;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->buyer = User::factory()->create();
    $this->seller = User::factory()->create();
    $this->product = Product::factory()->create(['user_id' => $this->seller->id]);
    $this->stateMachine = app(OrderStateMachine::class);
});

test('buyer can request cancellation from paid status', function () {
    $order = Order::factory()->paid()->create([
        'user_id' => $this->buyer->id,
        'source_id' => $this->product->id,
    ]);

    $result = $this->stateMachine->transition($order, OrderStatus::CANCEL_REQ, $this->buyer);

    expect($result->status)->toBe(OrderStatus::CANCEL_REQ)
        ->and($result->cancel_attempts)->toBe(1)
        ->and($result->cancel_requested_by)->toBe('buyer')
        ->and($result->auto_cancels_at)->not->toBeNull();
});

test('seller can accept cancellation request', function () {
    $order = Order::factory()->cancelRequested()->create([
        'user_id' => $this->buyer->id,
        'source_id' => $this->product->id,
    ]);

    $result = $this->stateMachine->transition($order, OrderStatus::CANCELLED, $this->seller);

    expect($result->status)->toBe(OrderStatus::CANCELLED)
        ->and($result->auto_cancels_at)->toBeNull();
});

test('seller can reject cancellation and order reverts to paid', function () {
    $order = Order::factory()->cancelRequested()->create([
        'user_id' => $this->buyer->id,
        'source_id' => $this->product->id,
        'cancel_attempts' => 1,
    ]);

    $result = $this->stateMachine->transition($order, OrderStatus::PAID, $this->seller);

    expect($result->status)->toBe(OrderStatus::PAID)
        ->and($result->auto_cancels_at)->toBeNull();
});

test('auto-escalation after second cancel rejection', function () {
    $order = Order::factory()->cancelRequested()->create([
        'user_id' => $this->buyer->id,
        'source_id' => $this->product->id,
        'cancel_attempts' => 2,
    ]);

    $result = $this->stateMachine->transition($order, OrderStatus::PAID, $this->seller);

    expect($result->status)->toBe(OrderStatus::ESCALATED)
        ->and($result->escalated_at)->not->toBeNull();
});

test('seller can mark order as delivered', function () {
    $order = Order::factory()->paid()->create([
        'user_id' => $this->buyer->id,
        'source_id' => $this->product->id,
    ]);

    $result = $this->stateMachine->transition($order, OrderStatus::DELIVERED, $this->seller);

    expect($result->status)->toBe(OrderStatus::DELIVERED)
        ->and($result->delivered_at)->not->toBeNull()
        ->and($result->auto_completes_at)->not->toBeNull()
        ->and($result->delivery_attempts)->toBe(1);
});

test('buyer can confirm delivery and complete order', function () {
    $order = Order::factory()->delivered()->create([
        'user_id' => $this->buyer->id,
        'source_id' => $this->product->id,
    ]);

    $result = $this->stateMachine->transition($order, OrderStatus::COMPLETED, $this->buyer);

    expect($result->status)->toBe(OrderStatus::COMPLETED)
        ->and($result->completed_at)->not->toBeNull();
});

test('buyer can open dispute from delivered status', function () {
    $order = Order::factory()->delivered()->create([
        'user_id' => $this->buyer->id,
        'source_id' => $this->product->id,
    ]);

    $result = $this->stateMachine->transition($order, OrderStatus::DISPUTED, $this->buyer, [
        'dispute_reason' => 'Item not as described',
    ]);

    expect($result->status)->toBe(OrderStatus::DISPUTED)
        ->and($result->is_disputed)->toBeTrue()
        ->and($result->auto_completes_at)->toBeNull();

    $this->assertDatabaseHas('disputes', [
        'order_id' => $order->id,
        'buyer_id' => $this->buyer->id,
        'description' => 'Item not as described',
    ]);
});

test('seller can re-deliver during dispute and delivery attempts increment', function () {
    $order = Order::factory()->disputed()->create([
        'user_id' => $this->buyer->id,
        'source_id' => $this->product->id,
        'delivery_attempts' => 1,
    ]);

    $result = $this->stateMachine->transition($order, OrderStatus::DELIVERED, $this->seller);

    expect($result->status)->toBe(OrderStatus::DELIVERED)
        ->and($result->delivery_attempts)->toBe(2)
        ->and($result->is_disputed)->toBeFalse();
});

test('escalation is possible from disputed status', function () {
    $order = Order::factory()->disputed()->create([
        'user_id' => $this->buyer->id,
        'source_id' => $this->product->id,
    ]);

    $result = $this->stateMachine->transition($order, OrderStatus::ESCALATED, $this->buyer);

    expect($result->status)->toBe(OrderStatus::ESCALATED)
        ->and($result->escalated_at)->not->toBeNull();
});

test('status history is recorded on every transition', function () {
    $order = Order::factory()->paid()->create([
        'user_id' => $this->buyer->id,
        'source_id' => $this->product->id,
    ]);

    $this->stateMachine->transition($order, OrderStatus::CANCEL_REQ, $this->buyer);

    $this->assertDatabaseHas('order_status_histories', [
        'order_id' => $order->id,
        'from_status' => OrderStatus::PAID->value,
        'to_status' => OrderStatus::CANCEL_REQ->value,
        'actor_type' => 'buyer',
    ]);
});

test('invalid transition throws exception', function () {
    $order = Order::factory()->completed()->create([
        'user_id' => $this->buyer->id,
        'source_id' => $this->product->id,
    ]);

    $this->stateMachine->transition($order, OrderStatus::CANCELLED, $this->buyer);
})->throws(\InvalidArgumentException::class);
