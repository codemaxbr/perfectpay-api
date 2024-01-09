<?php

namespace App\Services;

interface IntegrationService
{
    public function createCustomer($payload);

    public function updateCustomer($payload, $id);

    public function removeCustomer($id);

    public function createInvoice($payload);

    public function transactionBoleto($payload);

    public function transactionCreditCard($payload);

    public function transactionPix($payload);
}
