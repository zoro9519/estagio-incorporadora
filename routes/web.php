<?php

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoteamentoController;
use App\Http\Controllers\NewsletterController;
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
    return view('user.auth');
    // return view('welcome');
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
            Route::post("/", [\App\Http\Controllers\Admin\LoteamentoController::class, 'store'])->name("admin.loteamentos.store");

            Route::get("{loteamento}", [\App\Http\Controllers\Admin\LoteamentoController::class, 'show'])->name("admin.loteamentos.show");
            Route::get("{loteamento}/edit", [\App\Http\Controllers\Admin\LoteamentoController::class, 'edit'])->name("admin.loteamentos.edit");
            Route::post("{loteamento}/update", [\App\Http\Controllers\Admin\LoteamentoController::class, 'update'])->name("admin.loteamentos.update");

            Route::post("{loteamento}/updateLocation", [\App\Http\Controllers\Admin\LoteamentoController::class, 'updateLocation'])->name("admin.loteamentos.updateLocation");

            Route::post("{loteamento}/landing/update", [\App\Http\Controllers\Admin\LoteamentoController::class, 'updateLandingPage'])->name("admin.loteamentos.editLandingLayout");
            Route::post("{loteamento}/landing/uploadFile", [\App\Http\Controllers\Admin\LoteamentoController::class, 'uploadFile'])->name("admin.loteamentos.uploadFile");
            Route::get("{loteamento}/landing/uploadFile", [\App\Http\Controllers\Admin\LoteamentoController::class, 'uploadFile'])->name("admin.loteamentos.uploadFile");
            
        });

        // Admin / Quadras
        Route::prefix("quadras")->group(function() {

            // Embutida em loteamento.show
            // Route::get("/", [\App\Http\Controllers\Admin\QuadraController::class, 'all'])->name("admin.quadras.all");
            Route::post("/", [\App\Http\Controllers\Admin\QuadraController::class, 'store'])->name("admin.quadras.store");;

            Route::get("{quadra}", [\App\Http\Controllers\Admin\QuadraController::class, 'show'])->name("admin.quadras.show");

            Route::post("{quadra}/update", [\App\Http\Controllers\Admin\QuadraController::class, 'update'])->name("admin.quadras.update");

            Route::get("{quadra}/delete", [\App\Http\Controllers\Admin\QuadraController::class, 'destroy'])->name("admin.quadras.delete");

        });

        // Admin / Lotes
        Route::prefix("lotes")->group(function() {

            // Embutida em loteamento.show
            // Route::get("/", [\App\Http\Controllers\Admin\QuadraController::class, 'all'])->name("quadra.all");

            Route::post("/", [\App\Http\Controllers\Admin\LoteController::class, 'store'])->name("admin.lotes.store");

            Route::get("{lote}", [\App\Http\Controllers\Admin\LoteController::class, 'show'])->name("admin.lotes.show");

            Route::post("{lote}/update", [\App\Http\Controllers\Admin\LoteController::class, 'update'])->name("admin.lotes.update");
            
            Route::get("{lote}/delete", [\App\Http\Controllers\Admin\LoteController::class, 'destroy'])->name("admin.lotes.delete");
            
            Route::post("{lote}/reservar", [\App\Http\Controllers\Admin\LoteController::class, 'reservar'])->name("admin.lotes.reservar");
            Route::post("{lote}/liberar", [\App\Http\Controllers\Admin\LoteController::class, 'liberar'])->name("admin.lotes.liberar");

            // Admin / Proprietarios
            Route::prefix("{lote}/proprietarios")->group(function() {
                Route::get("/", [\App\Http\Controllers\Admin\ProprietarioController::class, 'index'])->name("admin.lotes.proprietarios.index");

                Route::post("/", [\App\Http\Controllers\Admin\ProprietarioController::class, 'store'])->name("admin.lotes.proprietarios.store");

                Route::get("{proprietario}", [\App\Http\Controllers\Admin\ProprietarioController::class, 'show'])->name("admin.lotes.proprietarios.show");
                
                Route::get("{proprietario}/delete", [\App\Http\Controllers\Admin\ProprietarioController::class, 'destroy'])->name("admin.lotes.proprietarios.remove");

                Route::post("transferir", [\App\Http\Controllers\Admin\ProprietarioController::class, 'transferir'])->name("admin.lotes.proprietarios.transferir");
            });
        });

        Route::prefix("assets")->group(function(){
            Route::get("{asset}/delete", [\App\Http\Controllers\AssetController::class, 'destroy'])->name("asset.delete");
        });

        // Admin / Imobiliarias
        Route::prefix("imobiliarias")->group(function() {
            Route::get("/", [\App\Http\Controllers\Admin\ImobiliariaController::class, 'all'])->name("admin.imobiliarias.all");
            Route::post("/", [\App\Http\Controllers\Admin\ImobiliariaController::class, 'store'])->name("admin.imobiliarias.store");

            Route::get("{imobiliaria}", [\App\Http\Controllers\Admin\ImobiliariaController::class, 'show'])->name("admin.imobiliarias.show");
            Route::get("{imobiliaria}/edit", [\App\Http\Controllers\Admin\ImobiliariaController::class, 'edit'])->name("admin.imobiliarias.edit");
            Route::post("{imobiliaria}/update", [\App\Http\Controllers\Admin\ImobiliariaController::class, 'update'])->name("admin.imobiliarias.update");
            Route::get("{imobiliaria}/toggle-status", [\App\Http\Controllers\Admin\ImobiliariaController::class, 'toggleStatus'])->name("admin.imobiliarias.toggle-status");

            Route::get("{imobiliaria}/delete", [\App\Http\Controllers\Admin\ImobiliariaController::class, 'destroy'])->name("admin.imobiliarias.delete");
            
        });

        // Admin / Corretores
        Route::prefix("corretores")->group(function() {
            Route::get("/", [\App\Http\Controllers\Admin\CorretorController::class, 'all'])->name("admin.corretores.all");
            Route::post("/", [\App\Http\Controllers\Admin\CorretorController::class, 'store'])->name("admin.corretores.store");

            Route::get("{corretor}", [\App\Http\Controllers\Admin\CorretorController::class, 'show'])->name("admin.corretores.show");
            
            Route::get("{corretor}/edit", [\App\Http\Controllers\Admin\CorretorController::class, 'edit'])->name("admin.corretores.edit");
            Route::post("{corretor}/update", [\App\Http\Controllers\Admin\CorretorController::class, 'update'])->name("admin.corretores.update");
            
            Route::get("{corretor}/delete", [\App\Http\Controllers\Admin\CorretorController::class, 'destroy'])->name("admin.corretores.delete");
        });
    
        // Handle user notifications
        Route::prefix("users")->group(function() {
            Route::get("/", [App\Http\Controllers\Admin\UserController::class, "all"])->name("admin.users.all");
            Route::post("/", [App\Http\Controllers\Admin\UserController::class, "store"])->name("admin.users.store");
            Route::get("{user}", [App\Http\Controllers\Admin\UserController::class, "show"])->name("admin.users.show");
            Route::get("{user}/edit", [App\Http\Controllers\Admin\UserController::class, "edit"])->name("admin.users.edit");
            Route::get("{user}/aprovar", [App\Http\Controllers\Admin\UserController::class, "aprovar"])->name("admin.users.aprovar");
            Route::get("{user}/recusar", [App\Http\Controllers\Admin\UserController::class, "recusar"])->name("admin.users.recusar");
            Route::post("{user}/update", [App\Http\Controllers\Admin\UserController::class, "update"])->name("admin.users.update");
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
            Route::post("vender/{lote}", [\App\Http\Controllers\Admin\VendaController::class, 'store'])->name("admin.vendas.create");
        });
        
        Route::prefix('relatorios')->group(function() {

            Route::get('agendamentos', [App\Http\Controllers\Admin\RelatorioController::class, 'agendamentos'])->name('admin.relatorios.agendamentos');
            Route::get('lotes', [App\Http\Controllers\Admin\RelatorioController::class, 'lotes'])->name('admin.relatorios.lotes');
        });
    });

});

        /**
         *          ROTAS
         * 
         *          USER
         */

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
    Route::middleware('auth:web')->group(function () {

        Route::get("/", [\App\Http\Controllers\UserController::class, 'index'])->name("user.home");
        Route::get('user', [\App\Http\Controllers\User\AuthController::class, "user"]);
        Route::get('logout', [AuthController::class, "logout"])->name("user.auth.logout");
    
        
        Route::prefix("profile")->group(function() {
            Route::get("/", [\App\Http\Controllers\User\ProfileController::class, 'index'])->name("user.profile");
            Route::post("/", [\App\Http\Controllers\User\ProfileController::class, 'update'])->name("user.profile.update");
        });

        Route::prefix("agendamentos")->group(function() {
            Route::get("/", [\App\Http\Controllers\User\AgendamentoController::class, 'index'])->name("user.agendamentos");
            Route::get("{loteamento}", [\App\Http\Controllers\User\AgendamentoController::class, 'showMap'])->name("user.agendamentos.showMap");
            Route::get("{loteamento}/agenda/{lote?}", [\App\Http\Controllers\User\AgendamentoController::class, 'showAgenda'])->name("user.agendamentos.showAgenda");
            // Route::get("{loteamento}/{lote}/agenda", [\App\Http\Controllers\User\AgendamentoController::class, 'showAgenda'])->name("user.agendamentos.showLoteAgenda");
            // Route::get("agenda/{loteamento}", [\App\Http\Controllers\User\AgendamentoController::class, 'showAgenda'])->name("user.agendamentos.showAgenda");
            Route::get("create", [\App\Http\Controllers\User\AgendamentoController::class, 'create'])->name("user.home.criarAgendamento");
            Route::post("store", [\App\Http\Controllers\User\AgendamentoController::class, 'store'])->name("user.agendamentos.store");
            // Route::get("delete/{agendamento}", [\App\Http\Controllers\User\AgendamentoController::class, 'destroy'])->name("user.agendamentos.delete");
            Route::get("cancel/{agendamento}", [\App\Http\Controllers\User\AgendamentoController::class, 'cancel'])->name("user.agendamentos.cancel");
            Route::post("{agendamento}", [\App\Http\Controllers\User\AgendamentoController::class, 'show'])->name("user.agendamentos.show");

        });

        Route::prefix("loteamentos")->group(function() {
            Route::get("{loteamento}", [\App\Http\Controllers\User\LoteamentoController::class, "show"])->name("user.loteamentos.show");
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
Route::post('{loteamento:link}/save', [\App\Http\Controllers\NewsletterController::class, 'registerMember'])->name("landing.save");

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