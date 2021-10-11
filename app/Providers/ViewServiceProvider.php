<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function($view) {
            $view->with("agendamento_status", [
                'A' => "Agendado",
                'C' => "Cancelado",
                'E' => "Aguardando decisão do admin",
                'N' => "Negado pelo admin",
                'R' => "Realizado"
                // A - Agendado, C - Cancelado, E - Esperando aprovação admin, N - Negado pelo admin, R - Realizado
            ]);

            $view->with("user_status", [
                'A' => "Aguardando Admin",
                'V' => "Cadastro Preenchido",
                // 'E' => "Aguardando decisão do admin",
                // 'N' => "Negado pelo admin",
                // 'R' => "Realizado"
                // A - Agendado, C - Cancelado, E - Esperando aprovação admin, N - Negado pelo admin, R - Realizado
            ]);

        });
    }
}
