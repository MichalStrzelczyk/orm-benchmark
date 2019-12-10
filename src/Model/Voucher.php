<?php
declare (strict_types=1);

namespace Model;

class Voucher extends \Phalcon\Mvc\Model
{
    public $id;

    public $voucher;

    public $createdDatetime;

    public function initialize()
    {
        $this->setSource('voucher');
    }
}