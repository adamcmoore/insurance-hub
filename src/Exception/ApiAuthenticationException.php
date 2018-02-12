<?php 
namespace InsuranceHub\Exception;

class ApiAuthenticationException extends Exception 
{
    public function errorMessage() 
    {
        return "Unauthorised request.  Check your Vendor ID and Api Key";
    }
}