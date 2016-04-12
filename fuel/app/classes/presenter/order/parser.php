<?php

/**
 * The order parser presenter.
 *
 * @package  app
 * @extends  Presenter
 */
class Presenter_Order_Parser extends Presenter
{
	/**
	 * Prepare the view data, keeping this in here helps clean up
	 * the controller.
	 *
	 * @return void
	 */
	public function view()
	{
            $data = '<status ua="custom-1.1"><merchant><account>10015043</account><site_id>183</site_id><site_secure_code>029834</site_secure_code></merchant><transaction><id>ORDER-SAMPLE-1</id></transaction></status>';

            $merchant = array('account' => 10015043, 'site_id' => 183, 'site_secure_code' => 029834);
            $transaction = array('transaction' => array('id' => 'ORDER-SAMPLE-1'));
            $status = array('merchant' => $merchant, 'transaction' => $transaction);

            $curl = Request::forge('https://devapi.multisafepay.com/ewx/', 'curl');
            $curl->set_method('post');
            //$curl->set_params(array('status' => $status));
            $curl->set_params($data);
            $curl->set_header('Content-Type', 'text/xml');
            //$curl->set_mime_type('xml');
            $curl->set_auto_format(true);
            $resultApi = $curl->execute();
            //var_dump($resultApiCall);
            $resultApiCall = $curl->response();

            //curl -H 'Content-Type: text/xml' -d @datcurl -H 'Content-Type: text/xml' -d @data.xml -X GET https://devapi.multisafepay.com/ewx/a.xml -X GET https://devapi.multisafepay.com/ewx/
            // abrimos la sesión cURL
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

            $this->data = $this->request()->param('data', $resultApiCall->body);
            //$this->data = $this->request()->param('data', $remote_server_output);
	}
}
