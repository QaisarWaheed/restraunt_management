<?php

namespace App\Http\Controllers\API\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Product::with(['category', 'creator', 'updater'])
                ->when($request->category_id, function ($q) use ($request) {
                    return $q->where('category_id', $request->category_id);
                })
                ->when($request->search, function ($q) use ($request) {
                    return $q->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('description', 'like', '%' . $request->search . '%');
                });

            // Add only_deleted support
            if ($request->has('only_deleted') && $request->only_deleted) {
                $query = $query->onlyTrashed();
            }

            if ($request->status) {
                $query = $query->where('status', $request->status);
            }

            $products = $query->orderBy('sort_order')->paginate($request->per_page ?? 10);

            return response()->json([
                'success' => true,
                'data' => $products
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching products: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch products'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            Log::info('Store product request: ' . json_encode($request->all()));
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'category_id' => 'required|exists:categories,id',
                'sku' => 'nullable|string|max:50|unique:products,sku',
                'barcode' => 'nullable|string|max:50|unique:products,barcode',
                'price' => 'required|numeric|min:0',
                'cost_price' => 'required|numeric|min:0',
                'stock_quantity' => 'required|integer|min:0',
                'min_stock_level' => 'required|integer|min:0',
                'status' => 'required|in:active,inactive',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            Log::info('Validated data: ' . json_encode($validated));
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $path = $image->store("public/products", 'public');
                $validated['image'] = $path;

                Log::info('Image stored at: ' . Storage::disk('public')->path($path));
            }
            // Log::info('Image path: ' . $validated['image']);

            $created_by = auth()->id();
            $updated_by = auth()->id();

            // Automatically set sort_order to max+1 (or 0 if no products exist)
            $sort_order = (Product::max('sort_order') ?? -1) + 1;

            $product = Product::create([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'price' => $validated['price'],
                'category_id' => $validated['category_id'],
                'image' => $validated['image'] ?? null,
                'is_active' => $validated['is_active'] ?? true,
                'is_featured' => $validated['is_featured'] ?? false,
                'stock_quantity' => $validated['stock_quantity'] ?? 0,
                'sku' => $validated['sku'] ?? null,
                'barcode' => $validated['barcode'] ?? null,
                'cost_price' => $validated['cost_price'] ?? 0,
                'min_stock_level' => $validated['min_stock_level'] ?? 0,
                'status' => $validated['status'] ?? 'active',
                'sort_order' => $sort_order,
                'created_by' => $created_by,
                'updated_by' => $updated_by,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'data' => $product->load(['category', 'creator', 'updater'])
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating product: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create product'
            ], 500);
        }
    }

    public function show(Product $product)
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $product->load(['category', 'creator', 'updater'])
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching product: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch product'
            ], 500);
        }
    }

    public function update(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'description' => 'nullable|string',
                'category_id' => 'sometimes|required|exists:categories,id',
                'sku' => 'nullable|string|max:50|unique:products,sku,' . $product->id,
                'barcode' => 'nullable|string|max:50|unique:products,barcode,' . $product->id,
                'price' => 'sometimes|required|numeric|min:0',
                'cost_price' => 'sometimes|required|numeric|min:0',
                'stock_quantity' => 'sometimes|required|integer|min:0',
                'min_stock_level' => 'sometimes|required|integer|min:0',
                'status' => 'sometimes|required|in:active,inactive',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            Log::info('Validated data: ' . json_encode($validated));
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                Log::info('Image deleted');
                $image = $request->file('image');


                $tenantId = tenant('id');
                
                $path = $image->store("/products", 'public');
                $validated['image'] = $path;
                Log::info('Image stored at: ' . Storage::disk('public')->path($path));
            }

            $validated['updated_by'] = auth()->id();

            $product->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully',
                'data' => $product->load(['category', 'creator', 'updater'])
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating product: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product'
            ], 500);
        }
    }

    public function destroy(Product $product)
    {
        try {
            Log::info('Destroying product: ' . $product->id);
            // Check if product has any orders or stock checks
            // if ($product->orderItems()->exists() || $product->stockChecks()->exists()) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Cannot delete product as it has associated records'
            //     ], 400);
            // }

            // Delete image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting product: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete product'
            ], 500);
        }
    }

    public function forceDelete($id)
    {
        try {
            $product = Product::withTrashed()->findOrFail($id);
            
            // Delete image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $product->forceDelete();

            return response()->json([
                'success' => true,
                'message' => 'Product permanently deleted'
            ]);
        } catch (\Exception $e) {
            Log::error('Error force deleting product: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to permanently delete product'
            ], 500);
        }
    }

    public function restore($id)
    {
        try {
            $product = Product::withTrashed()->findOrFail($id);
            $product->restore();

            return response()->json([
                'success' => true,
                'message' => 'Product restored successfully',
                'data' => $product->load(['category', 'creator', 'updater'])
            ]);
        } catch (\Exception $e) {
            Log::error('Error restoring product: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to restore product'
            ], 500);
        }
    }

    public function reorder(Request $request)
    {
        $order = $request->input('order', []);
        foreach ($order as $item) {
            Product::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }
        return response()->json(['success' => true, 'message' => 'Order updated']);
    }
} 