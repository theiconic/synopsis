# synopsis
PHP library to generate a language-agnostic description of PHP objects or values

[![Build Status](https://travis-ci.org/theiconic/synopsis.svg?branch=master)](https://travis-ci.org/theiconic/synopsis)
[![Coverage Status](https://coveralls.io/repos/github/theiconic/synopsis/badge.svg?branch=master&t=2)](https://coveralls.io/github/theiconic/synopsis?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/theiconic/synopsis/badges/quality-score.png?b=master&t=1)](https://scrutinizer-ci.com/g/theiconic/synopsis/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/theiconic/synopsis/v/stable?t=1)](https://packagist.org/packages/theiconic/synopsis)
[![Total Downloads](https://poser.pugx.org/theiconic/synopsis/downloads)](https://packagist.org/packages/theiconic/synopsis)
[![License](https://poser.pugx.org/theiconic/synopsis/license)](https://packagist.org/packages/theiconic/synopsis)
[![Dependency Status](https://www.versioneye.com/user/projects/58d46eb4dcaf9e0045d9728b/badge.svg?style=flat)](https://www.versioneye.com/user/projects/58d46eb4dcaf9e0045d9728b)

## Purpose
This library can be used to generate language-agnostic descriptions of
PHP variables or objects that can then be sent over a transport to
another system, e.g. for debugging, monitoring and inspection purposes.

It generates a standardised representation that can easily be formatted
in different ways.

E.g. possible use-cases are
- sending data together with log messages to a logging service
- sending debug data to a debugging/inspection tool
- pretty-formatting exceptions including their traces and the arguments in the calls of those traces
- output data on different channels (e.g. terminal, web, etc.) via standardised formatters

## Setup (via Composer)
Simply import the library in composer
```$bash
composer require theiconic/synopsis
```
## Basic Usage
You will need to start off by instantiating the factory
```$php
$factory = new TheIconic\Synopsis\Factory();
```
Now you can synopsise any value
```$php
class MyClass
{
    public $myProp = 1;
}

$myObject = new MyClass();
$myArray = [
    'string' => 'Hello World!',
    'integer' => 1,
    'boolean' = true,
];

$objectSynopsis = $factory->synopsize($myObject);
$arraySynopsis = $factory->synopsize($myArray);
```
Each call to `synopsize()` generates an `AbstractSynopsis`
instance which describes the passed value.

Now use one of the formatters to format that data in a way
that you can send over a transport or use by other components.
```$php
$formatter = new TheIconic\Synopsis\Formatter\ArrayFormatter();
$formatter->format($objectSynopsis);
/*
 * [
 *     'type' => 'MyClass',
 *     'length' => 1,
 *     'value' => ''
 *     'children' => [
 *         'myProp' => [
 *             'type' => 'integer',
 *             'length' => 1,
 *             'value' => 1,
 *         ]
 *     ]
 * ]
 */
 
$formatter->format($arraySynopsis);
/*
 * [
 *     'type' => 'array',
 *     'length' => 3,
 *     'value' => ''
 *     'children' => [
 *         'string' => [
 *             'type' => 'string',
 *             'length' => 12,
 *             'value' => 'Hello World!',
 *         ]
 *         'integer' => [
 *             'type' => 'integer',
 *             'length' => 1,
 *             'value' => 1,
 *         ],
 *         'string' => [
 *             'type' => 'boolean',
 *             'length' => 4,
 *             'value' => 'true',
 *         ]
 *     ]
 * ]
 */
```

## Object Synopsis
When synopsising objects, the factory checks if a custom
Synopsis class is registered for the type of the object (i.e. it's class name).
If so, then the special Synopsis type is used to synopsise the
object and the result entirely depends on its implementation.

Custom object types can be registered via
```$php
$factory->addObjectType(MyClass::$class, MyClassSynopsis::class);
```

If no custom type is registered, default object synopsis is used.

A custom IteratorSynopsis type is registered for objects that implement
Iterator or IteratorAggregate interfaces.

### Default Object Synopsis
The default ObjectSynopsis implementation will inspect the object
for any public properties. Each of those properties will be
treated as the objects children and synopsised recursively.

The **length** will be the number of public properties found.

The objects class name will be used as the **type**.

To determine the **value**, the implementation will check for the
presence and accessibility of any of the following methods in this order
- __toSynopsisValue
- __toString
- getId
- getName

The first method found will be executed and it's return value will
be cast to string and used as the objects **value**.

### Default Iterator Synopsis
The default IteratorSynopsis implementation will iterate through
the object, synopsise any of the iteration values and add them as
children.

## Resource Synopsis
When synopsising PHP resource pointers, the factory checks if a custom
Synopsis class is registered for the type of resource (determined via `get_resource_type()`).
If so, that type will be used.

By default, custom resource types are registered for some filetypes
and streams and they will use `stream_get_meta_data()` to determine
the resource uri and use it as the **value**.

Custom resource types can be registered via
```$php
$factory->addResourceType(MyClass::$class, MyClassSynopsis::class);
```

## Exception Synopsis
Exceptions and their traces are synopsised in a special way
adding additional properties to the synopsis objects.

These can be utilised in special Exception formatters.

### ExceptionSynopsis
- **type**: the exception type
- **value**: the exception message
- **length**: the length of the stack trace
- **line**: the line
- **file**: the file
- **children**: the synopsised stack trace

### TraceSynopsis
- **type**: a string representation of the full call
- **value**: a string representation of the file and line
- **length**: the number of call parameters
- **line**: the line
- **file**: the file
- **class**: the class name
- **function**: the function/method name
- **children**: the synopsised call parameters (if any)

## Overriding default Synopsis implementations
To override the behaviour for any of the types, simply implement
your own Synopsis class (inheriting from `AbstractSynopsis`) and
register it with the factory via e.g.
```$php
$factory->addType('string', MyStringSynopsis::class);
```

## License
THE ICONIC Synopsis library for PHP is released under the MIT License.
