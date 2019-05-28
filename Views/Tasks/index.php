
<?php

 ?>

<div class="mainWrapper">
    <?php
    /*
    if(!function_exists('renderChartData')) {
      require(ROOT . 'Controllers/chartController.php');
      $c = new chartController();
      $c->renderChartData();
    }
*/
    require(ROOT . 'Views/Date/chart.php');
    renderChart();

     ?>
