<?php
namespace CAPA_DATOS;
include_once "GDatos.php";
use CAPA_DATOS\GDatos;
class EntityClass
{
    public function Save() { 
        return GDatos::Insert($this); 
    }
    public function Update() { 
        return GDatos::Update($this);
    }
    public function Get() { 
        return GDatos::Get($this);
    }
    public function Get_WhereIN() { 
        return null; 
    }
    public function Get_WhereNotIN() { 
        return null; 
    }
}
