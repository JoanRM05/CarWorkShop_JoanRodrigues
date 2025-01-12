<?php

session_start();

if(!isset($_SESSION["login"])){

    $_SESSION["login"] = false;

}

if($_SESSION["login"]){

    session_destroy();

    $_SESSION["login"] = false;

}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role</title>
    <link rel="stylesheet" href="./index.css">
</head>
<body>
    
<form action="../src/View/ViewReparation.php" method="get">
    <h1>Search Reparation</h1>

    <h3>Introduce your role</h3>
    <div class="sel-container">
        <select name="role">
            <option value="employee">Employee</option>
            <option value="client">Client</option>   
        </select>
    </div>

    <input type="submit" value="SELECT">
</form>    

</body>
</html>