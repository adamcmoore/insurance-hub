<?php 
namespace InsuranceHub\Exception;

class ApiValidationException extends Exception 
{
    public function errorMessage() {
        return "Invalid Request : ".$this->getMessage();
    }
}
