<?php

include_once('../Helper/SwapiHelper.php');

/**
 * ===================================
 * Manage actions to consume SWAPI
 * ===================================
*/
try {

    $swapiHelper = new SwapiHelper();
    $action = $_POST['action'];
    $id = $_POST['id'];

    switch ($action) {
        case 1:
            /*Get vehicle data*/
            $result = $swapiHelper->getVehicle($id);
            break;
        case 2:
            /*Set total units - Vehicle*/
            $amount = $_POST['amount'];
            $result = $swapiHelper->setTotalVehicle($id,$amount);
            break;
        case 3:
            /*Add units - Vehicle*/
            $amount = $_POST['amount'];
            $result = $swapiHelper->incrementTotalVehicle($id,$amount);
            break;
        case 4:
            /*Remove units - Vehicle*/
            $amount = $_POST['amount'];
            $result = $swapiHelper->decrementTotalVehicle($id,$amount);
            break;
        case 5:
            /*Get starship data*/
            $result = $swapiHelper->getStarship($id);
            break;
        case 6:
            /*Set total units - Startship*/
            $amount = $_POST['amount'];
            $result = $swapiHelper->setTotalStartship($id,$amount);
            break;
        case 7:
              /*Add units - Startship*/
              $amount = $_POST['amount'];
              $result = $swapiHelper->incrementTotalStartship($id,$amount);
              break;
        case 8:
            /* Remove units - Startship*/
            $amount = $_POST['amount'];
            $result = $swapiHelper->decrementTotalStartship($id,$amount);
            break;
    }

    /* Return json*/
    echo $result;

}
catch (Exception $e) {
   return ["error"=>true, "description"=> $e->getMessage()];
}

?>