<?php

/*
* 3 vehicles:
* id:1, small vehicle, objective:shortest route
* id:2, small vehicle, objective:cheapest route
* id:3, truck, objective:safest route
*/

require 'vendor/autoload.php';

require 'classes/Db.php'; //add to autoload classmap

session_start();


$app = new \Slim\Slim(array(
    'mode' => 'development'
));

$app->config(array(
    'debug' => true,
    'templates.path' => 'templates/'
));

include_once 'ajax_routes.php';

$app->get('/', function () use ($app) {
    $employeeId = isset($_SESSION['employeeId']) ? $_SESSION['employeeId'] : 'Anonymous';
    $app->render('navigation.phtml', array('employeeId' => $employeeId)); // <-- SUCCESS
});


/*

};
*/
/*
$app->get('/', function (Request $request, Response $response)  use ($app){
    $name = $request->getAttribute('name');// $ticket_id = (int)$args['id']; {id}*/
    /* It is possible to get all the query parameters from a request by doing $request->getQueryParams() which will return an associative array. */
    //$response->getBody()->write("Hello, $name");

   // return $response;
   // $app->render('myTemplate.php', array('id' => $id));
//});






  //  $employeeId = $_SESSION['employeeId'] ?: 'Not set';

   // $app->render('\\templates\\navigation.phtml', array('employeeId' => $employeeId));

    //$response = $this->view->render($response, "navigation.phtml", ["employeeId" => $employeeId, "router" => $this->router]);
    //return $response;
//->setName("home");


/*
$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');// $ticket_id = (int)$args['id']; {id}
    // It is possible to get all the query parameters from a request by doing $request->getQueryParams() which will return an associative array.
    $response->getBody()->write("Hello, $name");

    return $response;
});
*/


$app->run();


/*  $mapper = new TicketMapper($this->db);
$tickets = $mapper->getTickets();
$response->getBody()->write(var_export($tickets, true));*/

/*
 * As long as the Content-Type header is set correctly,
 * Slim will parse a JSON payload into an array and you can access it
 * exactly the same way: by using $request->getParsedBody()
 */

?>
