<?php
    function WriteJson($filepath, $json){
        // encode the json
        $finalJson = json_encode($json);

        // write to the json file
        if(file_put_contents($filepath, $finalJson)){
            return true;
        }

        return false;
    }
?>