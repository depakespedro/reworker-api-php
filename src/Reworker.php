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
            return false;
        }

        if($response->result == 'success'){
            return $response->order_id;
        }elseif($response->result == 'fail'){
            $this->error_message = 'Error response : '.$response->error;
            return false;
        }else{
            $this->error_message = 'Error response!';
            return false;
        }
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