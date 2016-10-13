<?php

include __DIR__ . '/walmart-partner-api-sdk-php/vendor/autoload.php';

use Walmart\Inventory;

class WalmartSync {


    public $config = [];

    public function __construct()
    {
        $this->config = [
            'consumerId' => '',
            'privateKey' => '',
        ];
        
    }


    
    public function update($sku, $qty) {


        $client = new Inventory($this->config);     

        $array = array(
                'inventory' => [
                    'sku' => $sku,
                    'quantity' => [
                        'unit' => 'EACH',
                        'amount' => $qty,
                    ],
            'fulfillmentLagTime' => 3
                ]);


        //print_r($array);
       try {
            $feed = $client->update($array);
            return $feed;
            
        } catch (CommandClientException $e) {
            echo ($e->getMessage() . 'Error: ' . $error);
        } catch (\Exception $e) {
           echo $e->getMessage();
        }
    }

    }

    


