<?php

namespace Depakespedro\Reworker;

class ReworkerProduct
{
    private $order_product_sku = '';
    private $order_product_count = '';
    private $order_product_price = '';

    public function __construct($order_product_sku, $order_product_count, $order_product_price)
    {
        $this->order_product_sku = $order_product_sku;
        $this->order_product_count = $order_product_count;
        $this->order_product_price = $order_product_price;
    }

    public function get_sku()
    {
        return $this->order_product_sku;
    }

    public function get_count()
    {
        return $this->order_product_count;
    }

    public function get_price()
    {
        return $this->order_product_price;
    }
}