<?php

namespace Controllers;

use Controllers\Controller;
use Services\CartService;
use Models\CartDTO;

class CartController extends Controller
{

    private $cartService;
    function __construct()
    {
        $this->cartService = new CartService();
    }

    public function index()
    {
        require __DIR__ . '/../views/shop/cart.php';
    }

    public function pay()
    {
        $token = $this->checkForJwt();
        if (!$token) return;

        $userId = $token->data->id;

        $cartData = json_decode(file_get_contents('php://input'), true);
        $cartData = $cartData['products'];

        $cartDTOList = array();

        // create list of cartDTOs
        foreach ($cartData as $item) {
            $cartDTO = new CartDTO();
            $cartDTO->id = $item['id'];
            $cartDTO->name = $item['name'];
            $cartDTO->price = $item['price'];
            $cartDTO->quantity = $item['quantity'];
            $cartDTO->image = $item['image'];
            array_push($cartDTOList, $cartDTO);
        }
        $result = $this->cartService->pay($cartDTOList, $userId);

        if ($result) {
            $this->respond(array("message" => "Order placed successfully"));
        } else {
            $this->respondWithError(500, "Something went wrong while placing your order");
        }
    }
}
