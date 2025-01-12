<?php
namespace App\Model;

class Reparation {

    private string $uuid;
    private int $idworkshop;
    private string $nameworkshop;
    private string $registerdate;
    private string $licenseplate;
    private string $img;

    function __construct($uuid, $idworkshop, $nameworkshop, $registerdate, $licenseplate, $img){

        $this->uuid = $uuid;
        $this->idworkshop = $idworkshop;
        $this->nameworkshop = $nameworkshop;
        $this->registerdate = $registerdate;
        $this->licenseplate = $licenseplate;
        $this->img = $img;
        
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function setUuid($uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getIdworkshop()
    {
        return $this->idworkshop;
    }

    public function setIdworkshop($idworkshop)
    {
        $this->idworkshop = $idworkshop;

        return $this;
    }

    public function getNameworkshop()
    {
        return $this->nameworkshop;
    }

    public function setNameworkshop($nameworkshop)
    {
        $this->nameworkshop = $nameworkshop;

        return $this;
    }

    public function getRegisterdate()
    {
        return $this->registerdate;
    }

    public function setRegisterdate($registerdate)
    {
        $this->registerdate = $registerdate;

        return $this;
    }

    public function getLicenseplate()
    {
        return $this->licenseplate;
    }
 
    public function setLicenseplate($licenseplate)
    {
        $this->licenseplate = $licenseplate;

        return $this;
    }

    public function getImg()
    {
        return $this->img;
    }

    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }
}




?>