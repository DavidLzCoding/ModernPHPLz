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

### error function handlers
set_error_handler will also works without try and catch


```php
<?php
set_error_handler(function(int $number, string $message) {
   echo "Handler captured error $number: '$message'" . PHP_EOL  ;
});

?>
```

### Error lists

- Error::__construct — Construct the error object
- Error::getMessage — Gets the error message
- Error::getPrevious — Returns previous Throwable
- Error::getCode — Gets the error code
- Error::getFile — Gets the file in which the error occurred
- Error::getLine — Gets the line in which the error occurred
- Error::getTrace — Gets the stack trace
- Error::getTraceAsString — Gets the stack trace as a string
- Error::__toString — String representation of the error
- Error::__clone — Clone the error

# Exceptions

The way to throw exceptions:

```php
<?php
function inverse($x) {
    if (!$x) {
        throw new Exception('Division by zero.');
    }
    return 1/$x;
}

try {
    echo inverse(5) . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
} finally {
    echo "First finally.\n";
}

try {
    echo inverse(0) . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
} finally {
    echo "Second finally.\n";
}

// Continue execution
echo "Hello World\n";
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