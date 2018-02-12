<?php 
namespace InsuranceHub\Resource;

class Sale implements \JsonSerializable
{
    public $productOfferingId;
    public $sold;

    public function jsonSerialize() {
        return [
			'productOfferingId' => $this->productOfferingId,
			'sold'              => $this->sold,
        ];
    }
}