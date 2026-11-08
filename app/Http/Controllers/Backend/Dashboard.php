<?php
/**
 * Fabiano Gato
 *
 * NOTICE OF LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 *
 * É concedida permissão, gratuitamente, a qualquer pessoa que obtenha uma cópia
 * deste software e arquivos de documentação associados
 *
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
