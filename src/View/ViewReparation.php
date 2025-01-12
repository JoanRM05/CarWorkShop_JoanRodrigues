<?php

namespace App\View;

use App\Controller\ControllerReparation;
use App\Model\Reparation;
use Exception;

require __DIR__.'/../../vendor/autoload.php'; 

    session_start();

    if(isset($_GET["role"])){
        
        $_SESSION["login"] = true;
        $_SESSION["role"] = $_GET["role"];

    }

    if ($_SESSION["login"]){

    ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>WorkShop Menu</title>
            <link rel="stylesheet" href="./view.css">
        </head>
        <body>
                <h1>Car WorkShop Menu</h1>
                
            <form action="" method="get">
                <h3>Search Reparation</h3>
                <h4>Introduce UUID</h4>
                <input type="text" name="uuid" required>
                <input type="submit" name="get" value="SEARCH">
            </form>

            <br> <br> <br>
    <?php

    switch($_SESSION["role"]){
        case "employee":
            
            ?>

            <form action="" method="post" enctype="multipart/form-data">

                <h3>Insert Reparation</h3>
                <h4>Id WorkShop (F: 0000 to 9999)</h4>
                <input type="text" name="idw" pattern="\d{4}" required>

                <h4>Name Workshop (F: N/a)</h4>
                <input type="text" name="namew" maxlength="12" required>

                <h4>Register Date (F: yyyy-mm-dd)</h4>
                <input type="date" pattern="^\d{4}-\d{2}-\d{2}$" name="rdate" required>

                <h4>License Plate (F: 1111-XXX)</h4>
                <input type="text" pattern="^\d{4}-[A-Za-z]{3}$" name="lplate" required>

                <h4>Car Img</h4>
                <input type="file" name="image" accept="image/*" required>
                
                <br><br>
                <input type="submit" name="post" value="INSERT">

            </form>


            <?php

        break;
        
        default:
        break;
    }

    }

    if(isset($_GET['get'])){
        
        try{

            $controller = new ControllerReparation();

            $reparation = $controller->getReparation($_SESSION["role"], $_GET["uuid"]) ;

            $viewr = new ViewReparation();

            $viewr->render($reparation);

        }catch(Exception $e){
            echo $e->getMessage();
        }

    }

    if(isset($_POST['post'])){

        try{

            $_SESSION["idw"] = $_POST["idw"];
            $_SESSION["namew"] = $_POST["namew"];
            $_SESSION["rdate"] = $_POST["rdate"];
            $_SESSION["lplate"] = $_POST["lplate"];

            $controller = new ControllerReparation();

            $reparation = $controller->insertReparation();

            $viewr = new ViewReparation();

            $viewr->render($reparation);

        }catch(Exception $e){

            echo $e->getMessage();

        }

    }


class ViewReparation{

    function render(Reparation $reparation = null){

        if ($reparation != null){

            echo '<table style="width: 30%; margin: 20px auto; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 16px;">';
            
            echo '<tr style="background-color: #4CAF50; text-transform: uppercase;">';
            echo '<th style="border: 1px solid #ddd; padding: 12px; text-align: left; color: white">UUID</th>';
            echo '<td style="border: 1px solid #ddd; padding: 12px; background-color: #f9f9f9; color: black">' . $reparation->getUuid() . '</td>';
            echo '</tr>';


            echo '<tr>';
            echo '<th style="border: 1px solid #ddd; padding: 12px; text-align: left;">ID Workshop</th>';
            echo '<td style="border: 1px solid #ddd; padding: 12px; background-color: #f9f9f9;">' . $reparation->getIdworkshop() . '</td>';
            echo '</tr>';

            
            echo '<tr>';
            echo '<th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Name Workshop</th>';
            echo '<td style="border: 1px solid #ddd; padding: 12px; background-color: #f9f9f9;">' . $reparation->getNameworkshop() . '</td>';
            echo '</tr>';


            echo '<tr>';
            echo '<th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Register Date</th>';
            echo '<td style="border: 1px solid #ddd; padding: 12px; background-color: #f9f9f9;">' . $reparation->getRegisterdate() . '</td>';
            echo '</tr>';


            echo '<tr>';
            echo '<th style="border: 1px solid #ddd; padding: 12px; text-align: left;">License Plate</th>';
            echo '<td style="border: 1px solid #ddd; padding: 12px; background-color: #f9f9f9;">' . $reparation->getLicenseplate() . '</td>';
            echo '</tr>';
            
            echo '<tr>';
            echo '<th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Img</th>';
            echo '<td style="border: 1px solid #ddd; padding: 12px; background-color: #f9f9f9;"> <img src="data:image/*;base64,' . base64_encode($reparation->getImg()) . '" alt="Uploaded Image" style="max-width: 500px;"> </td>';
            echo '</tr>';

            echo '</table>';

        }else {

            throw new Exception("<h1> No hay ninguna reparacion con el UUID especificado. </h1>");

        }

    }

}

?>

</body>
</html>



