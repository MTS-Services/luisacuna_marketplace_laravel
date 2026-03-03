<?php

use App\Enums\OrderStatus;
use App\Enums\UserType;
use App\Livewire\Backend\Admin\Dashboard;
use App\Models\Category;
use App\Models\Game;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Livewire\Livewire;

/* ================================================================
 *  Helpers
 * ================================================================ */

function createSeller(): User
{
    return User::factory()->create(['user_type' => UserType::SELLER->value]);
}

function createBuyer(): User
{
    return User::factory()->create(['user_type' => UserType::BUYER->value]);
}

function createGameWithCategory(): array
{
    $game = Game::factory()->create();
    $category = Category::factory()->create();

    return [$game, $category];
}

function createOrderForProduct(Product $product, string $status, float $grandTotal): Order
{
    $buyer = createBuyer();

    return Order::create([
        'sort_order' => 0,
        'order_id' => strtoupper(fake()->bothify('ORD-########')),
        'user_id' => $buyer->id,
        'source_id' => $product->id,
        'source_type' => Product::class,
        'status' => $status,
        'unit_price' => $grandTotal,
        'total_amount' => $grandTotal,
        'tax_amount' => 0,
        'grand_total' => $grandTotal,
        'default_unit_price' => $grandTotal,
        'default_total_amount' => $grandTotal,
        'default_tax_amount' => 0,
        'default_grand_total' => $grandTotal,
        'default_currency' => 'USD',
        'exchange_rate' => 1,
        'quantity' => 1,
    ]);
}

function seedDashboardData(): void
{
    $seller = createSeller();
    [$game, $category] = createGameWithCategory();

    $product = Product::factory()->create([
        'user_id' => $seller->id,
        'game_id' => $game->id,
        'category_id' => $category->id,
    ]);

    createOrderForProduct($product, OrderStatus::DELIVERED->value, 100.00);
    createOrderForProduct($product, OrderStatus::PAID->value, 50.00);
    createOrderForProduct($product, OrderStatus::CANCELLED->value, 25.00);
}

/* ================================================================
 *  Tests
 * ================================================================ */

test('dashboard component renders without errors', function () {
    Livewire::test(Dashboard::class)
        ->assertStatus(200)
        ->assertViewIs('livewire.backend.admin.dashboard');
});

test('dashboard initialises all chart data arrays', function () {
    $component = Livewire::test(Dashboard::class);

    $component->assertSet('filter', 'current_week')
        ->assertSet('isEmpty', true); // no data seeded yet

    expect($component->get('financialFlowData'))->toBeArray()
        ->and($component->get('orderLifecycleData'))->toBeArray()
        ->and($component->get('revenueByGameData'))->toBeArray()
        ->and($component->get('revenueByGameCategoryData'))->toBeArray()
        ->and($component->get('profitCommissionData'))->toBeArray()
        ->and($component->get('withdrawalQueueData'))->toBeArray()
        ->and($component->get('sellerEngagementData'))->toBeArray();
});

test('dashboard is not empty when data exists', function () {
    seedDashboardData();

    $component = Livewire::test(Dashboard::class);

    $component->assertSet('isEmpty', false);
    expect($component->get('stats.total_orders'))->toBeGreaterThan(0);
});

test('stat cards contain correct keys', function () {
    seedDashboardData();

    $stats = Livewire::test(Dashboard::class)->get('stats');

    expect($stats)->toHaveKeys([
        'total_users',
        'users_growth',
        'total_orders',
        'orders_growth',
        'total_revenue',
        'revenue_growth',
        'total_sellers',
        'sellers_growth',
    ]);
});

test('stat cards compute correct revenue from revenue-eligible orders', function () {
    seedDashboardData();

    $stats = Livewire::test(Dashboard::class)->get('stats');

    // Only DELIVERED (100) + PAID (50) are revenue-eligible; CANCELLED (25) is not
    expect($stats['total_revenue'])->toBe(150.0);
});

test('financial flow chart has correct structure', function () {
    seedDashboardData();

    $data = Livewire::test(Dashboard::class)->get('financialFlowData');

    expect($data)->toHaveKeys(['labels', 'series'])
        ->and($data['series'])->toHaveCount(2)
        ->and($data['series'][0])->toHaveKey('name')
        ->and($data['series'][0])->toHaveKey('data');
});

test('order lifecycle chart groups orders into three buckets', function () {
    seedDashboardData();

    $data = Livewire::test(Dashboard::class)->get('orderLifecycleData');

    expect($data['labels'])->toHaveCount(3)
        ->and($data['series'])->toHaveCount(3);

    // Escrowed=1 (PAID), Delivered=1 (DELIVERED), Cancelled=1 (CANCELLED)
    expect($data['series'][0])->toBe(1) // Escrowed
        ->and($data['series'][1])->toBe(1) // Delivered
        ->and($data['series'][2])->toBe(1); // Cancelled
});

test('revenue by game chart returns correct labels and series', function () {
    seedDashboardData();

    $data = Livewire::test(Dashboard::class)->get('revenueByGameData');

    expect($data['labels'])->toHaveCount(1)
        ->and($data['series'])->toHaveCount(1)
        ->and($data['series'][0])->toBe(150.0); // 100 + 50 (revenue-eligible orders)
});

test('revenue by game category chart returns correct data', function () {
    seedDashboardData();

    $data = Livewire::test(Dashboard::class)->get('revenueByGameCategoryData');

    expect($data['labels'])->toHaveCount(1)
        ->and($data['series'])->toHaveCount(1)
        ->and($data['series'][0])->toBe(150.0);
});

test('profit commission chart has correct structure', function () {
    $data = Livewire::test(Dashboard::class)->get('profitCommissionData');

    expect($data)->toHaveKeys(['labels', 'series'])
        ->and($data['series'])->toHaveCount(2)
        ->and($data['series'][0]['name'])->toContain('Sales')
        ->and($data['series'][1]['name'])->toContain('Profit');
});

test('withdrawal queue chart returns four status buckets', function () {
    $data = Livewire::test(Dashboard::class)->get('withdrawalQueueData');

    expect($data['labels'])->toHaveCount(4)
        ->and($data['series'])->toHaveCount(4)
        ->and($data)->toHaveKey('colors');
});

test('seller engagement chart has correct structure', function () {
    $data = Livewire::test(Dashboard::class)->get('sellerEngagementData');

    expect($data)->toHaveKeys(['labels', 'series'])
        ->and($data['series'])->toHaveCount(2)
        ->and($data['series'][0]['name'])->toContain('Listings')
        ->and($data['series'][1]['name'])->toContain('Sellers');
});

test('filter change to current_month reloads data', function () {
    seedDashboardData();

    $component = Livewire::test(Dashboard::class)
        ->set('filter', 'current_month');

    expect($component->get('filter'))->toBe('current_month')
        ->and($component->get('stats'))->toBeArray();
});

test('filter change to real_time reloads data', function () {
    seedDashboardData();

    $component = Livewire::test(Dashboard::class)
        ->set('filter', 'real_time');

    expect($component->get('filter'))->toBe('real_time')
        ->and($component->get('stats.total_orders'))->toBeGreaterThanOrEqual(0);
});

test('custom range filter requires both dates', function () {
    $component = Livewire::test(Dashboard::class)
        ->set('filter', 'custom_range');

    // Should not crash — updatedFilter returns early if dates missing
    expect($component->get('filter'))->toBe('custom_range');
});

test('custom range filter loads data when both dates provided', function () {
    seedDashboardData();

    $component = Livewire::test(Dashboard::class)
        ->set('filter', 'custom_range')
        ->set('startDate', now()->startOfMonth()->toDateString())
        ->set('endDate', now()->endOfMonth()->toDateString());

    expect($component->get('stats'))->toBeArray()
        ->and($component->get('stats.total_orders'))->toBeGreaterThanOrEqual(0);
});

test('resetFilter reverts to current_week and clears dates', function () {
    $component = Livewire::test(Dashboard::class)
        ->set('filter', 'current_year')
        ->call('resetFilter');

    expect($component->get('filter'))->toBe('current_week')
        ->and($component->get('startDate'))->toBeNull()
        ->and($component->get('endDate'))->toBeNull();
});

test('refreshData dispatches charts-updated event', function () {
    Livewire::test(Dashboard::class)
        ->call('refreshData')
        ->assertDispatched('charts-updated');
});

test('empty state renders when no data exists', function () {
    Livewire::test(Dashboard::class)
        ->assertSet('isEmpty', true);
});

test('growth calculation returns 100 when previous is zero and current is positive', function () {
    // Create a single user this week, ensure previous period has none
    User::factory()->create();

    $stats = Livewire::test(Dashboard::class)->get('stats');

    expect($stats['users_growth'])->toBe(100.0);
});
