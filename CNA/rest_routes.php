<?php

$app->get('/rest', function() use($app) {
  $data = array( 'msg' => 'This is CNA REST API.' );
  $app->render('welcome.php', $data, 200);
});

/*
* event-based adjustments
*/
$app->post('/rest/adjustments/event-based/:adj', function ($adjName) use ($app) {
  switch ($adjName) {
    case 'shortest-route':
        $source = $app->request->post('source');
        $target = $app->request->post('target');
        $weightsArray = json_decode($app->request->post('weights_array'));
        $adj = new ShortestRouteAdjustment($source, $target, $weightsArray);
        break;
  }
    $result = $adj->execute();
    if ($result) {
      $app->response->setStatus(200);
      $app->response->headers->set('Content-Type', 'application/json');
      echo $result;
    } else {
      $app->response->setStatus(404);
    }
});

/*
* scheduled adjustments
*/
$app->get('/rest/adjustments/scheduled/:adjName', function ($adjName) use ($app) {
  switch ($adjName) {
    case 'left-turns-analysis':
        $adj = new LeftTurnsAnalysisAdjustment();
        break;
  }
    $result = $adj->execute();
    if ($result) {
      $app->response->setStatus(200);
      $app->response->headers->set('Content-Type', 'application/json');
      echo $result;
    } else {
      $app->response->setStatus(404);
    }
});

/*
* kpi calculations
*/
$app->get('/rest/adjustments/kpi-calculation/:adjName', function ($adjName) use ($app) {
    switch ($adjName) {
      case 'accidents-count':
          $adj = new AccidentsCountKpiCalculation();
          break;
      case 'left-turns-accidents-proportion':
          $adj = new LeftTurnsXAccidentsProportionKpiCalculation();
          break;
    }
    $result = $adj->execute();
    if ($result) {
      $app->response->setStatus(200);
      $app->response->headers->set('Content-Type', 'application/json');
      echo $result;
    } else {
      $app->response->setStatus(404);
    }
});

/*
* ctx calculations
*/
$app->get('/rest/adjustments/ctx-calculation/:adj', function ($adjName) use ($app) {
  switch ($adjName) {
    case 'road-safety':
        $adj = new SafetyCtxCalculation();
        break;
    case 'traffic-intensity':
        $adj = new TrafficIntensityCtxCalculation();
        break;
  }
  $result = $adj->execute();
  if ($result) {
    $app->response->setStatus(200);
    $app->response->headers->set('Content-Type', 'application/json');
    echo $result;
  } else {
    $app->response->setStatus(404);
  }
});
