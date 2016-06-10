<?php

/*
* Postman Tour Problem
*/

//todo: all post
$app->get('rest/postman-tour/routing-region-definition/', function () use ($app) {
});
$app->get('rest/postman-tour/routing-region-selection/', function () use ($app) {
});
$app->get('rest/postman-tour/tour-generation/', function () use ($app) {
});
$app->get('rest/postman-tour/tour-retrieval/', function () use ($app) {
});
$app->get('rest/postman-tour/tour-traversal/', function () use ($app) {
});
$app->get('rest/postman-tour/tour-progress-tracking/', function () use ($app) {
});

/*
* Shortest Path Problem
*/

$app->post('rest/shortest-path/', function () use ($app) {

  $sourceid = 268930;
  $targetid = 274199;

  $db = new Db();
  $con = $db::$connection;

  $stmt = $this->dbCon->prepare('
    select d.seq, t1.way_geom as geom, t1.name, d.cost as length, t1.turn_type, t1.angle
    from pgr_dijkstra('select id, from_id as source, to_id as target, length as cost
    from hw_lat_elg', :sourceid, :targetid, true, false) d,
    hw_lat_elg t1
    where t1.id = d.id2
  ');

  $stmt->bindParam(':sourceid', $sourceid, PDO::PARAM_INT);
  $stmt->bindParam(':targetid', $targetid, PDO::PARAM_INT);

  $stmt->execute();
  $result = $stmt->fetchAll();

  if($result) {
    $app->response->setStatus(200);
    $app->response()->headers->set('Content-Type', 'application/json');
    echo json_encode($result);
  } else {
      throw new Exception('No path found.');
  }
});
