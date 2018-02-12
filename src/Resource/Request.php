<?php 
namespace InsuranceHub\Resource;

class Request implements \JsonSerializable
{
    public $vendorId;
    public $apiKey;
    public $vendorRequestReference;
    public $products;
    public $premiumAsSummary;

    public function jsonSerialize() {
        return [
            'vendorId'               => $this->vendorId,
            'vendorRequestReference' => $this->vendorRequestReference,
            'products'               => $this->products,
            'premiumAsSummary'       => $this->premiumAsSummary,
        ];
    }
}