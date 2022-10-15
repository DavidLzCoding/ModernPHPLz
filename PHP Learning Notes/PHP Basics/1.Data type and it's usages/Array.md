## PHP array data type

**An array in PHP is actually an ordered dict which is a type that associates value to key.**


Array data type is optimized for several different uses;It can be treated as an array, list (vector), hash table (an implementation of a map), dictionary, collection, stack, queue, and probably more.


#### Syntax for about defining an array
- The key can either be an int or a string. The value can be of any type.

```php
<?php
// Using the normal array syntax
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

#### Rule for array keys:

- The key can either be an int or a string. The value can be of any type.Arrays and objects can not be used as keys
- **Use String as array key:** For string containing valid decimal integer, will be cast to the int type; Otherwise, 
  string will not be cast.
- **Use Float as array key:** Floats are also cast to ints, which means that the fractional part will be truncated. E.g. the key 8.7 will actually be stored under 8.
- **Use Boolean as array key:** Bools are cast to ints, too, i.e. the key true will actually be stored under 1 and the key false under 0.
- **Use Null as array key:** Null will be cast to the empty string.

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

#### Array elements Accessing Rules

- Array elements can be accessed using the array[key] syntax.

```php
<?php
/*
 * Array which not set keys will use natural number as key
 */
$array = array("foo", "bar", "hello", "world");
$array[0];
$array[3];

/*
 * Array with keys
 * we should only access array with it's key value.    
 */
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


//use foreach to get array
$array = array("a", "b", "c", "d", "e");
foreach ($array as $value) {
    echo $value;
}

// other way
foreach ($array as $i=>$value) {
    echo "{$i} => {$value}";
}

?>
```


- Arrays can be destructured using the [] or list() language constructs. 

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

- concatenating arrays

```php
<?php
// Using short array syntax.
// Also, works with array() syntax.
$arr1 = [1, 2, 3];
$arr2 = [...$arr1]; //[1, 2, 3]
$arr3 = [0, ...$arr1]; //[0, 1, 2, 3]
$arr4 = [...$arr1, ...$arr2, 111]; //[1, 2, 3, 1, 2, 3, 111]
$arr5 = [...$arr1, ...$arr1]; //[1, 2, 3, 1, 2, 3]

function getArr() {
  return ['a', 'b'];
}
$arr6 = [...getArr(), 'c' => 'd']; //['a', 'b', 'c' => 'd']
?>
```


#### Rule for modifying array elements

- Array elements can be modified and added using the "array[key] =xxx" syntax.

- Array and it's elements can be deleted using the unset function.**Be aware that, due to the data structure implementation of Array,the array will not be reindexed. If a true "remove and shift" behavior is desired, the array can be reindexed using the array_values() function.**

- Arrays are ordered. The order can be changed using various sorting functions.

```php
<?php
$arr = array(1 => 'one', 2 => 'two', 3 => 'three');

// This is the same as $arr[4] = 56;
$arr[] = 56;    

// This adds a new element to the array with key "x"
$arr["x"] = 42; 
         
// This will modify 56 to 5600       
$arr[4] = 5600; 

/*
 * This removes the element from the array.  
 * Be aware that, due to Array is implemented by dict
 * the array will not be reindexed.
 * The result is  $arr = array(1 => 'one', 3 => 'three',4=>5600);
 */             
unset($arr[2]); 

/*
 * if you wanna reset array index
 * Using array_values
 * Now $b is array(0 => 'one', 1 =>'three')
 */
$b = array_values($arr);

/*
 * This deletes the whole array
 * $arr=array();
 */
unset($arr);    


/*
 * use while loop and $array[] syntax 
 * to fill an array with many elements
 */
$handle = opendir('.');
while (false !== ($file = readdir($handle))) {
    $files[] = $file;  // will automatic fill array $files, through syntax  $files[] = xxx.
}
closedir($handle); 

/*
 * use symbol "&" to modify array in the loop
 */
$array = array("a", "b", "c", "d", "e");
foreach ($array as &$color) {
    $color = strtoupper($color);
}
unset($color); /* ensure that following writes to
$color will not modify the last array element */

print_r($array);


//sort array 
sort($array);
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

#### Array assignment always involves value copying

Array assignment always involves value copying. Use the reference operator to copy an array by reference.

```php
<?php
$arr1 = array(2, 3);
$arr2 = $arr1;
$arr2[] = 4; // $arr2 is changed,
             // $arr1 is still array(2, 3)
             
$arr3 = &$arr1;
$arr3[] = 4; // now $arr1 and $arr3 are the same
?>
```