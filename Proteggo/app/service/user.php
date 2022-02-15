<?php
    require '../app/FileHandling/readjson.php';
    
    function CheckUserExists($username, $password){
        $json_string = ReadJson();

        $emptyObj = array();

        foreach($json_string as $value){
            $Username = $value['username'];
            $Password = $value['password'];

            if($Username == $username && $Password == $password){
                array_push($emptyObj, $value);
                break;
            }
        }

        return $emptyObj;
    }
?>