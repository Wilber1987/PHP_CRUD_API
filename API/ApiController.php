<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=utf-8');
include_once "../MODEL/ModelDatabase.php";
use MODEL\Security_Permissions;

class ApiController {
    public function GetSecurity_Permissions($Data)
    {        
        $Data = new Security_Permissions($Data);
        return $Data->Get();
    }
    public function SaveSecurity_Permissions($Data)
    {        
        $Data = new Security_Permissions($Data);
        return $Data->Save();
    }
    public function UpdateSecurity_Permissions($Data)
    {        
        $Data = new Security_Permissions($Data);
        return $Data->Update();
    }
}

$JSONData = file_get_contents("php://input");
$Data = json_decode($JSONData);
$Function =  $_GET["function"];
$Api = new ApiController();
echo json_encode($Api->$Function($Data));