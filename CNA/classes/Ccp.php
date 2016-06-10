<?php

 class Ccp {

  public function __construct () {
 }

 public function GetMP($mpName)
 {
   /* GET */
     $curl = curl_init();
     $url = 'http://localhost/CDDdemo/CCP/rest/mps/' . $mpName;

     curl_setopt($curl, CURLOPT_URL, $url);
     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

     $result = curl_exec($curl);

     curl_close($curl);

     return $result;
 }

 public function SetMP($mpName, $value)
{
  /* POST */
    $data = $value;
    $curl = curl_init();
    $url = 'http://localhost/CDDdemo/CCP/rest/mps/' . $mpName;

    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}

}
