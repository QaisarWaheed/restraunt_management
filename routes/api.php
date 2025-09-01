<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\Dashboard\DashboardController;
use App\Http\Controllers\API\Dashboard\RoleController as DashboardRoleController;
use App\Http\Controllers\API\Dashboard\TenantController as DashboardTenantController;
use App\Http\Controllers\API\Dashboard\UserController as DashboardUserController;
use App\Http\Controllers\API\Tenant\AuthController as TenantAuthController;
use App\Http\Controllers\API\Tenant\BookingController as TenantBookingController;
use App\Http\Controllers\API\Tenant\CategoryController as TenantCategoryController;
use App\Http\Controllers\API\Tenant\CmsMenuController;
use App\Http\Controllers\API\Tenant\CustomerController as TenantCustomerController;
use App\Http\Controllers\API\Tenant\OrderController as TenantOrderController;
use App\Http\Controllers\API\Tenant\ProductController as TenantProductController;
use App\Http\Controllers\API\Tenant\RoleController as TenantRoleController;
use App\Http\Controllers\API\Tenant\StockCheckController as TenantStockCheckController;
use App\Http\Controllers\API\Tenant\TenantController as RestaurantTenantController;
use App\Http\Controllers\API\Tenant\TenantDashboardController;
use App\Http\Controllers\API\Tenant\TenantPdfUpload;
use App\Http\Controllers\API\Tenant\UserController as TenantUserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/check-subdomain/{subdomain}', [AuthController::class, 'checkSubdomain']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('tenants/list', [DashboardTenantController::class, 'index']);
// Public Routes for Tenant Registration
Route::post('/tenants/register', [RestaurantTenantController::class, 'register'])->name('tenant.register');

// Main application routes (using main database auth)
Route::middleware(['auth:sanctum'])->group(function () {

    // Roles Management
    Route::prefix('dashboard')->group(function () {
        Route::get('stats', [DashboardController::class, 'getStats']);
        Route::get('recent-tenants', [DashboardController::class, 'getRecentTenants']);
        Route::post('clear-cache', [DashboardController::class, 'clearCache']);
        Route::get('permissions', [DashboardRoleController::class, 'permissions']);
        Route::apiResource('roles', DashboardRoleController::class);
        Route::apiResource('users', DashboardUserController::class);

        Route::apiResource('tenants', DashboardTenantController::class);
        // Route::get('/tenants', [DashboardTenantController::class, 'index']);
        Route::get('/tenants/{id}', [DashboardTenantController::class, 'show']);
        Route::patch('/tenants/{id}/status', [DashboardTenantController::class, 'updateStatus']);
    });
});

// Tenant routes (using tenant database auth)
Route::middleware([
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->prefix('tenant')->group(function () {
    // Tenant Routes

    Route::post('/login', [TenantAuthController::class, 'login']);
    Route::get('/get-tenant-details', [App\Http\Controllers\API\Tenant\SettingController::class, 'getDetails']);
    Route::get('public/categories', [App\Http\Controllers\API\Tenant\HomeController::class, 'categories']);
    Route::get('public/products', [App\Http\Controllers\API\Tenant\HomeController::class, 'products']);
    Route::get('public/currency', [App\Http\Controllers\API\Tenant\HomeController::class, 'fetchCurrency']);
    Route::get('cms_page/{slug}', [App\Http\Controllers\API\Tenant\CmsMenuController::class, 'getPageBySlug']);
    Route::post('subscribe', [App\Http\Controllers\API\Tenant\HomeController::class, 'storeSubscriberEmail']);
    Route::post('save-order', [App\Http\Controllers\API\Tenant\HomeController::class, 'saveOrder']);
    Route::post('contact-info', [App\Http\Controllers\API\Tenant\HomeController::class, 'storeContactInfo']);
    Route::post('reservation', [App\Http\Controllers\API\Tenant\HomeController::class, 'storeReservationInfo']);
    Route::post('stock-check', [App\Http\Controllers\API\Tenant\HomeController::class, 'storeStockCheck']);
    Route::get('/settings', [App\Http\Controllers\API\Tenant\SettingController::class, 'index']);
    Route::get('/email-setting', [App\Http\Controllers\API\Tenant\SettingController::class, 'email_index']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/dashboard/home', [TenantDashboardController::class, 'index']);
        Route::get('/notifications', [TenantDashboardController::class, 'getNotifications']);
        Route::post('/notifications/{id}/read', [TenantDashboardController::class, 'markNotificationRead']);
        Route::post('/notifications/mark-all-read', [TenantDashboardController::class, 'markAllNotificationsRead']);
        Route::get('/cms_menu/menus', [CmsMenuController::class, 'getMenus']);
        Route::apiResource('cms_menu', CmsMenuController::class);
        Route::post('/cms_menu/reorder', [CmsMenuController::class, 'reorder']);
        Route::delete('/cms_menu/{id}/force', [CmsMenuController::class, 'forceDelete']);
        Route::post('/cms_menu/{id}/restore', [CmsMenuController::class, 'restore']);
        Route::post('/cms_menu/upload-image', [CmsMenuController::class, 'uploadImage']);

        // Booking Routes
        Route::get('/reservations-list', [TenantBookingController::class, 'showReservationInfo']);
        Route::get('/contacts-list', [TenantBookingController::class, 'showContactInfo']);
        Route::get('/subscribers-list', [TenantBookingController::class, 'showSubscriberEmail']);

        // Settings Routes
        Route::put('/settings', [App\Http\Controllers\API\Tenant\SettingController::class, 'update']);
        Route::put('/settings/discount', [App\Http\Controllers\API\Tenant\SettingController::class, 'updateDiscount']);
        Route::post('/upload-pdf', [TenantPdfUpload::class, 'upload']);
        Route::get('/pdfs', [TenantPdfUpload::class, 'list']);
        Route::delete('/pdfs/{id}', [TenantPdfUpload::class, 'delete']);

        Route::put('/email-setting', [App\Http\Controllers\API\Tenant\SettingController::class, 'save_email_setting']);
        Route::post('/upload-logo', [App\Http\Controllers\API\Tenant\SettingController::class, 'uploadLogo']);

        // Roles
        Route::get('permissions', [TenantRoleController::class, 'permissions']);
        Route::get('/roles', [TenantRoleController::class, 'index']);
        Route::post('/roles', [TenantRoleController::class, 'store']);
        Route::put('/roles/{role}', [TenantRoleController::class, 'update']);
        Route::delete('/roles/{role}', [TenantRoleController::class, 'destroy']);

        // Users
        Route::get('/users', [TenantUserController::class, 'index']);
        Route::post('/users', [TenantUserController::class, 'store']);
        Route::put('/users/{user}', [TenantUserController::class, 'update']);
        Route::delete('/users/{user}', [TenantUserController::class, 'destroy']);

        // Categories
        Route::get('/categories', [TenantCategoryController::class, 'index']);
        Route::post('/categories', [TenantCategoryController::class, 'store']);
        Route::post('/categories/{id}/restore', [TenantCategoryController::class, 'restore']);
        Route::put('/categories/{category}', [TenantCategoryController::class, 'update']);
        Route::delete('/categories/{category}', [TenantCategoryController::class, 'destroy']);
        Route::post('/categories/reorder', [TenantCategoryController::class, 'reorder']);

        // Products
        Route::get('/products', [TenantProductController::class, 'index']);
        Route::post('/products', [TenantProductController::class, 'store']);
        Route::put('/products/{product}', [TenantProductController::class, 'update']);
        Route::delete('/products/{product}', [TenantProductController::class, 'destroy']);
        Route::post('/products/{id}/restore', [TenantProductController::class, 'restore']);
        Route::post('/products/reorder', [TenantProductController::class, 'reorder']);

        // customers
        Route::get('/customers', [TenantCustomerController::class, 'index']);
        Route::get('/orders', [TenantOrderController::class, 'index']);
        Route::get('/stock-check-reqs', [TenantStockCheckController::class, 'index']);
        Route::get('/orders/{id}/status-change', [TenantOrderController::class, 'updateStatus']);
        // Authenticated tenant user info for dashboard auth check
        Route::get('/user', function (Request $request) {
            return response()->json("Saan");
        });
        Route::get('/auth-info', function () {
            $user = auth()->user();
            dd(auth()->user());
            return response()->json("Saan");
        });
        Route::get('/auth-check', function () {
            $user = Auth::user();
            Log::info("user is:" . $user);

            $roles = $user->getRoleNames();
            Log::info("roles are:" . $roles);
            $roleName = $roles->first();
            $formattedRoleName = ucwords(str_replace('_', ' ', $roleName));

            Log::info("Role Name is:" . $roleName);
            return response()->json([
                'authenticated' => $user ? true : false,
                'user' => $user,
                'role_name' => $formattedRoleName
            ]);
        });
        Route::post('/logout', function (Request $request) {
            $request->user()->currentAccessToken()->delete();
            Log::info("Logged out successfully");
            return response()->json(['message' => 'Logged out successfully']);
        });
    });
});

