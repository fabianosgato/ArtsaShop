<?php

namespace Modules\Sales\Emails;

use App\Models\SalesOrder;
use Idea\Framework\Repository\System\SysStoreRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Sales\Emails\Concerns\Configuration;
use Modules\Sales\Transformers\SalesOrderResource;

class SalesOrderCanceledMail extends Mailable
{
    use Queueable, SerializesModels, Configuration;

    public SalesOrder $order;

    /**
     * Create a new message instance.
     */
    public function __construct(SalesOrder $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     */
    public function build(): self
    {

        // Retorna todos os dados do pedido
        $orderData = (new SalesOrderResource($this->order))->resolve();

        // Retorna a store do pedido
        $store = SysStoreRepository::getStoreByCodeOrder(
            codeOrder: substr($orderData['incrementCode'], 0, strpos($orderData['incrementCode'], '-'))
        );

        return $this->subject("{$store->store_name} :: Pedido #{$orderData['incrementCode']} Cancelado")
            ->bcc($this->getEmails())
            ->view('sales::frontend.emails.order-canceled', [
                'store' => $store,
                'orderData' => $orderData
            ]);

    }
}
