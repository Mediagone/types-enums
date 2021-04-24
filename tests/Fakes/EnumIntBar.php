<?php declare(strict_types=1);

namespace Tests\Mediagone\Types\Enums\Fakes;

use Mediagone\Types\Enums\EnumInt;


/**
 * @method static EnumIntBar ONE
 * @method static EnumIntBar TWO
 */
final class EnumIntBar extends EnumInt
{
    private const ONE = 1;
    private const TWO = 2;
}
