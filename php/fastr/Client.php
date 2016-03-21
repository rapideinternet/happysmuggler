<?php

require_once __DIR__ . '/ClientException.php';

/**
 * Class Client
 * @author  Hidde Beydals <hidde@getfastr.co>
 */
final class Client
{
    const API_URL = 'api.getfastr.co';
    const API_VERSION = 1;

    /**
     * @var string
     */
    private $authorizationKey;

    /**
     * Client constructor.
     *
     * @param $authorizationKey
     */
    public function __construct($authorizationKey)
    {
        $this->authorizationKey = $authorizationKey;
    }

    /**
     * Request the creation of a new Order with the given arrays.
     *
     * @param  array|Item[]           $items
     * @param  array|ShippingOption[] $shippingOptions
     * @return array
     */
    public function newOrder(array $items, array $shippingOptions)
    {
        /*
         * Prepare the JSON POST data.
         */
        $data = json_encode([
            'orderItems'             => $items,
            'orderShippingOptions'   => $shippingOptions
        ]);

        /*
         * Set the request headers.
         */
        $headers = [
            'POST /v'. self::API_VERSION .'/checkouts HTTP/1.1',
            'Host: ' . self::API_URL,
            'Authorization: ' . $this->authorizationKey,
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ];

        /*
         * Init cURL with the POST data and headers.
         */
        $curl = curl_init($this->getSecureUrl('checkouts'));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        /*
         * Fire in the hole.
         */
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        /*
         * Look for validation or other unsuspected errors.
         */
        switch($httpCode) {
            case 401:
                throw new ClientException('We could not authenticate you, our dolphins guess that your authorization key is invalid.');
            case 400:
                $exception = new ClientException('There were some problems with your input.');
                $exception->setErrors(json_decode($response, true)['errors']['0']['detail']);
                return $exception;
            case 500:
                throw new ClientException('There is something unusual going on on our servers. Please try again later.');
        }

        return json_decode($response)->data->redirectUrl;
    }

    /**
     * Return a secure version of the API url based on the (optional) path.
     *
     * @param  string $path
     * @return string
     */
    private function getSecureUrl($path = '')
    {
        return 'https://' . self::API_URL . '/v' . self::API_VERSION . '/' . $path;
    }
}
