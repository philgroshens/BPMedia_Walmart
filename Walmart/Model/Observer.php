<?php

class BPMedia_Walmart_Model_Observer
{

   public function update(Varien_Event_Observer $observer)
      {
        $product = $observer->getProduct();
        if($product->getData('walmart') != "yes"){
        	return;
        } else {
    				$stockData = $product->getStockData();
    				if($stockData['original_inventory_qty'] == $stockData['qty']) {
    					return;
    				} else {

    				$data = array();
                    $data['sku'] = $product->getData('sku');
                    $data['old-qty'] = $stockData['original_inventory_qty'];
                    $data['qty'] = $stockData['qty'];
                    $data['walmart'] = $product->getData('walmart');
                    $key = 'TigddW91225KHB93XWrg5ty2nv8lsUHd';
                    $data['key'] = md5(md5($data['sku'].md5($key)));
                    

             //$query ='key='.$data['key'].'&sku='.$data['sku'].'&qty='.$data['qty'];
             $url = "inventory.php?".$query;

            $data_string = '';
            foreach($data as $key=>$value) { $data_string .= $key.'='.$value.'&'; }
            $data_string = rtrim($data_string, '&');

            
             $headers = array(
                    'Token :'.$data['key'],
                    "Content-Type: application/json",
                    "X-Parse-Application-Id: BPMedia_Walmart"

                );
             
             $ch = curl_init($url);

             curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
             curl_setopt($ch, CURLOPT_TIMEOUT, '3');
             curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
             //curl_setopt($ch, CURLOPT_POST, count($data));
             curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
             curl_setopt($ch, CURLOPT_URL, $url);
             curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
             //curl_setopt($ch, CURLOPT_INFILESIZE, strlen($data_string));
             //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
             $result = curl_exec($ch);
             curl_close($ch);


             $data['response'] = $result;
             Mage::log($data, null, 'walmart.log'); 

                    } 
                    }
                }



}




