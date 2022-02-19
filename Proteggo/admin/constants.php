<?php
    define('PROTOCOL', 'http://');
    define('HOMEURL', PROTOCOL . $_SERVER['HTTP_HOST'] . '/' . explode('/', $_SERVER['REQUEST_URI'])[1]);
    define('DefaultURL', explode('/', $_SERVER['REQUEST_URI'])[1] .'/'. explode('/', $_SERVER['REQUEST_URI'])[2]);
    define('APIURL', $_SERVER['HTTP_HOST'] . '/' . explode('/', $_SERVER['REQUEST_URI'])[1] . '/api');
?>