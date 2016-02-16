<?php

/**
 * Class Item
 * @author  Hidde Beydals <hidde@getfastr.co>
 */
class Item
{
    /**
     * The SKU identifier of the item.
     * 
     * @var string
     */
    public $sku;

    /**
     * The (optional) EAN number of the item.
     * 
     * @var string|null
     */
    public $ean = null;

    /**
     * The name of the item.
     * 
     * @var string
     */
    public $name;

    /**
     * The (optional) description of the item.
     *
     * @var string|null
     */
    public $description = null;

    /**
     * The quantity.
     *
     * @var int
     */
    public $qty;

    /**
     * The price (including taxes) per item.
     *
     * @var string
     */
    public $price;

    /**
     * The tax rate of the item.
     *
     * @var string
     */
    public $taxRate;

    /**
     * The optional comment of the item.
     *
     * @var string
     */
    public $comment = null;
}