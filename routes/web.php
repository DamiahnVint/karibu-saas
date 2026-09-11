<?php

use Src\Features\Auth\Presentation\Http\AuthController;
use Src\Features\Auth\Presentation\Http\RegisterController;
use Src\Features\Auth\Presentation\Http\ForgotPasswordController;
use Src\Features\Auth\Presentation\Http\ResetPasswordController;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\AdminPlanController;
use App\Http\Controllers\AdminTenantController;
use App\Http\Controllers\CmsPageController;
use App\Http\Controllers\CmsFormController;
use App\Http\Controllers\Admin\CmsDashboardController;
use App\Http\Controllers\Admin\CmsPageController as AdminCmsPageController;
use App\Http\Controllers\Admin\CmsSettingController;
use App\Http\Controllers\Admin\CmsNavigationController;
use App\Http\Controllers\Admin\CmsMediaController;
use App\Http\Controllers\Admin\CmsFormController as AdminCmsFormController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes CMS — publiques
|--------------------------------------------------------------------------
*/
Route::get('/', [CmsPageController::class, 'home'])->name('landing');

/*
|--------------------------------------------------------------------------
| Routes CMS — formulaires publics
|--------------------------------------------------------------------------
*/
Route::post('/form/{type}', [CmsFormController::class, 'store'])->name('cms.form.store');
Route::get('/form/contact/merci', [CmsFormController::class, 'contactSuccess'])->name('cms.form.contact.success');
Route::get('/form/demo/merci', [CmsFormController::class, 'demoSuccess'])->name('cms.form.demo.success');

/*
|--------------------------------------------------------------------------
| Routes Pricing & Checkout
|--------------------------------------------------------------------------
*/
Route::get('/tarifs', [PricingController::class, 'index'])->name('pricing');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

/*
|--------------------------------------------------------------------------
| Routes Demo
|--------------------------------------------------------------------------
*/
Route::get('/demo', [DemoController::class, 'index'])->name('demo.index');
Route::post('/demo', [DemoController::class, 'store'])->name('demo.store');
Route::get('/demo/merci', [DemoController::class, 'success'])->name('demo.success');

/*
|--------------------------------------------------------------------------
| Routes Subscription (pages publiques)
|--------------------------------------------------------------------------
*/
Route::get('/subscription/expired', fn () => view('subscription.expired'))->name('subscription.expired');
Route::get('/subscription/blocked', fn () => view('subscription.blocked'))->name('subscription.blocked');

/*
|--------------------------------------------------------------------------
| Routes Auth — guest (rediriger si déjà connecté)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/orion/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/orion/login', [AuthController::class, 'login']);

    Route::get('/orion/register', [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/orion/register', [RegisterController::class, 'register']);

    Route::get('/orion/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');
    Route::post('/orion/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');

    Route::get('/orion/reset-password/{token}', [ResetPasswordController::class, 'showForm'])->name('password.reset');
    Route::post('/orion/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Routes Auth — authentifié
|--------------------------------------------------------------------------
*/
Route::post('/orion/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Routes Dashboard — auth + subscription
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'subscription'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/{slug}/dashboard', [DashboardController::class, 'index'])->name('tenant.dashboard');
});

/*
|--------------------------------------------------------------------------
| Routes Admin — super_admin only
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:super_admin'])->prefix('orion/admin')->name('admin.')->group(function () {
    // Plans
    Route::get('/plans', [AdminPlanController::class, 'index'])->name('plans.index');
    Route::get('/plans/{plan}/edit', [AdminPlanController::class, 'edit'])->name('plans.edit');
    Route::put('/plans/{plan}', [AdminPlanController::class, 'update'])->name('plans.update');
    Route::post('/plans/{plan}/toggle', [AdminPlanController::class, 'toggle'])->name('plans.toggle');

    // Tenants
    Route::get('/tenants', [AdminTenantController::class, 'index'])->name('tenants.index');
    Route::get('/tenants/{tenant}', [AdminTenantController::class, 'show'])->name('tenants.show');
    Route::patch('/tenants/{tenant}/status', [AdminTenantController::class, 'updateStatus'])->name('tenants.status');
    Route::post('/tenants/{tenant}/payment', [AdminTenantController::class, 'addPayment'])->name('tenants.payment');

    // CMS Dashboard
    Route::get('/cms', [CmsDashboardController::class, 'index'])->name('cms.dashboard');

    // CMS Pages
    Route::get('/cms/pages', [AdminCmsPageController::class, 'index'])->name('cms.pages.index');
    Route::post('/cms/pages', [AdminCmsPageController::class, 'store'])->name('cms.pages.store');
    Route::get('/cms/pages/{page}', [AdminCmsPageController::class, 'show'])->name('cms.pages.show');
    Route::put('/cms/pages/{page}', [AdminCmsPageController::class, 'update'])->name('cms.pages.update');
    Route::delete('/cms/pages/{page}', [AdminCmsPageController::class, 'destroy'])->name('cms.pages.destroy');

    // CMS Sections
    Route::post('/cms/pages/{page}/sections', [AdminCmsPageController::class, 'storeSection'])->name('cms.pages.sections.store');
    Route::put('/cms/pages/{page}/sections/{section}', [AdminCmsPageController::class, 'updateSection'])->name('cms.pages.sections.update');
    Route::delete('/cms/pages/{page}/sections/{section}', [AdminCmsPageController::class, 'destroySection'])->name('cms.pages.sections.destroy');

    // CMS Settings
    Route::get('/cms/settings', [CmsSettingController::class, 'index'])->name('cms.settings.index');
    Route::put('/cms/settings', [CmsSettingController::class, 'update'])->name('cms.settings.update');

    // CMS Navigation
    Route::get('/cms/navigation', [CmsNavigationController::class, 'index'])->name('cms.navigation.index');
    Route::put('/cms/navigation', [CmsNavigationController::class, 'update'])->name('cms.navigation.update');

    // CMS Media
    Route::get('/cms/media', [CmsMediaController::class, 'index'])->name('cms.media.index');
    Route::post('/cms/media', [CmsMediaController::class, 'store'])->name('cms.media.store');
    Route::delete('/cms/media/{media}', [CmsMediaController::class, 'destroy'])->name('cms.media.destroy');

    // CMS Forms
    Route::get('/cms/forms', [AdminCmsFormController::class, 'index'])->name('cms.forms.index');
    Route::get('/cms/forms/{submission}', [AdminCmsFormController::class, 'show'])->name('cms.forms.show');
    Route::patch('/cms/forms/{submission}/read', [AdminCmsFormController::class, 'markAsRead'])->name('cms.forms.read');
    Route::delete('/cms/forms/{submission}', [AdminCmsFormController::class, 'destroy'])->name('cms.forms.destroy');
});

/*
|--------------------------------------------------------------------------
| Routes CMS pages — catch-all À LA FIN, après toutes les routes spécifiques
|--------------------------------------------------------------------------
*/
Route::get('/{slug}', [CmsPageController::class, 'render'])
    ->where('slug', '[a-z0-9-]+')
    ->name('cms.page')
    ->withoutMiddleware([\App\Http\Middleware\VerifySubscription::class]);
