<?php

class Db {

  public static $connection;

  public function __construct ( $file = 'dbsettings.ini') {


      if ( !isset(self::$connection) ) {

        $settings = parse_ini_file($file, true);

        $dbhost = $settings['database']['host'];
        $dbuser = $settings['database']['username'];
        $dbpass = $settings['database']['password'];
        $dbname = $settings['database']['dbname'];
        $dbport = $settings['database']['port'];

      try{
        self::$connection = new PDO('pgsql:dbname=' . $dbname . ';host=' . $dbhost .
            ';port=' . $dbport . ';user=' . $dbuser . ';password=' . $dbpass);
        self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
      }

      if (!self::$connection)

      echo 'Could not connect to database!';

      } else {

        //echo 'Warning: Connection is already established!';

      }

  }



}
