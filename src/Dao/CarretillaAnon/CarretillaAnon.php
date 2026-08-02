<?php

namespace Dao\CarretillaAnon;

use Dao\Table;

class CarretillaAnon extends Table
{
    public static function getCarretillaByAnon(string $anoncod)
    {
        $sqlstr = "SELECT
                        c.anoncod,
                        c.productId,
                        c.crrctd,
                        c.crrprc,
                        c.crrfching,
                        p.productName,
                        p.productDescription,
                        p.productImgUrl,
                        p.productStatus,
                        p.productStock
                    FROM carretillaanon c
                    INNER JOIN products p
                        ON c.productId = p.productId
                    WHERE c.anoncod = :anoncod";

        return self::obtenerRegistros(
            $sqlstr,
            ["anoncod" => $anoncod]
        );
    }

    public static function addToCarretilla(
        string $anoncod,
        int $productId,
        int $crrctd,
        float $crrprc
    ) {

        // Verificar stock disponible
        $product = self::obtenerUnRegistro(
            "SELECT productStock
             FROM products
             WHERE productId = :productId",
            [
                "productId" => $productId
            ]
        );

        if (!$product) {
            return 0;
        }

        if ($product["productStock"] < $crrctd) {
            return 0;
        }

        // Verificar si ya existe en la carretilla
        $exists = self::obtenerUnRegistro(
            "SELECT crrctd
             FROM carretillaanon
             WHERE anoncod = :anoncod
             AND productId = :productId",
            [
                "anoncod" => $anoncod,
                "productId" => $productId
            ]
        );

        if ($exists) {

            $newQty = $exists["crrctd"] + $crrctd;

            self::executeNonQuery(
                "UPDATE carretillaanon
                 SET crrctd = :crrctd,
                     crrprc = :crrprc,
                     crrfching = NOW()
                 WHERE anoncod = :anoncod
                 AND productId = :productId",
                [
                    "crrctd" => $newQty,
                    "crrprc" => $crrprc,
                    "anoncod" => $anoncod,
                    "productId" => $productId
                ]
            );

        } else {

            self::executeNonQuery(
                "INSERT INTO carretillaanon
                (anoncod, productId, crrctd, crrprc, crrfching)
                VALUES
                (:anoncod, :productId, :crrctd, :crrprc, NOW())",
                [
                    "anoncod" => $anoncod,
                    "productId" => $productId,
                    "crrctd" => $crrctd,
                    "crrprc" => $crrprc
                ]
            );
        }

        // Descontar stock
        self::executeNonQuery(
            "UPDATE products
             SET productStock = productStock - :cantidad
             WHERE productId = :productId",
            [
                "cantidad" => $crrctd,
                "productId" => $productId
            ]
        );

        return 1;
    }

    public static function updateQuantity(
        string $anoncod,
        int $productId,
        int $crrctd
    ) {

        $actual = self::obtenerUnRegistro(
            "SELECT crrctd
             FROM carretillaanon
             WHERE anoncod = :anoncod
             AND productId = :productId",
            [
                "anoncod" => $anoncod,
                "productId" => $productId
            ]
        );

        if (!$actual) {
            return 0;
        }

        if ($crrctd <= 0) {
            return self::removeFromCarretilla(
                $anoncod,
                $productId
            );
        }

        $diferencia = $crrctd - $actual["crrctd"];

        // Aumentó la cantidad
        if ($diferencia > 0) {

            $stock = self::obtenerUnRegistro(
                "SELECT productStock
                 FROM products
                 WHERE productId = :productId",
                [
                    "productId" => $productId
                ]
            );

            if ($stock["productStock"] < $diferencia) {
                return 0;
            }

            self::executeNonQuery(
                "UPDATE products
                 SET productStock = productStock - :cantidad
                 WHERE productId = :productId",
                [
                    "cantidad" => $diferencia,
                    "productId" => $productId
                ]
            );
        }

        // Disminuyó la cantidad
        if ($diferencia < 0) {

            self::executeNonQuery(
                "UPDATE products
                 SET productStock = productStock + :cantidad
                 WHERE productId = :productId",
                [
                    "cantidad" => abs($diferencia),
                    "productId" => $productId
                ]
            );
        }

        return self::executeNonQuery(
            "UPDATE carretillaanon
             SET crrctd = :crrctd
             WHERE anoncod = :anoncod
             AND productId = :productId",
            [
                "crrctd" => $crrctd,
                "anoncod" => $anoncod,
                "productId" => $productId
            ]
        );
    }

    public static function removeFromCarretilla(
        string $anoncod,
        int $productId
    ) {

        // Obtener cantidad para devolver al inventario
        $item = self::obtenerUnRegistro(
            "SELECT crrctd
             FROM carretillaanon
             WHERE anoncod = :anoncod
             AND productId = :productId",
            [
                "anoncod" => $anoncod,
                "productId" => $productId
            ]
        );

        if ($item) {

            self::executeNonQuery(
                "UPDATE products
                 SET productStock = productStock + :cantidad
                 WHERE productId = :productId",
                [
                    "cantidad" => $item["crrctd"],
                    "productId" => $productId
                ]
            );
        }

        return self::executeNonQuery(
            "DELETE FROM carretillaanon
             WHERE anoncod = :anoncod
             AND productId = :productId",
            [
                "anoncod" => $anoncod,
                "productId" => $productId
            ]
        );
    }

    public static function clearCarretilla(string $anoncod)
    {
        $items = self::obtenerRegistros(
            "SELECT productId, crrctd
             FROM carretillaanon
             WHERE anoncod = :anoncod",
            [
                "anoncod" => $anoncod
            ]
        );

        foreach ($items as $item) {
            self::executeNonQuery(
                "UPDATE products
                 SET productStock = productStock + :cantidad
                 WHERE productId = :productId",
                [
                    "cantidad" => $item["crrctd"],
                    "productId" => $item["productId"]
                ]
            );
        }

        return self::executeNonQuery(
            "DELETE FROM carretillaanon
             WHERE anoncod = :anoncod",
            [
                "anoncod" => $anoncod
            ]
        );
    }

    public static function getItemsCount(string $anoncod)
    {
        return self::obtenerUnRegistro(
            "SELECT COUNT(*) AS cantidad
             FROM carretillaanon
             WHERE anoncod = :anoncod",
            [
                "anoncod" => $anoncod
            ]
        );
    }
}