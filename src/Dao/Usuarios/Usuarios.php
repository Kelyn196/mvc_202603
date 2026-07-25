<?php

namespace Dao\Usuarios;

use Dao\Table;

class Usuarios extends Table
{
    public static function getUsuarios(
        string $partialName = "",
        string $status = "",
        string $orderBy = "",
        bool $orderDescending = false,
        int $page = 0,
        int $itemsPerPage = 10
    ) {

        $sqlstr = "SELECT
                    u.usercod,
                    u.useremail,
                    u.username,
                    u.userpswd,
                    u.userfching,
                    u.userpswdest,
                    u.userpswdexp,
                    u.userest,
                    u.useractcod,
                    u.userpswdchg,
                    u.usertipo,
                    CASE
                        WHEN u.userest = 'ACT' THEN 'Activo'
                        WHEN u.userest = 'INA' THEN 'Inactivo'
                        ELSE 'Sin Asignar'
                    END AS userestDsc
                FROM usuario u";

        $sqlstrCount = "SELECT COUNT(*) AS count
                        FROM usuario u";

        $conditions = [];
        $params = [];

        if ($partialName != "") {
            $conditions[] = "(u.username LIKE :partialName OR u.useremail LIKE :partialName)";
            $params["partialName"] = "%" . $partialName . "%";
        }

        if (!in_array($status, ["ACT", "INA", ""])) {
            throw new \Exception("Status inválido");
        }

        if ($status != "") {
            $conditions[] = "u.userest = :status";
            $params["status"] = $status;
        }

        if (count($conditions) > 0) {
            $sqlstr .= " WHERE " . implode(" AND ", $conditions);
            $sqlstrCount .= " WHERE " . implode(" AND ", $conditions);
        }

        if (!in_array($orderBy, ["usercod", "username", "useremail", ""])) {
            throw new \Exception("OrderBy inválido");
        }

        if ($orderBy != "") {
            $sqlstr .= " ORDER BY " . $orderBy;
            $sqlstr .= $orderDescending ? " DESC" : " ASC";
        }

        $numeroDeRegistros = self::obtenerUnRegistro(
            $sqlstrCount,
            $params
        )["count"] ?? 0;

        $pagesCount = ($numeroDeRegistros > 0)
            ? ceil($numeroDeRegistros / $itemsPerPage)
            : 1;

        if ($page < 0) {
            $page = 0;
        }

        if ($page >= $pagesCount) {
            $page = max(0, $pagesCount - 1);
        }

        $offset = $page * $itemsPerPage;

        $sqlstr .= " LIMIT " . intval($offset) . ", " . intval($itemsPerPage);

        $registros = self::obtenerRegistros(
            $sqlstr,
            $params
        );

        return [
            "usuarios" => $registros,
            "total" => $numeroDeRegistros,
            "page" => $page,
            "itemsPerPage" => $itemsPerPage
        ];
    }

    public static function getUsuarioById(int $usercod)
    {
        $sqlstr = "SELECT
                    usercod,
                    useremail,
                    username,
                    userpswd,
                    userfching,
                    userpswdest,
                    userpswdexp,
                    userest,
                    useractcod,
                    userpswdchg,
                    usertipo
                FROM usuario
                WHERE usercod = :usercod";

        return self::obtenerUnRegistro(
            $sqlstr,
            [
                "usercod" => $usercod
            ]
        );
    }

    public static function insertUsuario(
        string $useremail,
        string $username,
        string $userpswd,
        string $userfching,
        string $userpswdest,
        string $userpswdexp,
        string $userest,
        string $useractcod,
        string $userpswdchg,
        string $usertipo
    ) {

        $sqlstr = "INSERT INTO usuario (
                        useremail,
                        username,
                        userpswd,
                        userfching,
                        userpswdest,
                        userpswdexp,
                        userest,
                        useractcod,
                        userpswdchg,
                        usertipo
                    ) VALUES (
                        :useremail,
                        :username,
                        :userpswd,
                        :userfching,
                        :userpswdest,
                        :userpswdexp,
                        :userest,
                        :useractcod,
                        :userpswdchg,
                        :usertipo
                    )";

        return self::executeNonQuery(
            $sqlstr,
            [
                "useremail" => $useremail,
                "username" => $username,
                "userpswd" => $userpswd,
                "userfching" => $userfching,
                "userpswdest" => $userpswdest,
                "userpswdexp" => $userpswdexp,
                "userest" => $userest,
                "useractcod" => $useractcod,
                "userpswdchg" => $userpswdchg,
                "usertipo" => $usertipo
            ]
        );
    }

    public static function updateUsuario(
        int $usercod,
        string $useremail,
        string $username,
        string $userpswd,
        string $userfching,
        string $userpswdest,
        string $userpswdexp,
        string $userest,
        string $useractcod,
        string $userpswdchg,
        string $usertipo
    ) {

        $sqlstr = "UPDATE usuario
                    SET
                        useremail = :useremail,
                        username = :username,
                        userpswd = :userpswd,
                        userfching = :userfching,
                        userpswdest = :userpswdest,
                        userpswdexp = :userpswdexp,
                        userest = :userest,
                        useractcod = :useractcod,
                        userpswdchg = :userpswdchg,
                        usertipo = :usertipo
                    WHERE usercod = :usercod";

        return self::executeNonQuery(
            $sqlstr,
            [
                "usercod" => $usercod,
                "useremail" => $useremail,
                "username" => $username,
                "userpswd" => $userpswd,
                "userfching" => $userfching,
                "userpswdest" => $userpswdest,
                "userpswdexp" => $userpswdexp,
                "userest" => $userest,
                "useractcod" => $useractcod,
                "userpswdchg" => $userpswdchg,
                "usertipo" => $usertipo
            ]
        );
    }

    public static function deleteUsuario(int $usercod)
    {
        return self::executeNonQuery(
            "DELETE FROM usuario
             WHERE usercod = :usercod",
            [
                "usercod" => $usercod
            ]
        );
    }
}
?>