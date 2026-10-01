<?php
/**
 * Fabiano Gato
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 *
 * Não editar ou acrescentar à este arquivo se você quiser fazer o upgrade para versões
 * mais recentes no futuro.
 *****************************************************
 *
 * @copyright    Copyright (c) Fabiano Gato
 * @author       Fabiano Gato <fabianogattoti@gmail.com>
 *
 */
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Idea\Framework\Repository\Sales\SalesOrderRepository;

class Dashboard extends Controller
{

    public function index()
    {

        // Inicializa a Data para retornar os Pedidos
        $date = new \DateTime('now', new \DateTimeZone('America/Sao_Paulo'));

        // Data de 24 horas atrás
        $dataInicial = (clone $date)->modify('-24 hours')->format('Y-m-d H:i:s');

        // Data atual
        $dataFinal = $date->format('Y-m-d H:i:s');

        $salesOrderByDate = SalesOrderRepository::getApprovedByDate(
            $dataInicial,
            $dataFinal
        );

        return view('wsdadm.dashboard', [
            'orders' => [
                'total' => $salesOrderByDate->count(),
                'dateIni' => Carbon::parse($dataInicial)->format('d/m/Y H:i'),
                'dateEnd' => Carbon::parse($dataFinal)->format('d/m/Y H:i'),
            ]
        ]);

    }

    public function manual()
    {
        return view('wsdadm.manual');
    }

}
