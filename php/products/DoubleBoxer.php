<?php

require_once __DIR__ . '/../fastr/Item.php';

/**
 * Class DoubleBoxer
 * @author  Hidde Beydals <hidde@getfastr.co>
 */
final class DoubleBoxer extends Item
{
    /**
     * DoubleBoxer constructor.
     *
     * @param int       $qty
     * @param string    $comment
     */
    public function __construct($qty, $comment = null)
    {
        $this->sku      = 'double';
        $this->name     = 'Double Festival Boxer';
        $this->price    = '35.00';
        $this->taxRate  = 21;
        $this->qty      = $qty;
        $this->comment  = $comment;
    }
}