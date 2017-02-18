# synopsis
PHP framework to generate a language-agnostic description of PHP objects or values

Badges

## Setup (via Composer)
Add a repository entry for this repository in your composer.json
```$json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/theiconic/synopsis"
    }
]
```
Then import the library
```$bash
composer request theiconic/synopsis
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

## Overriding default Synopsis implementations
To override the behaviour for any of the types, simply implement
your own Synopsis class (inheriting from `AbstractSynopsis`) and
register it with the factory via e.g.
```$php
$factory->addType('string', MyStringSynopsis::class);
```