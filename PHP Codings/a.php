<?php
class BaseClass {
    function __construct() {
        print "In BaseClass constructor\n";
    }
}

class SubClass extends BaseClass {
    protected int $x;
    public float $y;

    function __construct(int $a, float $b) {
        parent::__construct();
        $x = $a;
        $y = $b;
        echo $x+$y;
    }
}

$obj = new SubClass(7,10.888);
?>