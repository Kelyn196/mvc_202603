<?php

namespace Utilities\Paypal;

class PayPalOrder
{
    private $_request;
    private $_body = array(
        "intent" => "CAPTURE",
        "purchase_units" => array(),
        "application_context" => array(
            "cancel_url" => "",
            "return_url" => ""
        )
    );
    private $_purchaseUnitTemplate = array();
    private $_itemTemplate = array();
    private $_currency = "USD";

    public function getOrder()
    {
        return $this->_body;
    }

    public function addItem($name, $description, $sku, $price, $tax, $quantity, $category)
    {
        $newItem = $this->_itemTemplate;
        $newItem["name"] = $name;
        $newItem["description"] = $description;
        $newItem["sku"] = $sku;
        $newItem["unit_amount"]["value"] = (string) number_format((float)$price, 2, '.', '');
        $newItem["unit_amount"]["currency_code"] = $this->_currency;
        $newItem["tax"]["value"] = (string) number_format((float)$tax, 2, '.', '');
        $newItem["tax"]["currency_code"] = $this->_currency;
        $newItem["quantity"] = (string) $quantity;
        $newItem["category"] = $category;

        $this->addToBody($newItem);
    }

    private function addToBody($newItem)
    {
        $itemTotal = (float) $this->_body["purchase_units"][0]["amount"]["breakdown"]["item_total"]["value"];
        $taxTotal = (float) $this->_body["purchase_units"][0]["amount"]["breakdown"]["tax_total"]["value"];
        $total = (float) $this->_body["purchase_units"][0]["amount"]["value"];

        $this->_body["purchase_units"][0]["items"][] = $newItem;
        $itemTotal += ((float) $newItem["unit_amount"]["value"]  *  (float) $newItem["quantity"]);
        $taxTotal += ((float) $newItem["tax"]["value"]  *  (float) $newItem["quantity"]);
        $total = $itemTotal + $taxTotal;

        $this->_body["purchase_units"][0]["amount"]["breakdown"]["item_total"]["value"] = (string) number_format($itemTotal, 2, '.', '');
        $this->_body["purchase_units"][0]["amount"]["breakdown"]["tax_total"]["value"] = (string) number_format($taxTotal, 2, '.', '');
        $this->_body["purchase_units"][0]["amount"]["value"] = (string) number_format($total, 2, '.', '');
    }

    public function  __construct($referenceID, $cancel_url, $return_url, $currency = "USD")
    {
        $this->_currency = $currency;

        $this->_purchaseUnitTemplate = array(
            "reference_id" => "",
            "custom_id" => "",
            "amount" => array(
                "value" => "0.00",
                "currency_code" => $this->_currency,
                "breakdown" => array(
                    "item_total" => array("currency_code" => $this->_currency, "value" => "0.00"),
                    "shipping" => array("currency_code" => $this->_currency, "value" => "0.00"),
                    "handling" => array("currency_code" => $this->_currency, "value" => "0.00"),
                    "tax_total" => array("currency_code" => $this->_currency, "value" => "0.00"),
                    "shipping_discount" => array("currency_code" => $this->_currency, "value" => "0.00"),
                )
            ),
            "items" => array()
        );

        $this->_itemTemplate = array(
            "name" => "",
            "description" => "",
            "sku" => "",
            "unit_amount" => array("currency_code" => $this->_currency, "value" => "0.00"),
            "tax" => array("currency_code" => $this->_currency, "value" => "0.00"),
            "quantity" => "0",
            "category" => ""
        );

        $this->_body["purchase_units"][] = $this->_purchaseUnitTemplate;
        $this->_body["purchase_units"][0]["reference_id"] = (string) $referenceID;
        $this->_body["application_context"]["cancel_url"] = $cancel_url;
        $this->_body["application_context"]["return_url"] = $return_url;
    }
}