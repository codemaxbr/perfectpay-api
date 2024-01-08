<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Boleto()
 * @method static static Pix()
 * @method static static Cartao()
 */
final class PaymentMethod extends Enum
{
    const Boleto = 'BOLETO';
    const Pix = 'PIX';
    const Cartao = 'CREDIT_CARD';
}
