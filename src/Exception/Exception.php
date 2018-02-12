<?php 
namespace InsuranceHub\Exception;

abstract class Exception extends \Exception 
{
    abstract protected function errorMessage();
}