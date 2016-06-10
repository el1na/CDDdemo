<?php

 class SafetyCtxCalculation {
   private $ccpApi = null;
   /*
   * mp data
   */
   private $trafficBlackHolesMp_json;
   private $criminalityIndexMp_json;

   private $trafficBlackHoles_normalized = array();
   private $criminalityIndex_normalized = array();
   /*
   * constants
   */
   private $trafficBlackHoles_weight = 0.3;
   private $criminalityIndex_weight = 0.7;
   private $rigaDistrictCount = 58;

  public function __construct () {
    $this->ccpApi = new Ccp();
 }

public function execute()
{
  $safetyCtx = array();

  $this->trafficBlackHolesMp_json = $this->ccpApi->GetMP('traffic-black-holes');
  $this->criminalityIndexMp_json = $this->ccpApi->GetMP('criminality-index');

  $this->normalizeMps();

  for ($i=0; $i < $this->rigaDistrictCount; $i++) {
    $safetyCtx[$i] = new stdClass();
    $safetyCtx[$i]->id = $i + 1;
    $safetyCtx[$i]->safety_ctx = $this->trafficBlackHoles_weight * $this->trafficBlackHoles_normalized[$i]
    + $this->criminalityIndex_weight * $this->criminalityIndex_normalized[$i];
  }

 $safetyCtx_json = json_encode($safetyCtx, JSON_PRETTY_PRINT);

  return $safetyCtx_json;
 }


private function normalizeMps() {
  $tbh = json_decode($this->trafficBlackHolesMp_json);
  $ci = json_decode($this->criminalityIndexMp_json);

  $max_tbh = $tbh[0]->traffic_black_holes;
  $min_tbh = $tbh[0]->traffic_black_holes;
  $max_ci = $ci[0]->criminality_index;
  $min_ci = $ci[0]->criminality_index;

  for ($i=0; $i < $this->rigaDistrictCount; $i++) {
      $obj = $tbh[$i];
      if ($obj->traffic_black_holes > $max_tbh) {
        $max_tbh = $obj->traffic_black_holes;
      } else if ($obj->traffic_black_holes < $min_tbh) {
        $min_tbh = $obj->traffic_black_holes;
      }

      $obj = $ci[$i];
      if ($obj->criminality_index > $max_ci) {
        $max_ci = $obj->criminality_index;
      } else if ($obj->criminality_index < $min_ci) {
        $min_ci = $obj->criminality_index;
      }
  }

  for ($i=0; $i < $this->rigaDistrictCount; $i++) {
     $this->trafficBlackHoles_normalized[$i] =  ($tbh[$i]->traffic_black_holes - $min_tbh) / ($max_tbh - $min_tbh);
     $this->criminalityIndex_normalized[$i] =  ($ci[$i]->criminality_index - $min_ci) / ($max_ci - $min_ci);
  }

}





 }
