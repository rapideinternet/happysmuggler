<?php

require_once __DIR__ . '/../fastr/ShippingOption.php';

/**
 * Class FreeShipping
 * @author  Hidde Beydals <hidde@getfastr.co>
 */
final class FreeShipping extends ShippingOption
{
    /**
     * FreeShipping constructor.
     */
    public function __construct()
    {
        $this->internalId = 'freeshipping';
        $this->name = 'Free Shipping';
        $this->description = 'Lorem ipsum';
        $this->price = 0;
        $this->taxRate = 0;
    }
}