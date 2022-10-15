## Float

### Representation of Float data

Floating point numbers (also known as "floats", "doubles", or "real numbers") can be specified using any of the 
following syntax:

```php
<?php
$a = 1.234; 
$b = 1.2e3; 
$c = 7E-10;  //science representation of float value
?>
```

### Floating point precision limit
Floating point numbers have limited precision. Although it depends on the system, PHP typically uses the 
IEEE 754 double precision format, which will give a maximum relative error due to rounding in the order of 1.11e-16.

#### Don't cast data with precision loss

Due to the loss precision about converting float into integer, please do not convert float into integer in frequently.
For example, floor((0.1+0.7)*10) will usually return 7 instead of the expected 8, since the internal representation
will be something like 7.9999999999999991118.

#### Comparing float values for equality with epsilon

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


#### NaN is a special value of float

Some numeric operations can result in a value represented by the constant NAN. This result represents an undefined or unrepresentable value in floating-point calculations. Any loose or strict comparisons of this value against any other value, including itself, but except true, will have a result of false.

Because NAN represents any number of different values, NAN should not be compared to other values, including itself, and instead should be checked for using is_nan().

```php
// will be true
is_nan(NAN);

// will be false
NAN == NAN;
```


