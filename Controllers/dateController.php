<?php

  class dateController extends Controller {

    //funktioner som har inparameter startdatum och säger till model att
    //hämta temp och hum från det datumet och framåt

    function __construct() {

  }

  function index()  {

    $this->render('index');
  }

//tar emot data från en form
  function receiveDate($params) {

    $days = (int)$params;

    error_log($days . " antal dagar som ska gås bakåt", 0);

    require(ROOT . 'Models/getData.php');
    $getData = new getData();
    $result = $getData->getDay($days);
    return $result;
    //på nåt sätt uppdatera sidan, vänta på ajax, borde kalla på ajax
  }

  //tar emot data från arduinon, som skickar get-request, lägger in i DB
    function receiveReq($temp, $hum) {

        require(ROOT . 'Models/getData.php');
        $getData = new getData();
        $getData->insertData($temp, $hum);
    }

    //hämtar alla temperaturer
    function getAll() {

      require(ROOT . 'Models/getData.php');

      $getData = new getData();
      $result = $getData->getAllTemp();

      return $result;
    }
  }
 ?>
