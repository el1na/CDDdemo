<?php

 class LeftTurnsXAccidentsProportionKpiCalculation {
   private $ccpApi = null;
   /*
   * mp data
   */
   private $leftTurnsPerMonthMp_int;
   private $registeredAccidentsPerMonthMp_int;

   /*
   * constants
   */

  public function __construct () {
    $this->ccpApi = new Ccp();

    $leftTurnsPerMonthMp_json = json_decode($this->ccpApi->GetMP('left-turn-count-current-month'));
    $registeredAccidentsPerMonthMp_json = json_decode($this->ccpApi->GetMP('registered-accidents-current-month'));

    $this->leftTurnsPerMonthMp_int = $leftTurnsPerMonthMp_json[0]->value;
    $this->registeredAccidentsPerMonthMp_int = $registeredAccidentsPerMonthMp_json[0]->value;
 }

public function execute()
{

  $leftTurnsXAccidentsProportion = $this->registeredAccidentsPerMonthMp_int == 0 ?
    0 : ($this->leftTurnsPerMonthMp_int / $this->registeredAccidentsPerMonthMp_int);

  $leftTurnsXAccidentsProportion_json = json_encode($leftTurnsXAccidentsProportion);

  return $leftTurnsXAccidentsProportion_json;
 }






 }
