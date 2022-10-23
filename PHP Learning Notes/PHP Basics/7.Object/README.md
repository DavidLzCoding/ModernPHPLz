# Classes and Objects

Basic class definitions begin with the keyword class, followed by a class name, followed by a pair of curly braces which enclose the definitions of the properties and methods belonging to the class.

A class may contain its own constants, variables (called "properties"), and functions (called "methods").

**About "$this":** The pseudo-variable $this is available when a method is called from within an object context. $this is the value of the calling object.

For example:

```php
<?php
class SimpleClass
{
    // property declaration
    public $var = 'a default value';

    // method declaration
    public function displayVar() {
        echo $this->var;
    }
}
?>
```

### Create an instance of a class

To create an instance of a class, the new keyword must be used. An object will always be created unless the object has a constructor defined that throws an exception on error. Classes should be defined before instantiation.

There are two kinds of syntax to new instances:
1. new classname() syntax.
2. new(str_of_classname)   syntax.

```php
<?php
/*
 * Example about "new classname()" instances syntax
 */
$instance = new SimpleClass();

// This can also be done with a variable:
$className = 'SimpleClass';
$instance = new $className(); // new SimpleClass()

/*
 * Example about "new(str_of_classname)" instances syntax
 */
class ClassA extends \stdClass {}
class ClassB extends \stdClass {}
class ClassC extends ClassB {}
class ClassD extends ClassA {}

function getSomeClass(): string
{
    return 'ClassA';
}

var_dump(new (getSomeClass()));  //new(str_of_classname) syntax to new instances.
var_dump(new ('Class' . 'B'));
var_dump(new ('Class' . 'C'));
var_dump(new (ClassD::class)); 
?>
```


### Rule of object assignment between values



```php
<?php
class SimpleClass
{
    // property declaration
    public $var = 'a default value';

    // method declaration
    public function displayVar() {
        echo $this->var;
    }
    
}

$instance = new SimpleClass();

$assigned   =  $instance;  //copy the value of variable $instances
$reference  =& $instance;  //keep the reference of variable $instance

$instance->var = '$assigned will have this value';

$instance = null; // $instance and $reference become null

var_dump($instance);   // NULL
var_dump($reference);  // still NULL
var_dump($assigned);   // object(SimpleClass)#1 (1)


?>
```


### Property and method of an instance

Class member variables are called properties.They are defined by using at least one modifier (such as Visibility, Static Keyword, or, as of PHP 8.1.0, readonly), optionally (except for readonly properties), as of PHP 7.4, followed by a type declaration, followed by a normal variable declaration.

Within class methods non-static properties may be accessed by using -> (Object Operator): $this->property (where property is the name of the property). Static properties are accessed by using the :: (Double Colon): self::$property.


```php
<?php
class sampleClass
{   
    /*
     * constant for class
     */
    public const CONSTANT = 'constant value';
    private const HELLO = "private hello";
    

    function showConstant() {
        echo self::CONSTANT;
        echo self::HELLO;
    }
    
    /*
     * "self" stands for class 
     * "$this" stands for instance
     */
    const TWO = ONE * 2;
    const THREE = ONE + self::TWO;
    
    
    /*
     * public visibility property and static property definition
     */
    public $bar = 'property';  
    public static $kar = "haha"; 
    
    /*
     * property definition with type declaration 
     */
    public int $id;
    public ?string $name;
    
    /*
     * method definition
     */
    public function foo() {
        // use "$this->" to get property
        return $this->bar;   
    }
    
    // method with type declared parameters
    public function bar(int $id, ?string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}



echo sampleClass::CONSTANT; //get the constant of sampleClass
echo sampleClass::$kar;    //get the static property of sampleClass

//echo sampleClass::HELLO;   can't fetch private constant

/*
 * use variable value as className
 */
$classname = "sampleClass";
echo $classname::CONSTANT;

$obj = new sampleClass();
echo $obj->bar;    // get the property of instance
echo $obj->foo();  // call the method of instance
echo $obj->showConstant(); 
?>
```


### Visibility
The visibility of a property, a method or (as of PHP 7.1.0) a constant can be defined by prefixing the declaration with the keywords public, protected or private.

- Class members declared public can be accessed everywhere. In additional, Properties declared without any explicit visibility keyword are defined as public.

- Members declared protected can be accessed only within the class itself and by inheriting and parent classes.

- Members declared as private may only be accessed by the class that defines the member.

```php
<?php
/**
 * Define MyClass
 */
class MyClass
{
    public $public = 'Public';
    protected $protected = 'Protected';
    private $private = 'Private';

    function printHello()
    {
        echo $this->public;
        echo $this->protected;
        echo $this->private;
    }
}

$obj = new MyClass();
echo $obj->public; // Works
echo $obj->protected; // Fatal Error
echo $obj->private; // Fatal Error
$obj->printHello(); // Shows Public, Protected and Private


/**
 * Define MyClass2
 */
class MyClass2 extends MyClass
{
    // We can redeclare the public and protected properties, but not private
    public $public = 'Public2';
    protected $protected = 'Protected2';

    function printHello()
    {
        echo $this->public;
        echo $this->protected;
        echo $this->private;
    }
}

$obj2 = new MyClass2();
echo $obj2->public; // Works
echo $obj2->protected; // Fatal Error
echo $obj2->private; // Undefined
$obj2->printHello(); // Shows Public2, Protected2, Undefined

?>
```

#### Method Visibility

Class methods may be defined as public, private, or protected. Methods declared without any explicit visibility keyword are defined as public.

```php
<?php
/**
 * Define MyClass
 */
class MyClass
{
    // Declare a public constructor
    public function __construct() { }

    // Declare a public method
    public function MyPublic() { }

    // Declare a protected method
    protected function MyProtected() { }

    // Declare a private method
    private function MyPrivate() { }

    // This is public
    function Foo()
    {
        $this->MyPublic();
        $this->MyProtected();
        $this->MyPrivate();
    }
}

$myclass = new MyClass;
$myclass->MyPublic(); // Works
$myclass->MyProtected(); // Fatal Error
$myclass->MyPrivate(); // Fatal Error
$myclass->Foo(); // Public, Protected and Private work


/**
 * Define MyClass2
 */
class MyClass2 extends MyClass
{
    // This is public
    function Foo2()
    {
        $this->MyPublic();
        $this->MyProtected();
        $this->MyPrivate(); // Fatal Error
    }
}

$myclass2 = new MyClass2;
$myclass2->MyPublic(); // Works
$myclass2->Foo2(); // Public and Protected work, not Private

class Bar 
{
    public function test() {
        $this->testPrivate();
        $this->testPublic();
    }

    public function testPublic() {
        echo "Bar::testPublic\n";
    }
    
    private function testPrivate() {
        echo "Bar::testPrivate\n";
    }
}

class Foo extends Bar 
{
    public function testPublic() {
        echo "Foo::testPublic\n";
    }
    
    private function testPrivate() {
        echo "Foo::testPrivate\n";
    }
}

$myFoo = new Foo();
$myFoo->test(); // Bar::testPrivate 
                // Foo::testPublic
?>
```

#### Visibility from other objects
Objects of the same type will have access to each others private and protected members even though they are not the same instances. This is because the implementation specific details are already known when inside those objects.

```php
<?php
class Test
{
    private $foo;

    public function __construct($foo)
    {
        $this->foo = $foo;
    }

    private function bar()
    {
        echo 'Accessed the private method.';
    }

    public function baz(Test $other)
    {
        // We can change the private property:
        $other->foo = 'hello';
        var_dump($other->foo);

        // We can also call the private method:
        $other->bar();
    }
}

$test = new Test('test');

$test->baz(new Test('other'));
?>
```


### Extends other class

**Class extension is an inheritance:**
1. A class can inherit the constants, methods, and properties of another class by using the keyword extends in the class declaration.

2. The inherited constants, methods, and properties can be overridden by redeclaring them with the same name defined in the parent class.

3. However, if the parent class has defined a method or constant as final, they may not be overridden.

4.  It is possible to access the overridden methods or static properties by referencing them with parent::.

**extend only once:** It is not possible to extend multiple classes; a class can only inherit from one base class.

```php
<?php
/*
 * Simple example of class extension
 */
class ExtendClass extends SimpleClass
{
    // Redefine the parent method
    function displayVar()
    {
        echo "Extending class\n";
        parent::displayVar();
    }
}

$extended = new ExtendClass();
$extended->displayVar();
?>
```

#### compatible child methods

When overriding a method, its signature must be compatible with the parent method.

A signature is compatible if it respects the variance rules, makes a mandatory parameter optional, and if any new parameters are optional.

```php
<?php

class Base
{
    public function foo(int $a) {
        echo "Valid\n";
    }
}

class Extend1 extends Base
{
    function foo(int $a = 5)
    {
        parent::foo($a);
    }
    
}

class Extend2 extends Base
{
    function foo(int $a, $b = 5)
    {
        parent::foo($a);
    }
}

$extended1 = new Extend1();
$extended1->foo();
$extended2 = new Extend2();
$extended2->foo(1);
```

#### “::class” syntax for fetching classname

To obtain the fully qualified name of a class ClassName use ClassName::class.

```php
<?php
namespace NS {
    class ClassName {
    }
    
    echo ClassName::class;  //will get "NS\ClassName"
    
    $c = new ClassName();
    print $c::class;      // still get "NS\ClassName"
}
?>
```

#### instance null-safe operator

```php
<?php

// As of PHP 8.0.0, this line:
$result = $repository?->getUser(5)?->name;

// Is equivalent to the following code block:
if (is_null($repository)) {
    $result = null;
} else {
    $user = $repository->getUser(5);
    if (is_null($user)) {
        $result = null;
    } else {
        $result = $user->name;
    }
}
?>
```

### Constructors

PHP allows developers to declare constructor methods for classes. Classes which have a constructor method call this method on each newly-created object, so it is suitable for any initialization that the object may need before it is used.

Parent constructors are not called implicitly if the child class defines a constructor. In order to run a parent constructor, a call to parent::__construct() within the child constructor is required.

If the child does not define a constructor then it may be inherited from the parent class just like a normal class method (if it was not declared as private).

```php
<?php
class BaseClass {
    function __construct() {
        print "In BaseClass constructor\n";
    }
}

class SubClass extends BaseClass {
    protected int $x;
    public float $y;
    
    function __construct(int $a, float $b) {
        parent::__construct();
        $x = $a;
        $y = $b;
        echo $x+$y;
    }
}

class OtherSubClass extends BaseClass {
    // inherits BaseClass's constructor
}

// In BaseClass constructor
$obj = new BaseClass();

// In BaseClass constructor
// In SubClass constructor
$obj = new SubClass();

// In BaseClass constructor
$obj = new OtherSubClass();
?>

```

### Destructors
PHP possesses a destructor concept similar to that of other object-oriented languages, such as C++. The destructor method will be called as soon as there are no other references to a particular object, or in any order during the shutdown sequence.

```php
<?php
class MyDestructableClass 
{
    function __construct() {
        print "In constructor\n";
    }

    function __destruct() {
        print "Destroying " . __CLASS__ . "\n";
    }
}

$obj = new MyDestructableClass();
```




### Autoloading Classes
Many developers writing object-oriented applications create one PHP source file per class definition. One of the biggest annoyances is having to write a long list of needed includes at the beginning of each script (one for each class).

The spl_autoload_register() function registers any number of autoloaders, enabling for classes and interfaces to be automatically loaded if they are currently not defined. By registering autoloaders, PHP is given a last chance to load the class or interface before it fails with an error.

spl_autoload_register() may be called multiple times in order to register multiple autoloaders. Throwing an exception from an autoload function, however, will interrupt that process and not allow further autoload functions to run. For that reason, throwing exceptions from an autoload function is strongly discouraged.

Any class-like construct may be autoloaded the same way. That includes classes, interfaces, traits, and enumerations.

Prior to PHP 8.0.0, it was possible to use __autoload() to autoload classes and interfaces. However, it is a less flexible alternative to spl_autoload_register() and __autoload() is deprecated as of PHP 7.2.0, and removed as of PHP 8.0.0.



You should not have to use require_once inside the autoloader, as if the class is not found it wouldn't be trying to look for it by using the autoloader. Just use require(), which will be better on performance as well as it does not have to check if it is unique.

```php
<?php
/*
 * This example attempts to load the classes MyClass1 and MyClass2
 *  from the files MyClass1.php and MyClass2.php respectively.
 */
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$obj  = new MyClass1();
$obj2 = new MyClass2(); 
?>
```

..

