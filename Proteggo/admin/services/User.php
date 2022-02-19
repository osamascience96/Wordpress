<?php
    require_once '../FileHandling/readjson.php';
    require_once '../FileHandling/writejson.php';

    function CheckUserLogin($username, $password){
        $filePath = '../log/user.json';

        $json_array = ReadJson($filePath);
        
        $emptyObj = array();

        foreach($json_array as $object){
            $Username = $object['username'];
            $Password = $object['password'];

            // check the credentials
            if($Username == $username && $Password == md5($password)){
                array_push($emptyObj, $object);
                break;
            }
        }

        return $emptyObj;
    }
?>