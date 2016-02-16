<?php

require_once __DIR__ . '/../fastr/Item.php';

/**
 * Class Couple
 * @author  Hidde Beydals <hidde@getfastr.co>
 */
final class Couple extends Item
{
    /**
     * Couple constructor.
     *
     * @param int    $qty
     * @param string $comment
     */
    public function __construct($qty, $comment = null)
    {
        $this->sku      = 'couple';
        $this->name     = 'Festival Couple';
        $this->price    = '32.50';
        $this->taxRate  = 21;
        $this->qty      = $qty;
        $this->comment  = $comment;
    }
}