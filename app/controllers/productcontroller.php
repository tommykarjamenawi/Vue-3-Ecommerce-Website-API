<?php

namespace Controllers;

use Exception;
use Services\ProductService;

class ProductController extends Controller
{
    private $service;

    // initialize services
    function __construct()
    {
        $this->service = new ProductService();
    }

    public function getAll()
    {
        // No need to check for jwt token because this is a public route
        $offset = NULL;
        $limit = NULL;

        if (isset($_GET["offset"]) && is_numeric($_GET["offset"])) {
            $offset = $_GET["offset"];
        }
        if (isset($_GET["limit"]) && is_numeric($_GET["limit"])) {
            $limit = $_GET["limit"];
        }

        $products = $this->service->getAll($offset, $limit);

        $this->respond($products);
    }

    public function getById()
    {
        // No need to check for jwt token because this is a public route
        $id = $this->getIdFromUrl();
        $product = $this->service->getById($id);
        if (!$product) {
            $this->respondWithError(404, "Product not found");
            return;
        }
        $this->respond($product);
    }

    public function create()
    {
        $token = $this->checkForJwt();
        if (!$token) return;

        // check admin privileges
        if ($token->data->role != 1) {
            $this->respondWithError(401, "Unauthorized");
            return;
        }

        try {
            $product = $this->createObjectFromPostedJson("Models\\Product");
            $product = $this->service->create($product);

        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($product);
    }

    public function update($id)
    {
        $token = $this->checkForJwt();
        if (!$token) return;

        // check admin privileges
        if ($token->data->role != 1) {
            $this->respondWithError(401, "Unauthorized");
            return;
        }

        try {
            $product = $this->createObjectFromPostedJson("Models\\Product");
            $product = $this->service->update($product, $id);

        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($product);
    }

    public function delete($id)
    {
        $token = $this->checkForJwt();
        if (!$token) return;

        // check admin privileges
        if ($token->data->role != 1) {
            $this->respondWithError(401, "Unauthorized");
            return;
        }
        
        try {
            $this->service->delete($id);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond(true);
    }
}
