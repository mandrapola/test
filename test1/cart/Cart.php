<?php

class Cart
{
    private $_user;
    private $_items = [];
    private $_discounts = [];
    /**
     * @var float
     */
    private $_discount;

    public function __construct(?User $user)
    {
        $this->_user = $user;
        $this->_discounts = [
            FirstBuyDiscount::class,
            OverSumDiscount::class,
            PensionerDiscount::class,
        ];
    }

    public function getUser(): ?User
    {
        return $this->_user;
    }

    // item_id, price, sku, etc.
    public function addItem(array $item): void
    {
        $this->_items[] = $item;
    }

    public function getDiscountedTotalAmount(): int
    {
        return $this->getTotalAmount() - $this->_getDiscount();
    }

    public function getTotalAmount(): int
    {
        $ret = 0;
        foreach ($this->_items as $item) {
            $ret += $item['price'];
        }

        return $ret;
    }

    private function _getDiscount(): float
    {
        if (null === $this->_discount) {
            $this->_discount = 0;
            foreach ($this->_discounts as $discount) {
                if ($discount instanceof DiscountInterface) {
                    if ($discount::isDiscount($this)) {
                        $this->_discount += $discount::getDiscount($this);
                    }
                }
            }
        }

        return $this->_discount;
    }

    private function _setDiscountToItems()
    {
        foreach ($this->_items as $item) {
            $item['discount'] = $item['price'] * $this->_getDiscount() / 100;
        }
    }
}