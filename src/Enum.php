<?php declare(strict_types=1);

namespace Mediagone\Types\Enums;

use JsonSerializable;
use LogicException;
use ReflectionClass;
use Serializable;
use function array_keys;
use function array_map;
use function count;
use function implode;


abstract class Enum implements JsonSerializable, Serializable
{
    //========================================================================================================
    // Static properties
    //========================================================================================================
    
    private static array $instances = [];
    
    private static array $instancesByValue = [];
    
    
    
    //========================================================================================================
    // Properties
    //========================================================================================================
    
    private string $name;
    
    /** @var mixed $value */
    private $value;
    
    
    
    //========================================================================================================
    // Constructor
    //========================================================================================================
    
    private function __construct(string $name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }
    
    
    
    //========================================================================================================
    // Static Methods
    //========================================================================================================
    
    abstract protected static function checkEnumConstantDefinitions(array $definitions) : void;
    
    
    final public static function fromName(string $constantName) : self
    {
        return static::$constantName();
    }
    
    
    
    //========================================================================================================
    // Static Methods
    //========================================================================================================
    
    final public static function __callStatic($constantName, $args) : self
    {
        $instances = self::getEnumInstances(static::class);
        
        if (! isset($instances[$constantName])) {
            throw new LogicException('Invalid enum name "' . static::class . '::' . $constantName . '".');
        }
        
        return $instances[$constantName];
    }
    
    
    /**
     * @return static[]
     */
    final public static function cases() : array
    {
        return self::getEnumInstances(static::class);
    }
    
    
    
    //========================================================================================================
    // Methods
    //========================================================================================================
    
    final public function jsonSerialize()
    {
        return $this->value;
    }
    
    
    final public function __toString() : string
    {
        return (string)$this->value;
    }
    
    
    final public function __get(string $key)
    {
        switch ($key) {
            case 'value':
                return $this->value;
            case 'name':
                return $this->name;
        }
        
        throw new LogicException('Undefined property "'.$key.'"');
    }
    
    
    
    //========================================================================================================
    // Private helpers
    //========================================================================================================
    
    private static function getEnumInstances(string $enumName) : array
    {
        if (! isset(self::$instances[$enumName])) {
            static::buildInstances($enumName);
        }
        
        return self::$instances[$enumName];
    }
    
    
    protected static function getEnumInstancesByValue(string $enumName) : array
    {
        if (! isset(self::$instancesByValue[$enumName])) {
            static::buildInstances($enumName);
        }
        
        return self::$instancesByValue[$enumName];
    }
    
    
    private static function buildInstances(string $enumName) : void
    {
        $definitions = self::extractEnumDefinitions($enumName);
        
        self::$instances[$enumName] = [];
        self::$instancesByValue[$enumName] = [];
        
        foreach ($definitions as $constantName => $constantValue) {
            $constant = new static($constantName, $constantValue);
            
            self::$instances[$enumName][$constantName] = $constant;
            self::$instancesByValue[$enumName][$constantValue] = $constant;
        }
    }
    
    
    private static function extractEnumDefinitions(string $enumName) : array
    {
        $enumClass = new ReflectionClass($enumName);
        
        $definitions = $enumClass->getConstants();
        $definitions = array_filter($definitions, static function (string $const) use ($enumClass) {
            return $enumClass->getReflectionConstant($const)->isPrivate();
        }, ARRAY_FILTER_USE_KEY);
        
        static::checkAgainstDuplicateValues($definitions);
        static::checkEnumConstantDefinitions($definitions);
        
        return $definitions;
    }
    
    
    private static function checkAgainstDuplicateValues(array $definitions) : void
    {
        $uniqueValues = array_unique(array_values($definitions));
        
        if (count($definitions) !== count($uniqueValues)) {
            $duplicatedDefinitions = array_diff_assoc($definitions, array_unique($definitions));
    
            $formattedValues = implode(', ', array_map(static function($k, $v) { return "$k => $v"; }, array_keys($duplicatedDefinitions), $duplicatedDefinitions));
            
            throw new LogicException('Duplicate enum values (' . $formattedValues . ') in "' . static::class . '".');
        }
    }
    
    
    //========================================================================================================
    // Serializable interface
    //========================================================================================================
    
    final public function serialize() : ?string
    {
        throw new LogicException('Enums cannot be serialized.');
    }
    
    
    final public function unserialize($serialized) : void
    {
        throw new LogicException('Enums cannot be unserialized.');
    }
    
    
    
}
