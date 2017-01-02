<?php

require_once __DIR__ . '/../fastr/OrderItem.php';

/**
 * Class TankTop
 * @author  Hidde Beydals <hidde@getfastr.co>
 */
final class TankTop extends OrderItem
{
    /**
     * TankTop constructor.
     *
     * @param int    $qty
     * @param string $comment
     */
    public function __construct($qty, $comment = null)
    {
        parent::__construct();

        $this->item->sku      = 'tanktop';
        $this->item->name     = 'Festival Tanktop';
        $this->price          = '17.50';
        $this->taxRate        = 21;
        $this->qty            = $qty;
        $this->comment        = $comment;
    }
}