<?php 
namespace InsuranceHub\Resource;

class Product implements \JsonSerializable
{
    public $categoryCode;
    public $price;
    public $completionDate;

    public function jsonSerialize() {
        return [
            'categoryCode'   => $this->categoryCode,
            'price'          => $this->price,
            'completionDate' => $this->completionDate->format(\DateTime::ISO8601),
        ];
    }
}