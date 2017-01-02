<?php

require_once __DIR__ . '/../fastr/OrderShippingOption.php';

/**
 * Class FreeShipping
 * @author  Hidde Beydals <hidde@getfastr.co>
 */
final class FreeShipping extends OrderShippingOption
{
    /**
     * FreeShipping constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->shippingOption->internalId   = 'freeshipping';
        $this->shippingOption->name         = 'Free Shipping';
        $this->shippingOption->description  = 'Lorem ipsum';
        $this->price                        = 0;
        $this->taxRate                      = 0;
    }
}