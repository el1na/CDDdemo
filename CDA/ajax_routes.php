<?php

$app->get('/ajax/get-route/:routeId', function ($routeId) use ($app) {

    $db = new Db();
    $dbCon = $db::$connection;

    $stmt = $dbCon->prepare("
    select seq, name, length, cost as weighted_cost, turn_type, st_astext(st_startPoint(way_geom)) as point
    from hw_lat.routes
    where route_id = :routeId
    order by seq
    ");

    $stmt->bindParam(':routeId', $routeId, PDO::PARAM_INT);

    $stmt->execute();
    $result = $stmt->fetchAll();

    echo json_encode($result, JSON_PRETTY_PRINT);

});

$app->post('/ajax/register-accident', function () use ($app) {
    $notes = $app->request->post('notes');
    $location = $app->request->post('location');

    $db = new Db();
    $dbCon = $db::$connection;

    $stmt = $dbCon->prepare("
    insert into hw_lat.registered_accidents (timestamp, notes, point)
    values (now(), :notes, st_geomFromText(:point, 4326))
    ");

    $stmt->bindParam(':notes', $notes, PDO::PARAM_STR);
    $stmt->bindParam(':point', $location, PDO::PARAM_STR);

    $stmt->execute();
    $result = $stmt->fetchAll();

    echo json_encode($result, JSON_PRETTY_PRINT);
});

  $app->post('/ajax/register-location', function () use ($app) {
  $routeid = $app->request->post('routeid');
  $location = $app->request->post('location');
  //timestamp
  //point-location, lat,lon
  //hw_lat.tracking
  $db = new Db();
  $dbCon = $db::$connection;

  $stmt = $dbCon->prepare("
  insert into hw_lat.tracking (timestamp, route_id, point)
  values (now(), :routeid, st_geomFromText(:point, 4326))
  ");

  $stmt->bindParam(':routeid', $routeid, PDO::PARAM_STR);
  $stmt->bindParam(':point', $location, PDO::PARAM_STR);

  $stmt->execute();
  $result = $stmt->fetchAll();

  echo json_encode($result, JSON_PRETTY_PRINT);

});
