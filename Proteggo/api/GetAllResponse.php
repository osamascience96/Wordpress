<?php
    require '../app/service/Response.php';

    $json_arr = GetAllResponse();
    echo json_encode($json_arr);
?>