<?php

namespace App\Http\Controllers\Backend\Admin\ProductManagement;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Controllers\Controller;

class CurrencyController extends Controller
{
    protected string $masterView = 'backend.admin.pages.product-management.category';
    public function __construct(protected ProductService $service) {}

    public function index($categorySlug)
    {
        return view($this->masterView, compact('categorySlug'));
    }
    public function details($id)
    {
        try {
            $id = decrypt($id);
            $product = Product::findOrFail($id);
            $categorySlug = $product->games->slug;

            return view($this->masterView, compact('categorySlug', 'id', 'product'));
        } catch (\Exception $e) {
            abort(404);
        }
    }
}
