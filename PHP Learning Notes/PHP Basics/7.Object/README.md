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

### New an instance of a class

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


```php
<?php
class sampleClass
{
    public $bar = 'property';
    
    public function foo() {
        return 'method';
    }
}

$obj = new sampleClass();
echo $obj->bar;    // get the property of instance
echo $obj->foo();  // call the method of instance
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

#### ::class 

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

