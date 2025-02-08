<?php
function selectDefaultValue($field, $options, $defaultValue) {
    foreach($options as $key => $option) {
        $key = $option['key'];
        if(isset($_GET[$field]) && $_GET[$field] == $key){
            $selected = 'selected';
        }
        if(!isset($_GET[$field]) && $key === $defaultValue) {
            $selected = 'selected';
        }
        echo "<option $selected value='$key'>$value</option>";
    }
}