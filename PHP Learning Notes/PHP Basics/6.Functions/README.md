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