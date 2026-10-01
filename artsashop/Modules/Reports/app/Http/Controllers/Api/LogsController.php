<?php
/**
 * Lef Tecnologia
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
namespace Modules\Reports\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Idea\Framework\Repository\Logs\SysLogsRepository;
use Illuminate\Http\Request;

class LogsController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if ($request->get('module')  == '') {
            // Retorna a validacao da variavel 'module'
            return response()->json([
                'error' => true,
                'message' => 'Variavel Module Nao definida'
            ]);
        } else if ($request->get('message')  == '') {
            // Retorna a validacao da variavel 'message'
            return response()->json([
                'error' => true,
                'message' => 'Variavel message não definida'
            ]);

        } else if ($request->get('type')  == '') {
            // Retorna a validacao da variavel 'type'
            return response()->json([
                'error' => true,
                'message' => 'Variavel type Nao definida'
            ]);

        } else if (!in_array($request->get('type'), ['INFO', 'CRITICAL', 'ERROR', 'SUCCESS', 'ORDERS'])) {
            // Retorna a validacao dos tipos da variavel 'module'
            return response()->json([
                'error' => true,
                'message' => 'A varialvel type apenas pode ser (INFO, CRITICAL, ERROR, SUCCESS, ORDERS)'
            ]);

        } else {

            try {

                // Inicializa a data do log
                $updateAt = new \DateTime('NOW', new \DateTimeZone('America/Sao_Paulo'));

                // Cria o Log no sistema
                SysLogsRepository::create([
                    'module' => $request->get('module'),
                    'type' => $request->get('type'),
                    'log' => $request->get('message'),
                    'created' => $updateAt->format('Y-m-d H:i:s'),
                ]);

                return response()->json([
                    'error' => false,
                    'message' => 'Log criado com sucesso'
                ]);

            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'message' => "Erro ao criar o Log: {$e->getMessage()}"
                ]);

            }

        }

    }

}
