<?php

namespace Controllers;

use Exception;
use Services\OrderService;

class OrderController extends Controller
{
    private $service;

    // initialize services
    function __construct()
    {
        $this->service = new OrderService();
    }

    public function getAll()
    {
        $token = $this->checkForJwt();
        if (!$token) return;

        // if user_id is set, get all orders from a single user else get all orders
        if(isset($_GET['user_id'])) {
            $userId = $_GET['user_id'];
            // check if user is admin or if user is the same as the user_id
            if ($token->data->role != 1 || $token->data->id != $userId) {
                $this->respondWithError(401, "Unauthorized");
                return;
            }
            $orders = $this->service->getAllByUserId($userId);
            $this->respond($orders);
            return;
        }

        // check admin privileges
        if ($token->data->role != 1) {
            $this->respondWithError(401, "Unauthorized");
            return;
        }

        $orders = $this->service->getAll();
        $this->respond($orders);
    }

    // get all products from a single order
    public function getOne()
    {
        $token = $this->checkForJwt();
        if (!$token) return;

        $orderId = $this->getIdFromUrl();
    
        $order_products = $this->service->getAllProductsByOrderId($orderId);
        $this->respond($order_products);
    }

}
