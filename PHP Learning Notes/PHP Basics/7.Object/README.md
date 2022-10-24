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



### Rule of object assignment to variables

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

- example 2:

```php
<?php
class Foo {
  private static $used;
  private $id;
  public function __construct() {
    $id = $used++;
  }
  public function __clone() {
    $id = $used++;
  }
}

$a = new Foo; // $a is a pointer pointing to Foo object 0
$b = $a; // $b is a pointer pointing to Foo object 0, however, $b is a copy of $a
$c = &$a; // $c and $a are now references of a pointer pointing to Foo object 0
$a = new Foo; // $a and $c are now references of a pointer pointing to Foo object 1, $b is still a pointer pointing to Foo object 0
unset($a); // A reference with reference count 1 is automatically converted back to a value. Now $c is a pointer to Foo object 1
$a = &$b; // $a and $b are now references of a pointer pointing to Foo object 0
$a = NULL; // $a and $b now become a reference to NULL. Foo object 0 can be garbage collected now
unset($b); // $b no longer exists and $a is now NULL
$a = clone $c; // $a is now a pointer to Foo object 2, $c remains a pointer to Foo object 1
unset($c); // Foo object 1 can be garbage collected now.
$c = $a; // $c and $a are pointers pointing to Foo object 2
unset($a); // Foo object 2 is still pointed by $c
$a = &$c; // Foo object 2 has 1 pointers pointing to it only, that pointer has 2 references: $a and $c;
const ABC = TRUE;
if(ABC) {
  $a = NULL; // Foo object 2 can be garbage collected now because $a and $c are now a reference to the same NULL value
} else {
  unset($a); // Foo object 2 is still pointed to $c
}

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

### Static Keyword
Declaring class properties or methods as static makes them accessible without needing an instantiation of the class.

These can also be accessed statically within an instantiated class object.

Static properties are accessed using the Scope Resolution Operator (::) and cannot be accessed through the object operator (->).

**Don't use $this inside static methods:** Because static methods are callable without an instance of the object created, the pseudo-variable $this is not available inside methods declared as static.

```php
<?php
class Foo {
    public static $my_static = 'foo';
    
        
    public static function aStaticMethod() {
        // ...
    }
    
    public function staticValue() {
        return self::$my_static;
    }

}

class Bar extends Foo
{
    public function fooStatic() {
        return parent::$my_static;
    }
}

//literal string as class name
Foo::aStaticMethod();
print Foo::$my_static . "\n";

//no static method and property use "->"
$foo = new Foo();
print $foo->staticValue() . "\n";

// use variable as class name
$classname = 'Foo';
$classname::aStaticMethod();

/*
 * inherit static property from parent class
 */
print Bar::$my_static . "\n";
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
        /*
         * can access and modify other
         * instance's private property
         */  
        $other->foo = 'hello';
        var_dump($other->foo);
        
        /*
         * can also call the private method
         * instance's private property
         */ 
        $other->bar();
    }
}

$test = new Test('test');
$test->baz(new Test('other'));  
?>
```

### Final keyword
The final keyword prevents child classes from overriding a method or constant by prefixing the definition with final. If the class itself is being defined final then it cannot be extended.

- Final method:

```php
<?php
class BaseClass {
   public function test() {
       echo "BaseClass::test() called\n";
   }
   
   final public function moreTesting() {
       echo "BaseClass::moreTesting() called\n";
   }
}

class ChildClass extends BaseClass {
   public function moreTesting() {
       echo "ChildClass::moreTesting() called\n";
   }
}
// Results in Fatal error: Cannot override final method BaseClass::moreTesting()
?>
```

- final class:

```php
<?php
final class BaseClass {
   public function test() {
       echo "BaseClass::test() called\n";
   }

   // As the class is already final, the final keyword is redundant
   final public function moreTesting() {
       echo "BaseClass::moreTesting() called\n";
   }
}

class ChildClass extends BaseClass {
}
// Results in Fatal error: Class ChildClass may not inherit from final class (BaseClass)
?>
```


### Extends other class

**Class extension is an inheritance:**
1. when extending a class, the subclass inherits all of the constants, methods, and properties of another class by using the keyword extends in the class declaration.

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

### The Scope Resolution Operator

The Scope Resolution Operator is a token that allows access to static, constant, and overridden properties or methods of a class.

When referencing these items from inside the class definition, use "self::" or "parent::"

When referencing these items from outside the class definition, use the name of the class, for example: "sampleClass::"

```php
<?php
class MyClass {
    const CONST_VALUE = 'A constant value';
    protected function myFunc() {
        echo "MyClass::myFunc()\n";
    }
}

echo MyClass::CONST_VALUE;

/*
 * use variable as class name
 */
$classname = 'MyClass';
echo $classname::CONST_VALUE;

/*
 * Three special keywords self, parent and static are used to 
 * access properties or methods from inside the class definition.
 */

class OtherClass extends MyClass
{
    public static $my_static = 'static var';

    public static function doubleColon() {
        echo parent::CONST_VALUE . "\n";
        echo self::$my_static . "\n";
    }
    
    
    // Override parent's definition
    public function myFunc()
    {
        // But still call the parent function
        parent::myFunc();
        echo "OtherClass::myFunc()\n";
    }
}

$classname = 'OtherClass';
$classname::doubleColon();

OtherClass::doubleColon();


/*
 * call parent's method
 */
 
 
?>
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


### Abstract Class
- PHP has abstract classes and methods. Classes defined as abstract cannot be instantiated, and any class that contains at least one abstract method must also be abstract.

- Methods defined as abstract simply declare the method's signature; they cannot define the implementation.

- When inheriting from an abstract class, all methods marked abstract in the parent's class declaration must be defined by the child class, and follow the usual inheritance and signature compatibility rules.

```php
<?php
/*
 * Example about abstract class 
 * and it's subclass extension usages
 */
abstract class AbstractClass
{
    // Force Extending class to define this method
    abstract protected function getValue();
    abstract protected function prefixValue($prefix);

    // Common method
    public function printOut() {
        print $this->getValue() . "\n";
    }
}

class ConcreteClass1 extends AbstractClass
{
    protected function getValue() {
        return "ConcreteClass1";
    }

    /*
     * Our child class may define optional 
     * arguments not in the parent's signature
     */
    public function prefixValue($prefix, $last = "last") {
        return "{$prefix}ConcreteClass1{$last}";
    }
}

class ConcreteClass2 extends AbstractClass
{
    public function getValue() {
        return "ConcreteClass2";
    }

    public function prefixValue($prefix) {
        return "{$prefix}ConcreteClass2";
    }
}

$class1 = new ConcreteClass1;

// get "ConcreteClass1"
$class1->printOut();   

//get "FOO_ConcreteClass1"
echo $class1->prefixValue('FOO_') ."\n"; 

$class2 = new ConcreteClass2;

// get "ConcreteClass2"
$class2->printOut();    

//get "FOO_ConcreteClass2"

echo $class2->prefixValue('FOO_') ."\n";  

?>
```

### Implement class interfaces

- Object interfaces allow you to create code which specifies which methods a class must implement, without having to define how these methods are implemented. 
  
- Interfaces share a namespace with classes and traits, so they may not use the same name.

- All methods declared in an interface must be public; this is the nature of an interface.

- To implement an interface, the implements operator is used. All methods in the interface must be implemented within a class; failure to do so will result in a fatal error. 
  
- Classes may implement more than one interface if desired by separating each interface with a comma.

```php
<?php

/*
 * Declare the interface 'Template'
 */
interface Template
{
    public function setVariable($name, $var);
    public function getHtml($template);
}

/*
 * Implement the interface
 * setVariable and getHtml must be implemented in this class
 */
class WorkingTemplate implements Template
{
    private $vars = [];
  
    public function setVariable($name, $var)
    {
        $this->vars[$name] = $var;
    }
  
    public function getHtml($template)
    {
        foreach($this->vars as $name => $value) {
            $template = str_replace('{' . $name . '}', $value, $template);
        }
 
        return $template;
    }
}

// This will not work
// Fatal error: Class BadTemplate contains 1 abstract methods
// and must therefore be declared abstract (Template::getHtml)
class BadTemplate implements Template
{
    private $vars = [];
  
    public function setVariable($name, $var)
    {
        $this->vars[$name] = $var;
    }
}
?>
```

interface example 2:

```php
<?php
interface A
{
    public function foo();
}

interface B extends A
{
    public function baz(Baz $baz);
}

// This will work
class C implements B
{
    public function foo()
    {
    }

    public function baz(Baz $baz)
    {
    }
}

// This will not work and result in a fatal error
class D implements B
{
    public function foo()
    {
    }

    public function baz(Foo $foo)
    {
    }
}
?>
```

### Traits

- Traits are a mechanism for code reuse in single inheritance languages such as PHP. A Trait is intended to reduce some limitations of single inheritance by enabling a developer to reuse sets of methods freely in several independent classes living in different class hierarchies.

- A Trait is similar to a class, but It is not possible to instantiate a Trait on its own.

- **The precedence order is that methods from the current class override Trait methods, which in turn override methods from the base class.**

```php
<?php
class Base {
    public function sayHello() {
        echo 'parent';
    }
}

trait SayWorld {
    public function sayHello() {
        echo 'trait';
    }
}

class MyHelloWorld extends Base {
    use SayWorld;
}

class MyHelloWorld2 extends Base {
    use SayWorld;
    public function sayHello() {
        echo 'MyHelloWorld2';
    }   
}

$o = new MyHelloWorld();
$o->sayHello();   //will get "trait"

$j = new MyHelloWorld2();
$j->sayHello(); //will get "MyHelloWorld2"
?>
```

- Multiple Traits can be inserted into a class by listing them in the use statement, separated by commas.

```php
<?php
trait Hello {
    public function sayHello() {
        echo 'Hello ';
    }
}

trait World {
    public function sayWorld() {
        echo 'World';
    }
}

class MyHelloWorld {
    use Hello, World;
    public function sayExclamationMark() {
        echo '!';
    }
}

$o = new MyHelloWorld();
$o->sayHello();  //use trait method "sayHello"
$o->sayWorld();  //use trait method "sayWorld"
$o->sayExclamationMark();
?>
```

- **Solve trait method name conflicts:**  If two Traits insert a method with the same name, a fatal error is produced, if the conflict is not explicitly resolved. To resolve naming conflicts between Traits used in the same class, the insteadof operator needs to be used to choose exactly one of the conflicting methods. Since this only allows one to exclude methods, the as operator can be used to add an alias to one of the methods. Note the as operator does not rename the method and it does not affect any other method either.


```php
<?php
trait A {
    public function smallTalk() {
        echo 'a';
    }
    public function bigTalk() {
        echo 'A';
    }
}

trait B {
    public function smallTalk() {
        echo 'b';
    }
    public function bigTalk() {
        echo 'B';
    }
}

class Talker {
    use A, B {
        B::smallTalk insteadof A;
        A::bigTalk insteadof B;
    }
}

class Aliased_Talker {
    use A, B {
        B::smallTalk insteadof A;
        A::bigTalk insteadof B;
        B::bigTalk as talk;
    }
}
?>
```

- Using the as syntax, one can also adjust the visibility of the method in the exhibiting class.

```php
<?php
trait HelloWorld {
    public function sayHello() {
        echo 'Hello World!';
    }
}

// Change visibility of sayHello
class MyClass1 {
    use HelloWorld { sayHello as protected; }
}

// Alias method with changed visibility
// sayHello visibility not changed
class MyClass2 {
    use HelloWorld { sayHello as private myPrivateHello; }
}
?>
```

- static and abstract trait methods

```php
<?php
/*
 * static trait methods
 */
trait StaticExample {
    public static function doSomething() {
        return 'Doing something';
    }
}

class Example {
    use StaticExample;
}

Example::doSomething();


/*
 * abstract trait methods
 */
trait Hello {
    public function sayHelloWorld() {
        echo 'Hello'.$this->getWorld();
    }
    abstract public function getWorld();
}

class MyHelloWorld {
    private $world;
    use Hello;
    public function getWorld() {
        return $this->world;
    }
    public function setWorld($val) {
        $this->world = $val;
    }
}
?>
```

### Overloading in PHP

Overloading in PHP provides means to dynamically create properties and methods. These dynamic entities are processed via magic methods one can establish in a class for various action types.

**property overloading:**

```php
<?php
class PropertyTest
{
    /**  Location for overloaded data.  */
    private $data = array();

    /**  Overloading not used on declared properties.  */
    public $declared = 1;

    /**  Overloading only used on this when accessed outside the class.  */
    private $hidden = 2;

    public function __set($name, $value)
    {
        echo "Setting '$name' to '$value'\n";
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        echo "Getting '$name'\n";
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }

    public function __isset($name)
    {
        echo "Is '$name' set?\n";
        return isset($this->data[$name]);
    }

    public function __unset($name)
    {
        echo "Unsetting '$name'\n";
        unset($this->data[$name]);
    }

    /**  Not a magic method, just here for example.  */
    public function getHidden()
    {
        return $this->hidden;
    }
}


echo "<pre>\n";

$obj = new PropertyTest;

$obj->a = 1;
echo $obj->a . "\n\n";

var_dump(isset($obj->a));
unset($obj->a);
var_dump(isset($obj->a));
echo "\n";

echo $obj->declared . "\n\n";

echo "Let's experiment with the private property named 'hidden':\n";
echo "Privates are visible inside the class, so __get() not used...\n";
echo $obj->getHidden() . "\n";
echo "Privates not visible outside of class, so __get() is used...\n";
echo $obj->hidden . "\n";
?>
```

**method overloading**

```php
<?php
class MethodTest
{
    public function __call($name, $arguments)
    {
        // Note: value of $name is case sensitive.
        echo "Calling object method '$name' "
             . implode(', ', $arguments). "\n";
    }

    public static function __callStatic($name, $arguments)
    {
        // Note: value of $name is case sensitive.
        echo "Calling static method '$name' "
             . implode(', ', $arguments). "\n";
    }
}

$obj = new MethodTest;
$obj->runTest('in object context');

MethodTest::runTest('in static context');
?>
```

### Object iteration
For example:

```php
<?php
class MyClass
{
    public $var1 = 'value 1';
    public $var2 = 'value 2';
    public $var3 = 'value 3';

    protected $protected = 'protected var';
    private   $private   = 'private var';

    function iterateVisible() {
       echo "MyClass::iterateVisible:\n";
       foreach ($this as $key => $value) {
           print "$key => $value\n";
       }
    }
}

$class = new MyClass();


/*
 * This will get:
 * var1 => value 1
 * var2 => value 2
 * var3 => value 3
 */

foreach($class as $key => $value) {
    print "$key => $value\n";
}
echo "\n";

/*
 * This will get:
 * var1 => value 1
 * var2 => value 2
 * var3 => value 3
 * protected => protected var
 * private => private var
 */
$class->iterateVisible();

?>
```

### Object Cloning

Creating a copy of an object with fully replicated properties is not always the wanted behavior.

An object copy is created by using the clone keyword (which calls the object's __clone() method if possible).

When an object is cloned, PHP will perform a shallow copy of all of the object's properties. Any properties that are references to other variables will remain references.

```php
<?php
class SubObject
{
    static $instances = 0;
    public $instance;

    public function __construct() {
        $this->instance = ++self::$instances;
    }

    public function __clone() {
        $this->instance = ++self::$instances;
    }
}

class MyCloneable
{
    public $object1;
    public $object2;

    function __clone()
    {
        // Force a copy of this->object, otherwise
        // it will point to same object.
        $this->object1 = clone $this->object1;
    }
}

$obj = new MyCloneable();

$obj->object1 = new SubObject();
$obj->object2 = new SubObject();

/*
 * According to __clone in MyCloneable
 * object1 will be clone too
 * but object2 will be just a copy-paste
 */
$obj2 = clone $obj;


print("Original Object:\n");
print_r($obj);

print("Cloned Object:\n");
print_r($obj2);

?>
```

### Late static binding

For example:

```php
<?php
class A {
    public static function who() {
        echo __CLASS__;
    }
    public static function test() {
        self::who();
    }
}

class B extends A {
    public static function who() {
        echo __CLASS__;
    }
}

B::test();  // would get "A"

?>
```

```php
class A {
    public static function who() {
        echo __CLASS__;
    }
    public static function test() {
        static::who(); // Here comes Late Static Bindings
    }
}

class B extends A {
    public static function who() {
        echo __CLASS__;
    }
}

B::test();  // would get B
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


### Object Serialization

```php
<?php
// classa.inc:
  
  class A {
      public $one = 1;
    
      public function show_one() {
          echo $this->one;
      }
  }
  
// page1.php:

  include("classa.inc");
  
  $a = new A;
  $s = serialize($a);
  // store $s somewhere where page2.php can find it.
  file_put_contents('store', $s);

// page2.php:
  
  // this is needed for the unserialize to work properly.
  include("classa.inc");

  $s = file_get_contents('store');
  $a = unserialize($s);

  // now use the function show_one() of the $a object.  
  $a->show_one();
?>
```


