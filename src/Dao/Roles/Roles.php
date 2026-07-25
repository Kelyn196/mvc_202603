<?php

namespace Dao\Roles;

use Dao\Table;

class Roles extends Table
{
   
    public static function getRoles(
        string $partialName = "",
        string $status = "",
        string $orderBy = "",
        bool $orderDescending = false,
        int $page = 0,
        int $itemsPerPage = 10
    ) {
        $sql = "SELECT 
                    r.rolescod, 
                    r.rolesdsc, 
                    r.rolesest, 
                    CASE 
                        WHEN r.rolesest = 'ACT' THEN 'Activo' 
                        WHEN r.rolesest = 'INA' THEN 'Inactivo' 
                        ELSE 'Sin Asignar' 
                    END AS rolesestDsc 
                FROM roles r";

        $sqlCount = "SELECT COUNT(*) AS total FROM roles r";

        $conditions = [];
        $params = [];

        if ($partialName !== "") {
            $conditions[] = "r.rolesdsc LIKE :partialName";
            $params["partialName"] = "%" . $partialName . "%";
        }

        if ($status !== "") {
            $conditions[] = "r.rolesest = :status";
            $params["status"] = $status;
        }

        if (count($conditions) > 0) {
            $whereClause = " WHERE " . implode(" AND ", $conditions);
            $sql .= $whereClause;
            $sqlCount .= $whereClause;
        }

        $allowedOrder = ["rolescod", "rolesdsc", "rolesest"];
        if (!in_array($orderBy, $allowedOrder)) {
            $orderBy = "rolescod";
        }

        $sql .= " ORDER BY $orderBy " . ($orderDescending ? "DESC" : "ASC");

        
        $totalData = self::obtenerUnRegistro($sqlCount, $params);
        $total = $totalData["total"] ?? 0;

        
        $offset = $page * $itemsPerPage;
        $sql .= " LIMIT $offset, $itemsPerPage";

        $data = self::obtenerRegistros($sql, $params);

        return [
            "roles" => $data,
            "total" => $total
        ];
    }

   
    public static function getRolById(string $rolescod)
    {
        $sql = "SELECT rolescod, rolesdsc, rolesest
                FROM roles
                WHERE rolescod = :rolescod";

        return self::obtenerUnRegistro($sql, ["rolescod" => $rolescod]);
    }

    
    public static function insertRol(string $rolescod, string $rolesdsc, string $rolesest)
    {
        $sql = "INSERT INTO roles (rolescod, rolesdsc, rolesest)
                VALUES (:rolescod, :rolesdsc, :rolesest)";

        return self::executeNonQuery($sql, [
            "rolescod" => $rolescod,
            "rolesdsc" => $rolesdsc,
            "rolesest" => $rolesest
        ]);
    }

    
    public static function updateRol(string $rolescod, string $rolesdsc, string $rolesest)
    {
        $sql = "UPDATE roles
                SET rolesdsc = :rolesdsc,
                    rolesest = :rolesest
                WHERE rolescod = :rolescod";

        return self::executeNonQuery($sql, [
            "rolescod" => $rolescod,
            "rolesdsc" => $rolesdsc,
            "rolesest" => $rolesest
        ]);
    }

   
    public static function deleteRol(string $rolescod)
    {
        $sql = "DELETE FROM roles
                WHERE rolescod = :rolescod";

        return self::executeNonQuery($sql, [
            "rolescod" => $rolescod
        ]);
    }
}
?>