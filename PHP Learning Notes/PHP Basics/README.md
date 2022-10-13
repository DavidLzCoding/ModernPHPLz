# PHP programming basics

## php tags

### php normal tags syntax
In normal, we would use ```<?php   ?>``` paired tags to include php codes, for example:
```php
<?php 
    echo 'While this is going to be parsed.'; 
?>

```



### Embedded PHP codes in HTML codes with PHP tages

Everything outside of a pair of opening and closing tags is ignored by the PHP parser which allows PHP to be embedded in HTML documents.

For example:

- The PHP interpreter hits the ?> closing tags, it simply starts outputting whatever it finds, until it hits another opening tag: 
```php
<?php echo 'While this is going to be parsed.'; ?>
<p>This will also be ignored by PHP and displayed by the browser.</p>
```

- php tags can also skip text when interpreter meets function definition syntax.

```html
<html>
<?php
function show($a) {
    ?>
    <a href="https://www.<?php echo $a ?>.com">
    Link
    </a>
    <?php
}
?>
<body>
    <?php show("google") ?>
</body>
</html>
```

- Embedded PHP conditional statements and control statements have special embedding rules. You should consider the entire conditional statements and control statements as one block. The interpreter will determine the outcome of the conditional, and decide which small block would be skipped over.

```html
<!--Take entire if-else-endif statements as a big block -->
<!--The interpreter will determine the statements outcome and decide to skip any small blocks -->
<?php if (1 == true): ?>
    This will be not skipped,because the expression is true.
<?php else: ?>
    This will be skipped,because the if statements is true.
<?php endif; ?>


<!--Take entire For statements as a big block -->
<?php for ($i = 0; $i < 5; ++$i): ?>
Hello, there!
<?php endfor; ?>
```

## PHP Comments

### one line comment
For example:

```php
<?php

// Control
echo microtime(), "<br />"; // 0.25163600 1292450508
echo microtime(), "<br />"; // 0.25186000 1292450508
?>

```

### Multi-line comment

```php
<?php
/**
* The second * here opens the DocBook commentblock, which could later on<br>
* in your development cycle save you a lot of time by preventing you having to rewrite<br>
* major documentation parts to generate some usable form of documentation.
*/
?>
```













### Type Manual Cast

- The casts Syntax allowed are:
    - (int) - cast to int
    - (bool) - cast to bool
    - (float) - cast to float
    - (string) - cast to string
    - (array) - cast to array
    - (object) - cast to object
    - (unset) - cast to NULL
    
For example:

```php
<?php
$foo = 10;   // $foo is an integer
$bar = (bool) $foo;   // $bar is a boolean
?>
```

Otherwise, you can use function ```settype``` to cast data type:

```php
<?php
$foo = "5bar"; // string
$bar = true;   // boolean

settype($foo, "integer"); // $foo is now 5   (integer)
settype($bar, "string");  // $bar is now "1" (string)
?>
```

### Type automatic cast


### Float variable comparisons

To test floating point values for equality, an upper bound on the relative error due to rounding is used. This value is known as the machine epsilon, or unit roundoff, and is the smallest acceptable difference in calculations.

For example, $a and $b are equal to 5 digits of precision. 

```php
<?php
$a = 1.23456789;
$b = 1.23456780;
$epsilon = 0.00001;

if(abs($a-$b) < $epsilon) {
    echo "true";
}
?>
```

### NAN value in float data type

Some numeric operations can result in a value represented by the constant NAN. This result represents an undefined or unrepresentable value in floating-point calculations. 

Because NAN represents any number of different values, NAN should not be compared to other values, including itself, and instead should be checked for using is_nan().

For example:

![img_3.png](img_3.png)


### String representation rules

In php, both single quote and double quote,can represent string values, but there are few differences usages between them. 


1. Single quote represented string:
   - The simplest way to specify a string is to enclose it in single quotes (the character '). To specify a literal single quote, escape it with a backslash (\). To specify a literal backslash, double it (\\). All other instances of backslash will be treated as a literal backslash: this means that the other escape sequences you might be used to, such as \r or \n, will be output literally as specified rather than having any special meaning.
  
```php
<?php
echo 'this is a simple string';

echo 'You can also have embedded newlines in
strings this way as it is
okay to do';

// Outputs: Arnold once said: "I'll be back"
echo 'Arnold once said: "I\'ll be back"';

// Outputs: You deleted C:\*.*?
echo 'You deleted C:\\*.*?';

// Outputs: You deleted C:\*.*?
echo 'You deleted C:\*.*?';

// Outputs: This will not expand: \n a newline
echo 'This will not expand: \n a newline';

// Outputs: Variables do not $expand $either
echo 'Variables do not $expand $either';
?>
```

2. Double quote represented string:
   - If the string is enclosed in double-quotes ("), PHP will interpret  such as \r or \n, will be output as special meaning,For example:
  
![img_4.png](img_4.png)


#### 


### PHP array data type

- What is array in php, how it's implemented?
    - An array in PHP is actually an ordered map. A map is a type that associates values to keys. 
      
- The usages about array in PHP
    - This type is optimized for several different uses;.
    - It can be treated as an array, list (vector), hash table (an implementation of a map), dictionary, collection, stack, queue, and probably more.
    

#### Syntax for about defining an array
- The key can either be an int or a string. The value can be of any type.

```php
<?php
/*
 * 
 */
$array = array(
    "foo" => "bar",
    1 => "foo",
);

// Using the short array syntax
$array = [
    "foo" => "bar",
    "bar" => "foo",
];

//Indexed arrays without key
$array = array("foo", "bar", "hello", "world");

?>
```

#### Rule for array key casting:

![img_5.png](img_5.png)
  
```php
<?php
$array = array(
    1    => 'a',
    '1'  => 'b', // the value "a" will be overwritten by "b"
    1.5  => 'c', // the value "b" will be overwritten by "c"
    -1 => 'd',
    '01'  => 'e', // as this is not an integer string it will NOT override the key for 1
    '1.5' => 'f', // as this is not an integer string it will NOT override the key for 1
    true => 'g', // the value "c" will be overwritten by "g"
    false => 'h',
    '' => 'i',
    null => 'j', // the value "i" will be overwritten by "j"
    'k', // value "k" is assigned the key 2. This is because the largest integer key before that was 1
    2 => 'l', // the value "k" will be overwritten by "l"
);

var_dump($array);
?>
```

#### Basic Rule for accessing array elements

- Array elements can be accessed using the array[key] syntax.

```php
<?php
$array = array(
    "foo" => "bar",
    42    => 24,
    "multi" => array(
         "dimensional" => array(
             "array" => "foo"
         )
    )
);

var_dump($array["foo"]);
var_dump($array[42]);
var_dump($array["multi"]["dimensional"]["array"]);


// constant and variables can also be used in array[key] syntax
const FOO="foo";
var_dump($array[FOO]);   // this will get "bar"

$Foo = "foo";
var_dump($array[$Foo]);  // this will also get "bar"


?>
```

#### Advanced rule for accessing array elements

Arrays can be destructured using the [] (as of PHP 7.1.0) or list() language constructs. These constructs can be used to destructure an array into distinct variables.

```php
<?php
$source_array = ['foo', 'bar', 'baz'];
// destruct array by assignment statement and [].
[$foo, $bar, $baz] = $source_array;
[, ,$baz] = $source_array;    //get the last element only


// destruct array by foreach statement and []
$source_array = [
    [1, 'John'],
    [2, 'Jane'],
];

foreach ($source_array as [$id, $name]) {
    // logic here with $id and $name
}
?>
```


#### Rule for modifying array elements

- Array elements can be modified and added using the array[key] syntax.

- Array and it's elements can be deleted using the unset function.**Be aware that, due to the data structure implementation of Array,the array will not be reindexed. If a true "remove and shift" behavior is desired, the array can be reindexed using the array_values() function.**

```php
<?php
$arr = array(5 => 1, 12 => 2);

$arr[] = 56;    // This is the same as $arr[13] = 56;
                // at this point of the script

$arr["x"] = 42; // This adds a new element to
                // the array with key "x"
                
$arr[13] = 5600; // This will modify 56 to 5600

echo var_dump($arr);
                
unset($arr[5]); // This removes the element from the array

echo var_dump($arr);

unset($arr);    // This deletes the whole array



$a = array(1 => 'one', 2 => 'two', 3 => 'three');

/* will produce an array that would have been defined as
   $a = array(1 => 'one', 3 => 'three');
   and NOT
   $a = array(1 => 'one', 2 =>'three');
*/
unset($a[2]);

// Now $b is array(0 => 'one', 1 =>'three')
$b = array_values($a);

// Now $a will be an empty array
unset($a);
?>
```

#### The array current-maximum-indexing little trap

Note that the maximum integer key used for this need not currently exist in the array. It need only have existed in the array at some time since the last time the array was re-indexed. The following example illustrates:

```php
<?php
// Create a simple array.
$array = array(1, 2, 3, 4, 5);
print_r($array);

// Now delete every item, but leave the array itself intact:
foreach ($array as $i => $value) {
    unset($array[$i]);
}
print_r($array);

// Append an item (note that the new key is 5, instead of 0).
$array[] = 6;
print_r($array);

// Re-index:
$array = array_values($array);
$array[] = 7;
print_r($array);
?>
```