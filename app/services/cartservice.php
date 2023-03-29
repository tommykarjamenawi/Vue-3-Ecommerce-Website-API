<?php

namespace Services;

use Repositories\CartRepository;

class CartService {
    private $repository;

    function __construct() {
        $this->repository = new CartRepository();
    }

    public function pay($cartDTOList, $userId) {
        $this->repository->createOrder($userId);

        // get the id of the order
        $orderId = $this->repository->lastOrderId();
        
        // loop through the cartDTOList and create an orderItem for each item
        foreach ($cartDTOList as $item) {
            if ($this->repository->createOrderItem($orderId,$item)) {
                continue;
            } else {
                return false;
            }
        }
        return true;
    }
}