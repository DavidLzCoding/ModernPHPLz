# Name Space

PHP Namespaces provide a way in which to group related classes, interfaces, functions and constants. Here is an example of namespace syntax in PHP:


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
 */
$d = namespace\MYCONST; 
echo $d;   //will get 1

$d = __NAMESPACE__ . '\MYCONST';
echo constant($d);   //will get 1 too
?>
```

