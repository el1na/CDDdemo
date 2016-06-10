<?php
require 'vendor/autoload.php';
require 'classes/Db.php'; //add to autoload classmap
require 'classes/Ccp.php'; //add to autoload classmap
require 'classes/adjustments/adj/LeftTurnsAnalysisAdjustment.php'; //add to autoload classmap
require 'classes/adjustments/adj/ShortestRouteAdjustment.php'; //add to autoload classmap
require 'classes/adjustments/ctx/SafetyCtxCalculation.php'; //add to autoload classmap
require 'classes/adjustments/ctx/TrafficIntensityCtxCalculation.php'; //add to autoload classmap
require 'classes/adjustments/kpi/AccidentsCountKpiCalculation.php'; //add to autoload classmap
require 'classes/adjustments/kpi/LeftTurnsXAccidentsProportionKpiCalculation.php'; //add to autoload classmap

$app = new \Slim\Slim(array(
    'mode' => 'development'
));

$view = $app->view();
$view->setTemplatesDirectory('./templates');

//app global variables

$app->get('/', function() use($app) {
  $data = array( 'msg' => 'This is CNA.' );
  $app->render('welcome.php', $data, 200);
});

require 'rest_routes.php';

$app->run();
