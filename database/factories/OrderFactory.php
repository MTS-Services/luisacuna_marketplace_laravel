<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $total = fake()->randomFloat(2, 5, 500);

        return [
            'order_id' => strtoupper(Str::random(16)),
            'user_id' => User::factory(),
            'source_id' => Product::factory(),
            'source_type' => Product::class,
            'status' => OrderStatus::INITIALIZED,
            'unit_price' => $total,
            'total_amount' => $total,
            'tax_amount' => 0,
            'grand_total' => $total,
            'default_unit_price' => $total,
            'default_total_amount' => $total,
            'default_tax_amount' => 0,
            'default_grand_total' => $total,
            'default_currency' => 'USD',
            'currency' => 'USD',
            'quantity' => 1,
        ];
    }

    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::PAID,
            'paid_at' => now(),
        ]);
    }

    public function delivered(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::DELIVERED,
            'paid_at' => now()->subDay(),
            'delivered_at' => now(),
            'auto_completes_at' => now()->addHours(72),
            'delivery_attempts' => 1,
        ]);
    }

    public function disputed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::DISPUTED,
            'paid_at' => now()->subDays(2),
            'delivered_at' => now()->subDay(),
            'is_disputed' => true,
        ]);
    }

    public function escalated(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::ESCALATED,
            'paid_at' => now()->subDays(3),
            'delivered_at' => now()->subDays(2),
            'escalated_at' => now(),
            'is_disputed' => true,
        ]);
    }

    public function cancelRequested(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::CANCEL_REQ_BY_BUYER,
            'paid_at' => now()->subDay(),
            'cancel_attempts' => 1,
            'auto_cancels_at' => now()->addHours(72),
        ]);
    }

    public function cancelRequestedBySeller() {}

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::COMPLETED,
            'paid_at' => now()->subDays(3),
            'delivered_at' => now()->subDays(2),
            'completed_at' => now(),
        ]);
    }
}
