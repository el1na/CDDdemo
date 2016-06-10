<?php

$app->get('/rest', function () use ($app) {
  $data = array( 'msg' => 'This is CCP REST API.' ) ;
  $app->render('welcome.php', $data, 200);
});

$app->get('/rest/mps/:mp', function ($mpName) use ($app) {
    $Mp = new MeasurableProperty($mpName);
    $result = $Mp->GetValue();

    if($result) {
      $app->response->setStatus(200);
      $app->response->headers->set('Content-Type', 'application/json');
      echo $result;
    } else {
        $app->response->setStatus(404);
    }
});

$app->post('/rest/mps/:mp', function ($mpName) use ($app) {
  $app->response->headers->set('Content-Type', 'application/json');
  $Mp = new MeasurableProperty($mpName);
  $value = $app->request()->post('value');
  $Mp->SetValue($value);
  //return success or 404

});
