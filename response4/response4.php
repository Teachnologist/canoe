<?php
class foo {
    public $value = 6;
    public function func1(&$value){
        $return = $value;
        $value += 1;
        return $return;
    }
    public function &func2(){
        return $this->value;
    }
    public function &func3(){
        static $value = 8;
        $value++;
        return $value;
    }
}
$obj = new foo;
$a = 2;
$b = $obj->func1($a);
echo "\nWhat is the value of $a and why?";
echo "\n$a is equal to 3 because using & in the method's parameter passes a reference to to the original variable, in which the original variable is directly mutated.\n";
$a = &$obj->func2();
echo "\nWhat is the value of $a and why?";
echo "\nfunc2 is a getter for the value variable; so whatever value is set at at the time this is called will be returned. There is no setter, so the & in front of the function makes the variable a reference";
$obj->value = 5;
echo "\nWhat is the value of $a and why?";
echo "\nIn the previous command, $a became a reference for $obj->value. When $obj->value is set to something else, and $a remains, $a assumes the value of $obj->value";
$a = &$obj->func3();
echo "\nWhat is the value of $a and why?";
echo "\nThe method returns a value. Inside the method, $value becomes static, is reinstantiated, incremented and returned";
$obj->value = 7;
echo "\nWhat is the value of $a and why?";
echo "\nEven though a function reference has been created, func3 still instantiates value and returns a value.";

?>