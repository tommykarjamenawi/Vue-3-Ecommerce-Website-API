<?php

namespace Repositories;

use Models\Category;
use Models\Product;
use PDO;
use PDOException;
use Repositories\Repository;

class ProductRepository extends Repository
{
    function getAll($offset = NULL, $limit = NULL)
    {
        try {
            $query = "SELECT * FROM PRODUCTS";
            if (isset($limit) && isset($offset)) {
                $query .= " LIMIT :limit OFFSET :offset ";
            }
            $stmt = $this->connection->prepare($query);
            if (isset($limit) && isset($offset)) {
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            }
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\Product');
            $products = $stmt->fetchAll();

            return $products;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function getById($id)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM PRODUCTS WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\Product');
            $product = $stmt->fetch();

            return $product;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function insert($product)
    {
        try {
            $stmt = $this->connection->prepare("INSERT into product (name, price, description, image, category_id) VALUES (?,?,?,?,?)");

            $stmt->execute([$product->name, $product->price, $product->description, $product->image, $product->category_id]);

            $product->id = $this->connection->lastInsertId();

            return $this->getById($product->id);
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function update($product, $id)
    {
        // update product  with name description image category brand price
        try {
            $stmt = $this->connection->prepare("UPDATE PRODUCTS SET name = :name, description = :description, image = :image, category = :category, brand = :brand, price = :price WHERE id = :id");

            $stmt->bindParam(':name', $product->name);
            $stmt->bindParam(':price', $product->price);
            $stmt->bindParam(':description', $product->description);
            $stmt->bindParam(':image', $product->image);
            $stmt->bindParam(':category', $product->category);
            $stmt->bindParam(':brand', $product->brand);
            $stmt->bindParam(':id', $id);

            $stmt->execute();

            return $this->getById($id);
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function delete($id)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM product WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return;
        } catch (PDOException $e) {
            echo $e;
        }
        return true;
    }
}
