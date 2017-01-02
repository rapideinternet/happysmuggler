<?php

require_once __DIR__ . '/../fastr/OrderItem.php';

/**
 * Class DoubleBoxer
 * @author  Hidde Beydals <hidde@getfastr.co>
 */
final class DoubleBoxer extends OrderItem
{
    /**
     * DoubleBoxer constructor.
     *
     * @param int       $qty
     * @param string    $comment
     */
    public function __construct($qty, $comment = null)
    {
        parent::__construct();

        $this->item->sku      = 'double';
        $this->item->name     = 'Double Festival Boxer';
        $this->price          = '35.00';
        $this->taxRate        = 21;
        $this->qty            = $qty;
        $this->comment        = $comment;
    }
}