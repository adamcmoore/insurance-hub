<?php 
namespace InsuranceHub\Exception;

class ApiException extends Exception 
{
	public function errorMessage() 
	{
		$error = "InsureHub API Exception : ".$this->getMessage();
		return $error;
	}
}