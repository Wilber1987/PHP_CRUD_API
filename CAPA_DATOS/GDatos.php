<?php
namespace CAPA_DATOS;

class GDatos
{
    public static function SqlConexion()
    {
        $serverName = "localhost";
        $connectionOptions = array(
            "Database" => "SNIBD",
            "Uid" => "sa", "PWD" => "zaxscd",
        );
        $conn = sqlsrv_connect($serverName, $connectionOptions);
        if ($conn == false) {
            die(FormatErrors(sqlsrv_errors()));
        }
        return $conn;
    }
    public static function ExcuteDataQuery($Query)
    {
        $Form = [];
        $Conexion = GDatos::SqlConexion();
        $q = sqlsrv_query($Conexion, $Query);
        if ($q == false) {
            die(FormatErrors(sqlsrv_errors()));
        }
        while ($fila = sqlsrv_fetch_array($q, SQLSRV_FETCH_ASSOC)) {
            $Form[] = $fila;
        }
        sqlsrv_free_stmt($q);
        sqlsrv_close($Conexion);
        return $Form;
    }
    public static function GetModelTable($Intancia)
    {
        $Query = "SELECT * FROM [INFORMATION_SCHEMA].[COLUMNS]
            WHERE [TABLE_NAME] = '" . substr(get_class($Intancia), strrpos(get_class($Intancia), '\\') + 1) . "'
            ORDER by [ORDINAL_POSITION]";
        try {
            return GDatos::ExcuteDataQuery($Query);
        } catch (\Exception$th) {
            echo "<hr> error: $Query <hr>" . json_encode($th);
        }
    }
    public static function Get($Intancia)
    {
        $Query = "SELECT * FROM  " . substr(get_class($Intancia), strrpos(get_class($Intancia), '\\') + 1);
        try {
            return GDatos::ExcuteDataQuery($Query);
        } catch (\Exception$th) {
            echo "<hr> error: $Query <hr>" . json_encode($th);
        }
    }
    public static function Insert($Intancia)
    {
        $tablename = substr(get_class($Intancia), strrpos(get_class($Intancia), '\\') + 1);
        $Conexion = GDatos::SqlConexion();
        $colums = "";
        $values = "";
        foreach (GDatos::GetModelTable($Intancia) as $key => $value) {
            if ($key != 0) {
                $columName = $value["COLUMN_NAME"];
                $colums = $colums . $value["COLUMN_NAME"] . ",";
                switch ($value["DATA_TYPE"]) {
                    case 'int':case 'smallint':case 'bigint':
                        $values = $values . $Intancia->$columName . ",";
                    case 'decimal':case 'money':case 'float':
                        $values = $values . $Intancia->$columName . ",";
                        break;
                    case 'datetime':
                        $values = $values . "'" . $Intancia->$columName . "',";
                        break;
                    case 'date':
                        $values = $values . "'" . $Intancia->$columName . "',";
                        break;
                    case 'bit':
                        $values = $values . "'" . $Intancia->$columName . "',";
                        break;
                    default:
                        $values = $values . "'" . $Intancia->$columName . "',";
                        break;
                }
            }
        }
        $colums = substr($colums, 0, -1);
        $values = substr($values, 0, -1);
        $Query = "INSERT INTO $tablename($colums) values($values)";
        try {
            return GDatos::ExcuteDataQuery($Query);
        } catch (\Exception$th) {
            echo "<hr> error: $Query <hr>" . json_encode($th);
        }
    }
    public static function Update($Intancia)
    {
        $tablename = substr(get_class($Intancia), strrpos(get_class($Intancia), '\\') + 1);
        $Conexion = GDatos::SqlConexion();
        $values = "";
        $WhereCondicion = "";
        foreach (GDatos::GetModelTable($Intancia) as $key => $value) {
            $columName = $value["COLUMN_NAME"];
            $valId = $Intancia->$columName;
            if ($key != 0) {
                switch ($value["DATA_TYPE"]) {
                    case 'int':case 'smallint':case 'bigint':
                        $values = $values . " $columName = '$valId',";
                        break;
                    case 'decimal':case 'money':case 'float':
                        $values = $values . " $columName = $valId,";
                        break;
                    case 'datetime':
                        $values = $values . " $columName = $valId,";
                        break;
                    case 'date':
                        $values = $values . " $columName = $valId,";
                        break;
                    case 'bit':
                        $$values = $values . " $columName = $valId,";
                        break;
                    default:
                        $values = $values . " $columName = '$valId',";
                        break;
                }
            } else {
                $valId = $Intancia->$columName;
                switch ($value["DATA_TYPE"]) {
                    case 'int':case 'smallint':case 'bigint':
                        $WhereCondicion = "WHERE  $columName = $valId";
                        break;
                    case 'decimal':case 'money':case 'float':
                        $WhereCondicion = "WHERE  $columName = $valId";
                        break;
                    case 'datetime':
                        $WhereCondicion = "WHERE  $columName = '$valId'";
                        break;
                    default:
                        $WhereCondicion = "WHERE  $columName = '$valId'";
                        break;
                }
            }
        }
        $values = substr($values, 0, -1);
        $Query = "UPDATE $tablename SET $values $WhereCondicion";
        try {
            return GDatos::ExcuteDataQuery($Query);
        } catch (\Exception$th) {
            echo "<hr> error: $Query <hr>" . json_encode($th);
        }
    }
    public static function Delete($request)
    {
        # code...
    }
}
