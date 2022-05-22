<?php
$router->get('home', 'HomeController@index');
$router->get('step_1', 'StepController@firstStep');
$router->get('step_2', 'StepController@installStep');
$router->post('step_2', 'StepController@installStepAction');
$router->get('step_3', 'StepController@finalStep');
$router->get('showerror', 'ErrorController@showError');



