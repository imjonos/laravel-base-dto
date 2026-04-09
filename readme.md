# 📦 Laravel Base DTO

[![Latest Version on Packagist](https://img.shields.io/packagist/v/imjonos/laravel-base-dto.svg?style=flat-square)](https://packagist.org/packages/imjonos/laravel-base-dto)  
[![Total Downloads](https://img.shields.io/packagist/dt/imjonos/laravel-base-dto.svg?style=flat-square)](https://packagist.org/packages/imjonos/laravel-base-dto)

A **generic base DTO (Data Transfer Object) implementation** for Laravel projects that provides a consistent and reusable way to handle data transformation and transfer between application layers. This package offers abstract classes and interfaces for creating DTOs and DTO collections with support for array and JSON transformations.

---

## 🧩 Overview

This package provides a complete DTO (Data Transfer Object) implementation for Laravel applications. It includes abstract classes and interfaces for creating DTOs and DTO collections with built-in support for data transformation between array and JSON formats. The implementation follows SOLID principles and provides a consistent way to handle data transfer between different layers of your application.

---

## 🛠 Installation

Install the package via Composer:

```bash
composer require imjonos/laravel-base-dto
```

---

## ✅ Usage

### 1. Create Your DTO Class

Create a new DTO class that extends the base DTO functionality. You can use the provided traits for data transformation:

```php
namespace App\DTO;

use Nos\BaseDto\Interfaces\DtoInterface;

class UserDTO implements DtoInterface
{
    use \Nos\BaseDto\Traits\DataTransforms\ArrayDataTransformable;
    use \Nos\BaseDto\Traits\DataTransforms\JsonDataTransformable;
    
    public function __construct(
        public string $name,
        public string $email,
        public \DateTimeInterface $createdAt
    ) {}
}
```

### 2. Create Your DTO Collection

Create a collection class for your DTOs:

```php
namespace App\DTO;

use Nos\BaseDto\DTOCollection;

class UserCollection extends DTOCollection
{
    protected function createDTO(array $array): UserDTO
    {
        return new UserDTO(
            $array['name'],
            $array['email'],
            new \DateTime($array['created_at'])
        );
    }
}
```

### 3. Use DTOs in Your Application

Transform data between different formats:

```php
// Create DTO from array
$userData = [
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'created_at' => '2023-01-01 12:00:00'
];
$userDTO = UserDTO::fromArray($userData);

// Convert DTO to array
$array = $userDTO->toArray();

// Convert DTO to JSON
$json = $userDTO->toJson();

// Work with collections
$users = UserCollection::fromArray([$userData, $userData]);
$users->each(fn ($user) => echo $user->name);
```

---

## 🔧 Available Features

### DTO Interface
- `fromArray(array $data)`: Create DTO instance from array data
- `toArray()`: Convert DTO to array format
- `fromJson(string $json)`: Create DTO instance from JSON string
- `toJson()`: Convert DTO to JSON string

### DTO Collection
- Implements `Iterator` and `Countable` interfaces
- `fromArray(array $data)`: Create collection from array data
- `map(callable $callback)`: Transform collection items
- `each(callable $callback)`: Iterate through collection items
- `filter(callable $callback)`: Filter collection items
- `findBy(callable $callback)`: Find first item matching criteria
- `findByKey(int $key)`: Find item by index/key
- `findByKeyAndValue(string $key, string $value)`: Find item by property value

---

## 🌐 Project Structure

```
vendor/
└── imjonos/
    └── laravel-base-dto/
        ├── src/
        │   ├── DTOCollection.php
        │   ├── Interfaces/
        │   │   ├── CollectionInterface.php
        │   │   ├── DtoCollectionInterface.php
        │   │   ├── DtoInterface.php
        │   │   └── DataTransforms/
        │   │       ├── ArrayDataTransforms.php
        │   │       └── JsonDataTransforms.php
        │   └── Traits/
        │       └── DataTransforms/
        │           ├── ArrayDataTransformable.php
        │           └── JsonDataTransformable.php
```

---

## 📦 Requirements

- PHP 8.0+
- Laravel 9+
- PHP Reflection extension (for property introspection)

---

## 🧪 Testing

DTOs are easy to test as they are simple data objects. You can write unit tests to verify data transformation methods and collection operations. The immutability and pure functions in DTOs make them predictable and reliable in tests.

---

## 📝 License

This package is open-sourced software licensed under the MIT license.
Please see the [license file](license.md) for more information.

---

## 🚀 Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## 🌟 Features

- **Type Safety**: Uses PHP generics (via PHPDoc) for better IDE support and type checking
- **Data Transformation**: Built-in support for array and JSON transformations
- **Collection Operations**: Full-featured collection class with iterator support
- **Extensible Design**: Easy to extend with custom transformation logic
- **Framework Agnostic Core**: While designed for Laravel, the core DTO functionality can be used in any PHP project
