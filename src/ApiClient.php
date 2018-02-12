<?php 
namespace InsuranceHub;

use InsuranceHub\Exception\ApiException;
use InsuranceHub\Exception\ApiAuthenticationException;
use InsuranceHub\Exception\ApiValidationException;

class ApiClient
{
    public $url;
    public $certificatePath;

    public function __construct($serviceURL, $caCertificatePath) {
        $this->url = $serviceURL;
        $this->certificatePath = $caCertificatePath;
    }

	public function execute($request)
    {
        $authToken = new AuthToken($request->vendorId, $request->apiKey);

        $ch = curl_init($this->url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_CAINFO, $this->certificatePath);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-InsuranceHub-VendorId: '.$request->vendorId,
            'X-InsuranceHub-AuthToken: '.$authToken->getToken()]);

        $response = curl_exec($ch);

        if ($response === false) {
            throw new \Exception(curl_error($ch), curl_errno($ch));
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        switch ($httpCode) {
            case 401:
                throw new ApiAuthenticationException();
            case 403:
                throw new ApiAuthorisationException();
            case 400:
                $validationError = json_decode($response);

                $validationMessages = implode(",", $validationError->validationMessages);

                throw new ApiValidationException($validationMessages);
            case 500:
                $apiError = json_decode($response);
                throw new ApiException($apiError->message);
        }

        curl_close($ch);

        return array($httpCode, json_decode($response));
    }
}
