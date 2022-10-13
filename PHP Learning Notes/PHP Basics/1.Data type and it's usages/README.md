## PHP Data Types

Like other programming languages, PHP provides a series of primitive data types


### Scalar primitive types
- bool
- int 
- float
- string

### Compound primitive types
Compound primitive types have compound data structure, and it contains some of scalar data.

- array
- object
- callable
- iterable

### Special primitive types

Special primitive types provide special usages for programmers.

- resources
- NULL


### System pre-defined constant for data types

```php
echo PHP_INT_MAX; //check the maximum representation about int type
echo PHP_FLOAT_MIN;   //check the minimum representation about float type
echo PHP_INT_SIZE; //check the storage bit size about int type

```

### System self-contained functions for data types checking

For example:

```php
<?php
$a = 12;

// function var_dump will return data type and data value both
// this statement will get text "int(12)" as a return value
var_dump($a);

// function gettype will return data type only
// this statement will get text "integer"
gettype($a);

// function is_string will return boolean value
// this statement will get false,because of $a is integer type.
is_string($a);
?>



```




### PHP data type cast

Like other programming languages, PHP defined its type cast rules that control the value transformation between different data types.

There are two kinds of data cast which are "manual data cast" and "automatic data cast".

#### automatic data type cast
- Arithmetic operation with different type of values will execute automatic data type cast.

```php
<?php
/*
 * string will be automatic convert to int or float 
 * that depends on content of the string.
 */
$foo = 1 + "10";  // "10" will be casted to int(10)
$foo = 1 + "10.5"; // "10.5" will be casted to float(10.5)
$foo = 1 + "10.2 Little Piggies";   // will be float(10.2)


/*
 * True will be casted to int(1),
 * False will be casted to int(0).
 */
$foo = 1 + True;   // variable $foo will result in 2 

?>
```

- Division operation will cast the result into float when the result is not still integer.

```php
<?php
// float(3.5714285714286)
var_dump(25/7);         

// if you want integer division
var_dump(intdiv(25,7)); //will get 3
?>
```

- integer overflow will cast it into float data type.

```php
<?php
// int(9223372036854775807) is the biggest number in 64-bit system
$large_number = 9223372036854775807;
var_dump($large_number);       

/*
 * int(9223372036854775808) is over flow
 * and will be casted into float(9.2233720368548E+18)
 */   
$large_number = 9223372036854775808;
var_dump($large_number);                     

?>
```


#### manual data type cast

- use "(type)value" syntax or type cast function will cast data manually.

```php
<?php
// use (int)value  to cast value into integer
var_dump((int) (25/7)); // int(3)

// use function intval() to cast value into integer
var_dump(intval(25/7));  // float(4)
?>
```


#### Rules about casting values to integer value:

1. **Boolean to Integer:** false will yield 0 (zero), and true will yield 1 (one).
2. **Float to Integer:** When converting from float to int, the number will be rounded towards zero.
3. **String to Integer:** If the string is numeric or leading numeric then it will resolve to the corresponding integer value, otherwise it is converted to zero (0).
4. **NaN,null and Infinity to Integer:** NaN,null and Infinity will always be zero when cast to int.

#### Rules about casting values to Float value:


#### Rules about casting values to Boolean value:


