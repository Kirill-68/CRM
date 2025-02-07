<?php

function inputDefaultValue($field, $value, $defaultValue){
    if(isset($_SESSION[$field])){
        $input = empty($value) ? $defaultValue : $value;

        echo "$value='$input'";
    }
    else{
        echo '';
    }
}
