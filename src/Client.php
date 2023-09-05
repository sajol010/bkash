<?php

namespace Betacoders\Bkash;

use GuzzleHttp\Exception\GuzzleException;

class Client
{
    const BASE_URL = "https://checkout.sandbox.bka.sh/v1.2.0-beta";
    private $client;
    private $payload;
    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client(['base_uri' => self::BASE_URL]);
    }

    private function getOptions(){
        $data = $this->payload ?? null;
        $options = [
            'headers' => [
                'Authorization' => '',
                'Content-type' => 'application/json'
            ],
            'http_errors' => false
        ];

        if (!empty($data)){
            $options["json"] = $data;
        }

        return $options;
    }

    public function setPayload($payload){
        $this->payload = $payload->toArray();
        return $this;
    }

    /**
     * @throws \Exception
     */
    public function call($method, $url, $options = []){
        if (empty($options)){
            $options = $this->getOptions();
        }

        try {
            $res = $this->client->request($method, $url, $options)->getBody()->getContents();
        }catch (GuzzleException $exception){
            throw new \Exception($exception->getMessage());
        }
       return $res;
    }


    /**
     * @return string
     * @throws \Exception
     */
    public function pay(){
        return $this->call("POST", "checkout/payment/create");
    }

    /**
     * @param $id
     * @return string
     * @throws \Exception
     */
    public function execute($id){
        return $this->call("POST", "checkout/payment/execute/$id");
    }

    /**
     * @param $id
     * @return string
     * @throws \Exception
     */
    public function detail($id){
        return $this->call("POST", "checkout/payment/query/$id");
    }

    /**
     * @param $id
     * @return string
     * @throws \Exception
     */
    public function void($id){
        return $this->call("POST", "checkout/payment/void/$id");
    }

    /**
     * @param $id
     * @return string
     * @throws \Exception
     */
    public function capture($id){
        return $this->call("POST", "checkout/payment/capture/$id");
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function refund(){
        return $this->call("POST", "checkout/payment/refund");
    }


}
