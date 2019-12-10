<?php
declare (strict_types=1);

namespace Data\Voucher;

class Entity extends \Maleficarum\Data\Model\Persistable\AbstractModel
{
    private $id;
    private $voucher;
    private $createdDatetime;

    public function setId($a):  \Maleficarum\Data\Model\AbstractModel {
        $this->id = $a;

        return $this;
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




    /**
     * @see \Maleficarum\Data\Model\Persistable\AbstractModel::validate()
     */
    public function validate(bool $clear = true): bool {
        return true;
    }

    /**
     * @see \Maleficarum\Data\Model\Persistable\AbstractModel::getDomainGroup()
     */
    public function getDomainGroup(): string {
        return '';
    }

    /**
     * @see \Maleficarum\Data\Model\Persistable\AbstractModel::getModelPrefix()
     */
    public function getModelPrefix(): string {
        return '';
    }

    /**
     * @see \Maleficarum\Data\Model\Persistable\AbstractModel::getStorageGroup()
     */
    public function getStorageGroup(): string {
        return 'voucher';
    }
}