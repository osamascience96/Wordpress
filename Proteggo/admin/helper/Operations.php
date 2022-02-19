<?php
    function IsNullOrEmpty($object){
        $bool = true;
        
        if($object != null){
            $type = gettype($object);
            if($type == "string"){
                if($object !== ""){
                    $bool = false;
                }
            }else if($type == "array"){
                if(!empty($object)){
                    $bool = false;
                }
            }
        }

        return $bool;
    }
?>