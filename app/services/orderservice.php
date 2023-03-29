<?php

namespace Services;

use Repositories\OrderRepository;

class OrderService {
    private $repository;

    function __construct() {
        $this->repository = new OrderRepository();
    }

    public function getAll() {
        return $this->repository->getAll();
    }

    public function getAllByUserId($id) {
        return $this->repository->getAllByUserId($id);
    }

    public function getAllProductsByOrderId($orderId) {
        return $this->repository->getAllProductsByOrderId($orderId);
    }
}