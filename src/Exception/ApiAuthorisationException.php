<?php 
namespace InsuranceHub\Exception;

class ApiAuthorisationException extends Exception 
{
    public function errorMessage() 
    {
        return "You do not have access to this service.  Please contact support if you think this is in error.";
    }
}