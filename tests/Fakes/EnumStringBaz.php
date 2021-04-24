<?php declare(strict_types=1);

namespace Tests\Mediagone\Types\Enums\Fakes;

use Mediagone\Types\Enums\EnumString;


/**
 * @method static EnumStringBaz ONE
 * @method static EnumStringBaz TWO
 */
final class EnumStringBaz extends EnumString
{
    private const ONE = 'one';
    private const TWO = 'two';
}
