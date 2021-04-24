<?php declare(strict_types=1);

namespace Tests\Mediagone\Types\Enums\Fakes;

use Mediagone\Types\Enums\EnumString;


/**
 * @method static EnumStringBar ONE
 * @method static EnumStringBar TWO
 */
final class EnumStringBar extends EnumString
{
    private const ONE = 'one';
    private const TWO = 'two';
}
