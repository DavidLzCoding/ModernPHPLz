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


### Type check function

var_dump will return data type and value of special variable.

gettype will only return data type of special variable.

is_xx will check the type of special variable, it returns 1 if it's true, it returns 0 in contrast.

![img_1.png](img_1.png)


### Type cast

- The casts allowed are:
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

