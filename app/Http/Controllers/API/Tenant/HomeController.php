<?php

namespace App\Http\Controllers\API\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subscriber;
use App\Models\Contact;
use App\Models\TableReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Currency;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Notification;

class HomeController extends Controller
{
    public function categories(Request $request)
    {
        try {
            $query = Category::with(['parent', 'children']);
            if ($request->has('only_deleted') && $request->only_deleted) {
                $query = $query->onlyTrashed();
            }
            if ($request->parent_id) {
                $query = $query->where('parent_id', $request->parent_id);
            }
            if ($request->search) {
                $query = $query->where(function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('description', 'like', '%' . $request->search . '%');
                });
            }
            if ($request->has('is_active') && $request->is_active !== '') {
                $query = $query->where('is_active', filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN));
            }
            $query = $query->orderBy('sort_order');
            $categories = $query->paginate($request->per_page ?? 10);

            return response()->json([
                'success' => true,
                'data' => $categories
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching categories: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch categories'
            ], 500);
        }
    }
    public function products(Request $request)
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
    public function storeSubscriberEmail(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email|unique:subscribers'
            ]);

            $subscribe = Subscriber::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'You have successfully subscribed to our newsletter.',
                'data' => $subscribe
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating setting: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Subscription failed or already subscribed.'
            ], 500);
        }
    }
    public function storeContactInfo(Request $request)
    {
        try {
            Log::info('contact details adding');
            $validated = $request->validate([
                'email' => 'required|email',
                'name' => 'required|string',
                'subject' => 'required|string',
                'phone' => 'required|string',
                'message' => 'required|string',
            ]);
            Log::info('validation added');
            $contact = Contact::create($validated);
            Log::info('saved');

            return response()->json([
                'success' => true,
                'message' => 'You message successfully send, we will get back to you shortly.',
                'data' => $contact
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error sending contact message: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send your message. Please try again later.'
            ], 500);
        }
    }
    public function storeReservationInfo(Request $request)
    {
        try {
            Log::info('Starting reservation process...');
            $validated = $request->validate([
                'email' => 'required|email',
                'full_name' => 'required|string',
                'date' => 'required|string',
                'time' => 'required|string',
                'guests' => 'required|integer',
                'phone_number' => 'required|string',
                'message' => 'nullable|string',
            ]);
            Log::info('validation added');
            $tableReservation = TableReservation::create($validated);
            Log::info('saved');
            
            return response()->json([
                'success' => true,
                'message' => 'Reservation submitted successfully.',
                'data' => $tableReservation
                ], 201);
            } catch (\Exception $e) {
                Log::error('Reservation error: ' . $e->getMessage());

                return response()->json([
                    'success' => false,
                    'message' => 'Could not submit reservation. Try again later.'
                ], 500);
        }
    }
    public function storeStockCheck(Request $request)
    {
        try {
            Log::info('Starting stock check process...');
            $validated = $request->validate([
                'email' => 'required|email',
                'full_name' => 'required|string',
                'phone_number' => 'required|string',
                'product_id' => 'required|integer|exists:products,id',
                'qty' => 'required|integer|min:1',
            ]);
            Log::info('Validation passed');
            $stockCheck = \App\Models\StockCheckReq::create($validated);
            Log::info('Stock check saved');

            // Create notification for admin
            \App\Models\Notification::create([
                'type' => 'stock_check',
                // 'stock_check_id' => $stockCheck->id,
                'title' => 'New Stock Check Request',
                'message' => 'Stock check for product ID #' . $stockCheck->product_id . ' (Qty: ' . $stockCheck->qty . ') has been submitted.',
                'is_read' => false,
            ]);

            return response()->json([
                'success' => true,
                'message' => "Stock check request has been sent. You’ll get a response soon on your given number or email.",
                'data' => $stockCheck
            ], 201);
        } catch (\Exception $e) {
            Log::error('Stock check error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Could not submit stock check. Try again later.'
            ], 500);
        }
    }
    
    public function saveOrder(Request $request)
    {
        Log::info('Order Save Request:', $request->all());

        DB::beginTransaction();
        try {
            // 1. Save customer (or update if email/phone already exists)
            $customerData = $request->input('customer');
            $customer = Customer::updateOrCreate(
                [
                    'email' => $customerData['email'],
                    'phone' => $customerData['phone']
                ],
                [
                    'name' => $customerData['name'],
                    'address' => $customerData['address'],
                    'device_info' => $customerData['device_info'] ?? null,
                    'status' => 'active'
                ]
            );
            $setting = Setting::first();
            // 2. Save order
            $orderData = $request->input('order');
            $order = new Order();
            $order->customer_id = $customer->id;
            $order->order_number = Str::random(6);
            $order->applied_discount = $setting->discount;
            $order->currency_symbol = $setting->currency_symbol;
            $order->tracking_id = Str::random(6);
            $order->total_amount = $orderData['total_amount'];
            $order->status = $orderData['status'] ?? 'pending';
            $order->delivery_address = $orderData['delivery_address'] ?? $customer->address;
            $order->save();

            // 3. Save order details
            $orderDetails = $request->input('order_details', []);
            foreach ($orderDetails as $detail) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $detail['product_id'],
                    'quantity' => $detail['quantity'],
                    'price' => $detail['price']
                ]);
            }

            // 4. Save notification for new order
            Notification::create([
                'type' => 'order',// set this if you have multi-tenant
                'order_id' => $order->id,
                'title' => 'New Order Received',
                'message' => 'Order #' . $order->order_number . ' has been placed.',
                'is_read' => false,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order saved successfully',
                'order_id' => $order->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info('Order Save Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to save order: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getNotifications(Request $request)
    {
        $notifications = Notification::orderBy('created_at', 'desc')
            ->where('is_read', false)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $notifications
        ]);
    }
    public function fetchCurrency()
    {
        $currencies = Currency::get();
        Log::info('currencies', [$currencies]);
        return response()->json([
            'success' => true,
            'data' => $currencies
        ]);
    }
} 