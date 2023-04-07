<?php

namespace Repositories;

use PDO;
use PDOException;
use Repositories\Repository;

class OrderRepository extends Repository
{
    function getAll()
    {
        try {
            $sqlquery = "SELECT * FROM ORDERS";
            $stmt = $this->connection->prepare($sqlquery);

            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\\Order');
            $orders = $stmt->fetchAll();
            return $orders;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function getAllByUserId($id)
    {
        try {
            $sqlquery = "SELECT * FROM ORDERS WHERE user_id = :id";
            $stmt = $this->connection->prepare($sqlquery);

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\\Order');
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function getAllProductsByOrderId($orderId) {
        try {
            $sqlquery = "SELECT p.id, p.name, oi.quantity, p.image
            FROM PRODUCTS as p
            INNER JOIN ORDER_ITEMS as oi ON p.id = oi.product_id
            WHERE oi.order_id = :id";
            $stmt = $this->connection->prepare($sqlquery);

            $stmt->bindParam(':id', $orderId, PDO::PARAM_INT);

            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\\OrderProduct');
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo $e;
        }
    }
}
