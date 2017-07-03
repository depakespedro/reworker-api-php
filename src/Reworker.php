<?php


namespace Depakespedro\Reworker;

class Reworker
{
    private $reworker_client_id = '';
    private $reworker_client_key = '';

    private $error_message = '';
    private $raw_response = '';

    public function __construct($client_id, $client_key)
    {
        $this->reworker_client_id = $client_id;
        $this->reworker_client_key = $client_key;
    }

    public function createOrder(ReworkerOrder $order)
    {
        $order_args = $order->get_args();

        $order_args['reworker_client_id'] = $this->reworker_client_id;

        $data = http_build_query($order_args, '', '&');

        if( $curl = curl_init() ) {
            curl_setopt($curl, CURLOPT_URL, 'http://www.reworker.ru/clients/api/lead_postback.php');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            $response = curl_exec($curl);
            curl_close($curl);
        }

        $this->raw_response = $response;

        try{
            $response = json_decode($response);
        }catch (\Exception $e){
            $this->error_message = 'Error parse response : '.$response;
            return null;
        }

        if($response->result == 'success'){
            return new ReworkerOrder($response->order_id);
        }elseif($response->result == 'fail'){
            $this->error_message = 'Error response : '.$response->error;
            return null;
        }else{
            $this->error_message = 'Error response!';
            return null;
        }
    }

    public function getStateOrders(array $reworker_orders)
    {
        $orders_ids = '';
        foreach($reworker_orders as $order){
            $orders_ids .= $order->get('id') . ',';
        }

        $orders_ids = substr($orders_ids, 0, -1);

        $data = [];
        $data['reworker_client_id'] = $this->reworker_client_id;
        $data['order_ids'] = $orders_ids;

        $data = http_build_query($data, '', '&');

        if( $curl = curl_init() ) {
            curl_setopt($curl, CURLOPT_URL, 'http://reworker.ru/clients/api/lead_status.php');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            $response = curl_exec($curl);
            curl_close($curl);
        }

        $this->raw_response = $response;

        try{
            $response = json_decode($response);
        }catch (\Exception $e){
            $this->error_message = 'Error parse response : '.$response;
            return null;
        }

        if(isset($response->order_statuses)){
            $this->error_message = 'Error response : '.$response->order_statuses;
            return null;
        }

        $reworker_orders = [];
        foreach ($response as $order){
            $reworker_order = new ReworkerOrder($order->order_id);
            $reworker_order->set_out_order_id($order->order_source_id);
            $reworker_order->set_state($order->order_status_code);

            $reworker_orders[] = $reworker_order;
        }

        return $reworker_orders;
    }

    public function getRawResponse()
    {
        return $this->raw_response;
    }


    public function getErrorMessage()
    {
        return $this->error_message;
    }

}