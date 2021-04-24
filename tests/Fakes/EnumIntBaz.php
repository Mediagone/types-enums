<?php declare(strict_types=1);

namespace Tests\Mediagone\Types\Enums\Fakes;

use Mediagone\Types\Enums\EnumInt;


/**
 * @method static EnumIntBaz ONE
 * @method static EnumIntBaz TWO
 */
final class EnumIntBaz extends EnumInt
{
    private const ONE = 1;
    private const TWO = 2;
}
