<?php
namespace Dao\Products;

use Dao\Table;

class Products extends Table
{

    public static function getProducts(
        string $partialName = "",
        string $categoria = "",
        string $orderBy = "",
        bool $orderDescending = false,
        int $page = 0,
        int $itemsPerPage = 10
    ) {

        $sqlstr = "SELECT
                        p.id_producto,
                        p.nombre,
                        p.descripcion,
                        p.precio_menor,
                        p.precio_mayor,
                        p.stock,
                        p.imagen,
                        p.categoria
                    FROM productos p";

        $sqlstrCount = "SELECT COUNT(*) as count FROM productos p";

        $conditions = [];
        $params = [];

        if ($partialName != "") {
            $conditions[] = "p.nombre LIKE :partialName";
            $params["partialName"] = "%" . $partialName . "%";
        }

        if ($categoria != "") {
            $conditions[] = "p.categoria = :categoria";
            $params["categoria"] = $categoria;
        }

        if (count($conditions) > 0) {
            $sqlstr .= " WHERE " . implode(" AND ", $conditions);
            $sqlstrCount .= " WHERE " . implode(" AND ", $conditions);
        }

        if (!in_array($orderBy, [
            "id_producto",
            "nombre",
            "precio_menor",
            "precio_mayor",
            "stock",
            ""
        ])) {
            throw new \Exception("Error Processing Request OrderBy has invalid value");
        }

        if ($orderBy != "") {
            $sqlstr .= " ORDER BY " . $orderBy;

            if ($orderDescending) {
                $sqlstr .= " DESC";
            }
        }

        $numeroDeRegistros = self::obtenerUnRegistro($sqlstrCount, $params)["count"];

        $pagesCount = ceil($numeroDeRegistros / $itemsPerPage);

        if ($page > $pagesCount - 1) {
            $page = $pagesCount - 1;
        }

        if ($page < 0) {
            $page = 0;
        }

        $sqlstr .= " LIMIT " . ($page * $itemsPerPage) . ", " . $itemsPerPage;

        $registros = self::obtenerRegistros($sqlstr, $params);

        return [
            "products" => $registros,
            "total" => $numeroDeRegistros,
            "page" => $page,
            "itemsPerPage" => $itemsPerPage
        ];
    }

    public static function getProductById(int $id_producto)
    {
        $sqlstr = "SELECT
                        id_producto,
                        nombre,
                        descripcion,
                        precio_menor,
                        precio_mayor,
                        stock,
                        imagen,
                        categoria
                    FROM productos
                    WHERE id_producto = :id_producto";

        return self::obtenerUnRegistro(
            $sqlstr,
            ["id_producto" => $id_producto]
        );
    }

    public static function insertProduct(
        string $nombre,
        string $descripcion,
        float $precio_menor,
        float $precio_mayor,
        int $stock,
        string $imagen,
        string $categoria
    ) {

        $sqlstr = "INSERT INTO productos
                    (
                        nombre,
                        descripcion,
                        precio_menor,
                        precio_mayor,
                        stock,
                        imagen,
                        categoria
                    )
                    VALUES
                    (
                        :nombre,
                        :descripcion,
                        :precio_menor,
                        :precio_mayor,
                        :stock,
                        :imagen,
                        :categoria
                    )";

        $params = [
            "nombre" => $nombre,
            "descripcion" => $descripcion,
            "precio_menor" => $precio_menor,
            "precio_mayor" => $precio_mayor,
            "stock" => $stock,
            "imagen" => $imagen,
            "categoria" => $categoria
        ];

        return self::executeNonQuery($sqlstr, $params);
    }

    public static function updateProduct(
        int $id_producto,
        string $nombre,
        string $descripcion,
        float $precio_menor,
        float $precio_mayor,
        int $stock,
        string $imagen,
        string $categoria
    ) {

        $sqlstr = "UPDATE productos
                    SET
                        nombre = :nombre,
                        descripcion = :descripcion,
                        precio_menor = :precio_menor,
                        precio_mayor = :precio_mayor,
                        stock = :stock,
                        imagen = :imagen,
                        categoria = :categoria
                    WHERE id_producto = :id_producto";

        $params = [
            "id_producto" => $id_producto,
            "nombre" => $nombre,
            "descripcion" => $descripcion,
            "precio_menor" => $precio_menor,
            "precio_mayor" => $precio_mayor,
            "stock" => $stock,
            "imagen" => $imagen,
            "categoria" => $categoria
        ];

        return self::executeNonQuery($sqlstr, $params);
    }

    public static function deleteProduct(int $id_producto)
    {
        $sqlstr = "DELETE FROM productos
                    WHERE id_producto = :id_producto";

        return self::executeNonQuery(
            $sqlstr,
            ["id_producto" => $id_producto]
        );
    }
}
?>