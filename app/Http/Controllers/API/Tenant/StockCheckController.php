<?php

namespace App\Http\Controllers\API\Tenant;

use App\Http\Controllers\Controller;
use App\Models\StockCheckReq;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StockCheckController extends Controller
{
    public function index()
    {
        try {
            $stockChecks = StockCheckReq::with(['product'])
                ->paginate(5);
            
            return response()->json([
                'success' => true,
                'data' => $stockChecks
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching stock checks: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch stock checks'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
                'notes' => 'nullable|string',
                'created_by' => 'nullable|exists:users,id',
                'updated_by' => 'nullable|exists:users,id'
            ]);

            $product = Product::findOrFail($validated['product_id']);
            
            // Check if product is in stock
            $inStock = $product->stock_quantity >= $validated['quantity'];
            
            $stockCheck = StockCheckReq::create([
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'in_stock' => $inStock,
                'notes' => $validated['notes'] ?? null,
                'created_by' => $validated['created_by'] ?? null,
                'updated_by' => $validated['updated_by'] ?? null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Stock check created successfully',
                'data' => [
                    'stock_check' => $stockCheck->load('product'),
                    'in_stock' => $inStock,
                    'available_quantity' => $product->stock_quantity
                ]
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating stock check: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create stock check'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $stockCheck = StockCheckReq::with(['product', 'creator', 'updater'])
                ->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $stockCheck
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching stock check: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Stock check not found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $stockCheck = StockCheckReq::findOrFail($id);

            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
                'notes' => 'nullable|string',
                'updated_by' => 'nullable|exists:users,id'
            ]);

            $product = Product::findOrFail($validated['product_id']);
            $inStock = $product->stock_quantity >= $validated['quantity'];

            $stockCheck->update([
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'in_stock' => $inStock,
                'notes' => $validated['notes'] ?? null,
                'updated_by' => $validated['updated_by'] ?? null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Stock check updated successfully',
                'data' => [
                    'stock_check' => $stockCheck->load('product'),
                    'in_stock' => $inStock,
                    'available_quantity' => $product->stock_quantity
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating stock check: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update stock check'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $stockCheck = StockCheckReq::findOrFail($id);
            $stockCheck->delete();

            return response()->json([
                'success' => true,
                'message' => 'Stock check deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting stock check: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete stock check'
            ], 500);
        }
    }

    public function checkProductStock(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1'
            ]);

            $product = Product::findOrFail($validated['product_id']);
            $inStock = $product->stock_quantity >= $validated['quantity'];

            return response()->json([
                'success' => true,
                'data' => [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'requested_quantity' => $validated['quantity'],
                    'available_quantity' => $product->stock_quantity,
                    'in_stock' => $inStock,
                    'status' => $inStock ? 'Available' : 'Out of Stock'
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error checking product stock: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to check product stock'
            ], 500);
        }
    }
} 