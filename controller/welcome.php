<?php


class welcome {

    public $sss = "apple";

    public function index() {
       echo "A:index";
    }

    public function member($actions, $arr2) {
        echo "C:member|" . $this->sss;

       // print_r($actions);
       // print_r($arr2);
    }

    public function __call($name, $arguments) 
    {
    	echo "___call: [" . $name . "]" . "[" . $arguments . "]" . $this->sss;
    }
}