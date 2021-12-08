<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Agendamento;
use App\Models\User;
use App\Models\Lote;

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
                'V' => "Aprovado",
                'E' => "Recusado"
            ]);

            $view->with("lote_status", [
                Lote::STATUS_RESERVED => 'Reservado',
                Lote::STATUS_AVAILABLE => 'Disponível',
                Lote::STATUS_SOLD => 'Vendido',
                Lote::STATUS_CANCELED => 'Cancelado',
            ]);

            $view->with("formas_pagamento", [
                'cheque' => 'Cheque',
                'fatura_cartao' => 'Fatura Cartão',
                'carne' => 'Carnê'
            ]);

            $contas_pendentes = User::where("status", User::STATUS_EMESPERA)->count();
            $view->with("contas_pendentes", $contas_pendentes);
            
            $agendamentos_pendentes = Agendamento::where("status", Agendamento::STATUS_EMESPERA)->where('type', Agendamento::TYPE_VISITA)->count();
            $view->with("agendamentos_pendentes", $agendamentos_pendentes);

            // $estadosBrasileiros = array(
            //     'AC'=>'Acre',
            //     'AL'=>'Alagoas',
            //     'AP'=>'Amapá',
            //     'AM'=>'Amazonas',
            //     'BA'=>'Bahia',
            //     'CE'=>'Ceará',
            //     'DF'=>'Distrito Federal',
            //     'ES'=>'Espírito Santo',
            //     'GO'=>'Goiás',
            //     'MA'=>'Maranhão',
            //     'MT'=>'Mato Grosso',
            //     'MS'=>'Mato Grosso do Sul',
            //     'MG'=>'Minas Gerais',
            //     'PA'=>'Pará',
            //     'PB'=>'Paraíba',
            //     'PR'=>'Paraná',
            //     'PE'=>'Pernambuco',
            //     'PI'=>'Piauí',
            //     'RJ'=>'Rio de Janeiro',
            //     'RN'=>'Rio Grande do Norte',
            //     'RS'=>'Rio Grande do Sul',
            //     'RO'=>'Rondônia',
            //     'RR'=>'Roraima',
            //     'SC'=>'Santa Catarina',
            //     'SP'=>'São Paulo',
            //     'SE'=>'Sergipe',
            //     'TO'=>'Tocantins'
            //     );
            // $view->with('ufs', $estadosBrasileiros);

        });
    }
}
