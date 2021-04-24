<?php declare(strict_types=1);

namespace Tests\Mediagone\Types\Enums;

use LogicException;
use Mediagone\Types\Enums\EnumString;
use PHPUnit\Framework\TestCase;
use Tests\Mediagone\Types\Enums\Fakes\EnumStringBar;
use Tests\Mediagone\Types\Enums\Fakes\EnumStringBaz;
use Tests\Mediagone\Types\Enums\Fakes\EnumStringInvalidDouble;
use Tests\Mediagone\Types\Enums\Fakes\EnumStringInvalidInt;


/**
 * @covers \Mediagone\Types\Enums\EnumString
 */
final class EnumStringTest extends TestCase
{
    //========================================================================================================
    // Tests
    //========================================================================================================
    
    public function test_can_be_created() : void
    {
        $one = EnumStringBar::ONE();
        
        self::assertTrue(is_subclass_of($one, EnumString::class));
        self::assertInstanceOf(EnumStringBar::class, $one);
    }
    
    
    public function test_can_get_value_as_integer() : void
    {
        $one = EnumStringBar::ONE();
        
        self::assertIsString($one->value);
        self::assertSame('one', $one->value);
    }
    
    
    public function test_can_compare_equal_values() : void
    {
        $one = EnumStringBar::ONE();
        
        self::assertTrue($one == EnumStringBar::ONE());
        self::assertTrue($one === EnumStringBar::ONE());
        self::assertTrue($one === EnumStringBar::from($one->value));
    }
    
    
    public function test_can_tell_values_are_different() : void
    {
        $one = EnumStringBar::ONE();
        
        self::assertTrue($one !== 'one');
        self::assertTrue($one !== $one->value);
        self::assertTrue($one !== EnumStringBar::TWO());
        self::assertTrue($one !== EnumStringBaz::ONE());
    }
    
    
    
    //========================================================================================================
    // Tests
    //========================================================================================================
    
    public function test_cannot_declare_string_const() : void
    {
        $this->expectException(LogicException::class);
        EnumStringInvalidInt::ONE();
    }
    
    
    public function test_cannot_declare_double_const() : void
    {
        $this->expectException(LogicException::class);
        EnumStringInvalidDouble::DOUBLE();
    }
    
    
    
}
