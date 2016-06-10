<?php

 class TrafficIntensityCtxCalculation {
   private $ccpApi = null;
   /*
   * mp data
   */
   private $trafficIntensityMp_json;

   private $trafficIntensity_normalized = array();
   /*
   * constants
   */
   private $rigaDistrictCount = 58;

  public function __construct () {
    $this->ccpApi = new Ccp();
 }

public function execute()
{
  $trafficIntensityCtx = null;

  $this->trafficIntensityMp_json = $this->ccpApi->GetMP('traffic-intensity');

  $this->normalizeMps();

  for ($i=0; $i < $this->rigaDistrictCount; $i++) {
    $trafficIntensityCtx[$i] = new stdClass();
    $trafficIntensityCtx[$i]->id = $i + 1;
    $trafficIntensityCtx[$i]->traffic_intensity_ctx = $this->trafficIntensity_normalized[$i];
  }

 $trafficIntensityCtx_json = json_encode($trafficIntensityCtx, JSON_PRETTY_PRINT);

  return $trafficIntensityCtx_json;
 }


private function normalizeMps() {
  $ti = json_decode($this->trafficIntensityMp_json);

  $max_ti = $ti[0]->traffic_intensity;
  $min_ti = $ti[0]->traffic_intensity;

  for ($i=0; $i < $this->rigaDistrictCount; $i++) {
      $obj = $ti[$i];

      if ($obj->traffic_intensity > $max_ti) {
        $max_ti = $obj->traffic_intensity;
      } else if ($obj->traffic_intensity < $min_ti) {
        $min_ti = $obj->traffic_intensity;
      }
  }

  for ($i=0; $i < $this->rigaDistrictCount; $i++) {
     $this->trafficIntensity_normalized[$i] =  ($ti[$i]->traffic_intensity - $min_ti) / ($max_ti - $min_ti);
  }

}





 }
