# Name Space

PHP Namespaces provide a way in which to group related classes, interfaces, functions and constants. 

Namespaces are declared using the namespace keyword. A file containing a namespace must declare the namespace at the top of the file before any other code， For example:

```php
<?php
namespace my\name; 

class MyClass {}
function myfunction() {}
const MYCONST = 1;



$c = new \my\name\MyClass; 


/*
 * namespace operator and
 * __NAMESPACE__ magic constant
 * can stands for current namespace str
 */
$d = namespace\MYCONST;   //will get "\my\name\MYCONST"
echo $d;   //will get 1

$d = __NAMESPACE__ . '\MYCONST';   //will get "\my\name\MYCONST" too
echo constant($d);   //will get 1 too
?>
```

### Namespace Resolution Rules

1. For Fully qualified name like ```$a = new \currentnamespace\foo(); ``` This always resolves to the literal name specified in the code, currentnamespace\foo.

2. For Qualified name  like ```$a = new subnamespace\foo();``` 
    -  If the code is global, non-namespaced code, this resolves to subnamespace\foo.
    - If the current namespace is currentnamespace, this resolves to currentnamespace\subnamespace\foo. 
    
3. For Unqualified name like ``` $a = new foo(); ```
    - If the code is global, non-namespaced code, this resolves to foo.
     - If the current namespace is currentnamespace, this resolves to currentnamespace\foo. 


### Namespace constant
- The value of __NAMESPACE__ is a string that contains the current namespace name.
- In global, un-namespaced code, it contains an empty string.

```php
<?php
namespace MyProject;

echo '"', __NAMESPACE__, '"'; // outputs "MyProject"
?>
```

```php
<?php

echo '"', __NAMESPACE__, '"'; // outputs ""
?>
```

### Namespace aliasing

Aliasing is accomplished with the use operator. PHP can alias constants, functions, classes, interfaces, traits, enums and namespaces.

```php
<?php
namespace foo;

// importing a global class
use ArrayObject;

// aliasing class 
use My\Full\Classname as Another;

// importing a constant
use const My\Full\CONSTANT;

/*
 * importing a function
 * this is the same as use My\Full\functionName as functionName
 */
use function My\Full\functionName;

// aliasing a function
use function My\Full\functionName as func;

/*
 * equal to $obj = new namespace\Another;
 */
$obj = new Another; 

/*
 * euqal to calls function My\Full\NSname\subns\func
 */
NSname\subns\func(); 

// instantiates object of class ArrayObject
$a = new ArrayObject(array(1)); 

// calls function My\Full\functionName
func(); 

// echoes the value of My\Full\CONSTANT
echo CONSTANT; 
?>
```

- Group use declarations

```php
<?php

use some\namespace\ClassA;
use some\namespace\ClassB;
use some\namespace\ClassC as C;

use function some\namespace\fn_a;
use function some\namespace\fn_b;
use function some\namespace\fn_c;

use const some\namespace\ConstA;
use const some\namespace\ConstB;
use const some\namespace\ConstC;
?>

```

is equivalent to:

```php
<?php
use some\namespace\{ClassA, ClassB, ClassC as C};
use function some\namespace\{fn_a, fn_b, fn_c};
use const some\namespace\{ConstA, ConstB, ConstC};
?>
```

- namespace aliasing is performed at compile-time, and so does not affect dynamic class, function or constant names.

```php
<?php
use My\Full\Classname as Another, My\Full\NSname;

$obj = new Another; // instantiates object of class My\Full\Classname
$a = 'Another';
$obj = new $a;      // instantiates object of class Another
?>
```

- In addition, **namespace aliasing only affects unqualified and qualified names. Fully qualified names are absolute, and unaffected by imports.**

```php
<?php
use My\Full\Classname as Another, My\Full\NSname;

$obj = new Another; // instantiates object of class My\Full\Classname
$obj = new \Another; // instantiates object of class Another
$obj = new Another\thing; // instantiates object of class My\Full\Classname\thing
$obj = new \Another\thing; // instantiates object of class Another\thing
?>
```

- The use keyword must be declared in the outermost scope of a file (the global scope) or inside namespace declarations. This is because the importing is done at compile time and not runtime, so it cannot be block scoped. 

```php
<?php
namespace Languages;

function toGreenlandic()
{
    use Languages\Danish; //causes fatal error

}
?>
```

- If you need to access internal or non-namespaced user classes, one must refer to them with their fully qualified Name


```php
<?php
namespace A\B\C;
class Exception extends \Exception {}

$a = new Exception('hi'); // $a is an object of class A\B\C\Exception
$b = new \Exception('hi'); // $b is an object of class Exception

$c = new ArrayObject; // fatal error, class A\B\C\ArrayObject not found
?>
```

- If you need to get functions and constants, PHP will fall back to global functions or constants if a namespaced function or constant does not exist.

```php
<?php
namespace A\B\C;

const E_ERROR = 45;
function strlen($str)
{
    return \strlen($str) - 1;
}

echo E_ERROR, "\n"; // prints "45"
echo INI_ALL, "\n"; // prints "7" - falls back to global INI_ALL

echo strlen('hi'), "\n"; // prints "1"
if (is_array('hi')) { // prints "is not array"
    echo "is array\n";
} else {
    echo "is not array\n";
}
?>
```


### Name resolution rule examples

```php
<?php
namespace A;
use B\D, C\E as F;

// function calls

foo();      // first tries to call "foo" defined in namespace "A"
            // then calls global function "foo"

\foo();     // calls function "foo" defined in global scope

my\foo();   // calls function "foo" defined in namespace "A\my"

F();        // first tries to call "F" defined in namespace "A"
            // then calls global function "F"

// class references

new B();    // creates object of class "B" defined in namespace "A"
            // if not found, it tries to autoload class "A\B"

new D();    // using import rules, creates object of class "D" defined in namespace "B"
            // if not found, it tries to autoload class "B\D"

new F();    // using import rules, creates object of class "E" defined in namespace "C"
            // if not found, it tries to autoload class "C\E"

new \B();   // creates object of class "B" defined in global scope
            // if not found, it tries to autoload class "B"

new \D();   // creates object of class "D" defined in global scope
            // if not found, it tries to autoload class "D"

new \F();   // creates object of class "F" defined in global scope
            // if not found, it tries to autoload class "F"

// static methods/namespace functions from another namespace

B\foo();    // calls function "foo" from namespace "A\B"

B::foo();   // calls method "foo" of class "B" defined in namespace "A"
            // if class "A\B" not found, it tries to autoload class "A\B"

D::foo();   // using import rules, calls method "foo" of class "D" defined in namespace "B"
            // if class "B\D" not found, it tries to autoload class "B\D"

\B\foo();   // calls function "foo" from namespace "B"

\B::foo();  // calls method "foo" of class "B" from global scope
            // if class "B" not found, it tries to autoload class "B"

// static methods/namespace functions of current namespace

A\B::foo();   // calls method "foo" of class "B" from namespace "A\A"
              // if class "A\A\B" not found, it tries to autoload class "A\A\B"

\A\B::foo();  // calls method "foo" of class "B" from namespace "A"
              // if class "A\B" not found, it tries to autoload class "A\B"
?>
```