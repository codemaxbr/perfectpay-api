<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class OrderStatus extends Enum
{
    const Pending       = 'pending';
    const InProgress    = 'in_progress';
    const Failed        = 'failed';
    const Finished      = 'finished';
}
