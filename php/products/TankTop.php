<?php

require_once __DIR__ . '/../fastr/Item.php';

/**
 * Class TankTop
 * @author  Hidde Beydals <hidde@getfastr.co>
 */
final class TankTop extends Item
{
    /**
     * TankTop constructor.
     *
     * @param int    $qty
     * @param string $comment
     */
    public function __construct($qty, $comment = null)
    {
        $this->sku      = 'tanktop';
        $this->name     = 'Festival Tanktop';
        $this->price    = '17.50';
        $this->taxRate  = 21;
        $this->qty      = $qty;
        $this->comment  = $comment;
    }
}