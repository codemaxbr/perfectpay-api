<?php

namespace App\Listeners;

use App\Enums\PaymentMethod;
use App\Events\OrderCreated;
use App\Integrations\AsaasIntegration;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;

class OrderIntegration
{
    private $config;
    private $gateway;
    public $integration;

    public function __construct()
    {
        $this->gateway = env('GATEWAY_DEFAULT');
        $this->config = [
            'base_url' => env('GATEWAY_URL'),
            'access_token' => env('GATEWAY_KEY'),
        ];

        /** @var AsaasIntegration $integrationClass */
        $integrationClass = 'App\\Integrations\\' . ucfirst($this->gateway) . 'Integration';
        $this->integration = new $integrationClass($this->config);
    }

    /**
     * Handle the event.
     *
     * @param  OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        /** @var Order $order */
        $order = $event->order;

        /** @var Product $product */
        $product = $event->product;

        $payment_method = $event->payment_method;

        /** @var Customer $customer */
        $customer = $event->customer;

        switch ($payment_method) {
            case PaymentMethod::Boleto:
            case PaymentMethod::Pix:
                $transaction = $this->integration->transactionBoleto((object) [
                    'customer' => $customer,
                    'order' => $order,
                    'product' => $product,
                ]);

                $info = [
                    'boleto_url' => $transaction->bankSlipUrl,
                    'boleto_validade' => $transaction->dueDate,
                    'boleto_barcode' => $this->integration->getBarCodeBankSlip($transaction->id),
                    'pix' => $this->integration->getPixQrCode($transaction->id)
                ];

                $order->external_id = $transaction->id;
                $order->response = json_encode($info);
                $order->save();

                break;

            case PaymentMethod::Cartao:
                dd('Cartão', $order, $product, $customer);
                break;

            case PaymentMethod::Pix:
                dd('Pix', $order, $product, $customer);
                break;
        }
    }
}
