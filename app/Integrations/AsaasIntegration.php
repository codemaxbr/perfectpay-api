<?php

namespace App\Integrations;

use App\Enums\PaymentMethod;
use App\Services\IntegrationService;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

class AsaasIntegration implements IntegrationService
{
    private $token;
    private $url;

    public function __construct($config)
    {
        $this->url = $config['base_url'];
        $this->token = $config['access_token'];
    }

    private function requestApi($method, $uri, $params = array())
    {
        try {
            $client = new Client();
            $headers = [
                'headers' => [
                    'access_token' => $this->token,
                    'Content-Type' => 'application/json',
                ],
            ];

            if ($method == 'POST' || $method == 'PUT') {
                $headers['json'] = $params;
            }

            $response = $client->request($method, $this->url . $uri, $headers);
            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $http_code = $e->getResponse()->getStatusCode();
                $error = json_decode($e->getResponse()->getBody()->getContents());

                throw new \Exception('Erro ao processar requisição na API.', $http_code);
            }
        }
    }

    public function getBarCodeBankSlip($id)
    {
        return $this->requestApi('GET', '/v3/payments/' . $id .'/identificationField');
    }

    public function getPixQrCode($id)
    {
        return $this->requestApi('GET', '/v3/payments/' . $id .'/pixQrCode');
    }

    public function createCustomer($payload)
    {
        return $this->requestApi('POST', '/v3/customers', [
            'name' => $payload->name,
            'email' => $payload->email,
            'phone' => $payload->phone_number,
            'cpfCnpj' => $payload->cpf_cnpj,
        ]);
    }

    public function updateCustomer($payload, $id)
    {
        return $this->requestApi('PUT', '/v3/customers/' . $id, [
            'name' => $payload->name,
            'email' => $payload->email,
            'phone' => $payload->phone_number,
            'cpfCnpj' => $payload->cpf_cnpj,
        ]);
    }

    public function removeCustomer($id)
    {
        return $this->requestApi('DELETE', '/v3/customers/' . $id);
    }

    public function createInvoice($payload)
    {
        // TODO: Implement createInvoice() method.
    }

    public function transactionBoleto($payload)
    {
        return $this->requestApi('POST', '/v3/payments', [
            'customer' => $payload->customer->external_id,
            'billingType' => PaymentMethod::Boleto,
            'value' => $payload->order->amount,
            'dueDate' => Carbon::createFromDate($payload->order->due)->format('Y-m-d'),
            'description' => 'Pedido #' . $payload->order->id .' - Compra - ' . $payload->product->name,
            'externalReference' => $payload->order->id,
        ]);
    }

    public function transactionCreditCard($payload)
    {
        // TODO: Implement transactionCreditCard() method.
    }

    public function transactionPix($payload)
    {
        // TODO: Implement transactionPix() method.
    }
}
