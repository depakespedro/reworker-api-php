<?php

namespace Depakespedro\Reworker;

class ReworkerOrder
{
    private $args = [];
    
    public function __construct($id = null)
    {
        $this->args['id'] = $id;
    }

    public function set_reworker_shop_id($reworker_shop_id)
    {
        $this->args['reworker_shop_id'] = $reworker_shop_id;
        return $this;
    }

    public function set_order_source_id($order_source_id)
    {
        $this->args['order_source_id'] = $order_source_id;
        return $this;
    }

    public function set_order_name($order_name)
    {
        $this->args['order_name'] = $order_name;
        return $this;
    }

    public function set_order_sname($order_sname)
    {
        $this->args['order_sname'] = $order_sname;
        return $this;
    }

    public function set_order_phone($order_phone)
    {
        $this->args['order_phone'] = $order_phone;
        return $this;
    }

    public function set_order_email($order_email)
    {
        $this->args['order_email'] = $order_email;
        return $this;
    }

    public function set_order_address($order_address)
    {
        $this->args['order_address'] = $order_address;
        return $this;
    }

    public function set_zip($zip)
    {
        $this->args['zip'] = $zip;
        return $this;
    }

    public function set_order_comment($order_comment)
    {
        $this->args['order_comment'] = $order_comment;
        return $this;
    }

    public function set_order_prepaid($order_prepaid)
    {
        $this->args['order_prepaid'] = $order_prepaid;
        return $this;
    }

    public function set_order_preprocessed($order_preprocessed)
    {
        $this->args['order_preprocessed'] = $order_preprocessed;
        return $this;
    }

    public function set_delivery_price($delivery_price)
    {
        $this->args['delivery_price'] = $delivery_price;
        return $this;
    }

    public function set_delivery_id($delivery_id)
    {
        $this->args['delivery_id'] = $delivery_id;
        return $this;
    }

    public function set_order_mb_prepaid($order_mb_prepaid)
    {
        $this->args['order_mb_prepaid'] = $order_mb_prepaid;
        return $this;
    }

    public function set_products(array $products)
    {
        $this->args['order_product_sku'] = '';
        $this->args['order_product_count'] = '';
        $this->args['order_product_price'] = '';
        
        foreach ($products as $product){
            $this->args['order_product_sku'] .= $product->get_sku() . ',';
            $this->args['order_product_count'] .= $product->get_count() . ',';
            $this->args['order_product_price'] .= $product->get_price() . ',';
        }

        $this->args['order_product_sku'] = substr($this->args['order_product_sku'], 0, -1);
        $this->args['order_product_count'] = substr($this->args['order_product_count'], 0, -1);
        $this->args['order_product_price'] = substr($this->args['order_product_price'], 0, -1);
        
        return $this;
    }

    public function get_args()
    {
        return $this->args;
    }
    
    public function get($var)
    {
        return isset($this->args[$var]) ? $this->args[$var] : null;
    }
}