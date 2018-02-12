<?php 
namespace InsuranceHub\Exception;

class ValidationException extends Exception 
{
    public function errorMessage() {
        return "Invalid Request : ".$this->getMessage();
    }
}