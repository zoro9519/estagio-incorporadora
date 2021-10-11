<?php

use App\Helpers\ResponseHelper;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoteamentoController;
use App\Http\Controllers\User\AuthController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


        /**
         *          ROTAS
         * 
         *          ADMIN
         */
// Admin
Route::prefix("admin")->group(function(){

    // Auth related 
    Route::prefix("auth")->group(function() {
        Route::get("/", [\App\Http\Controllers\Admin\AuthController::class, "index"])->name("admin.auth");
        Route::get("remember", [\App\Http\Controllers\Admin\AuthController::class, "remember"])->name("admin.auth.remember");
        Route::post("login", [\App\Http\Controllers\Admin\AuthController::class, "login"])->name("admin.auth.login");
        Route::post("store", [\App\Http\Controllers\Admin\AuthController::class, "store"])->name("admin.auth.store");
        Route::post("forgot", [\App\Http\Controllers\Admin\AuthController::class, "forgot"])->name("admin.auth.forgot");
        Route::post("reset", [\App\Http\Controllers\Admin\AuthController::class, "reset"])->name("admin.auth.reset");
    });
});

Route::middleware('auth:admin')->group(function () {
    Route::prefix("admin")->group(function(){
        Route::get("auth/logout", [\App\Http\Controllers\Admin\AuthController::class, "logout"])->name("admin.auth.logout");
        Route::get("/", [AdminController::class, 'index'])->name("admin.home");
    
        // Admin / Loteamentos
        Route::prefix("loteamentos")->group(function() {
            Route::get("/", [\App\Http\Controllers\Admin\LoteamentoController::class, 'all'])->name("admin.loteamentos.all");
            Route::get("{loteamento}", [\App\Http\Controllers\Admin\LoteamentoController::class, 'show'])->name("admin.loteamentos.show");
            Route::post("store", [\App\Http\Controllers\Admin\LoteamentoController::class, 'store'])->name("admin.loteamentos.store");

            Route::post("{loteamento}/updateLocation", [\App\Http\Controllers\Admin\LoteamentoController::class, 'updateLocation'])->name("admin.loteamentos.updateLocation");

            Route::post("{loteamento}/landing/update", [\App\Http\Controllers\Admin\LoteamentoController::class, 'updateLandingPage'])->name("admin.loteamentos.editLandingLayout");
            Route::post("{loteamento}/landing/uploadFile", [\App\Http\Controllers\Admin\LoteamentoController::class, 'uploadFile'])->name("admin.loteamentos.uploadFile");
            Route::get("{loteamento}/landing/uploadFile", [\App\Http\Controllers\Admin\LoteamentoController::class, 'uploadFile'])->name("admin.loteamentos.uploadFile");
            
        });

        // Admin / Quadras
        Route::prefix("quadras")->group(function() {

            // Embutida em loteamento.show
            // Route::get("/", [\App\Http\Controllers\Admin\QuadraController::class, 'all'])->name("admin.quadras.all");

            Route::get("{quadra}", [\App\Http\Controllers\Admin\QuadraController::class, 'show'])->name("admin.quadras.show");

            Route::post("/store", [\App\Http\Controllers\Admin\QuadraController::class, 'store'])->name("admin.quadras.store");;

            Route::get("/delete/{quadra}", [\App\Http\Controllers\Admin\QuadraController::class, 'destroy'])->name("admin.quadras.delete");

        });

        // Admin / Lotes
        Route::prefix("lotes")->group(function() {

            // Embutida em loteamento.show
            // Route::get("/", [\App\Http\Controllers\Admin\QuadraController::class, 'all'])->name("quadra.all");

            Route::get("{lote}", [\App\Http\Controllers\Admin\LoteController::class, 'show'])->name("admin.lotes.show");

            Route::post("store", [\App\Http\Controllers\Admin\LoteController::class, 'store'])->name("admin.lotes.store");

            Route::post("vender/{lote}", [\App\Http\Controllers\Admin\LoteController::class, 'vender'])->name("admin.lotes.vender");
            
            Route::get("/delete/{lote}", [\App\Http\Controllers\Admin\LoteController::class, 'destroy'])->name("admin.lotes.delete");

            Route::post("{lote}/adicionar_proprietario", [\App\Http\Controllers\Admin\LoteController::class, 'adicionarProprietario'])->name("admin.lotes.adicionar_proprietario");
    
        });

        // Admin / Proprietarios
        Route::prefix("proprietarios")->group(function() {

            Route::get("/lote/{lote}", [\App\Http\Controllers\Admin\ProprietarioController::class, 'show'])->name("admin.proprietarios.byLote");
            Route::get("{proprietario}", [\App\Http\Controllers\Admin\ProprietarioController::class, 'show'])->name("admin.proprietarios.show");

            // Route::post("store", [\App\Http\Controllers\Admin\ProprietarioController::class, 'store'])->name("admin.proprietarios.store");
            
            Route::get("/delete/{proprietario}", [\App\Http\Controllers\Admin\LoteController::class, 'removerProprietario'])->name("admin.proprietarios.remove");
            Route::post("{lote}/adicionar_proprietario", [\App\Http\Controllers\Admin\LoteController::class, 'adicionarProprietario'])->name("admin.lotes.adicionar_proprietario");
        });

        Route::prefix("assets")->group(function(){
            Route::get("{asset}/delete", [\App\Http\Controllers\AssetController::class, 'destroy'])->name("asset.delete");
        });

        // Admin / Imobiliarias
        Route::prefix("imobiliarias")->group(function() {
            Route::get("/", [\App\Http\Controllers\Admin\ImobiliariaController::class, 'all'])->name("admin.imobiliarias.all");
            Route::get("{imobiliaria}", [\App\Http\Controllers\Admin\ImobiliariaController::class, 'show'])->name("admin.imobiliarias.show");
            Route::post("store", [\App\Http\Controllers\Admin\ImobiliariaController::class, 'store'])->name("admin.imobiliarias.store");

            Route::get("/delete/{imobiliaria}", [\App\Http\Controllers\Admin\ImobiliariaController::class, 'destroy'])->name("admin.imobiliarias.delete");
            // Route::post("/favorite/{product}", [ProductController::class, 'setFavorite']);
    
            // Route::get("/actives", [ProductController::class, 'actives']);
            // Route::post("/active/{product}", [ProductController::class, 'setActive']);
        });
        // Route::prefix("imobiliarias")->group(function() {
        //     Route::get("/", [ImobiliariaController::class, "all"])->name("imobiliaria.all");
        // });

        // Admin / Corretores
        Route::prefix("corretores")->group(function() {
            Route::get("/", [\App\Http\Controllers\Admin\CorretorController::class, 'all'])->name("admin.corretores.all");
            Route::get("{corretor}", [\App\Http\Controllers\Admin\CorretorController::class, 'show'])->name("admin.corretores.show");
            Route::post("store", [\App\Http\Controllers\Admin\CorretorController::class, 'store'])->name("admin.corretores.store");
            Route::get("/delete/{corretor}", [\App\Http\Controllers\Admin\CorretorController::class, 'destroy'])->name("admin.corretores.delete");
        });
        // Route::prefix("corretores")->group(function() {
        //     Route::get("/", [CorretorController::class, "all"])->name("corretor.all");
        // });

    
        // Handle user notifications
        Route::prefix("users")->group(function() {
            Route::get("/", [App\Http\Controllers\Admin\UserController::class, "all"])->name("admin.users.all");
            Route::get("{user}", [App\Http\Controllers\Admin\UserController::class, "show"])->name("admin.users.show");
            Route::get("aprovar/{user}", [App\Http\Controllers\Admin\UserController::class, "aprovar"])->name("admin.users.aprovar");
        });

        Route::prefix("agendamentos")->group(function() {
            Route::get("/", [App\Http\Controllers\Admin\AgendamentoController::class, "all"])->name("admin.agendamentos.all");
            Route::get("{agendamento}", [App\Http\Controllers\Admin\AgendamentoController::class, "show"])->name("admin.agendamentos.show");
            Route::post("/", [App\Http\Controllers\Admin\AgendamentoController::class, "all"])->name("admin.agendamentos.all");
            Route::post("/{agendamento}/changeStatus", [App\Http\Controllers\Admin\AgendamentoController::class, "changeStatus"])->name("admin.agendamentos.changeStatus");
            Route::post("/{agendamento}/setCorretor/{id_corretor}", [App\Http\Controllers\Admin\AgendamentoController::class, "setCorretor"])->name("admin.agendamentos.setCorretor");
            Route::post("update/{agendamento}", [App\Http\Controllers\Admin\AgendamentoController::class, "update"])->name("admin.agendamentos.update");
        });

        Route::prefix("vendas")->group(function() {
            Route::get("/", [App\Http\Controllers\Admin\VendaController::class, "all"])->name("admin.vendas.all");
            Route::get("{venda}", [App\Http\Controllers\Admin\VendaController::class, "show"])->name("admin.vendas.show");
        });
        
    });

});

Route::prefix("user")->group(function(){

    // Auth related 
    Route::prefix("auth")->group(function() {
        Route::get("/", [AuthController::class, "index"])->name("user.auth");
        Route::get("remember", [AuthController::class, "remember"])->name("user.auth.remember");
        Route::post("login", [AuthController::class, "login"])->name("user.auth.login");
        Route::post("register", [AuthController::class, "register"]);
        Route::post("forgot", [AuthController::class, "forgot"]);
        Route::post("reset", [AuthController::class, "reset"]);
    });
    
    // Auth is mandatory
    Route::middleware('auth:sanctum')->group(function () {

        Route::get('user', [AuthController::class, "user"]);
        Route::post('logout', [AuthController::class, "logout"]);
    
        Route::resource('subscriptions', SubscriptionController::class, [
            'except' => ['edit', 'show', 'create']
        ]);
    
        Route::resource('transactions', TransactionController::class, [
            'except' => ['edit', 'show', 'create']
        ]);
    
        Route::prefix("products")->group(function() {
            Route::get("/favorites", [ProductController::class, 'favorites']);
            Route::post("/favorite/{product}", [ProductController::class, 'setFavorite']);
    
            Route::get("/actives", [ProductController::class, 'actives']);
            Route::post("/active/{product}", [ProductController::class, 'setActive']);
        });
        Route::resource('products', ProductController::class, [
            'except' => ['edit', 'show', 'store', 'create', 'update', 'destroy']
        ]);
    
        // Handle user notifications
        Route::prefix("notifications")->group(function() {
            Route::get("read/{notification}", \App\Http\Controllers\NotificationController::class . "@setRead");
            Route::get("unread", [NotificationController::class, "unread"]);
        });
        Route::resource('notifications', NotificationController::class, [
            'except' => ['create', 'destroy', 'store']
        ]);
    
        /**
         *          ROTAS
         * 
         *          ADMIN
         */
    
        Route::middleware('admin_auth')->prefix("admin")->group(function() {
            Route::resource("plans", \App\Http\Controllers\Admin\PlanController::class, [
                'except' => ['create', 'destroy', 'edit']
            ]);
            
            Route::resource("users", \App\Http\Controllers\Admin\UserController::class, [
                'except' => [ 'create', 'store', 'destroy', 'edit']
            ]);
            // Support routes for handle the user behavior
            Route::prefix("users")->group(function() {
                Route::post("toggleActive/{user}", [\App\Http\Controllers\Admin\UserController::class, "toggleActive"]);
                Route::post("toggleAdmin/{user}", [\App\Http\Controllers\Admin\UserController::class, "toggleAdmin"]);
            });
        
        
            Route::prefix("subscriptions")->group(function() {
                Route::post("cancel/{subscription}", [\App\Http\Controllers\Admin\SubscriptionController::class, "cancel"]);
            });
            Route::resource("subscriptions", \App\Http\Controllers\Admin\SubscriptionController::class);
        });
        
    
    });

    // Auth is not mandatory
    // Category
    // Route::get('/categories', [CategoryController::class,'index']);
    
    // Product
    // Route::get('/products', [ProductController::class,'index']);
    
    // Plan
    // Route::get('/plans', [PlanController::class,'index']);
    
});


// Rotas úteis para API pública
// Search user
Route::post("users/search", [\App\Http\Controllers\UserController::class, 'search']);
Route::get("corretores/{imobiliaria_id?}", [\App\Http\Controllers\CorretorController::class, 'index']);


Route::any('{loteamento:link}', [\App\Http\Controllers\LoteamentoController::class, 'show'])->name("landing.view");
Route::post('{loteamento:link}/save', [\App\Http\Controllers\NewsletterMemberController::class, 'registerMember'])->name("landing.save");

// Route::any('{url}', function(){
//     return ResponseHelper::error(__('Página não encontrada'), 404, []);
// })->where("url");

// Route::get('/', function(){
//     return ResponseHelper::success(
//         [ 
//             'app_name' => env("APP_NAME")
//         ], 
//         __('Bem vindo (a)')
//     );
// });