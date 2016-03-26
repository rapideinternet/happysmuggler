<?php

require_once __DIR__ . '/../fastr/Item.php';

/**
 * Class OrderItem
 * @author  Hidde Beydals <hidde@getfastr.co>
 */
class OrderItem
{
    /**
     * The Item.
     *
     * @var Item
     */
    public $item;

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

    /**
     * OrderItem constructor.
     */
    public function __construct()
    {
        $this->item = new Item;
    }
}