<?php
/*
 * Class to call API and return data response 
 */
class Controller_Api extends \Controller_Rest
{
    function get_order()
    {
        $data = '<status ua="custom-1.1"><merchant><account>10015043</account><site_id>183</site_id><site_secure_code>029834</site_secure_code></merchant><transaction><id>ORDER-SAMPLE-1</id></transaction></status>';

        $curl = Request::forge('https://devapi.multisafepay.com/ewx/', 'curl');
        $curl->set_method('post');
        $curl->set_params($data);
        $curl->set_header('Content-Type', 'text/xml');
        $curl->set_auto_format(false);
        $curl->set_options(array(CURLOPT_RETURNTRANSFER => true));
        //$curl->set_mime_type('text/xml');
        $curl->execute();

        $resultApiCall = $curl->response();
        Log::debug($resultApiCall);
        $resultApiCallBody = preg_replace('/^.+\n/', '', $resultApiCall->body);
        $resultApiCallBody= str_replace(array("\n", "\r", "\t"), '', $resultApiCallBody);
        $resultApiCallBody = trim(str_replace('"', "'", $resultApiCallBody));
        //Debug::dump($resultApiCallBody);
        //$this->response->set_header('Content-Type', 'text/xml');
        $this->response($resultApiCallBody);
    }


    function get_order2()
    {
        $data = '<status ua="custom-1.1"><merchant><account>10015043</account><site_id>183</site_id><site_secure_code>029834</site_secure_code></merchant><transaction><id>ORDER-SAMPLE-1</id></transaction></status>';

            $ch = curl_init();

            // definimos la URL a la que hacemos la petición
            curl_setopt($ch, CURLOPT_URL,"https://devapi.multisafepay.com/ewx/");
            // definimos el número de campos o parámetros que enviamos mediante POST
            curl_setopt($ch, CURLOPT_POST, 1);
            // definimos cada uno de los parámetros
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

            // recibimos la respuesta y la guardamos en una variable
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $remote_server_output = curl_exec ($ch);

            // cerramos la sesión cURL
            curl_close ($ch);

            $this->response->set_header('Content-Type', 'application/json');

            $result = $this->parseXmlToJson($remote_server_output);
            $this->response($result);
            //$this->response($remote_server_output);
    }

    public function parseXmlToJson ($data) 
    {
        $data = str_replace(array("\n", "\r", "\t"), '', $data);
        $data = trim(str_replace('"', "'", $data));
        $simpleXml = simplexml_load_string($data);
        $json = json_encode($simpleXml);
        return $json;
    }
}
?>
