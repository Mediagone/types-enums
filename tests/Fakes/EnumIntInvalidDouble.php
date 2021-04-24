<?php declare(strict_types=1);

namespace Tests\Mediagone\Types\Enums\Fakes;

use Mediagone\Types\Enums\EnumInt;


/**
 * @method static EnumIntInvalidDouble DOUBLE
 */
final class EnumIntInvalidDouble extends EnumInt
{
    private const DOUBLE = 2.5;
}
