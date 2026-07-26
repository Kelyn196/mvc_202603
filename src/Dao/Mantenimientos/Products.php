<?php

namespace Dao\Mantenimientos;

use Dao\Table;

/*
    productId int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    productName VARCHAR(255),
    productDescription TEXT,
    productPrice DECIMAL(10,2),
    productImgUrl VARCHAR(255),
    productStock INT,
    productStatus CHAR(15)
*/

class Products extends Table
{
    //CRUD Create Read Update Delete
    // Read One Read All

    public static function getAll(): array
    {
        $sqlstr = "SELECT *,
        CASE
            WHEN productStatus='DISPO' THEN 'Disponible'
            WHEN productStatus='AGO' THEN 'Agotado'
            ELSE 'Sin Estado'
        END AS productStatusDsc
        FROM products;";

        return self::obtenerRegistros($sqlstr, []);
    }

    public static function getById(int $productId): array
    {
        $sqlstr = "SELECT * FROM products where productId=:productId;";
        // if soft delete
        // $sqlstr = "SELECT * FROM products where productId=:productId and deleted_at is null;";
        return self::obtenerUnRegistro($sqlstr, ["productId" => $productId]);
    }

    public static function create(
        string $productName,
        string $productDescription,
        float $productPrice,
        string $productImgUrl,
        int $productStock,
        string $productStatus
    ) {
        $sqlIns = "insert into products (
            productName,
            productDescription,
            productPrice,
            productImgUrl,
            productStock,
            productStatus
        )
        values
        (
            :productName,
            :productDescription,
            :productPrice,
            :productImgUrl,
            :productStock,
            :productStatus
        );";

        $param = [
            "productName" => $productName,
            "productDescription" => $productDescription,
            "productPrice" => $productPrice,
            "productImgUrl" => $productImgUrl,
            "productStock" => $productStock,
            "productStatus" => $productStatus
        ];

        return self::executeNonQuery($sqlIns, $param);
    }

    public static function update(
        int $productId,
        string $productName,
        string $productDescription,
        float $productPrice,
        string $productImgUrl,
        int $productStock,
        string $productStatus
    ) {
        $sqlUpd = "update products set
            productName = :productName,
            productDescription = :productDescription,
            productPrice = :productPrice,
            productImgUrl = :productImgUrl,
            productStock = :productStock,
            productStatus = :productStatus
            where productId = :productId;";

        $param = [
            "productName" => $productName,
            "productDescription" => $productDescription,
            "productPrice" => $productPrice,
            "productImgUrl" => $productImgUrl,
            "productStock" => $productStock,
            "productStatus" => $productStatus,
            "productId" => $productId
        ];

        return self::executeNonQuery($sqlUpd, $param);
    }

    // HARD Delete
    public static function delete(int $productId)
    {
        $sqlstr = "DELETE FROM products where productId=:productId;";
        return self::executeNonQuery($sqlstr, ["productId" => $productId]);
    }

    // Buena Práctica (NO SE BORRA NADA DE NADA PARA NADA NI DE BROMA)
    // SOFT Delete
    // Implica en la tabla existe un campo (columna) deleted_at (null)
    public static function softDelete(int $productId)
    {
        $sqlstr = "UPDATE products set deleted_at = now() where productId=:productId;";
        return self::executeNonQuery($sqlstr, ["productId" => $productId]);
    }
}
?>