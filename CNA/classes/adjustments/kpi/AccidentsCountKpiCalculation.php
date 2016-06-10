<?php

 class AccidentsCountKpiCalculation {
   private $ccpApi = null;
   /*
   * mp data
   */
   private $accidentsCountCurrentMonth;

   /*
   * constants
   */

  public function __construct () {
    $this->ccpApi = new Ccp();
    $this->accidentsCountCurrentMonth = $this->ccpApi->GetMP('registered-accidents-current-month');
  }

  public function execute()
  {
    return $this->accidentsCountCurrentMonth; //already json
   }


 }
