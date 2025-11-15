<?php

namespace App\Http\Controllers\Admin\Promo;

use App\DataTables\Admin\Promo\PromoDataTable;
use App\Http\Controllers\Controller;
use App\Models\Produk\Produk;
use App\Models\Produk\ProdukCategory;
use App\Models\Promo\Promo;
use App\Models\Promo\PromoCategory;
use App\Models\Promo\PromoProduct;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class PromoController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:promo view', only: ['index', 'show']),
            new Middleware('permission:promo create', only: ['create', 'store']),
            new Middleware('permission:promo edit', only: ['edit', 'update']),
            new Middleware('permission:promo delete', only: ['destroy']),
        ];
    }

    public function index(PromoDataTable $dataTable)
    {
        return $dataTable->render('admin.promo.promo.index', [
            'title' => 'Promo Management'
        ]);
    }

    public function create()
    {
        $categories = ProdukCategory::orderBy('name')->get();
        $products = Produk::where('status', 'publish')->orderBy('name')->get();

        return view('admin.promo.promo.create', [
            'title' => 'Create New Promo',
            'categories' => $categories,
            'products' => $products
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'start_date' => 'nullable|date|after_or_equal:today',
            'end_date' => 'nullable|date|after:start_date',
            'is_active' => 'boolean',
            'usage_limit' => 'nullable|integer|min:1',
            'applicable_to' => 'required|in:all,category,product',
            'promo_code' => 'nullable|string|max:20|unique:promos,promo_code',
            'categories' => 'required_if:applicable_to,category|array',
            'categories.*' => 'exists:produk_categories,id',
            'products' => 'required_if:applicable_to,product|array',
            'products.*' => 'exists:produks,id',
            'category_overrides' => 'nullable|array',
            'category_overrides.*.discount_type' => 'nullable|in:percentage,fixed',
            'category_overrides.*.discount_value' => 'nullable|numeric|min:0',
            'product_overrides' => 'nullable|array',
            'product_overrides.*.discount_type' => 'nullable|in:percentage,fixed',
            'product_overrides.*.discount_value' => 'nullable|numeric|min:0',
        ]);

        // Additional validation based on discount type
        if ($request->discount_type === 'percentage' && $request->discount_value > 100) {
            return back()->withErrors(['discount_value' => 'Percentage discount cannot exceed 100%']);
        }

        DB::beginTransaction();
        try {
            $promo = Promo::create([
                'name' => $request->name,
                'description' => $request->description,
                'discount_type' => $request->discount_type,
                'discount_value' => $request->discount_value,
                'start_date' => $request->start_date ? Carbon::parse($request->start_date) : null,
                'end_date' => $request->end_date ? Carbon::parse($request->end_date) : null,
                'is_active' => $request->boolean('is_active', true),
                'usage_limit' => $request->usage_limit,
                'applicable_to' => $request->applicable_to,
                'promo_code' => $request->promo_code,
                'created_by' => Auth::id(),
            ]);

            // Create category relationships
            if ($request->applicable_to === 'category' && $request->categories) {
                foreach ($request->categories as $categoryId) {
                    $override = $request->category_overrides[$categoryId] ?? [];
                    PromoCategory::create([
                        'promo_id' => $promo->id,
                        'category_id' => $categoryId,
                        'discount_type' => $override['discount_type'] ?? null,
                        'discount_value' => $override['discount_value'] ?? null,
                    ]);
                }
            }

            // Create product relationships
            if ($request->applicable_to === 'product' && $request->products) {
                foreach ($request->products as $productId) {
                    $override = $request->product_overrides[$productId] ?? [];
                    PromoProduct::create([
                        'promo_id' => $promo->id,
                        'produk_id' => $productId,
                        'discount_type' => $override['discount_type'] ?? null,
                        'discount_value' => $override['discount_value'] ?? null,
                    ]);
                }
            }

            // Update promo cache for affected products
            $this->updatePromoCache($promo);

            DB::commit();

            return redirect()->route('admin.promo.promo.index')
                           ->with('success', 'Promo created successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Failed to create promo: ' . $e->getMessage()]);
        }
    }

    public function show(Promo $promo)
    {
        $promo->load(['creator', 'updater', 'categories.category', 'products.produk', 'categories.category.produks', 'products.produk.category']);

        // Calculate statistics
        $totalProducts = $promo->applicable_to === 'all'
            ? Produk::where('status', 'publish')->count()
            : ($promo->applicable_to === 'category'
                ? $promo->categories->sum(fn($pc) => $pc->category->produks()->where('status', 'publish')->count())
                : $promo->products()->count());

        // Calculate active products (simplified calculation)
        $activeProducts = $totalProducts; // For now, use total as active until promo cache system is implemented

        return view('admin.promo.promo.show', [
            'title' => 'Promo Details: ' . $promo->name,
            'promo' => $promo,
            'totalProducts' => $totalProducts,
            'activeProducts' => $activeProducts
        ]);
    }

    public function edit(Promo $promo)
    {
        $promo->load(['categories', 'products']);
        $categories = ProdukCategory::orderBy('name')->get();
        $products = Produk::where('status', 'publish')->orderBy('name')->get();

        return view('admin.promo.promo.edit', [
            'title' => 'Edit Promo: ' . $promo->name,
            'promo' => $promo,
            'categories' => $categories,
            'products' => $products
        ]);
    }

    public function update(Request $request, Promo $promo)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'start_date' => [
                'nullable',
                'date',
                function ($attribute, $value, $fail) use ($promo) {
                    if ($value && $promo && $promo->start_date) {
                        $newDate = Carbon::parse($value);
                        $oldDate = Carbon::parse($promo->start_date);
                        // Allow if promo hasn't started yet, or if changing to future date
                        if ($oldDate->lte(now()) && $newDate->lt(now())) {
                            $fail('Cannot change start date to past for active promo.');
                        }
                    } elseif ($value && Carbon::parse($value)->lt(now())) {
                        $fail('Start date cannot be in the past.');
                    }
                },
            ],
            'end_date' => 'nullable|date|after:start_date',
            'is_active' => 'boolean',
            'usage_limit' => 'nullable|integer|min:1',
            'applicable_to' => 'required|in:all,category,product',
            'promo_code' => 'nullable|string|max:20|unique:promos,promo_code,' . $promo->id,
            'categories' => 'required_if:applicable_to,category|array',
            'categories.*' => 'exists:produk_categories,id',
            'products' => 'required_if:applicable_to,product|array',
            'products.*' => 'exists:produks,id',
            'category_overrides' => 'nullable|array',
            'category_overrides.*.discount_type' => 'nullable|in:percentage,fixed',
            'category_overrides.*.discount_value' => 'nullable|numeric|min:0',
            'product_overrides' => 'nullable|array',
            'product_overrides.*.discount_type' => 'nullable|in:percentage,fixed',
            'product_overrides.*.discount_value' => 'nullable|numeric|min:0',
        ]);

        // Additional validation based on discount type
        if ($request->discount_type === 'percentage' && $request->discount_value > 100) {
            return back()->withErrors(['discount_value' => 'Percentage discount cannot exceed 100%']);
        }

        DB::beginTransaction();
        try {
            // Clear previous cache before updating
            $this->updatePromoCache($promo, true);

            $promo->update([
                'name' => $request->name,
                'description' => $request->description,
                'discount_type' => $request->discount_type,
                'discount_value' => $request->discount_value,
                'start_date' => $request->start_date ? Carbon::parse($request->start_date) : null,
                'end_date' => $request->end_date ? Carbon::parse($request->end_date) : null,
                'is_active' => $request->boolean('is_active'),
                'usage_limit' => $request->usage_limit,
                'applicable_to' => $request->applicable_to,
                'promo_code' => $request->promo_code,
                'updated_by' => Auth::id(),
            ]);

            // Update category relationships
            $promo->categories()->delete();
            if ($request->applicable_to === 'category' && $request->categories) {
                foreach ($request->categories as $categoryId) {
                    $override = $request->category_overrides[$categoryId] ?? [];
                    PromoCategory::create([
                        'promo_id' => $promo->id,
                        'category_id' => $categoryId,
                        'discount_type' => $override['discount_type'] ?? null,
                        'discount_value' => $override['discount_value'] ?? null,
                    ]);
                }
            }

            // Update product relationships
            $promo->products()->delete();
            if ($request->applicable_to === 'product' && $request->products) {
                foreach ($request->products as $productId) {
                    $override = $request->product_overrides[$productId] ?? [];
                    PromoProduct::create([
                        'promo_id' => $promo->id,
                        'produk_id' => $productId,
                        'discount_type' => $override['discount_type'] ?? null,
                        'discount_value' => $override['discount_value'] ?? null,
                    ]);
                }
            }

            // Update promo cache for affected products
            $this->updatePromoCache($promo);

            DB::commit();

            return redirect()->route('admin.promo.promo.index')
                           ->with('success', 'Promo updated successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Failed to update promo: ' . $e->getMessage()]);
        }
    }

    public function destroy(Promo $promo)
    {
        try {
            DB::beginTransaction();

            // Clear promo cache before deleting
            $this->updatePromoCache($promo, true);

            $promo->categories()->delete();
            $promo->products()->delete();
            $promo->delete();

            DB::commit();

            return redirect()->route('admin.promo.promo.index')
                           ->with('success', 'Promo deleted successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Failed to delete promo: ' . $e->getMessage()]);
        }
    }

    public function toggleStatus(Promo $promo)
    {
        try {
            $promo->update([
                'is_active' => !$promo->is_active,
                'updated_by' => Auth::id(),
            ]);

            // Update promo cache
            $this->updatePromoCache($promo);

            return back()->with('success', 'Promo status updated successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update promo status: ' . $e->getMessage()]);
        }
    }

    public function duplicate(Promo $promo)
    {
        try {
            $newPromo = $promo->replicate();
            $newPromo->name = $promo->name . ' (Copy)';
            $newPromo->promo_code = null; // Will generate new code
            $newPromo->usage_count = 0;
            $newPromo->created_by = Auth::id();
            $newPromo->updated_by = null;
            $newPromo->save();

            // Duplicate category relationships
            foreach ($promo->categories as $category) {
                PromoCategory::create([
                    'promo_id' => $newPromo->id,
                    'category_id' => $category->category_id,
                    'discount_type' => $category->discount_type,
                    'discount_value' => $category->discount_value,
                ]);
            }

            // Duplicate product relationships
            foreach ($promo->products as $product) {
                PromoProduct::create([
                    'promo_id' => $newPromo->id,
                    'produk_id' => $product->produk_id,
                    'discount_type' => $product->discount_type,
                    'discount_value' => $product->discount_value,
                ]);
            }

            // Update promo cache for duplicated promo
            $this->updatePromoCache($newPromo);

            return redirect()->route('admin.promo.promo.edit', $newPromo)
                           ->with('success', 'Promo duplicated successfully!');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to duplicate promo: ' . $e->getMessage()]);
        }
    }

    private function updatePromoCache(Promo $promo, bool $clear = false)
    {
        try {
            $affectedProducts = $this->getAffectedProducts($promo);
            
            foreach ($affectedProducts as $product) {
                $product->updatePromoCache();
            }
        } catch (\Exception $e) {
            Log::error('Failed to update promo cache: ' . $e->getMessage(), [
                'promo_id' => $promo->id,
                'clear' => $clear
            ]);
        }
    }

    private function getAffectedProducts(Promo $promo)
    {
        if ($promo->applicable_to === 'all') {
            return Produk::where('status', 'publish')->get();
        } elseif ($promo->applicable_to === 'category') {
            $categoryIds = $promo->categories()->pluck('category_id');
            return Produk::whereIn('category_id', $categoryIds)
                         ->where('status', 'publish')
                         ->get();
        } else { // product
            $productIds = $promo->products()->pluck('produk_id');
            return Produk::whereIn('id', $productIds)
                         ->where('status', 'publish')
                         ->get();
        }
    }
}