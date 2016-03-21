<?php

require_once __DIR__ . '/../fastr/OrderItem.php';

/**
 * Class SingleBoxer
 * @author  Hidde Beydals <hidde@getfastr.co>
 */
final class SingleBoxer extends OrderItem
{
    /**
     * SingleBoxer constructor.
     *
     * @param int    $qty
     * @param string $comment
     */
    public function __construct($qty, $comment = null)
    {
        parent::__construct();

        $this->item->sku      = 'single';
        $this->item->name     = 'Single Festival Boxer';
        $this->price          = '19.00';
        $this->taxRate        = 21;
        $this->qty            = $qty;
        $this->comment        = $comment;
    }
}