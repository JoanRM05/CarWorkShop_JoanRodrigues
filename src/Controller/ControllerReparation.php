<?php
namespace App\Controller;

use App\Service\ServiceReparation;


class ControllerReparation{

    function insertReparation(){

        $service = new ServiceReparation();

        return $service->insertReparation($_SESSION["idw"], $_SESSION["namew"], $_SESSION["rdate"], $_SESSION["lplate"]);

    }

    function getReparation($role, $uuid){

        $service = new ServiceReparation();

        return $service->getReparation($role, $uuid);

    }
    
}

?>