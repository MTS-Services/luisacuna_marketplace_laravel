<?php

use App\Actions\Order\ResolveOrderAction;
use App\Enums\DisputeStatus;
use App\Enums\OrderStatus;
use App\Enums\ResolutionType;
use App\Models\Admin;
use App\Models\Dispute;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->buyer = User::factory()->create();
    $this->seller = User::factory()->create();
    $this->product = Product::factory()->create(['user_id' => $this->seller->id]);
    $this->admin = Admin::factory()->create();
    $this->resolveAction = app(ResolveOrderAction::class);
});

test('admin can resolve in favor of buyer with full refund', function () {
    $order = Order::factory()->escalated()->create([
        'user_id' => $this->buyer->id,
        'source_id' => $this->product->id,
    ]);

    Dispute::create([
        'order_id' => $order->id,
        'buyer_id' => $this->buyer->id,
        'vendor_id' => $this->seller->id,
        'status' => DisputeStatus::ESCALATED,
        'description' => 'Test dispute',
    ]);

    $result = $this->resolveAction->execute($order, $this->admin, [
        'resolution_type' => 'buyer_wins',
        'notes' => 'Buyer provided sufficient evidence.',
    ]);

    expect($result->status)->toBe(OrderStatus::RESOLVED)
        ->and($result->resolution_type)->toBe(ResolutionType::BuyerWins)
        ->and($result->resolved_by)->toBe($this->admin->id)
        ->and($result->resolved_at)->not->toBeNull();

    $this->assertDatabaseHas('disputes', [
        'order_id' => $order->id,
        'status' => DisputeStatus::RESOLVED_BUYER_WINS->value,
    ]);
});

test('admin can resolve in favor of seller', function () {
    $order = Order::factory()->escalated()->create([
        'user_id' => $this->buyer->id,
        'source_id' => $this->product->id,
    ]);

    Dispute::create([
        'order_id' => $order->id,
        'buyer_id' => $this->buyer->id,
        'vendor_id' => $this->seller->id,
        'status' => DisputeStatus::ESCALATED,
        'description' => 'Test dispute',
    ]);

    $result = $this->resolveAction->execute($order, $this->admin, [
        'resolution_type' => 'seller_wins',
        'notes' => 'Seller delivered correctly.',
    ]);

    expect($result->status)->toBe(OrderStatus::RESOLVED)
        ->and($result->resolution_type)->toBe(ResolutionType::SellerWins);

    $this->assertDatabaseHas('disputes', [
        'order_id' => $order->id,
        'status' => DisputeStatus::RESOLVED_SELLER_WINS->value,
    ]);
});

test('admin can apply partial split', function () {
    $order = Order::factory()->escalated()->create([
        'user_id' => $this->buyer->id,
        'source_id' => $this->product->id,
        'default_grand_total' => 100.00,
        'grand_total' => 100.00,
    ]);

    Dispute::create([
        'order_id' => $order->id,
        'buyer_id' => $this->buyer->id,
        'vendor_id' => $this->seller->id,
        'status' => DisputeStatus::ESCALATED,
        'description' => 'Test dispute',
    ]);

    $result = $this->resolveAction->execute($order, $this->admin, [
        'resolution_type' => 'partial_split',
        'buyer_amount' => 60.00,
        'seller_amount' => 40.00,
        'notes' => 'Partial fault on both sides.',
    ]);

    expect($result->status)->toBe(OrderStatus::RESOLVED)
        ->and($result->resolution_type)->toBe(ResolutionType::PartialSplit)
        ->and((float) $result->resolution_buyer_amount)->toBe(60.00)
        ->and((float) $result->resolution_seller_amount)->toBe(40.00);
});

test('partial split amounts must equal escrow total', function () {
    $order = Order::factory()->escalated()->create([
        'user_id' => $this->buyer->id,
        'source_id' => $this->product->id,
        'default_grand_total' => 100.00,
        'grand_total' => 100.00,
    ]);

    $this->resolveAction->execute($order, $this->admin, [
        'resolution_type' => 'partial_split',
        'buyer_amount' => 60.00,
        'seller_amount' => 50.00,
    ]);
})->throws(\InvalidArgumentException::class);

test('admin can apply neutral cancellation', function () {
    $order = Order::factory()->escalated()->create([
        'user_id' => $this->buyer->id,
        'source_id' => $this->product->id,
    ]);

    Dispute::create([
        'order_id' => $order->id,
        'buyer_id' => $this->buyer->id,
        'vendor_id' => $this->seller->id,
        'status' => DisputeStatus::ESCALATED,
        'description' => 'Test dispute',
    ]);

    $result = $this->resolveAction->execute($order, $this->admin, [
        'resolution_type' => 'neutral_cancel',
    ]);

    expect($result->status)->toBe(OrderStatus::RESOLVED)
        ->and($result->resolution_type)->toBe(ResolutionType::NeutralCancel);

    $this->assertDatabaseHas('disputes', [
        'order_id' => $order->id,
        'status' => DisputeStatus::RESOLVED_NEUTRAL->value,
    ]);
});

test('status history records admin resolution', function () {
    $order = Order::factory()->escalated()->create([
        'user_id' => $this->buyer->id,
        'source_id' => $this->product->id,
    ]);

    $this->resolveAction->execute($order, $this->admin, [
        'resolution_type' => 'buyer_wins',
    ]);

    $this->assertDatabaseHas('order_status_histories', [
        'order_id' => $order->id,
        'from_status' => OrderStatus::ESCALATED->value,
        'to_status' => OrderStatus::RESOLVED->value,
        'actor_type' => 'admin',
        'actor_id' => $this->admin->id,
    ]);
});
