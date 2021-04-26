<?php declare(strict_types=1);

namespace Tests\Mediagone\Types\Enums;

use LogicException;
use Mediagone\Types\Enums\EnumInt;
use PHPUnit\Framework\TestCase;
use Tests\Mediagone\Types\Enums\Fakes\EnumIntBar;
use Tests\Mediagone\Types\Enums\Fakes\EnumIntBaz;
use Tests\Mediagone\Types\Enums\Fakes\EnumIntInvalidDouble;
use Tests\Mediagone\Types\Enums\Fakes\EnumIntInvalidString;
use function is_subclass_of;
use function serialize;


/**
 * @covers \Mediagone\Types\Enums\EnumInt
 */
final class EnumIntTest extends TestCase
{
    //========================================================================================================
    // Tests
    //========================================================================================================
    
    public function test_can_be_created() : void
    {
        $one = EnumIntBar::ONE();
        
        self::assertTrue(is_subclass_of($one, EnumInt::class));
        self::assertInstanceOf(EnumIntBar::class, $one);
    }
    
    
    public function test_can_be_created_from_name() : void
    {
        $one = EnumIntBar::ONE();
    
        self::assertTrue($one === EnumIntBar::fromName($one->name));
        self::assertTrue($one === EnumIntBar::fromName('ONE'));
        self::assertTrue($one !== EnumIntBar::fromName('TWO'));
    }
    
    
    public function test_cannot_be_created_from_invalid_name() : void
    {
        $this->expectException(LogicException::class);
        EnumIntBar::fromName('WHAT');
    }
    
    
    public function test_can_get_value_as_integer() : void
    {
        self::assertSame(1, EnumIntBar::ONE()->value);
        self::assertSame(2, EnumIntBar::TWO()->value);
    }
    
    
    public function test_can_get_name() : void
    {
        self::assertSame('ONE', EnumIntBar::ONE()->name);
        self::assertSame('TWO', EnumIntBar::TWO()->name);
    }
    
    
    public function test_can_compare_equal_values() : void
    {
        $one = EnumIntBar::ONE();
        
        self::assertTrue($one == EnumIntBar::ONE());
        self::assertTrue($one === EnumIntBar::ONE());
        self::assertTrue($one === EnumIntBar::from($one->value));
    }
    
    
    public function test_can_tell_values_are_different() : void
    {
        $one = EnumIntBar::ONE();
        
        self::assertTrue($one !== 1);
        self::assertTrue($one !== $one->value);
        self::assertTrue($one !== EnumIntBar::TWO());
        self::assertTrue($one !== EnumIntBaz::ONE());
    }
    
    
    
    //========================================================================================================
    // Serialization
    //========================================================================================================
    
    public function test_cannot_declare_string_const() : void
    {
        $this->expectException(LogicException::class);
        EnumIntInvalidString::ONE();
    }
    
    
    public function test_cannot_declare_double_const() : void
    {
        $this->expectException(LogicException::class);
        EnumIntInvalidDouble::DOUBLE();
    }
    
    
    public function test_cannot_be_serialized() : void
    {
        $this->expectException(LogicException::class);
        serialize(EnumIntBar::ONE());
    }
    
    
    
}
