<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Stancl\Tenancy\Resolvers\DomainTenantResolver;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\TenantRegistrationController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\RoleController;
use App\Http\Controllers\SuperAdmin\TenantController;
use App\Http\Controllers\SuperAdmin\TenantDashboardController;
use App\Http\Controllers\SuperAdmin\TenantProfileController;
use App\Http\Controllers\SuperAdmin\TenantSubscriptionController;
use App\Http\Controllers\SuperAdmin\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
// routes/web.php

// Route::middleware([
//     // Apply tenancy only if tenant exists
//     \Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class,
// ])->group(function () {


//     if (! tenancy()->initialized) {
//         Route::get('/{any}', function () {
//             return view('app'); // Your Vue SPA entry
//         })->where('any', '.*');
//     }
// });
    Route::middleware(['web'])->group(function () {
        Route::get('/login', fn() => view('app'))->name('login');
        Route::get('/{any}', fn() => view('app'))->where('any', '.*');
    });
