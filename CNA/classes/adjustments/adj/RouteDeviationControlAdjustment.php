<?php
//todo: class
 class RouteDeviationControlAdjustment {

   private $ccpApi = null;
   /*
   * input data
   */

   /*
   * context data
   */
   private $location;

   /*
   * constants
   */

  public function __construct () {
    $this->ccpApi = new Ccp();

    //get nearest point on the route, how arf from it is

    $safetyCalc = new SafetyCtxCalculation();
    $trafficIntensityCalc = new TrafficIntensityCtxCalculation();

    $this->safetyJsonCtx = $safetyCalc->execute();
    $this->trafficIntensityJsonCtx = $trafficIntensityCalc->execute();

}

public function execute()
{
  $db = new Db();
  $dbCon = $db::$connection;

  $stmt = $dbCon->prepare("
  select * from  hw_lat.bestRoute(:sql , :sourceid , :targetid )
  ");

  $stmt->bindParam(':sql', $sql, PDO::PARAM_STR);
  $stmt->bindParam(':sourceid', $this->source, PDO::PARAM_INT);

  $stmt->execute();
  $result = $stmt->fetchAll();

  return json_encode($result);

}

 }
