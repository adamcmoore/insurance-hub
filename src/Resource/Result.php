<?php 
namespace InsuranceHub\Resource;

class Result implements \JsonSerializable
{
    public $vendorId;
    public $apiKey;
    public $offeringId;
    public $vendorSaleReference;
    public $customerForename;
    public $customerSurname;
    public $sales = [];

    public function jsonSerialize() {
        return [
            'vendorId'            => $this->vendorId,
            'offeringId'          => $this->offeringId,
            'vendorSaleReference' => $this->vendorSaleReference,
            'customerForename'    => $this->customerForename,
            'customerSurname'     => $this->customerSurname,
            'sales'               => $this->sales,
        ];
    }
}