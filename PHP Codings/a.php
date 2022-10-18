<?php
function makeyogurt2($container = "bowl", $flavour )
{
    return "Making a $container of $flavour yogurt.\n";
}

//otherwise you  can specify the arguments rule.
echo makeyogurt2(flavour: "raspberry");
?>