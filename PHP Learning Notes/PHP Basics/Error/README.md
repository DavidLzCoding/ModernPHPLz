# Error

### try-catch errors

```php
<?php
try {
    var_dump(sum(1, 2));
    var_dump(sum(1.5, 2.5));
} 
catch (TypeError $e) {
    echo 'Error: ', $e->getMessage();
}
?>
```



### Exceptions lists

```text
Exception
ErrorException
Error
ArgumentCountError
ArithmeticError
AssertionError
DivisionByZeroError
CompileError
ParseError
TypeError
ValueError
UnhandledMatchError
FiberError
```