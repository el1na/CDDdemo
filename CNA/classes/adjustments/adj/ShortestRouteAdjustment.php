<?php

 class ShortestRouteAdjustment {

   private $ccpApi = null;
   /*
   * input data
   */
   private $source;
   private $target;
   private $weightsArray = array(); //or ctx
   /*
   * context data
   */
   private $safetyJsonCtx;
   private $trafficIntensityJsonCtx;

   /*
   * constants
   */

  public function __construct ($source, $target, $weightsArray, $adjConstFile = 'AdjustmentConstants.ini') {
    $this->ccpApi = new Ccp();

    $adjConstants = parse_ini_file($adjConstFile, true);

    $this->weightsArray = $weightsArray;
    /*
    * safety_weight
    *  isLeftTurn_weight
    *  fuel_consumption_weight
    *  traffic_intensity_weight
    *  distance_weight
    *  allowedMaxSpeed_weight
    */

    //todo:get nearest point id from location raw
    $this->source = $source;
    $this->target = $target;

    $safetyCalc = new SafetyCtxCalculation();
    $trafficIntensityCalc = new TrafficIntensityCtxCalculation();

    $this->safetyJsonCtx = $safetyCalc->execute();
    $this->trafficIntensityJsonCtx = $trafficIntensityCalc->execute();
}

private function updateGraph() {
  $db = new Db();
  $dbCon = $db::$connection;

   //update riga_elg_clean normalaized ctx values  safety

   $stmt = $dbCon->prepare("
     select * from hw_lat.setSafetyCtx(:safetyData)
   ");
     $stmt->bindParam(':safetyData', $this->safetyJsonCtx, PDO::PARAM_STR);
     $stmt->execute();

   //update riga_elg_clean normalaized ctx values traffic intensity
   $stmt = $dbCon->prepare("
     select * from hw_lat.setTrafficIntensityCtx(:trafficIntensityData)
   ");
     $stmt->bindParam(':trafficIntensityData', $this->trafficIntensityJsonCtx, PDO::PARAM_STR);
     $stmt->execute();

}

public function execute()
{
  $db = new Db();
  $dbCon = $db::$connection;

   $this->updateGraph();

   //run shortest path with costs as weighted function

   $costs_function = '__safety_norm * '. $this->weightsArray->safety_weight. '::double precision'
      .' +  __isleft_norm           * '. $this->weightsArray->isLeftTurn_weight. '::double precision'
      .' +  __fuel_consumption_norm  * '. $this->weightsArray->fuel_consumption_weight. '::double precision'
      .' +  __traffic_intensity_norm * '. $this->weightsArray->traffic_intensity_weight. '::double precision'
      .' +  __distance_norm          * '. $this->weightsArray->distance_weight. '::double precision'
      .' +  __maxspeed_norm          * '. $this->weightsArray->allowedMaxSpeed_weight.'::double precision';

  $sql = 'select id, from_id as source, to_id as target, ('.$costs_function.') as cost from hw_lat.riga_elg_clean';

/*  $stmt = $dbCon->prepare("
  create table hw_lat.test1 as
      select d.seq, st_startPoint(t1.way_geom) as geom, t1.name, d.cost as cost, t1.length as distance, t1.turn_type
    from hw_lat.riga_elg_clean t1,
    pgr_dijkstra(:sql, :sourceid, :targetid, true, false) d
    where t1.id = d.id2
    order by d.seq
  ");*/

  $stmt = $dbCon->prepare("
  select * from  hw_lat.bestRoute(:sql , :sourceid , :targetid )
  ");

  $stmt->bindParam(':sql', $sql, PDO::PARAM_STR);
  $stmt->bindParam(':sourceid', $this->source, PDO::PARAM_INT);
  $stmt->bindParam(':targetid', $this->target, PDO::PARAM_INT);

  $stmt->execute();
  $result = $stmt->fetchAll();

  return json_encode($result);

}

 }
