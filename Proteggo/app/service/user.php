<?php
    require '../app/FileHandling/readjson.php';
    require '../app/FileHandling/writejson.php';

    function GetUserAttemp($username){
        $filePath = '../app/log/attempts.json';

        $json_array = ReadJson($filePath);

        $emptyArr = array();

        foreach($json_array as $object){
            if($username == $object['username']){
                array_push($emptyArr, $object);
            }
        }

        return $emptyArr;
    }

    function GetAllUsers(){
        $filePath = '../app/log/userlog.json';

        $json_array = ReadJson($filePath);
        return $json_array;
    }

    function GetAllUserAttempts(){
        $filePath = '../app/log/userlog.json';

        $json_array = ReadJson($filePath);
        for($i=0; $i < count($json_array); $i++){
            $json_array[$i]['user_attempts'] = GetUserAttemp($json_array[$i]['username']);
        }

        return $json_array;
    }

    function GetUserAttempt($username){
        $filePath = '../app/log/userlog.json';

        $json_array = ReadJson($filePath);
        foreach($json_array as $jsonObj){
            if($jsonObj['username'] == $username){
                $jsonObj['user_attempts'] = GetUserAttemp($username);
                return $jsonObj;
            }
        }
    }

    function GetUser($username){
        $filePath = '../app/log/userlog.json';

        $object = array();

        $json_array = ReadJson($filePath);
        foreach($json_array as $obj){
            if($username == $obj['username']){
                array_push($object, $obj);
                break;
            }
        }

        return $object;
    }
    
    function CheckUserExists($username, $password){
        $json_string = ReadJson('../app/log/userlog.json');

        $emptyObj = array();

        foreach($json_string as $value){
            $Username = $value['username'];
            $Password = $value['password'];

            if($Username == $username){
                if($Password == $password){
                    array_push($emptyObj, $value);
                    UpdateUserAttempts($username, "login_success");
                    break;
                }else{
                    UpdateUserAttempts($username, "login_failed");
                }
            }
        }

        return $emptyObj;
    }

    function InsertUser($username, $password, $createdAt){
        $filePath = '../app/log/userlog.json';

        $json_array = ReadJson($filePath);

        $user_exists = false;

        foreach($json_array as $obj){
            if($obj['username'] == $username){
                $user_exists = true;
                break;
            }
        }

        if(!$user_exists){
            $emptyObj = array("username" => $username, "password" => $password, "created_at" => $createdAt);
            array_push($json_array, $emptyObj);

            WriteJson($filePath, $json_array);
            return true;
        }else{
            return false;
        }
    }

    function UpdateUserAttempts($username, $status){
        $filePath = '../app/log/attempts.json';

        // Get the json from the attempts.json
        $json_array = ReadJson($filePath);
        // user exists bool
        $user_exists = false;

        // current timestamp
        $timestamp = date("Y-m-d h:i:s a");

        for($i=0; $i < count($json_array); $i++){
            if($username == $json_array[$i]['username']){
                $previousDate = explode(" ", $json_array[$i]['timestamp'])[0];
                $currentDate = explode(" ", $timestamp)[0];
                
                if($previousDate == $currentDate){
                    $json_array[$i]['attempts']+=1;
                    $json_array[$i]['timestamp'] = $timestamp;
                    $json_array[$i]['status'] = $status;
                    $user_exists = true;
                    break;
                }        
            }
        }


        // if user does not exists
        if(!$user_exists){
            $emptyObj = array("username" => $username, "attempts" => 1, "status" => $status, "timestamp" => $timestamp);
            // add to the json_array
            array_push($json_array, $emptyObj);
        }

        // send the updated to the log file
        WriteJson($filePath, $json_array);
    }
?>