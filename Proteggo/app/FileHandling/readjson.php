<?php
    function ReadJson(){
        $string = file_get_contents('../app/log/userlog.json');
        $json = json_decode($string, true);

        return $json;
    }
?>