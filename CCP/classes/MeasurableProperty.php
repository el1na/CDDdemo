<?php

class MeasurableProperty {

private $name;

public function __construct ($mpName) {
  $this->name = $mpName;
}

/*
* GET: Gets Measurable property
*/
public function GetValue()
{
 $db = new Db();
 $dbCon = $db::$connection;

  if ($this->name == 'traffic-black-holes') {
   $stmt = $dbCon->prepare('
   select id, traffic_black_holes
   from riga_districts_mps
   order by id asc');
 }
  else if ($this->name == 'criminality-index') {
   $stmt = $dbCon->prepare('
   select id, criminality_index
   from riga_districts_mps
   order by id asc');
 }
 else if ($this->name == 'traffic-intensity') {
   $stmt = $dbCon->prepare('
   select id, traffic_intensity
   from riga_districts_mps
   order by id asc');
 }
 else if ($this->name == 'left-turn-count-current-month') {
   $stmt = $dbCon->prepare("
   select value
   from mps
   where name = :name ");
   $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
 }
 else if ($this->name == 'registered-accidents-current-month') {
   $stmt = $dbCon->prepare("
   select value
   from mps
   where name = :name ");
   $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
 }

 else {
   return null;
 }

 $stmt->execute();
 $result = $stmt->fetchAll();

return json_encode($result, JSON_PRETTY_PRINT);
}

/*
* POST: Sets/updates measurable property
*/
  public function SetValue($value)
  {
   $db = new Db();
   $dbCon = $db::$connection;

  //2013-01-28 date example

   if ($this->name == 'left-turn-count-current-month') {
     $stmt = $dbCon->prepare("
     update mps
     set value = :count
     where name = :name ");
     $stmt->bindParam(':count', $value, PDO::PARAM_STR);
     $stmt->bindParam(':name',$this->name, PDO::PARAM_STR);
   }
   else if ($this->name == 'registered-accidents-current-month') {
     $stmt = $dbCon->prepare("
     update mps
     set value = :count
     where name = :name ");
     $stmt->bindParam(':count', $value, PDO::PARAM_STR);
     $stmt->bindParam(':name',$this->name, PDO::PARAM_STR);
   }

   else {
     return null;
   }

   $stmt->execute();
   $result = $stmt->fetchAll();

   return json_encode($result, JSON_PRETTY_PRINT);
  }

}
