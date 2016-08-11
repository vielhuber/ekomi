<?php
class Ekomi
{
	protected $interface_id;
	protected $interface_pw;

	public function __construct($interface_id, $interface_pw)
	{
		$this->interface_id = $interface_id;
		$this->interface_pw = $interface_pw;
	}

	public function generateLink($order_id = null, $product_ids = null)
	{
		$url = "";
		$url.= "https://api.ekomi.de/v3/";
		$url.= "putOrder?auth=";
		$url.= $this->interface_id;
		$url.= "|";
		$url.= $this->interface_pw;
		$url.= "&";
		$url.= "version=cust-1.0.0";
		$url.= "&";
		$url.= "type=json";
		$url.= "&";
		$url.= "charset=utf-8";
		$url.= "&";
		$url.= "order_id=" . rawurlencode($order_id);
		if ($product_ids !== null)
		{
			$url.= "&";
			$url.= "product_ids=" . implode(",", $product_ids);
		}

		$response = json_decode(file_get_contents($url));
		if ($response->done == 1)
		{
			return $response->link;
		}
		else
		{
			return false;
		}
	}

	public function createProduct($product_id, $product_name)
	{
		$url = "";
		$url.= "https://api.ekomi.de/v3/";
		$url.= "putProduct?auth=";
		$url.= $this->interface_id;
		$url.= "|";
		$url.= $this->interface_pw;
		$url.= "&";
		$url.= "version=cust-1.0.0";
		$url.= "&";
		$url.= "type=json";
		$url.= "&";
		$url.= "charset=utf-8";
		$url.= "&";
		$url.= "product_id=" . rawurlencode($product_id);
		$url.= "&";
		$url.= "product_name=" . rawurlencode($product_name);
		$response = json_decode(file_get_contents($url));
		if ($response->done == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

$ekomi = new Ekomi("XXXXX", "XXXXXXXXXXXXXXXXXXXX");
$link = $ekomi->createProduct("00001", "Produktname #1");
$link = $ekomi->createProduct("00002", "Produktname #2");
$link = $ekomi->createProduct("00003", "Produktname #3");
$link = $ekomi->generateLink("3298748a");
$link = $ekomi->generateLink("3298748b", ["00001", "00002", "00003"]);