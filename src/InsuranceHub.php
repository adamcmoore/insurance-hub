<?php 
namespace InsuranceHub;

use InsuranceHub\Exception\ApiException;
use InsuranceHub\Resource\Request;
use InsuranceHub\Resource\Result;
use InsuranceHub\Resource\Product;
use InsuranceHub\Resource\Sale;

class InsuranceHub
{
	protected $vendorId;
	protected $apiKey;
	protected $offeringRequestURL;
	protected $offeringResultURL;


	public function __construct($vendorId, $apiKey, $offeringRequestURL, $offeringResultURL)
	{
		$this->vendorId            = $vendorId;
		$this->apiKey              = $apiKey;
		$this->offeringRequestURL = $offeringRequestURL;
		$this->offeringResultURL  = $offeringResultURL;
		$this->certPath            = getcwd()."/ComodoCACert.cer";;
	}


	public function getOffering($products, $reference = null)
	{
		$client            = new ApiClient($this->offeringRequestURL, $this->certPath);		
		$request           = new Request();
		$request->vendorId = $this->vendorId;
		$request->apiKey   = $this->apiKey;		
		$request->products = $products;

		if ($reference) {
			$request->vendorRequestReference = $reference;
		}		

		$offering = $client->execute($request)[1];

		return $offering;
	}


	public function sendSaleResult($offering, $reference, $customerFirstName, $customerLastName)
	{
		return $this->sendResult($offering, $reference, $customerFirstName, $customerLastName, true);
	}


	public function sendNoSaleResult($offering, $reference, $customerFirstName, $customerLastName)
	{
		return $this->sendResult($offering, $reference, $customerFirstName, $customerLastName, false);
	}


	private function sendResult($offering, $reference, $customerFirstName, $customerLastName, $isSale)
	{
		$client                      = new ApiClient($this->offeringResultURL, $this->certPath);		
		$result                      = new Result();
		$result->vendorId            = $this->vendorId;
		$result->apiKey              = $this->apiKey;
		$result->offeringId          = $offering->id;
		$result->vendorSaleReference = $reference;
		$result->customerForename    = $customerFirstName;
		$result->customerSurname     = $customerLastName;
		
		foreach ($offering->productOfferings as $i => $product) {
			$sale = new Sale();
	        $sale->productOfferingId = $product->id;
	        $sale->sold = $isSale;

	        $result->sales[$i] = $sale;
	    }

		$responseCode = $client->execute($result)[0];

		// check success reponse code recieved (2xx)
		if ($responseCode >= 200 && $responseCode < 300) {
			return true;
		} else {
			throw new ApiException('Sending offering Result returned HTTP status code '.$responseCode);
		}
	}
}
