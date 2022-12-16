<?php
namespace MODEL;
include_once "../CAPA_DATOS/EntityClass.php";
use CAPA_DATOS\EntityClass;
class Security_Users extends  EntityClass {
	function __construct($params){
		foreach ($params as $key => $value) {
			$this->$key = $value;
		}
	}
	public $Id_User;
	public $Nombres;
	public $Estado;
	public $Descripcion;
	public $Password;
	public $Mail;
} 
 
class Security_Roles extends  EntityClass {
	function __construct($params){
		foreach ($params as $key => $value) {
			$this->$key = $value;
		}
	}
	public $Id_Role;
	public $Descripcion;
	public $Estado;
}
class Security_Users_Roles extends  EntityClass {
	function __construct($params){
		foreach ($params as $key => $value) {
			$this->$key = $value;
		}
	}
	public $Id_Role;
	public $Id_User;
	public $Estado;
}
 
class Security_Permissions extends  EntityClass {
	function __construct($params){			
		foreach ($params as $key => $value) {
			$this->$key = $value;
		}
	}
	public $Id_Permission;
	public $Descripcion;
	public $Estado;
}
class Security_Permissions_Roles extends  EntityClass {
	function __construct($params){
		foreach ($params as $key => $value) {
			$this->$key = $value;
		}
	}
	public $Id_Role;
	public $Id_Permission;
	public $Estado;
}
 
 
?>