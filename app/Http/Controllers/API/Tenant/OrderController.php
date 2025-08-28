<?php

namespace App\Http\Controllers\API\Tenant;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\API\Tenant\CustomerController;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $customerController;

    public function __construct(CustomerController $customerController)
    {
        $this->customerController = $customerController;
    }

    public function placeOrder(Request $request)
    {
        $customer = $this->customerController->getOrCreateCustomer($request);
        $cartItems = Cart::with('product')
            ->where('customer_unique_id', $customer->unique_id)
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        $totalAmount = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $order = Order::create([
            'tracking_id' => 'ORD-' . Str::random(10),
            'customer_id' => $customer->id,
            'restaurant_id' => $request->restaurant_id,
            'total_amount' => $totalAmount,
            'delivery_address' => $request->delivery_address,
            'special_instructions' => $request->special_instructions,
            'payment_method' => $request->payment_method
        ]);

        foreach ($cartItems as $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'options' => $item->options
            ]);
        }

        // Clear the cart after order is placed
        Cart::where('customer_unique_id', $customer->unique_id)->delete();

        return response()->json($order);
    }

    public function getOrderDetails(Order $order)
    {
        $order->load(['orderDetails.product', 'customer']);
        return response()->json($order);
    }

    public function updateOrderStatus(Order $order, Request $request)
    {
        $order->update(['status' => $request->status]);
        return response()->json($order);
    }

    public function getCustomerOrders(Request $request)
    {
        $customer = $this->customerController->getOrCreateCustomer($request);
        $orders = Order::with(['orderDetails.product'])
            ->where('customer_id', $customer->id)
            ->latest()
            ->get();

        return response()->json($orders);
    }

    public function index(Request $request)
    {
        try {
            $query = Order::with(['customer', 'orderDetails', 'orderDetails.product'])
                ->when($request->customer_id, function ($q) use ($request) {
                    return $q->where('customer_id', $request->customer_id);
                })
                ->when($request->status, function ($q) use ($request) {
                    return $q->where('status', $request->status);
                })
                ->when($request->date_from, function ($q) use ($request) {
                    return $q->whereDate('created_at', '>=', $request->date_from);
                })
                ->when($request->date_to, function ($q) use ($request) {
                    return $q->whereDate('created_at', '<=', $request->date_to);
                })
                ->when($request->search, function ($q) use ($request) {
                    return $q->where('order_number', 'like', '%' . $request->search . '%')
                        ->orWhereHas('customer', function ($query) use ($request) {
                            $query->where('name', 'like', '%' . $request->search . '%');
                        });
                });

            $orders = $query->orderBy('created_at', 'desc')
                ->paginate($request->per_page ?? 10);
                // dd($orders);
            Log::info("orders", [$orders]);
            return response()->json([
                'success' => true,
                'data' => $orders
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching orders: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch orders'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'customer_id' => 'required|exists:customers,id',
                'items' => 'required|array|min:1',
                'items.*.product_id' => 'required|exists:products,id',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.price' => 'required|numeric|min:0',
                'notes' => 'nullable|string',
                'status' => 'required|in:pending,processing,completed,cancelled'
            ]);

            // Generate order number
            $orderNumber = 'ORD-' . strtoupper(uniqid());

            // Create order
            $order = Order::create([
                'order_number' => $orderNumber,
                'customer_id' => $validated['customer_id'],
                'notes' => $validated['notes'],
                'status' => $validated['status'],
                'created_by' => auth()->id(),
                'updated_by' => auth()->id()
            ]);

            // Create order items and update product stock
            $totalAmount = 0;
            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                
                // Check if product has enough stock
                if ($product->stock_quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for product: {$product->name}");
                }

                // Create order item
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['quantity'] * $item['price']
                ]);

                // Update product stock
                $product->decrement('stock_quantity', $item['quantity']);

                $totalAmount += $orderItem->total;
            }

            // Update order total
            $order->update(['total_amount' => $totalAmount]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'data' => $order->load(['items.product', 'customer', 'creator', 'updater'])
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating order: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(Order $order)
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $order->load(['items.product', 'customer', 'creator', 'updater'])
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching order: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch order'
            ], 500);
        }
    }

    public function update(Request $request, Order $order)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'status' => 'sometimes|required|in:pending,processing,completed,cancelled',
                'notes' => 'nullable|string'
            ]);

            // If order is being cancelled, restore product stock
            if ($validated['status'] === 'cancelled' && $order->status !== 'cancelled') {
                foreach ($order->items as $item) {
                    $product = $item->product;
                    $product->increment('stock_quantity', $item->quantity);
                }
            }

            $validated['updated_by'] = auth()->id();
            $order->update($validated);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order updated successfully',
                'data' => $order->load(['items.product', 'customer', 'creator', 'updater'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating order: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update order'
            ], 500);
        }
    }

    public function destroy(Order $order)
    {
        try {
            DB::beginTransaction();

            // Restore product stock
            foreach ($order->items as $item) {
                $product = $item->product;
                $product->increment('stock_quantity', $item->quantity);
            }

            $order->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting order: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete order'
            ], 500);
        }
    }

    public function forceDelete($id)
    {
        try {
            DB::beginTransaction();

            $order = Order::withTrashed()->findOrFail($id);
            
            // Delete order items
            $order->items()->forceDelete();
            
            // Delete order
            $order->forceDelete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order permanently deleted'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error force deleting order: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to permanently delete order'
            ], 500);
        }
    }

    public function restore($id)
    {
        try {
            DB::beginTransaction();

            $order = Order::withTrashed()->findOrFail($id);
            
            // Restore order items
            $order->items()->restore();
            
            // Restore order
            $order->restore();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order restored successfully',
                'data' => $order->load(['items.product', 'customer', 'creator', 'updater'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error restoring order: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to restore order'
            ], 500);
        }
    }
    
    public function updateStatus(Request $request, $id)
    {
        $status = $request->query('status'); // or $request->get('status')
        
        $request->validate([
            'status' => ['required', Rule::in(['pending', 'processing', 'completed', 'cancelled'])]
        ]);

        $tenant = Order::findOrFail($id);
        $tenant->status = $status;
        $tenant->save();

        return response()->json([
            'success' => true,
            'message' => 'Tenant status updated successfully',
            'data' => $tenant
        ]);
    }
} 