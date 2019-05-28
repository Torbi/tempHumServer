<?php
/**
 *
 */
class chartController extends Controller
{

#Skapar en dateController och kallar på en getAllTemp i dateController som kallar på en
#funktion i modelfilen getData getAllTemp som hämtar all data från databasen
#det encodas till json och hämtas med ajax från jsfilen chart.js
  function renderChartData($params)  {

    require(ROOT . 'Controllers/dateController.php');
    $dateController = new dateController();
    $data = [];

    switch ($params) {
      case 1:
        $data = $dateController->receiveDate(1);
        break;
      case 7:
        $data = $dateController->receiveDate(7);
        break;
      case 30:
        $data = $dateController->receiveDate(30);
        break;
      case 69:
        $data = $dateController->getAll();
        break;
      default:
        $data = $dateController->getAll();
        break;
    }

    echo json_encode($data);

  }
}
 ?>
