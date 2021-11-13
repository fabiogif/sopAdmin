<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ACL\PermissionController;
use App\Http\Controllers\Admin\ACL\ProfileController;
use App\Http\Controllers\Admin\ACL\RoleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\IssuingController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\TenantController;
use App\Http\Controllers\Admin\OccurrencesController;
use App\Http\Controllers\Admin\TypeOccurrenceController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();

Route::get('/login', [App\Http\Controllers\HomeController::class, 'index'])->name('login');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')
    ->namespace('')
    ->middleware('auth')
    ->group(function () {

        //Route::get('/teste', function () {});

        //Role X User
        Route::get('/users/{id}/roles/{idRole}/detach', [App\Http\Controllers\Admin\ACL\RoleUserController::class, 'detachRoleUser'])->name('users.role.detach');
        Route::post('/users/{id}/roles', [App\Http\Controllers\Admin\ACL\RoleUserController::class, 'attachRolesUser'])->name('users.roles.attach');
        Route::any('/users/{id}/roles/create', [App\Http\Controllers\Admin\ACL\RoleUserController::class, 'rolesAvailable'])->name('users.roles.available');
        Route::get('/users/{id}/roles', [App\Http\Controllers\Admin\ACL\RoleUserController::class, 'roles'])->name('users.roles');
        Route::get('/roles/{id}/users', [App\Http\Controllers\Admin\ACL\RoleUserController::class, 'users'])->name('roles.users');

        //Table - Mesas
        Route::any('tables/search', [App\Http\Controllers\Admin\TableController::class, 'search'])->name('tables.search');
        Route::resource('tables', TableController::class);


        //Categorias
        Route::any('categories/search', [App\Http\Controllers\Admin\CategoryController::class, 'search'])->name('categories.search');
        Route::resource('categories', CategoryController::class);


        //Produtos
        Route::any('products/search', [App\Http\Controllers\Admin\ProductController::class, 'search'])->name('products.search');
        Route::resource('products', ProductController::class);

        //Usuário
        Route::any('users/search', [App\Http\Controllers\Admin\UserController::class, 'search'])->name('users.search');
        Route::resource('users', UserController::class);

        //tenants -Empresa
        Route::any('tenants/search', [App\Http\Controllers\Admin\TenantController::class, 'search'])->name('tenants.search');
        Route::resource('tenants', TenantController::class);


        //Role - Cargo
        Route::any('roles/search', [App\Http\Controllers\Admin\ACL\RoleController::class, 'search'])->name('roles.search');
        Route::resource('roles', RoleController::class);


        //Permissão - Role
        Route::get('/roles/{id}/permission/{idPermission}/detach', [App\Http\Controllers\Admin\ACL\PermissionRoleController::class, 'detachPermissionRole'])->name('roles.permissions.detach');
        Route::post('/roles/{id}/permission/store', [App\Http\Controllers\Admin\ACL\PermissionRoleController::class, 'attachPermissionRole'])->name('roles.permissions.attach');
        Route::any('/roles/{id}/permission/create', [App\Http\Controllers\Admin\ACL\PermissionRoleController::class, 'permissionsAvailable'])->name('roles.permissions.available');
        Route::get('/roles/{id}/permission', [App\Http\Controllers\Admin\ACL\PermissionRoleController::class, 'permissions'])->name('roles.permissions');
        Route::get('/permission/{id}/roles', [App\Http\Controllers\Admin\ACL\PermissionRoleController::class, 'roles'])->name('permission.roles');



        //Permissão X Perfil
        Route::get('/plans/{id}/profiles/{idProfile}/detach', [App\Http\Controllers\Admin\ACL\PlanProfileController::class, 'detachPlanProfile'])->name('plans.profile.detach');
        Route::post('/plans/{id}/profiles', [App\Http\Controllers\Admin\ACL\PlanProfileController::class, 'attachProfilesPlan'])->name('plans.profiles.attach');
        Route::any('/plans/{id}/profiles/create', [App\Http\Controllers\Admin\ACL\PlanProfileController::class, 'profilesAvailable'])->name('plans.profiles.available');
        Route::get('/plans/{id}/profiles', [App\Http\Controllers\Admin\ACL\PlanProfileController::class, 'profiles'])->name('plans.profiles');
        Route::get('/profiles/{id}/plans', [App\Http\Controllers\Admin\ACL\PlanProfileController::class, 'plans'])->name('profiles.plans');

        //DetailsPlans
        Route::delete('plans/{id}/details/{idDetails}', [App\Http\Controllers\Admin\DetailPlanController::class, 'destroy'])->name('details.plans.delete');
        Route::get('plans/{id}/details/create', [App\Http\Controllers\Admin\DetailPlanController::class, 'create'])->name('details.plans.create');
        Route::get('plans/{id}/details/{idDetails}', [App\Http\Controllers\Admin\DetailPlanController::class, 'show'])->name('details.plans.show');
        Route::put('plans/{id}/details/{idPlan}', [App\Http\Controllers\Admin\DetailPlanController::class, 'update'])->name('details.plans.update');
        Route::get('plans/{id}/details/{idPlan}/edit', [App\Http\Controllers\Admin\DetailPlanController::class, 'edit'])->name('details.plans.edit');
        Route::post('plans/{id}/details', [App\Http\Controllers\Admin\DetailPlanController::class, 'store'])->name('details.plans.store');
        Route::get('plans/{id}/details', [App\Http\Controllers\Admin\DetailPlanController::class, 'index'])->name('details.plans.index');


        //Planos
        Route::get('/plans/create', [App\Http\Controllers\Admin\PlanController::class, 'create'])->name('plans.create');
        Route::any('/plans/search', [App\Http\Controllers\Admin\PlanController::class, 'search'])->name('plans.search');
        Route::post('/plans', [App\Http\Controllers\Admin\PlanController::class, 'store'])->name('plans.store');
        Route::get('/plans/{id}', [App\Http\Controllers\Admin\PlanController::class, 'show'])->name('plans.show');
        Route::delete('/plans/{id}', [App\Http\Controllers\Admin\PlanController::class, 'destroy'])->name('plans.destroy');
        Route::put('/plans/{id}', [App\Http\Controllers\Admin\PlanController::class, 'update'])->name('plans.update');
        Route::get('/plans', [App\Http\Controllers\Admin\PlanController::class, 'index'])->name('plans.index');
        Route::get('/plans/{id}/edit', [App\Http\Controllers\Admin\PlanController::class, 'edit'])->name('plans.edit');

        //Perfis
        Route::any('/profiles/search', [App\Http\Controllers\Admin\ACL\ProfileController::class, 'search'])->name('profiles.search');
        Route::resource('profiles', ProfileController::class);

        //Perfil x Permissão
        Route::get('/profiles/{id}/permission/{idPermission}/detach', [App\Http\Controllers\Admin\ACL\PermissionProfileController::class, 'detachPermissionProfile'])->name('profiles.permissions.detach');
        Route::post('/profiles/{id}/permission/store', [App\Http\Controllers\Admin\ACL\PermissionProfileController::class, 'attachPermissionProfile'])->name('profiles.permissions.attach');
        Route::any('/profiles/{id}/permission/create', [App\Http\Controllers\Admin\ACL\PermissionProfileController::class, 'permissionsAvailable'])->name('profiles.permissions.available');
        Route::get('/profiles/{id}/permission', [App\Http\Controllers\Admin\ACL\PermissionProfileController::class, 'permissions'])->name('profiles.permissions');
        Route::get('/permission/{id}/profiles', [App\Http\Controllers\Admin\ACL\PermissionProfileController::class, 'profiles'])->name('permission.profiles');


        //Permissão
        Route::any('/permission/search', [App\Http\Controllers\Admin\ACL\PermissionController::class, 'search'])->name('permission.search');
        Route::resource('permission', PermissionController::class);
        //Home
        Route::get('/', [App\Http\Controllers\Admin\PlanController::class, 'index'])->name('admin.index');
        //Ocorrencias
        Route::any('/occurrences/search', [App\Http\Controllers\Admin\ACL\OccurrencesController::class, 'search'])->name('occurrences.search');
        Route::resource('occurrences', OccurrencesController::class);

        //Tipo de ocorrencia
        Route::any('/typeOccurrences/search', [App\Http\Controllers\Admin\TypeOccurrenceController::class, 'search'])->name('typeOccurrences.search');
        Route::resource('typeOccurrences', TypeOccurrenceController::class);

        //Orgão
        Route::any('/issuings/search', [App\Http\Controllers\Admin\IssuingController::class, 'search'])->name('issuings.search');
        Route::resource('issuings', IssuingController::class);
    });


Route::get('/plan/{id}', [App\Http\Controllers\Site\SiteController::class, 'plan'])->name('plan.subscription');
Route::get('/', [App\Http\Controllers\Site\SiteController::class, 'index'])->name('site.home');


/*Route::get('/home', function () {
    return view('home');
})->name('home')->middleware('auth');
*/

Auth::routes();
