<?php

require_once __DIR__ . '/../fastr/OrderItem.php';

/**
 * Class Couple
 * @author  Hidde Beydals <hidde@getfastr.co>
 */
final class Couple extends OrderItem
{
    /**
     * Couple constructor.
     *
     * @param int    $qty
     * @param string $comment
     */
    public function __construct($qty, $comment = null)
    {
        parent::__construct();

        $this->item->sku      = 'couple';
        $this->item->name     = 'Festival Couple';
        $this->price          = '32.50';
        $this->taxRate        = 21;
        $this->qty            = $qty;
        $this->comment        = $comment;
    }
}