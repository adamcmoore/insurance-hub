<?php

use PHPUnit\Framework\TestCase;
use InsuranceHub\InsuranceHub;
use InsuranceHub\Resource\Product;


class SendOfferingTest extends TestCase
{

	private $client;

	public function __construct()
	{
		parent::__construct();

		global $config;

		$this->client = new InsuranceHub($config['vendor_id'], $config['api_key'], $config['offering_request_url'], $config['submit_offering_url']);
	}


	private function _createOffering()
	{
		$product1 = new Product();
		$product1->categoryCode = 'TKT';
		$product1->price = 100.00;
		$product1->completionDate = new \DateTime();

		$product2 = new Product();
		$product2->categoryCode = 'TKT';
		$product2->price = 200.00;
		$product2->completionDate = new \DateTime();

		$products = [$product1, $product2];

		return $this->client->getOffering($products, 'ref123');
	}


	public function testGetOffering()
	{
		$offering = $this->_createOffering();

		$this->assertObjectHasAttribute('productOfferings', $offering);
		$this->assertEquals(count($offering->productOfferings), 2);

		foreach ($offering->productOfferings as $product_offer) {
			$this->assertObjectHasAttribute('categoryCode', $product_offer);
			$this->assertObjectHasAttribute('currencyCode', $product_offer);
			$this->assertObjectHasAttribute('premium', $product_offer);
		}
	}


	public function testSendSaleResult()
	{
		$offering = $this->_createOffering();

		$result = $this->client->sendSaleResult($offering, 123, 'John', 'Smith');

		$this->AssertTrue($result);
	}


	public function testSendNoSaleResult()
	{
		$offering = $this->_createOffering();

		$result = $this->client->sendNoSaleResult($offering, 123, 'John', 'Smith');

		$this->AssertTrue($result);
	}
}