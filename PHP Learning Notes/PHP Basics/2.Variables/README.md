## Variables

Variables in PHP are represented by a dollar sign followed by the name of the variable. The variable name is case-sensitive.

```php
<?php
$Foo = 'Bob';
$Bar = 'Joe';
// $foo is not work due to case-sensitive
echo "$Foo, $Bar";      // outputs "Bob, Joe"
?>

```

### Assign variables by value

By default, variables are always assigned by value.This means, for instance, that after assigning one variable's value to another, changing one of those variables will have no effect on the other.

```php
<?php
$foo = 'Bob';              // Assign the value 'Bob' to $foo
$bar = $foo;               // Reference $foo via $bar.
$bar = "Jack";             // Alter $bar,but not foo
echo $bar;                 // $bar is jack
echo $foo;                 // $foo is Bob

?>
```

### Assign variables by reference

To assign by reference, simply prepend an ampersand (&) to the beginning of the variable which is being assigned (the source variable).

This means that the new variable simply references (in other words, "becomes an alias for" or "points to") the original variable. Changes to the new variable affect the original, and vice versa.

```php
<?php
$foo = 'Bob';              // Assign the value 'Bob' to $foo
$bar = &$foo;              // Reference $foo via $bar.
$bar = "My name is $bar";  // Alter $bar...
echo $bar;
echo $foo;                 // $foo is altered too.
?>
```

Invalid assign by reference 

```php
<?php
$foo = 25;
$bar = &$foo;      // This is a valid assignment.

// Invalid; references an unnamed expression.
$bar = &(24 * 7);  


function test()
{
   return 25;
}

// Invalid. php can't assign a reference of function
$bar = &test();    
?>
```


### Uninitialized variables rule


```php
<?php
// Unset AND unreferenced (no use context) variable; outputs NULL
var_dump($unset_var);

// Boolean usage; outputs 'false' (See ternary operators for more on this syntax)
echo($unset_bool ? "true\n" : "false\n");

// String usage; outputs 'string(3) "abc"'
$unset_str .= 'abc';
var_dump($unset_str);

// Integer usage; outputs 'int(25)'
$unset_int += 25; // 0 + 25 => 25
var_dump($unset_int);

// Float usage; outputs 'float(1.25)'
$unset_float += 1.25;
var_dump($unset_float);

// Array usage; outputs array(1) {  [3]=>  string(3) "def" }
$unset_arr[3] = "def"; // array() + array(3 => "def") => array(3 => "def")
var_dump($unset_arr);

// Object usage; creates new stdClass object (see http://www.php.net/manual/en/reserved.classes.php)
// Outputs: object(stdClass)#1 (1) {  ["foo"]=>  string(3) "bar" }
$unset_obj->foo = 'bar';
var_dump($unset_obj);
?>
```


E_NOTICE level error is issued in case of working with uninitialized variables, isset() language construct can be used to detect if a variable has been already initialized.

```php
<?php

isset($a);
?>
```

### PHP predefined variables

PHP provides a large number of predefined variables to any script which it runs. Many of these variables, however, cannot be fully documented as they are dependent upon which server is running.

```text
Superglobals — Built-in variables that are always available in all scopes
$GLOBALS — References all variables available in global scope
$_SERVER — Server and execution environment information
$_GET — HTTP GET variables
$_POST — HTTP POST variables
$_FILES — HTTP File Upload variables
$_REQUEST — HTTP Request variables
$_SESSION — Session variables
$_ENV — Environment variables
$_COOKIE — HTTP Cookies
$php_errormsg — The previous error message
$http_response_header — HTTP response headers
$argc — The number of arguments passed to script
$argv — Array of arguments passed to script

```

### PHP variable scope

For the most part all PHP variables only have a single scope. This single scope spans included and required files as well.

For example,Here the $a variable will be available within the included b.inc script.

```php
<?php
$a = 1;
include 'b.inc';
?>

```

#### local function scope

Any variable used inside a function is by default limited to the local function scope. For example:

```php
<?php


function test()
{ 
    $a = 1; 
    echo $a; // reference to local scope variable
} 

// local scope variable can't access in global scope
$a;  
?>

```

#### Global scope variable rules

Global variables in C are automatically available to functions unless specifically overridden by a local definition. 

This can cause some problems in that people may inadvertently change a global variable. 

In PHP global variables must be declared global inside a function if they are going to be used in that function.

There is no limit to the number of global variables that can be manipulated by a function.

For example:

```php
<?php
$a = 1;
$b = 2;

function Sum()
{
    global $a, $b;

    $b = $a + $b;
} 

Sum();
echo $b;   // should be 3, due to global keywords
?>
```

A second way to access variables from the global scope is to use the special PHP-defined $GLOBALS array. The previous example can be rewritten as:

```php
<?php
$a = 1;
$b = 2;

function Sum()
{
    $GLOBALS['b'] = $GLOBALS['a'] + $GLOBALS['b'];
} 

Sum();
echo $b;
?>
```

#### static variable scope

A static variable exists only in a local function scope, but it does not lose its value when program execution leaves this scope.

Now, $a is initialized only in first call of function and every time the test() function is called it will print the value of $a and increment it.

Static variables can be assigned values which are the result of constant expressions, but dynamic expressions, such as function calls, will cause a parse error.


```php
<?php
function test()
{
    static $a = 0;
    static $int = sqrt(121);  // wrong  (as it is a function)
    echo $a;
    $a++;
}
?>
```


As of PHP 8.1.0, when a method using static variables is inherited (but not overridden), the inherited method will now share static variables with the parent method. This means that static variables in methods now behave the same way as static properties.


```php
<?php
class Foo {
    public static function counter() {
        static $counter = 0;
        $counter++;
        return $counter;
    }
}
class Bar extends Foo {}
var_dump(Foo::counter()); // int(1)
var_dump(Foo::counter()); // int(2)
var_dump(Bar::counter()); // int(3), prior to PHP 8.1.0 int(1)
var_dump(Bar::counter()); // int(4), prior to PHP 8.1.0 int(2)
?>
```