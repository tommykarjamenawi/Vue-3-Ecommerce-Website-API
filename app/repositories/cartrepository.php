<?php

namespace Repositories;

use Repositories\Repository;
use Models\Order;
use PDO;
use PDOException;

class CartRepository extends Repository
{
    function __construct()
    {
        parent::__construct();
    }

    public function createOrder($userId)
    {
        // create order
        try {
            $sql = "INSERT INTO ORDERS (user_id) VALUES (:user_id)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function lastOrderId()
    {
        try {
            $sql = "SELECT MAX(id) FROM ORDERS";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['MAX(id)'];
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function createOrderItem($newOrderId, $product)
    {
        try {
            $sql = "INSERT INTO ORDER_ITEMS (order_id, product_id, quantity) VALUES (:order_id, :product_id, :quantity)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':order_id', $newOrderId);
            $stmt->bindParam(':product_id', $product->id);
            $stmt->bindParam(':quantity', $product->quantity);
            $result = $stmt->execute();
            return ($result) ? true : false;
        } catch (PDOException $e) {
            echo $e;
        }
    }
}
