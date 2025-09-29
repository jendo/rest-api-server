<?php

declare(strict_types=1);

namespace App\Entity\CustomerLog;

use MyCLabs\Enum\Enum;

/**
 * @method static CustomerLogAction CREATED()
 * @method static CustomerLogAction UPDATED()
 * @extends Enum<string>
 */
class CustomerLogAction extends Enum
{
    public const CREATED = 'created';
    public const UPDATED = 'updated';
}
