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
namespace Modules\Sales\Services\Concerns;

use App\Models\SalesOrder;
use App\Models\SalesOrderPayment;
use Idea\Framework\Repository\Sales\SalesOrderPaymentRepository;
use Idea\Framework\Repository\Sales\SalesOrderRepository;
use Idea\Framework\Repository\Sales\SalesOrderStatusRepository;
use Idea\Framework\Services\Payments\IpagPayment;

trait ValidatePayments
{

    public function paymentDescription($paymentMethod)
    {

        if ($paymentMethod == 'boleto') {
            return "Boleto Bancário";
        } elseif ($paymentMethod == 'credit_card') {
            return "Cartão de Crédito";
        } elseif ($paymentMethod == 'pix') {
            return "Pix";
        }

        return null;

    }

    /**
     * Metodo responsavel por validar os Pagamentos
     * @param \App\Models\SalesOrder $salesOrder
     * @param \App\Models\SalesOrderPayment $salesOrderPayment
     * @param $quoteModel
     * @param $payload
     * @return \App\Models\SalesOrder|null
     */
    public function validatePayment(SalesOrder $salesOrder, SalesOrderPayment $salesOrderPayment, $quoteModel, $payload): ?SalesOrder
    {

        // Se o Pagamento for "Cartão de Crédito"
        if ($salesOrderPayment->method === 'credit_card') {

            // Realiza o pagamento do "Cartão de crédito"
            $paymentInformation = app(IpagPayment::class)->paymentCreditCard(
                salesOrder: SalesOrderRepository::getOrder($salesOrder->order_id)->get()->first(),
                paymentCard: $payload['payment']
            );

            // Valida se o pagamento possui validação 3ds
            if ($paymentInformation['requires_3ds']) {

                // Atualiza o metodo com as informacoes do cartão
                SalesOrderPaymentRepository::getData()
                    ->find(
                        $salesOrderPayment->entity_id
                    )
                    ->update([
                        'additional_information' => json_encode($paymentInformation)
                    ]);

                // Retorna o status do pagamento "Pagamento Pendente"
                $statusOrder = SalesOrderStatusRepository::getByCode('pending_payment');

            } else {

                // Valida se o pagamento foi executado com Sucesso
                if (!$paymentInformation['success']) {
                    // Retorna o status do Pagamento como "Cancelado"
                    $statusOrder = SalesOrderStatusRepository::getByCode('canceled');
                } else {
                    // Retorna o status do pedido como "Aprovado"
                    $statusOrder = SalesOrderStatusRepository::getByCode('approved');
                }

            }

        } else if ($salesOrderPayment->method === 'pix') {

            // Retorna as informações do pagamento "PIX"
            $paymentInformation = app(IpagPayment::class)->paymentPix(
                salesOrder: SalesOrderRepository::getOrder($salesOrder->order_id)->get()->first()
            );

            // Valida se o pagamento foi executado com Sucesso
            if ($paymentInformation['status_payment'] == 'canceled') {
                // Retorna o status do Pagamento como "Cancelado"
                $statusOrder = SalesOrderStatusRepository::getByCode('canceled');

            } else {

                // Atualiza o metodo com as informacoes do PIX
                SalesOrderPaymentRepository::getData()
                    ->find(
                        $salesOrderPayment->entity_id
                    )
                    ->update([
                        'additional_information' => json_encode($paymentInformation)
                    ]);

                // Retorna o status do pedido como "Pagamento Pendente"
                $statusOrder = SalesOrderStatusRepository::getByCode('pending_payment');

            }

        } else if ($salesOrderPayment->method === 'boleto') {

            // Retorna as informações do pagamento "Boleto"
            $paymentInformation = app(IpagPayment::class)->paymentBankSlips(
                salesOrder: SalesOrderRepository::getOrder($salesOrder->order_id)->get()->first()
            );

            // Valida se o pagamento foi executado com Sucesso
            if ($paymentInformation['status_payment'] == 'canceled') {
                // Retorna o status do Pagamento como "Cancelado"
                $statusOrder = SalesOrderStatusRepository::getByCode('canceled');

            } else {

                // Atualiza o metodo com as informacoes do PIX
                SalesOrderPaymentRepository::getData()
                    ->find(
                        $salesOrderPayment->entity_id
                    )
                    ->update([
                        'additional_information' => json_encode($paymentInformation)
                    ]);


                // Retorna o status do pedido como "Pagamento Pendente"
                $statusOrder = SalesOrderStatusRepository::getByCode('pending_payment');

            }

        } else {

            // Retorna o status do pagamento "Cancelado"
            $statusOrder = SalesOrderStatusRepository::getByCode('canceled');

        }

        // Atualiza o status do pedido
        SalesOrderRepository::updateOrder(
            orderId: $salesOrder->order_id,
            attributes: [
                'status_id'    => $statusOrder->status_id,
                'status_type'  => $statusOrder->status,
                'status_code'  => $statusOrder->status,
                'status_label' => $statusOrder->label,
                'shipping_cost'=> $quoteModel->shipping_cost ?? 0,
                'canal'        => 'web',
            ]);

        // Retorna as informações do pedido
        return SalesOrderRepository::getOrder($salesOrder->order_id)->first();

    }

}
