<?php
    require '../app/FileHandling/readjson.php';
    require '../app/FileHandling/writejson.php';
    
    function WriteLoginSuccessResponse($response){
        $filePath = '../app/log/response.json';
        $json_array = ReadJson($filePath);

        // change the response
        $json_array[0]['after_loginsuccess_response'] = $response;
        
        // write back to json file
        WriteJson($filePath, $json_array);

        // return response
        return $json_array;
    }

    function WriteLoginFailedResponse($response){
        $filePath = '../app/log/response.json';
        $json_array = ReadJson($filePath);

        // change the response
        $json_array[1]['after_loginfailed_response'] = $response;

        // write back to json file
        WriteJson($filePath, $json_array);
        
        // return response
        return $json_array;
    }

    function GetAllResponse(){
        $filePath = '../app/log/response.json';
        $json_array = ReadJson($filePath);
        return $json_array;
    }
?>