# Control structures

### If-elseif-else

```php
<?php
$a=1;
$b=2;
if ($a > $b) {
    echo "a is bigger than b";
} elseif ($a == $b) {
    echo "a is equal to b";
} else {
    echo "a is smaller than b";
}
?>
```

### While

```php
<?php
$i = 1;
while ($i <= 10) {
    echo $i++; 
}
?>
```

### For

```php
<?php
/*
 * This is an array with some data we want to modify
 * when running through the for loop.
 */
$people = array(
    array('name' => 'Kalle', 'salt' => 856412),
    array('name' => 'Pierre', 'salt' => 215863)
);

for($i = 0; $i < count($people); ++$i) {
    $people[$i]['salt'] = mt_rand(000000, 999999);
}
?>
```

### For each
```php
<?php
$arr = array(1, 2, 3, 4);
foreach ($arr as &$value) {
    $value = $value * 2;
}
// $arr is now array(2, 4, 6, 8)
unset($value); // break the reference with the last element


$array = [
    [1, 2],
    [3, 4],
];

foreach ($array as list($a, $b)) {
    // $a contains the first element of the nested array,
    // and $b contains the second element.
    echo "A: $a; B: $b\n";
}


?>
```

### Switch case & match candy

```php
<?php
// This switch statement:

switch ($i) {
    case 0:
        echo "i equals 0";
        break;
    case 1:
        echo "i equals 1";
        break;
    case 2:
        echo "i equals 2";
        break;
}

/*
 * The match expression branches evaluation based on an identity  * check of a value. Similarly to a switch statement
 */

$food = 'cake';

$return_value = match ($food) {
    'apple' => 'This food is an apple',
    'bar' => 'This food is a bar',
    'cake' => 'This food is a cake',
};

var_dump($return_value);  //get 'This food is a cake'
?>



```

### Include & Require

The "include" and "require" expression copy and insert the other php files in specified line.

When the include is falling, it will emit an E_WARNING if it cannot find a file; this is different behavior from require, which will emit an E_ERROR.

```php
<?php
// a.php
$a=10;
?>

<?php
/* b.php
 *insert paste all lines of
 * code from a.php into here.
 */ 
include "a.php";  
$a += 1; //will get 11
?>

```


#### The accessing scope about include&require
1. Any variables available at that line in the calling file will be available within the called file, from that point forward. 

```php
<?php
// a.php
$y=10;

/*
 * will past all lines code of b.php
 * will echo 11
 */
include "b.php";  
?>

<?php
// b.php
$x=1;
echo $x+$y;
?>


```
   
2. All functions and classes defined in the included file have the global scope.

```php
<?php
//vars.php
$color = 'green';
$fruit = 'apple';

?>


<?php
//test.php
echo "A $color $fruit"; // A

// $color and $fruit in vars.php has global scope
include 'vars.php';    

// code in test.php can access vars.php as global scope
echo "A $color $fruit"; 

?>
```

#### require once & include once

if you want to require or include file only once time,please use it. PHP will check if the file has already been included, and if so, not include (require) it again.

