<?php

declare(strict_types=1);

namespace App\Entity\Order;

use MyCLabs\Enum\Enum;

/**
 * @method static OrderStatus PENDING()
 * @method static OrderStatus PROCESSED()
 * @method static OrderStatus FAILED()
 * @method static OrderStatus DELETED()
 * @extends Enum<string>
 */
class OrderStatus extends Enum
{
    public const PENDING = 'pending';
    public const PROCESSED = 'physical';
    public const FAILED = 'failed';
    public const DELETED = 'deleted';
}
