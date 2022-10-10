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

