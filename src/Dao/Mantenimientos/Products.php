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
        $sqlstr = "SELECT * FROM products WHERE productId = :productId;";
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
        $sqlIns = "INSERT INTO products (
            productName,
            productDescription,
            productPrice,
            productImgUrl,
            productStock,
            productStatus
        )
        VALUES
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
        $sqlUpd = "UPDATE products SET
            productName = :productName,
            productDescription = :productDescription,
            productPrice = :productPrice,
            productImgUrl = :productImgUrl,
            productStock = :productStock,
            productStatus = :productStatus
            WHERE productId = :productId;";

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

    public static function delete(int $productId)
    {
        self::executeNonQuery(
            "DELETE FROM carretilla WHERE productId = :productId;",
            ["productId" => $productId]
        );

        return self::executeNonQuery(
            "DELETE FROM products WHERE productId = :productId;",
            ["productId" => $productId]
        );
    }

    public static function softDelete(int $productId)
    {
        $sqlstr = "UPDATE products
                   SET deleted_at = NOW()
                   WHERE productId = :productId;";

        return self::executeNonQuery($sqlstr, ["productId" => $productId]);
    }
}

?>