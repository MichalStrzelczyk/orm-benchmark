<?php
declare (strict_types=1);

namespace Doctrine;

/**
 * @Entity
 * @Table(name="voucher")
 */
class Voucher
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="SEQUENCE")
     */
    private $id;

    /** @Column(type="string") */
    private $voucher;

    /** @Column(name="createdDatetime", type="datetime") */
    private $createdDatetime;

    public function setId($a){
        $this->id = $a;
    }

    public function getId() {
        return $this->id;
    }

    public function setVoucher($a){
        $this->voucher = $a;
    }

    public function getVoucher(){
        return $this->voucher;
    }

    public function setCreatedDatetime($a){
        $this->createdDatetime = $a;
    }

    public function getCreatedDatetime(){
        return $this->createdDatetime;
    }

}