<?php
function foo()
{
    function bar(){
        echo "bar";
    }
    bar();
    echo "foo";
}
foo();
bar();
?>