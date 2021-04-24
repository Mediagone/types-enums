<?php declare(strict_types=1);

namespace Mediagone\Types\Enums;

use LogicException;
use function is_string;


abstract class EnumString extends Enum
{
    //========================================================================================================
    // Constructors
    //========================================================================================================
    
    final public static function from(string $value) : self
    {
        $instances = self::getEnumInstancesByValue(static::class);
        
        if (! isset($instances[$value])) {
            throw new LogicException('The value "' .$value. '" is not defined as constant in the enum class "' . static::class . '".');
        }
        
        return $instances[$value];
    }
    
        
    
    //========================================================================================================
    // Helpers
    //========================================================================================================
    
    protected static function checkEnumConstantDefinitions(array $definitions) : void
    {
        array_walk($definitions, static function($constValue, $constName) {
            if (! is_string($constValue)) {
                throw new LogicException('The enum value "' .static::class. '::' .$constName. '" must be a string, got "' .gettype($constValue). '".');
            }
        });
    }
    
    
    
}
