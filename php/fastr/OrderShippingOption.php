<?php

require_once __DIR__ . '/../fastr/ShippingOption.php';

/**
 * Class OrderShippingOption
 * @author  Hidde Beydals <hidde@getfastr.co>
 */
class OrderShippingOption
{
    /**
     * @var ShippingOption
     */
    public $shippingOption;

    /**
     * The price (including taxes) of the shipping option.
     *
     * @var string
     */
    public $price;

    /**
     * The tax rate of the shipping option.
     *
     * @var string
     */
    public $taxRate;

    /**
     * OrderShippingOption constructor.
     */
    public function __construct()
    {
        $this->shippingOption = new ShippingOption;
    }
}