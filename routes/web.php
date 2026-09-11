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

    /*
    |--------------------------------------------------------------------------
    | Routes Module Paie — auth + subscription
    |--------------------------------------------------------------------------
    */
    Route::prefix('paie')->name('paie.')->group(function () {
        // Dashboard
        Route::get('/', [\Src\Features\Paie\Presentation\Http\PaieDashboardController::class, 'index'])->name('dashboard');

        // Simulateur
        Route::get('/simulateur', function () {
            return view('paie.simulateur');
        })->name('simulateur');
        Route::post('/simulateur', [\Src\Features\Paie\Presentation\Http\PayslipController::class, 'simulate'])->name('simulateur.run');

        // Employés
        Route::get('/employes', [\Src\Features\Paie\Presentation\Http\EmployeeController::class, 'index'])->name('employees.index');
        Route::get('/employes/creer', [\Src\Features\Paie\Presentation\Http\EmployeeController::class, 'create'])->name('employees.create');
        Route::post('/employes', [\Src\Features\Paie\Presentation\Http\EmployeeController::class, 'store'])->name('employees.store');
        Route::get('/employes/{id}', [\Src\Features\Paie\Presentation\Http\EmployeeController::class, 'show'])->name('employees.show');
        Route::put('/employes/{id}', [\Src\Features\Paie\Presentation\Http\EmployeeController::class, 'update'])->name('employees.update');
        Route::delete('/employes/{id}', [\Src\Features\Paie\Presentation\Http\EmployeeController::class, 'destroy'])->name('employees.destroy');

        // Bulletins
        Route::get('/bulletins', [\Src\Features\Paie\Presentation\Http\PayslipController::class, 'index'])->name('payslips.index');
        Route::get('/bulletins/creer', [\Src\Features\Paie\Presentation\Http\PayslipController::class, 'create'])->name('payslips.create');
        Route::post('/bulletins', [\Src\Features\Paie\Presentation\Http\PayslipController::class, 'store'])->name('payslips.store');
        Route::get('/bulletins/{id}', [\Src\Features\Paie\Presentation\Http\PayslipController::class, 'show'])->name('payslips.show');
        Route::post('/bulletins/{id}/valider', [\Src\Features\Paie\Presentation\Http\PayslipController::class, 'validate'])->name('payslips.validate');
        Route::delete('/bulletins/{id}', [\Src\Features\Paie\Presentation\Http\PayslipController::class, 'destroy'])->name('payslips.destroy');

        // Congés
        Route::get('/conges', [\Src\Features\Paie\Presentation\Http\LeaveController::class, 'index'])->name('leaves.index');
        Route::get('/conges/creer', [\Src\Features\Paie\Presentation\Http\LeaveController::class, 'create'])->name('leaves.create');
        Route::post('/conges', [\Src\Features\Paie\Presentation\Http\LeaveController::class, 'store'])->name('leaves.store');
        Route::post('/conges/{id}/approuver', [\Src\Features\Paie\Presentation\Http\LeaveController::class, 'approve'])->name('leaves.approve');
        Route::delete('/conges/{id}', [\Src\Features\Paie\Presentation\Http\LeaveController::class, 'destroy'])->name('leaves.destroy');

        // Timesheets
        Route::get('/feuilles-temps', [\Src\Features\Paie\Presentation\Http\TimesheetController::class, 'index'])->name('timesheets.index');
        Route::get('/feuilles-temps/creer', [\Src\Features\Paie\Presentation\Http\TimesheetController::class, 'create'])->name('timesheets.create');
        Route::post('/feuilles-temps', [\Src\Features\Paie\Presentation\Http\TimesheetController::class, 'store'])->name('timesheets.store');
        Route::delete('/feuilles-temps/{id}', [\Src\Features\Paie\Presentation\Http\TimesheetController::class, 'destroy'])->name('timesheets.destroy');

        // Notes de frais
        Route::get('/frais', [\Src\Features\Paie\Presentation\Http\ExpenseController::class, 'index'])->name('expenses.index');
        Route::get('/frais/creer', [\Src\Features\Paie\Presentation\Http\ExpenseController::class, 'create'])->name('expenses.create');
        Route::post('/frais', [\Src\Features\Paie\Presentation\Http\ExpenseController::class, 'store'])->name('expenses.store');
        Route::post('/frais/{id}/approuver', [\Src\Features\Paie\Presentation\Http\ExpenseController::class, 'approve'])->name('expenses.approve');
        Route::delete('/frais/{id}', [\Src\Features\Paie\Presentation\Http\ExpenseController::class, 'destroy'])->name('expenses.destroy');

        // Départements
        Route::get('/departements', [\Src\Features\Paie\Presentation\Http\DepartmentController::class, 'index'])->name('departments.index');
        Route::post('/departements', [\Src\Features\Paie\Presentation\Http\DepartmentController::class, 'store'])->name('departments.store');
        Route::put('/departements/{id}', [\Src\Features\Paie\Presentation\Http\DepartmentController::class, 'update'])->name('departments.update');
        Route::delete('/departements/{id}', [\Src\Features\Paie\Presentation\Http\DepartmentController::class, 'destroy'])->name('departments.destroy');

        // Déclarations
        Route::get('/declarations', [\Src\Features\Paie\Presentation\Http\DeclarationController::class, 'index'])->name('declarations.index');
        Route::get('/declarations/cnps', [\Src\Features\Paie\Presentation\Http\DeclarationController::class, 'cnps'])->name('declarations.cnps');
        Route::get('/declarations/its', [\Src\Features\Paie\Presentation\Http\DeclarationController::class, 'its'])->name('declarations.its');
    });
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
