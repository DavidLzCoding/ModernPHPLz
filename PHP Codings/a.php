<?php
class SimpleClass
{
    // property declaration
    public $var = 'a default value';

    // method declaration
    public function displayVar() {
        echo $this->var;
    }
}
$instance = new SimpleClass();

$assigned   =  $instance;
$reference  =& $instance;

//$instance->var = '$assigned will have this value';
//
//$instance = null; // $instance and $reference become null

var_dump($instance);
var_dump($reference);
var_dump($assigned);
?>