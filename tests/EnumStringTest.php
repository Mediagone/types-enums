<?php declare(strict_types=1);

namespace Tests\Mediagone\Types\Enums;

use LogicException;
use Mediagone\Types\Enums\EnumString;
use PHPUnit\Framework\TestCase;
use Tests\Mediagone\Types\Enums\Fakes\EnumStringBar;
use Tests\Mediagone\Types\Enums\Fakes\EnumStringBaz;
use Tests\Mediagone\Types\Enums\Fakes\EnumStringInvalidDouble;
use Tests\Mediagone\Types\Enums\Fakes\EnumStringInvalidInt;
use function is_subclass_of;
use function serialize;


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
    
    
    public function test_can_be_created_from_name() : void
    {
        $one = EnumStringBar::ONE();
        
        self::assertTrue($one === EnumStringBar::fromName($one->name));
        self::assertTrue($one === EnumStringBar::fromName('ONE'));
        self::assertTrue($one !== EnumStringBar::fromName('TWO'));
    }
    
    
    public function test_cannot_be_created_from_invalid_name() : void
    {
        $this->expectException(LogicException::class);
        EnumStringBar::fromName('WHAT');
    }
    
    
    public function test_can_get_value_as_integer() : void
    {
        self::assertSame('one', EnumStringBar::ONE()->value);
        self::assertSame('two', EnumStringBar::TWO()->value);
    }
    
    
    public function test_can_get_name() : void
    {
        self::assertSame('ONE', EnumStringBar::ONE()->name);
        self::assertSame('TWO', EnumStringBar::TWO()->name);
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
    
    
    public function test_can_get_cases() : void
    {
        self::assertSame([EnumStringBar::ONE(), EnumStringBar::TWO()], EnumStringBar::cases());
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
    
    
    public function test_cannot_be_serialized() : void
    {
        $this->expectException(LogicException::class);
        serialize(EnumStringBar::ONE());
    }
    
    
    
}
