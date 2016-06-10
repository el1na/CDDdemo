<?php
//analysis for the current day timestamp >= now()::date

 class LeftTurnsAnalysisAdjustment {
   /*
   * input data
   */

   /*
   * context data
   */

   /*
   * constants
   */
   private $car_length;
   private $leftTurnAngle_min;
   private $leftTurnAngle_max;

  public function __construct ($adjConstFile = 'AdjustmentConstants.ini') {

    $adjConstants = parse_ini_file($adjConstFile, true);

    $this->car_length = $adjConstants['left-turns-analysis-adjustment']['car_length'];
    $this->leftTurnAngle_min = $adjConstants['left-turns-analysis-adjustment']['leftTurnAngle_min'];
    $this->leftTurnAngle_max = $adjConstants['left-turns-analysis-adjustment']['leftTurnAngle_max'];
 }

public function execute()
{

  $db = new Db();
  $dbCon = $db::$connection;

  $stmt = $dbCon->prepare("
    select count_left_turns as left_turn_count
    from hw_lat.count_left_turns(:car_length, :leftTurnAngle_min, :leftTurnAngle_max)
  ");

  $stmt->bindParam(':car_length', $this->car_length, PDO::PARAM_STR);
  $stmt->bindParam(':leftTurnAngle_min', $this->leftTurnAngle_min, PDO::PARAM_INT);
  $stmt->bindParam(':leftTurnAngle_max', $this->leftTurnAngle_max, PDO::PARAM_INT);

  $stmt->execute();
  $result = $stmt->fetch();

  $this->register_analysis($result['left_turn_count']);

  return json_encode($result, JSON_PRETTY_PRINT);

}


private function register_analysis($left_turns_count) {
  $db = new Db();
  $dbCon = $db::$connection;

  $stmt = $dbCon->prepare("
    insert into hw_lat.analysis (timestamp, left_turns)
    values (now(), :left_turns)
  ");

  $stmt->bindParam(':left_turns', $left_turns_count, PDO::PARAM_INT);

  $stmt->execute();
}





 }
