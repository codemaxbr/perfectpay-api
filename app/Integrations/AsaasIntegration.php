<?php

namespace App\Integrations;

use App\Services\IntegrationService;
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

    public function createCustomer($payload): string
    {
        try {
            $client = new Client();
            $response = $client->request('POST', $this->url . '/v3/customers', [
                'headers' => [
                    'access_token' => $this->token,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'name' => $payload->name,
                    'email' => $payload->email,
                    'phone' => $payload->phone_number,
                    'cpfCnpj' => $payload->cpf_cnpj,
                ],
            ]);

            $result = json_decode($response->getBody()->getContents());
            return $result->id;
        } catch (ClientException $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function updateCustomer($payload, $id): string
    {
        try {
            $client = new Client();
            $response = $client->request('PUT', $this->url . '/v3/customers/' . $id, [
                'headers' => [
                    'access_token' => $this->token,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'name' => $payload->name,
                    'email' => $payload->email,
                    'phone' => $payload->phone_number,
                    'cpfCnpj' => $payload->cpf_cnpj,
                ],
            ]);

            $result = json_decode($response->getBody()->getContents());
            return $result->id;
        } catch (ClientException $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function removeCustomer($id)
    {
        try {
            $client = new Client();
            $response = $client->request('DELETE', $this->url . '/v3/customers/' . $id, [
                'headers' => [
                    'access_token' => $this->token,
                    'Content-Type' => 'application/json',
                ]
            ]);

            $result = json_decode($response->getBody()->getContents());
            return $result->deleted;
        } catch (ClientException $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function createInvoice($payload)
    {
        // TODO: Implement createInvoice() method.
    }

    public function transactionBoleto($payload)
    {
        // TODO: Implement transactionBoleto() method.
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
