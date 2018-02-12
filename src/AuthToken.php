<?php 
namespace InsuranceHub;

class AuthToken
{
    protected $formattedVendorId;
    protected $formattedApiKey;

	public function __construct($vendorId, $apiKey)
    {
        $this->formattedVendorId = str_replace('-', '', strtolower($vendorId));
        $this->formattedApiKey = str_replace('-', '', strtolower($apiKey));
    }

    public function getToken()
    {
        $date = gmdate('dmY');

        return base64_encode(hash_hmac('sha1', $this->formattedVendorId.$date, $this->formattedApiKey, true));
    }
}