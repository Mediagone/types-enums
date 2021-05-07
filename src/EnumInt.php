<?php declare(strict_types=1);

namespace Mediagone\Types\Enums;

use JsonSerializable;
use LogicException;
use function is_int;


/**
 * @property int $value
 */
abstract class EnumInt extends Enum
{
    //========================================================================================================
    // Constructors
    //========================================================================================================
    
    final public static function from(int $value) : self
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
            if (! is_int($constValue)) {
                throw new LogicException('The enum value "' .static::class. '::' .$constName. '" must be an integer, got "' .gettype($constValue). '".');
            }
        });
    }
    
    
    
}
