# Functions

### Rule about functions

1. Functions need not be defined before they are referenced.
   
```php
<?php
/* We can call bar() */
bar();

function bar() 
{
  echo "I exist immediately upon program start.\n";
}

?>
```

2. Any valid PHP code may appear inside a function, even other functions and class definitions.

3. All functions and classes in PHP have the global scope - they can be called outside a function even if they were defined inside and vice vers.

```php
<?php
function foo()
{
    function bar(){
        echo "bar";
    }
    bar();
    echo "foo";
}

   
// error! var yet defined before foo first called
bar(); 


/* Now we can call bar(),
   foo()'s processing has
   made it accessible. */
foo();
bar();
?>
```