<?php

/**
 * Class ShippingOption
 * @author  Hidde Beydals <hidde@getfastr.co>
 */
class ShippingOption
{
    /**
     * The internal identifier of the shipping option.
     *
     * @var string
     */
    public $internalId;

    /**
     * The name of the shipping option.
     *
     * @var string
     */
    public $name;

    /**
     * The description of the shipping option.
     *
     * @var string
     */
    public $description;

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
}