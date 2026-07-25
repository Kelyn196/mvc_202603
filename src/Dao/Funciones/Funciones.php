<?php

namespace Dao\Funciones;

use Dao\Table;

class Funciones extends Table
{
    public static function getFunciones(
        string $partialName = "",
        string $status = "",
        string $orderBy = "",
        bool $orderDescending = false,
        int $page = 0,
        int $itemsPerPage = 10
    ) {

        $sqlstr = "SELECT
                        fncod,
                        fndsc,
                        fnest,
                        fntyp,
                        CASE
                            WHEN fnest = 'ACT' THEN 'Activo'
                            WHEN fnest = 'INA' THEN 'Inactivo'
                            ELSE 'Sin Estado'
                        END AS fnestDsc
                    FROM funciones";

        $sqlstrCount = "SELECT COUNT(*) AS count FROM funciones";

        $conditions = [];
        $params = [];

        if ($partialName != "") {
            $conditions[] = "fndsc LIKE :partialName";
            $params["partialName"] = "%" . $partialName . "%";
        }

        if (!in_array($status, ["ACT", "INA", ""])) {
            throw new \Exception("Estado inválido");
        }

        if ($status != "") {
            $conditions[] = "fnest = :status";
            $params["status"] = $status;
        }

        if (count($conditions) > 0) {
            $sqlstr .= " WHERE " . implode(" AND ", $conditions);
            $sqlstrCount .= " WHERE " . implode(" AND ", $conditions);
        }

        if (!in_array($orderBy, ["fncod", "fndsc", "fnest", "fntyp", ""])) {
            throw new \Exception("OrderBy inválido");
        }

        if ($orderBy != "") {
            $sqlstr .= " ORDER BY " . $orderBy;

            if ($orderDescending) {
                $sqlstr .= " DESC";
            }
        }

        $numeroDeRegistros = self::obtenerUnRegistro($sqlstrCount, $params)["count"] ?? 0;

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

        $registros = self::obtenerRegistros($sqlstr, $params);

        return [
            "funciones" => $registros,
            "total" => $numeroDeRegistros,
            "page" => $page,
            "itemsPerPage" => $itemsPerPage
        ];
    }

    public static function getFuncionById(string $fncod)
    {
        $sqlstr = "SELECT
                        fncod,
                        fndsc,
                        fnest,
                        fntyp
                    FROM funciones
                    WHERE fncod = :fncod";

        return self::obtenerUnRegistro(
            $sqlstr,
            [
                "fncod" => $fncod
            ]
        );
    }

    public static function insertFuncion(
        string $fncod,
        string $fndsc,
        string $fnest,
        string $fntyp
    ) {

        $sqlstr = "INSERT INTO funciones
                    (
                        fncod,
                        fndsc,
                        fnest,
                        fntyp
                    )
                    VALUES
                    (
                        :fncod,
                        :fndsc,
                        :fnest,
                        :fntyp
                    )";

        return self::executeNonQuery(
            $sqlstr,
            [
                "fncod" => $fncod,
                "fndsc" => $fndsc,
                "fnest" => $fnest,
                "fntyp" => $fntyp
            ]
        );
    }

    public static function updateFuncion(
        string $fncod,
        string $fndsc,
        string $fnest,
        string $fntyp
    ) {

        $sqlstr = "UPDATE funciones
                    SET
                        fndsc = :fndsc,
                        fnest = :fnest,
                        fntyp = :fntyp
                    WHERE fncod = :fncod";

        return self::executeNonQuery(
            $sqlstr,
            [
                "fncod" => $fncod,
                "fndsc" => $fndsc,
                "fnest" => $fnest,
                "fntyp" => $fntyp
            ]
        );
    }

    public static function deleteFuncion(string $fncod)
    {
        return self::executeNonQuery(
            "DELETE FROM funciones WHERE fncod = :fncod",
            [
                "fncod" => $fncod
            ]
        );
    }
}
?>