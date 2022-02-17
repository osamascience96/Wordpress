<?php
    function ReadJson($filepath){
        $string = file_get_contents($filepath);
        $json = json_decode($string, true);

        return $json;
    }
?>