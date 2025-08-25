<?php

namespace App\Controllers;

class Test extends BaseController
{
    public function test()
    {
        $wsdl = "https://backoffice.voipinnovations.com/Services/APIService.asmx?WSDL";
        $soapAction = "http://tempuri.org/SendSMS";

        $options = array(
            'trace' => 1,
            'exceptions' => true,
        );

       try {
            $client = new \SoapClient($wsdl, $options);

            $params = [
                'login'     => 'Sconet',
                'secret'    => 'Sconet64!!',
                'sender'    => '+17132213759',
                'recipient' => '+17132213759',
                'message'   => 'test',
            ];

            $response = $client->__soapCall('SendSMS', [$params], ['SOAPAction' => $soapAction]);

            // You can return the response as JSON
            print_r($response);

        } catch (\SoapFault $e) {
            print_r($e->getMessage());

        }
    }

   
}
