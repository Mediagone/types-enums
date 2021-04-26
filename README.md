# Types Enums

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Software License][ico-license]](LICENSE)



## Installation
This package requires **PHP 7.4+**

Add it as Composer dependency:
```sh
$ composer require mediagone/types-enums
```


## Introduction

Using constants to represent enumerable values is unsafe unless we provide sufficient checks to prevent any problem:
```php
class Article
{
    public const STATUS_DRAFT = 0;
    public const STATUS_PUBLISHED = 1;
    
    private int $status;
    
    public function changeStatus(int $status) : void
    {
        // We need need to check if the provided status value is valid.
        if (! in_array($status, [Article::STATUS_DRAFT, Article::STATUS_PUBLISHED], true)) {
            throw new LogicException("Invalid status ($status)");
        }
        
        $this->status = $status;
    }
}

$article->changeStatus(Article::STATUS_PUBLISHED); // valid
$article->changeStatus(1); // valid but not safe
$article->changeStatus(2); // invalid and risky if there is no validity check in the method
$article->changeStatus(OtherClass::SOME_INT_CONSTANT); // valid but senseless
```

Using **strongly typed Enums** instead of PHP primitive types (int, string) allows to safely typehint them everywhere and ensure that your data is valid without adding any check in your code.

Unfortunately, PHP doesn't provide native enums prior to 8.1, but they can be emulated using classes.


## Documentation

### Simple usage

First of all, create an enum class that defines your enumerable values as **private constants**: \
_Note: add static method annotations to your class to enable autocompletion in your favorite IDE._

```php
/**
 * @method static ArticleStatus DRAFT()
 * @method static ArticleStatus PUBLISHED()
 */
final class ArticleStatus extends EnumInt
{
    private const DRAFT = 0;
    private const PUBLISHED = 1;
}
```

Enum values are now accessible using static methods which return an instance of `ArticleStatus`:

```php
ArticleStatus::DRAFT();
ArticleStatus::PUBLISHED();

// Strict comparisons are valid since methods always return the same instance
ArticleStatus::PUBLISHED() === ArticleStatus::PUBLISHED(); // true
ArticleStatus::DRAFT() === ArticleStatus::PUBLISHED(); // false
```

Now, you can use it in your class as a regular typed property:

```php
class Article
{
    private ArticleStatus $status;
    
    public function changeStatus(ArticleStatus $status) : void
    {
        // No check needed because $status is always a valid value.
        $this->status = $status;
    }
}

$article->changeStatus(ArticleStatus::PUBLISHED()); // valid
$article->changeStatus(1); // invalid
```



### Enum informations

You can access enum underlying value and name by using `->value` and `->name` properties:

```php
final class ArticleStatus extends EnumInt
{
    private const DRAFT = 0;
    private const PUBLISHED = 1;
}

ArticleStatus::PUBLISHED()->value; // 1
ArticleStatus::PUBLISHED()->name; // "PUBLISHED"
```

### Serialization

Because the PHP serialization mechanism doesn't allow to define which instance is restored, it totally breaks how the library works and strict comparison:
```php
$a = unserialize(serialize(ArticleStatus::PUBLISHED()));
$b = ArticleStatus::PUBLISHED();

$a === $b; // false
```

That's why `serialize()` and `unserialize()` are blocked for all enums classes.

If you need to deal with serialization, you'll have to store the **enum's value** and restore it afterward manually:

```php
$serializedValue = ArticleStatus::PUBLISHED()->value;

// restore the enum
$enum = ArticleStatus::from($serializedValue);
```
_Note: using enum's name for serialization is not recommended since code refactoring might break it anytime._



## License

_Types Enums_ is licensed under MIT license. See LICENSE file.



[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg
[ico-version]: https://img.shields.io/packagist/v/mediagone/types-enums.svg
[ico-downloads]: https://img.shields.io/packagist/dt/mediagone/types-enums.svg

[link-packagist]: https://packagist.org/packages/mediagone/types-enums
[link-downloads]: https://packagist.org/packages/mediagone/types-enums
