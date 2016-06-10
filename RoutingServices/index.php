<?php
ini_set('max_execution_time', 0);
ini_set('memory_limit', '256M');

require 'vendor/autoload.php';

$app = new \Slim\Slim(array(
    'mode' => 'development'
));

$view = $app->view();
$view->setTemplatesDirectory('./templates');

$app->get('/', function() use($app) {
  $data = array( 'msg' => 'Welcome to Routing Services.' );
  $app->render('welcome.php', $data, 200);
});

require 'rest_routes.php';

try {
  $app->run();
} catch (Exception $e) {
  $app->response()->setStatus(404); //todo:another status, dynamic status
  echo '{"error":{"text":'. $e->getMessage() .'}}';
}


/*
Post your problem json: curl -X POST -H "Content-Type: application/json" "https://graphhopper.com/api/1/vrp/optimize?key=[YOUR_KEY]" --data @your-vrp-problem.json
Poll every 500ms until a solution is available: curl -X GET "https://graphhopper.com/api/1/vrp/solution/[RETURNED_JOB_ID]?key=[YOUR_KEY]"
For more details also about the format of the your-vrp-problem.json file you can use one of the examples.
*/
