<?php

namespace Dao\CarretillaAnon;

use Dao\Table;

class CarretillaAnon extends Table
{
    private const ESTADO_ABIERTO = 'ABIERTO';
    private const ESTADO_CERRADO = 'CERRADO';
    private const ESTADO_PROCESADO = 'PROCESADO';
    private const ESTADO_CANCELADO = 'CANCELADO';

    public static function getCarretillaByAnon(string $anoncod)
    {
        $sqlstr = "SELECT
                        c.anoncod,
                        c.productId,
                        c.crrctd,
                        c.crrprc,
                        c.crrestado,
                        c.crrfching,
                        p.productName,
                        p.productDescription,
                        p.productImgUrl,
                        p.productStatus,
                        p.productStock
                    FROM carretillaanon c
                    INNER JOIN products p
                        ON c.productId = p.productId
                    WHERE c.anoncod = :anoncod
                      AND c.crrestado = :estado";

        return self::obtenerRegistros(
            $sqlstr,
            [
                "anoncod" => $anoncod,
                "estado" => self::ESTADO_ABIERTO
            ]
        );
    }

    public static function addToCarretilla(
        string $anoncod,
        int $productId,
        int $crrctd,
        float $crrprc
    ) {

        $product = self::obtenerUnRegistro(
            "SELECT productStock FROM products WHERE productId = :productId",
            ["productId" => $productId]
        );

        if (!$product || $product["productStock"] < $crrctd) {
            return 0;
        }

        $exists = self::obtenerUnRegistro(
            "SELECT crrctd
             FROM carretillaanon
             WHERE anoncod = :anoncod
             AND productId = :productId
             AND crrestado = :estado",
            [
                "anoncod" => $anoncod,
                "productId" => $productId,
                "estado" => self::ESTADO_ABIERTO
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
                 AND productId = :productId
                 AND crrestado = :estado",
                [
                    "crrctd" => $newQty,
                    "crrprc" => $crrprc,
                    "anoncod" => $anoncod,
                    "productId" => $productId,
                    "estado" => self::ESTADO_ABIERTO
                ]
            );

        } else {

            self::executeNonQuery(
                "INSERT INTO carretillaanon
                (anoncod, productId, crrctd, crrprc, crrestado, crrfching)
                VALUES
                (:anoncod, :productId, :crrctd, :crrprc, :estado, NOW())",
                [
                    "anoncod" => $anoncod,
                    "productId" => $productId,
                    "crrctd" => $crrctd,
                    "crrprc" => $crrprc,
                    "estado" => self::ESTADO_ABIERTO
                ]
            );
        }

        self::executeNonQuery(
            "UPDATE products SET productStock = productStock - :cantidad WHERE productId = :productId",
            ["cantidad" => $crrctd, "productId" => $productId]
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
             AND productId = :productId
             AND crrestado = :estado",
            [
                "anoncod" => $anoncod,
                "productId" => $productId,
                "estado" => self::ESTADO_ABIERTO
            ]
        );

        if (!$actual) {
            return 0; // no existe o no está ABIERTO -> no se toca
        }

        if ($crrctd <= 0) {
            return self::removeFromCarretilla($anoncod, $productId);
        }

        $diferencia = $crrctd - $actual["crrctd"];

        if ($diferencia > 0) {

            $stock = self::obtenerUnRegistro(
                "SELECT productStock FROM products WHERE productId = :productId",
                ["productId" => $productId]
            );

            if ($stock["productStock"] < $diferencia) {
                return 0;
            }

            self::executeNonQuery(
                "UPDATE products SET productStock = productStock - :cantidad WHERE productId = :productId",
                ["cantidad" => $diferencia, "productId" => $productId]
            );

        } elseif ($diferencia < 0) {

            self::executeNonQuery(
                "UPDATE products SET productStock = productStock + :cantidad WHERE productId = :productId",
                ["cantidad" => abs($diferencia), "productId" => $productId]
            );
        }

        return self::executeNonQuery(
            "UPDATE carretillaanon
             SET crrctd = :crrctd
             WHERE anoncod = :anoncod
             AND productId = :productId
             AND crrestado = :estado",
            [
                "crrctd" => $crrctd,
                "anoncod" => $anoncod,
                "productId" => $productId,
                "estado" => self::ESTADO_ABIERTO
            ]
        );
    }

    public static function removeFromCarretilla(
        string $anoncod,
        int $productId
    ) {

        $item = self::obtenerUnRegistro(
            "SELECT crrctd
             FROM carretillaanon
             WHERE anoncod = :anoncod
             AND productId = :productId
             AND crrestado = :estado",
            [
                "anoncod" => $anoncod,
                "productId" => $productId,
                "estado" => self::ESTADO_ABIERTO
            ]
        );

        if ($item) {
            self::executeNonQuery(
                "UPDATE products SET productStock = productStock + :cantidad WHERE productId = :productId",
                ["cantidad" => $item["crrctd"], "productId" => $productId]
            );
        }

        return self::executeNonQuery(
            "DELETE FROM carretillaanon
             WHERE anoncod = :anoncod
             AND productId = :productId
             AND crrestado = :estado",
            [
                "anoncod" => $anoncod,
                "productId" => $productId,
                "estado" => self::ESTADO_ABIERTO
            ]
        );
    }

    public static function closeCarretilla(string $anoncod)
    {
        return self::executeNonQuery(
            "UPDATE carretillaanon
             SET crrestado = :nuevo
             WHERE anoncod = :anoncod
             AND crrestado = :actual",
            [
                "nuevo" => self::ESTADO_CERRADO,
                "actual" => self::ESTADO_ABIERTO,
                "anoncod" => $anoncod
            ]
        );
    }

    public static function procesarCarretilla(string $anoncod)
    {
        return self::executeNonQuery(
            "UPDATE carretillaanon
             SET crrestado = :nuevo
             WHERE anoncod = :anoncod
             AND crrestado = :actual",
            [
                "nuevo" => self::ESTADO_PROCESADO,
                "actual" => self::ESTADO_CERRADO,
                "anoncod" => $anoncod
            ]
        );
    }

    public static function cancelarCarretilla(string $anoncod)
    {
        // Devolver stock de todas las líneas activas (ABIERTO o CERRADO)
        $items = self::obtenerRegistros(
            "SELECT productId, crrctd
             FROM carretillaanon
             WHERE anoncod = :anoncod
             AND crrestado IN ('ABIERTO','CERRADO')",
            ["anoncod" => $anoncod]
        );

        foreach ($items as $item) {
            self::executeNonQuery(
                "UPDATE products SET productStock = productStock + :cantidad WHERE productId = :productId",
                ["cantidad" => $item["crrctd"], "productId" => $item["productId"]]
            );
        }

        return self::executeNonQuery(
            "UPDATE carretillaanon
             SET crrestado = :nuevo
             WHERE anoncod = :anoncod
             AND crrestado IN ('ABIERTO','CERRADO')",
            [
                "nuevo" => self::ESTADO_CANCELADO,
                "anoncod" => $anoncod
            ]
        );
    }

    public static function getItemsCount(string $anoncod)
    {
        return self::obtenerUnRegistro(
            "SELECT COUNT(*) AS cantidad
             FROM carretillaanon
             WHERE anoncod = :anoncod
             AND crrestado = :estado",
            [
                "anoncod" => $anoncod,
                "estado" => self::ESTADO_ABIERTO
            ]
        );
    }
}