<?php
namespace App\Service;

use App\Model\Reparation;
use Exception;
use Monolog\Logger;
use Monolog\Level;
use Monolog\Handler\StreamHandler;

use Ramsey\Uuid\Uuid;

use Intervention\Image\ImageManager;

use mysqli;
use mysqli_sql_exception;


class ServiceReparation{

    function connect(){
        $log = new Logger("LogWorkerDBCon");
        $log->pushHandler(new StreamHandler("../../logs/app_workshop.log", Level::Info)); 

        try{
            $db = parse_ini_file("../../cfg/db_config.ini");

            $mysqli = new mysqli($db["host"], $db["user"], $db["pwd"], $db["db_name"]);

            $log->info("Conection with database established");

            return $mysqli;
        
        }catch (mysqli_sql_exception $e){

            $log->error("Connection with database failed");

            throw new Exception("<h1> Error, La conexion no se ha podido establecer. </h1>");
        }

    }


    function generateUUID(){

        $uuid = Uuid::uuid4();

        return $uuid->toString();

    }


    function insertReparation(int $idw, string $namew, string $rdate, string $lplate){

        $log = new Logger("LogWorkerDBIns");
        $log->pushHandler(new StreamHandler("../../logs/app_workshop.log", Level::Info));

        $managerImage = new ImageManager();

        $conn = $this->connect(); 
        
        $uuid = $this->generateUUID();

        $imageObject = $managerImage->make($_FILES["image"]["tmp_name"]);

        $watermark = $uuid.$lplate;

        $imageObject->resize(400, 250);

        $imageObject->text($watermark, 370, 230, function ($font) {
            $font->size(70);
            $font->color('fff');
            $font->align('right');
            $font->valign('bottom');
        });

        $imageObject->save("../../resources/imgs/output/" . $_FILES["image"]["name"]);

        $imgContent = file_get_contents("../../resources/imgs/output/" . $_FILES["image"]["name"]);

        unlink("../../resources/imgs/output/" . $_FILES["image"]["name"]);

        $sql = "INSERT INTO reparation VALUES ('$uuid', $idw, '$namew', '$rdate', '$lplate', ?);";

        try {
                
            $statement = $conn->prepare($sql);

            $statement->bind_param('s', $imgContent);

            $statement->execute();

            $log->info("Insert to Reparations table complited");

            return new Reparation($uuid, $idw, $namew, $rdate, $lplate, $imgContent);

        }catch (mysqli_sql_exception $e) {

            $log->warning("Insert to Reparations table failed");
            
            throw new Exception("<h1> No se ha podido insertar correctamente la reparación. </h1>");

        }

    }   


    function getReparation(String $role, string $uuid){

        $log = new Logger("LogWorkerDBSel");
        $log->pushHandler(new StreamHandler("../../logs/app_workshop.log", Level::Info)); 

        $managerImage = new ImageManager();

        $conn = $this->connect(); 

        $sql_sentence = "SELECT * FROM Reparation WHERE uuid = '$uuid'";

        try {
                
            $result = $conn->query($sql_sentence);

            $log->info("Select to Reparations table complited");

            while ($row = mysqli_fetch_assoc($result)) {
        
                if($role == "client"){
                    
                    $image = $managerImage->make($row["img"]);

                    $image->pixelate(20);

                    $image->save("../../resources/imgs/input/image1.jpg");

                    $imgContent = file_get_contents("../../resources/imgs/input/image1.jpg");

                    unlink("../../resources/imgs/input/image1.jpg");

                    return new Reparation($row["uuid"], $row["id_workshop"], $row["name_workshop"], $row["register_date"], "****-***", $imgContent);    

                } else {

                    return new Reparation($row["uuid"], $row["id_workshop"], $row["name_workshop"], $row["register_date"], $row["license_plate"], $row["img"]);

                }
                
            }
    
        } catch (mysqli_sql_exception $e) {

            $log->warning("Select to Reparations table failed");

            throw new Exception("<h1> No se ha podido recuperar la reparacion indicada. </h1>");

        }

    }  

}



?>