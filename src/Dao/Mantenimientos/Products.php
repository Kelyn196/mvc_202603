<?php

namespace Dao\Products;

use Dao\Table;

/*
    productId INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary Key',
    productName VARCHAR(255),
    productDescription VARCHAR(255),
    productPrice DECIMAL(12,2),
    productStock INT,
    productImgUrl VARCHAR(255),
    productStatus VARCHAR(3)
*/

class Products extends Table
{

    public static function getAll(): array
    {
        $sqlstr = "SELECT * FROM products;";
        return self::obtenerRegistros($sqlstr, []);
    }

    public static function getById(int $id): array
    {
        $sqlstr = "SELECT * FROM products WHERE productId = :productId;";
        return self::obtenerUnRegistro($sqlstr, ["productId" => $id]);
    }

    public static function create(
        string $productName,
        string $productDescription,
        float $productPrice,
        int $productStock,
        string $productImgUrl,
        string $productStatus
    ) {
        $sqlIns = "INSERT INTO products (
            productName, productDescription, productPrice, productStock, productImgUrl, productStatus
        ) VALUES (
            :productName, :productDescription, :productPrice, :productStock, :productImgUrl, :productStatus
        );";

        $param = [
            "productName" => $productName,
            "productDescription" => $productDescription,
            "productPrice" => $productPrice,
            "productStock" => $productStock,
            "productImgUrl" => $productImgUrl,
            "productStatus" => $productStatus
        ];

        return self::executeNonQuery($sqlIns, $param);
    }

    public static function update(
        int $productId,
        string $productName,
        string $productDescription,
        float $productPrice,
        int $productStock,
        string $productImgUrl,
        string $productStatus
    ) {
        $sqlUpd = "UPDATE products SET
            productName = :productName,
            productDescription = :productDescription,
            productPrice = :productPrice,
            productStock = :productStock,
            productImgUrl = :productImgUrl,
            productStatus = :productStatus
        WHERE productId = :productId;";

        $param = [
            "productId" => $productId,
            "productName" => $productName,
            "productDescription" => $productDescription,
            "productPrice" => $productPrice,
            "productStock" => $productStock,
            "productImgUrl" => $productImgUrl,
            "productStatus" => $productStatus
        ];

        return self::executeNonQuery($sqlUpd, $param);
    }

    public static function delete(int $productId)
    {
        $sqlstr = "DELETE FROM products WHERE productId = :productId;";
        return self::executeNonQuery($sqlstr, ["productId" => $productId]);
    }

    public static function softDelete(int $productId): array
    {
        $sqlstr = "UPDATE products SET deleted_at = NOW() WHERE productId = :productId;";
        return self::executeNonQuery($sqlstr, ["productId" => $productId]);
    }
}