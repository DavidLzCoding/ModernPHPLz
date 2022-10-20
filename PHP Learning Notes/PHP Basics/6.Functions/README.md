# Functions

### Rule about function definition and calling

1. Functions need not be defined before they are referenced.
   
```php
<?php
/* We can call bar() */
bar();

function bar() 
{
  echo "I exist immediately upon program start.\n";
}

?>
```

2. Any valid PHP code may appear inside a function, even other functions and class definitions.

3. All functions and classes in PHP have the global scope - they can be called outside a function even if they were defined inside and vice vers.

```php
<?php
function foo()
{
    function bar(){
        echo "bar";
    }
    bar();
    echo "foo";
}

   
// error! var yet defined before foo first called
bar(); 


/* Now we can call bar(),
   foo()'s processing has
   made it accessible. */
foo();
bar();
?>
```

### Function arguments
Information may be passed to functions via the argument list, which is a comma-delimited list of expressions. The arguments are evaluated from left to right, before the function is actually called (eager evaluation).

#### Passing arguments as value copy

```php
<?php
function add_some_extra($string)
{
    $string .= 'and something extra.';
}
$str = 'This is a string, ';
add_some_extra($str);

// only outputs 'This is a string'
echo $str;    
?>
```


#### Passing arguments as reference

```php
<?php
function add_some_extra(&$string)
{
    $string .= 'and something extra.';
}
$str = 'This is a string, ';
add_some_extra($str);

// outputs 'This is a string, and something extra.'
echo $str;    
?>
```

#### Rules about default argument values
The default value must be a constant expression, not (for example) a variable, a class member or a function call.

```php
<?php
function makecoffee($type = "cappuccino")
{
    return "Making a cup of $type.\n";
}

// Making a cup of cappuccino.
echo makecoffee();   

// Making a cup of .
echo makecoffee(null);    

//Making a cup of espresso.
echo makecoffee("espresso"); 
?>
```


```php
<?php
/*
 * No-scalar types as default argument values
 */
 
function makecoffee($types = array("cappuccino"), $coffeeMaker = NULL)
{
    $device = is_null($coffeeMaker) ? "hands" : $coffeeMaker;
    return "Making a cup of ".join(", ", $types)." with $device.\n";
}
echo makecoffee();
echo makecoffee(array("cappuccino", "lavazza"), "teapot");
?>
```


```php
<?php
/*
 * using object as default argument values
 */
 class DefaultCoffeeMaker {
    public function brew() {
        return 'Making coffee.';
    }
}
class FancyCoffeeMaker {
    public function brew() {
        return 'Crafting a beautiful coffee just for you.';
    }
}
function makecoffee($coffeeMaker = new DefaultCoffeeMaker)
{
    return $coffeeMaker->brew();
}
echo makecoffee();
echo makecoffee(new FancyCoffeeMaker);
 
?>
```

```php
<?php
/*
 * The sequence rule about default arguments
 * which be passed by.
 */
function makeyogurt($flavour, $container = "bowl")
{
    return "Making a $container of $flavour yogurt.\n";
}

/*
 * "raspberry" has been passed into $flavour
 * due to the sequence rules
 */
echo makeyogurt("raspberry"); 


function makeyogurt2($container = "bowl", $flavour )
{
    return "Making a $container of $flavour yogurt.\n";
}

/*
 * After PHP8.0.
 * otherwise you  can name the arguments to pass value.
 */
echo makeyogurt2(flavour: "raspberry");  
?>
```


#### Variable-length argument

Variable-length argument can be used in function define or function call, in order to pass variable-length of arguments.

For example:
```php
<?php
/*
 * Use ...$numbers as variable-length argument definition.
 */
function sum(...$numbers) {
    $acc = 0;
    foreach ($numbers as $n) {
        $acc += $n;
    }
    return $acc;
}

echo sum(1, 2, 3, 4);


function add($a, $b) {
    return $a + $b;
}

//use ...[1,2] as variable-length argument function all
echo add(...[1, 2])."\n";   

//use ...$array as variable-length argument function all
$a = [1, 2];
echo add(...$a);


/*
 *  Type declared variable-length arguments
 */
function total_intervals($unit, DateInterval ...$intervals) {
    $time = 0;
    foreach ($intervals as $interval) {
        $time += $interval->$unit;
    }
    return $time;
}

$a = new DateInterval('P1D');
$b = new DateInterval('P2D');
echo total_intervals('d', $a, $b).' days';

// This will fail, since null isn't a DateInterval object.
echo total_intervals('d', null);
?>

```

### Return values

Return statement causes the function to end its execution immediately and pass control back to the line from which it was called.

Any type may be returned, including arrays and objects. 

#### Return scalar value

```php
<?php
function square($num)
{
    return $num * $num;
}
echo square(4);   // outputs '16'.
?>
```

#### Return array 

```php
<?php
function small_numbers()
{
    return [0, 1, 2];
}
// Array destructuring will collect each member of the array individually
[$zero, $one, $two] = small_numbers();

// Prior to 7.1.0, the only equivalent alternative is using list() construct
list($zero, $one, $two) = small_numbers();

?>
```

#### Return as references
To return a reference from a function, use the reference operator & in both the function declaration and when assigning the returned value to a variable:

```php
<?php
function &returns_reference()
{
    $someref=1;
    return $someref;
}

$newref =& returns_reference();
?>
```

### Variable-name function
PHP supports the concept of variable functions. This means that if a variable name has parentheses appended to it, PHP will look for a function with the same name as whatever the variable evaluates to, and will attempt to execute it.

```php
<?php
class Foo
{
    function Variable()
    {
        $name = 'Bar';
        $this->$name(); // This calls the Bar() method
    }
    
    function Bar()
    {
        echo "This is Bar";
    }
}

$foo = new Foo();
$funcname = "Variable";
$foo->$funcname();  // This calls $foo->Variable()
?>
```

#### variable-name of static method 

```php
class Foo
{
    static $variable = 'static property';
    static function Variable()
    {
        echo 'Method Variable called';
    }
}


/*
 * This prints 'static property'.
 * It does need a $variable in this scope.
 */
echo Foo::$variable; 

/*
 * This calls $foo->Variable() reading $variable in this scope.
 */
$variable = "Variable";
Foo::$variable();  
```


### Anonymous function

Anonymous functions, also known as closures, allow the creation of functions which have no specified name. They are most useful as the value of callable parameters, but they have many other uses.

```php
<?php
// anonymous function used in function call 
echo preg_replace_callback('~-([a-z])~', function ($match) {
    return strtoupper($match[1]);
}, 'hello-world');


// anonymous function assignment to variable
$greet = function($name)
{
    printf("Hello %s\r\n", $name);
};

$greet('World');
$greet('PHP');
?>
```

#### Anonymous function inherit variables from parent scope

Closures may also inherit variables from the parent scope, through the "use()"syntax.

As of PHP 7.1, in "use()" syntax,it must not include super-global variables, $this, or variables with the same name as a parameter. A return type declaration of the function has to be placed after the use clause.

```php
<?php
$message = 'hello';

/*
 * "use()" syntax in value passed by copy
 */
$example = function () use ($message) {
    var_dump($message);
};
$example(); // will output "hello"

$message = 'world';

// still output "hello" due to the use is value copy syntax now
$example();   


/*
 * "use()" syntax in value passed by reference
 */
$message = 'hello';

$example = function () use (&$message) {
    var_dump($message);
};

$example();   //will export hello

$message = 'world';
$example();   // will export world



/*
 * Closures can also accept regular arguments
 */ 
$example = function ($arg) use ($message) {
    var_dump($arg . ' ' . $message);
};
$example("hello");


/*
 * Return type declaration comes after the use clause
 */
$example = function () use ($message): string {
    return "hello $message";
};
var_dump($example());

?>
```

#### Anonymous function automatic binding

When anonymous function declared in the context of a class, the current class is automatically bound to it, making $this available inside of the function's scope.

```php
<?php

class Test
{
    public function testing()
    {
        return function() {
            var_dump($this);
        };
    }
}

$object = new Test;
$function = $object->testing();




var_dump($object);  // will output object(Test)#1 

$function(); //still output object(Test)#1 
    
?>
```

#### Good example of anonymous function 

```php
<?php
// A basic shopping cart which contains a list of added products
// and the quantity of each product. Includes a method which
// calculates the total price of the items in the cart using a
// closure as a callback.
class Cart
{
    const PRICE_BUTTER  = 1.00;
    const PRICE_MILK    = 3.00;
    const PRICE_EGGS    = 6.95;

    protected $products = array();
    
    public function add($product, $quantity)
    {
        $this->products[$product] = $quantity;
    }
    
    public function getQuantity($product)
    {
        return isset($this->products[$product]) ? 
        $this->products[$product] : FALSE;
    }
    
    public function getTotal($tax)
    {
        $total = 0.00;
        
        $callback =
            function ($quantity, $product) use ($tax, &$total)
            {
                $pricePerItem = constant(__CLASS__ . "::PRICE_" .
                    strtoupper($product));
                $total += ($pricePerItem * $quantity) * ($tax + 1.0);
            };
        
        array_walk($this->products, $callback);
        return round($total, 2);
    }
}

$my_cart = new Cart;

// Add some items to the cart
$my_cart->add('butter', 1);
$my_cart->add('milk', 3);
$my_cart->add('eggs', 6);

// Print the total with a 5% sales tax.
print $my_cart->getTotal(0.05) . "\n";
// The result is 54.29
?>
```

#### Static anonymous functions

Anonymous functions may be declared statically. This prevents them from having the current class automatically bound to them. Objects may also not be bound to them at runtime.

```php
<?php

class Foo
{
    function __construct()
    {
        $func = static function() {
            var_dump($this);
        };
        $func();
    }
};
new Foo();  //will output Notice: Undefined variable: this in %s on line %d

?>
```

### Arrow functions

Arrow functions were introduced in PHP 7.4 as a more concise syntax for anonymous functions.

Arrow functions support the same features as anonymous functions, except that using variables from the parent scope is always automatic.When a variable used in the expression is defined in the parent scope it will be implicitly captured by-value.

```php
<?php

$y = 1;

$fn2 = function ($x) use ($y) {
    return $x + $y;
};
 
$fn1 = fn($x) => $x + $y;  //arrow function can used without "use" sytax


var_export($fn2(3)); //will output 4

var_export($fn1(3)); //still output 4

/*
 * passed by value about arrow function
 */
$x = 1;
$fn = fn() => $x++; // Has no effect
$fn();
var_export($x);  // Outputs 1 


/*
 * Examples of other arrow function examples
 */
fn(array $x) => $x;
static fn($x): int => $x;
fn($x = 42) => $x;
fn(&$x) => $x;
fn&($x) => $x;
fn($x, ...$rest) => $rest;

?>
```




