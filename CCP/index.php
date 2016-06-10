<?php

require 'vendor/autoload.php';
require 'classes/Db.php'; //add to autoload classmap
require 'classes/MeasurableProperty.php'; //add to autoload classmap

$app = new \Slim\Slim(array(
    'mode' => 'development'
));

$view = $app->view();
$view->setTemplatesDirectory('./templates');

$app->get('/', function() use($app) {
  $data = array( 'msg' => 'This is CCP.' ) ;
  $app->render('welcome.php', $data, 200);
});

require 'rest_routes.php';

$app->run();
