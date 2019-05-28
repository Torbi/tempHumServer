<?php

  class getData extends Model {

    var $dbconn;

    function _construct()  {
    //  $this->$dbconn = Database::getBdd();
    }

    //lägg in värden som kommer från arduinon
    function insertData($params) {

      $dbconn = Database::getBdd();

      $sql = "INSERT INTO reader_values(timestamp_pk, temperature, humidity) VALUES (:timestamp_pk, :temperature, :humidity)";

      $first = strpos($params, "=") + 1;
      $last = strrpos($params, "=") + 1;
      $and = strpos($params, "&");
      $length = strlen($params) + 1;

      $temp = filter_var(substr($params, $first, ($and - 6)), FILTER_SANITIZE_STRING);
      $hum = filter_var(substr($params, $last, ($length - 1)), FILTER_SANITIZE_STRING);

      $req = Database::getBdd()->prepare($sql);
      $req->execute([
        'timestamp_pk' => date('Y-m-d H:i:s'),
        'temperature' => $temp,
        'humidity' => $hum
      ]);
    }

    //hämta alla värden
    function getAllTemp() {

      $dbconn = Database::getBdd();

      $sql = "SELECT timestamp_pk, temperature, humidity FROM reader_values ORDER BY timestamp_pk ASC";

      $req = $dbconn->prepare($sql);
      $req->execute();
      $data = $req->fetchAll();
      return $data;

    }

    function getDay($params)  {

      error_log("getDay params " . $params, 0);

      $days = $params;
      $result = [];
      //måste vara ett DateTime objekt för att kunna modifiera det
      $date = date_create();
      //måste vara ett DateInterval objekt som intervall för att modifiera DateTime
      $dateInterval = new DateInterval('P1D');

      for($i = 0; $i < $days; $i++) {
        $currentDate = $date->format('Y-m-d');
        $sqlDate = $currentDate.'%';

        $sql = "SELECT * FROM reader_values WHERE timestamp_pk LIKE :currentDate ORDER BY timestamp_pk ASC";
        $req = Database::getBdd()->prepare($sql);
        $req->execute([
          'currentDate' => $sqlDate
        ]);
        $data = $req->fetchAll();
        //lägg in de nya värdena i result-arrayen
        $result = array_merge($result, $data);
        //ta bort en dag
        date_sub($date, $dateInterval);
      }
      return $result;
    }
  }
 ?>
