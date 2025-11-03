<?php

namespace App\Livewire\Forms\Backend\Admin\ProductManagement;

use Livewire\Form;
use App\Models\Product;
use App\Enums\ProductsStatus;
use Livewire\Attributes\Locked;
use App\Enums\ProductsVisibility;
use Livewire\Attributes\Validate;
use App\Enums\ProductsDeliveryMethod;

class ProducForm extends Form
{
    #[Locked]
    public ?int $id = null;
    public string $title = '';
    public string $slug = '';
    public string $seller_id = '';
    public string $game_id = '';
    public string $product_type_id = '';
    public string $description = '';
    public string $price = '';
    public ?string $currency = '';
    public ?string $discount_percentage = '';
    public ?string $discounted_price = '';
    public ?string $stock_quantity = '';
    public ?string $min_purchase_quantity = '';
    public ?string $max_purchase_quantity = '';
    public ?string $unlimited_stock = '';
    public string $delivery_method = '';
    public ?string $delivery_time_hours = '';
    public ?string $auto_delivery_content = '';
    public ?string $server_id = '';
    public ?string $platform = '';
    public ?string $region = '';
    public ?string $specifications = '';
    public ?string $requirements = '';
    public string $status = '';
    public ?string $is_featured = '';
    public ?string $is_hot_deal = '';
    public string $visibility = '';
    public ?string $total_sales = '';
    public ?string $total_revenue = '';
    public ?string $view_count = '';
    public ?string $favorite_count = '';
    public ?string $average_rating = '';
    public ?string $total_reviews = '';
    public ?string $reviewed_by = '';
    public ?string $reviewed_at = '';
    public ?string $rejection_reason = '';
    public ?string $meta_title = '';
    public ?string $meta_description = '';
    public ?string $meta_keywords = '';

    public function __construct()
    {
        // ডিফল্ট ভ্যালু সেট করুন
        $this->delivery_method = ProductsDeliveryMethod::MANUAL->value;
        $this->status = ProductsStatus::ACTIVE->value;
        $this->visibility = ProductsVisibility::PUBLIC->value;
    }

    public function rules(): array
    {
        $slugRule = $this->isUpdating()
            ? 'required|string|max:10|unique:products,slug,' . $this->id
            : 'required|string|max:10|unique:products,slug';

        return [
            // Locked fields
            'id' => 'nullable|integer',

            // Foreign keys
            'seller_id' => 'required|integer|exists:users,id',
            'game_id' => 'required|integer|exists:games,id',
            'product_type_id' => 'required|integer|exists:product_types,id',
            'server_id' => 'nullable|integer|exists:servers,id',
            'reviewed_by' => 'nullable|integer|exists:users,id',

            // Basic info
            'title' => 'required|string|max:255',
            'slug' => $slugRule,
            'description' => 'required|string',

            // Pricing
            'price' => 'required|numeric|min:0',
            'currency' => 'nullable|string|size:3',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'discounted_price' => 'nullable|numeric|min:0',

            // Stock
            'stock_quantity' => 'nullable|integer|min:0',
            'min_purchase_quantity' => 'nullable|integer|min:1',
            'max_purchase_quantity' => 'nullable|integer|min:1',
            'unlimited_stock' => 'boolean',

            // Delivery
            'delivery_method' => 'required|string|in:' . implode(',', array_column(ProductsDeliveryMethod::cases(), 'value')),
            'delivery_time_hours' => 'nullable|integer|min:1',
            'auto_delivery_content' => 'nullable|string',

            // Extra info
            'platform' => 'nullable|string|max:50',
            'region' => 'nullable|string|max:50',
            'specifications' => 'nullable|json',
            'requirements' => 'nullable|json',

            // Status & flags
            'status' => 'required|string|in:' . implode(',', array_column(ProductsStatus::cases(), 'value')),
            'is_featured' => 'boolean',
            'is_hot_deal' => 'boolean',
            'visibility' => 'required|string|in:' . implode(',', array_column(ProductsVisibility::cases(), 'value')),

            // Stats
            'total_sales' => 'nullable|integer|min:0',
            'total_revenue' => 'nullable|numeric|min:0',
            'view_count' => 'nullable|integer|min:0',
            'favorite_count' => 'nullable|integer|min:0',
            'average_rating' => 'nullable|numeric|min:0|max:5',
            'total_reviews' => 'nullable|integer|min:0',

            // Review info
            'reviewed_at' => 'nullable|date',
            'rejection_reason' => 'nullable|string',

            // Meta
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ];
    }

    public function setData(Product $product): void
    {
        $this->id = $product->id;
        $this->seller_id = $product->seller_id;
        $this->game_id = $product->game_id;
        $this->product_type_id = $product->product_type_id;
        $this->title = $product->title;
        $this->slug = $product->slug;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->currency = $product->currency;
        $this->discount_percentage = $product->discount_percentage;
        $this->discounted_price = $product->discounted_price;
        $this->stock_quantity = $product->stock_quantity;
        $this->min_purchase_quantity = $product->min_purchase_quantity;
        $this->max_purchase_quantity = $product->max_purchase_quantity;
        $this->unlimited_stock = $product->unlimited_stock;
        
        // ✅ Enum গুলোকে string value তে কনভার্ট করুন
        $this->delivery_method = $product->delivery_method?->value ?? ProductsDeliveryMethod::MANUAL->value;
        
        $this->delivery_time_hours = $product->delivery_time_hours;
        $this->auto_delivery_content = $product->auto_delivery_content;
        $this->server_id = $product->server_id;
        $this->platform = $product->platform;
        $this->region = $product->region;
        $this->specifications = $product->specifications;
        $this->requirements = $product->requirements;
        
        // ✅ Enum গুলোকে string value তে কনভার্ট করুন
        $this->status = $product->status?->value ?? ProductsStatus::ACTIVE->value;
        
        $this->is_featured = $product->is_featured;
        $this->is_hot_deal = $product->is_hot_deal;
        
        // ✅ Enum গুলোকে string value তে কনভার্ট করুন
        $this->visibility = $product->visibility?->value ?? ProductsVisibility::PUBLIC->value;
        
        $this->total_sales = $product->total_sales;
        $this->total_revenue = $product->total_revenue;
        $this->view_count = $product->view_count;
        $this->favorite_count = $product->favorite_count;
        $this->average_rating = $product->average_rating;
        $this->total_reviews = $product->total_reviews;
        $this->reviewed_by = $product->reviewed_by;
        $this->reviewed_at = $product->reviewed_at;
        $this->rejection_reason = $product->rejection_reason;
        $this->meta_title = $product->meta_title;
        $this->meta_description = $product->meta_description;
        $this->meta_keywords = $product->meta_keywords;
    }

    public function reset(...$properties): void
    {
        parent::reset(
            'id',
            'seller_id',
            'game_id',
            'product_type_id',
            'title',
            'slug',
            'description',
            'price',
            'currency',
            'discount_percentage',
            'discounted_price',
            'stock_quantity',
            'min_purchase_quantity',
            'max_purchase_quantity',
            'unlimited_stock',
            'delivery_method',
            'delivery_time_hours',
            'auto_delivery_content',
            'server_id',
            'platform',
            'region',
            'specifications',
            'requirements',
            'status',
            'is_featured',
            'is_hot_deal',
            'visibility',
            'total_sales',
            'total_revenue',
            'view_count',
            'favorite_count',
            'average_rating',
            'total_reviews',
            'reviewed_by',
            'reviewed_at',
            'rejection_reason',
            'meta_title',
            'meta_description',
            'meta_keywords'
        );

        $this->resetValidation();
        
        // রিসেট করার পর ডিফল্ট ভ্যালু আবার সেট করুন
        $this->delivery_method = ProductsDeliveryMethod::MANUAL->value;
        $this->status = ProductsStatus::ACTIVE->value;
        $this->visibility = ProductsVisibility::PUBLIC->value;
    }

    protected function isUpdating(): bool
    {
        return !empty($this->id);
    }

    public function fillables(): array
    {
        return [
            'seller_id',
            'game_id',
            'product_type_id',
            'title',
            'slug',
            'description',
            'price',
            'currency',
            'discount_percentage',
            'discounted_price',
            'stock_quantity',
            'min_purchase_quantity',
            'max_purchase_quantity',
            'unlimited_stock',
            'delivery_method',
            'delivery_time_hours',
            'auto_delivery_content',
            'server_id',
            'platform',
            'region',
            'specifications',
            'requirements',
            'status',
            'is_featured',
            'is_hot_deal',
            'visibility',
            'total_sales',
            'total_revenue',
            'view_count',
            'favorite_count',
            'average_rating',
            'total_reviews',
            'reviewed_by',
            'reviewed_at',
            'rejection_reason',
            'meta_title',
            'meta_description',
            'meta_keywords',
        ];
    }
}