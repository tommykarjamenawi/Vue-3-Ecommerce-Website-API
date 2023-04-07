<?php

namespace Controllers;

use Exception;
use Services\UserService;
use \Firebase\JWT\JWT;

class UserController extends Controller
{
    private $service;

    // initialize services
    function __construct()
    {
        $this->service = new UserService();
    }

    public function login() {

        // read user data from request body
        $postedUser = $this->createObjectFromPostedJson("Models\\User");

        // get user from db
        $user = $this->service->checkUsernamePassword($postedUser->email, $postedUser->password);

        // if the method returned false, the username and/or password were incorrect
        if($user == null) {
            $this->respondWithError(401, "Invalid login");
            return;
        }

        // generate jwt
        $tokenResponse = $this->generateJwt($user);       

        $this->respond($tokenResponse);    
    }

    public function generateJwt($user) {
        $secret_key = "YOUR_SECRET_KEY";

        $issuer = "THE_ISSUER"; // this can be the domain/servername that issues the token
        $audience = "THE_AUDIENCE"; // this can be the domain/servername that checks the token

        $issuedAt = time(); // issued at
        $notbefore = $issuedAt; //not valid before 
        $expire = $issuedAt + 6000; // expiration time is set at +600 seconds (10 minutes)

        // JWT expiration times should be kept short (10-30 minutes)
        // A refresh token system should be implemented if we want clients to stay logged in for longer periods

        // note how these claims are 3 characters long to keep the JWT as small as possible
        $payload = array(
            "iss" => $issuer,
            "aud" => $audience,
            "iat" => $issuedAt,
            "nbf" => $notbefore,
            "exp" => $expire,
            "data" => array(
                "id" => $user->id,
                "full_name" => $user->full_name,
                "email" => $user->email,
                "role" => $user->role,
                "image" => $user->image
        ));

        $jwt = JWT::encode($payload, $secret_key, 'HS256');

        return 
            array(
                "message" => "Successful login.",
                "jwt" => $jwt,
                "id" => $user->id,
                "full_name" => $user->full_name,
                "email" => $user->email,
                "role" => $user->role,
                "expireAt" => $expire
            );
    } 
    
    public function delete() {
        $token = $this->checkForJwt();
        if (!$token) return;

        // check if user is admin
        if ($token->data->role != 1) {
            $this->respondWithError(401, "Unauthorized");
            return;
        }

        // get id from url
        $id = $this->getIdFromUrl();

        $result = $this->service->getById($id);
        if (!$result) {
            $this->respondWithError(404, $id + "User not found");
            return;
        }

        $this->service->delete($id);
        $this->respond(array("message" => "User deleted"));
    }

    public function getAll() {
        // check if user wants to search by email
        if(isset($_GET["email"])) {
            $this->getByEmail();
            return;
        }

        $token = $this->checkForJwt();
        if (!$token) return;

        // check if user is admin
        if ($token->data->role != 1) {
            $this->respondWithError(401, "Unauthorized");
            return;
        }

        $offset = NULL;
        $limit = NULL;

        if (isset($_GET["offset"]) && is_numeric($_GET["offset"])) {
            $offset = $_GET["offset"];
        }
        if (isset($_GET["limit"]) && is_numeric($_GET["limit"])) {
            $limit = $_GET["limit"];
        }

        $users = $this->service->getAll($offset, $limit);
        $this->respond($users);
    }

    public function getById() {
        $token = $this->checkForJwt();
        if (!$token) return;

        // check if user is admin or if user is requesting his own data
        if ($token->data->role != 1 && $token->data->id != $this->getIdFromUrl()) {
            $this->respondWithError(401, "Unauthorized");
            return;
        }

        // get id from url
        $id = $this->getIdFromUrl();

        $user = $this->service->getById($id);
        // error if user is empty
        if (!$user) {
            $this->respondWithError(404, "User not found");
            return;
        }
        $this->respond($user);
    }

    public function getByEmail() {
        $token = $this->checkForJwt();
        if (!$token) return;

        // check if user is admin
        if ($token->data->role != 1) {
            $this->respondWithError(401, "Unauthorized");
            return;
        }

        $email = "";

        if (isset($_GET["email"]) && is_string($_GET["email"])) {
            $email = $_GET["email"];
        }

        $user = $this->service->getByEmail($email);
        // error if user is empty
        if (!$user) {
            $this->respondWithError(404, "User not found");
            return;
        }
        $this->respond($user);
    }

    public function register() {

        // read user data from request body
        $postedUser = $this->createObjectFromPostedJson("Models\\User");

        // check if email is already in use
        $user = $this->service->getByEmail($postedUser->email);
        if ($user) {
            $this->respondWithError(400, "Email is already in use");
            return;
        }
        // hash password
        $postedUser->password = password_hash($postedUser->password, PASSWORD_DEFAULT);

        $tempUser = $this->newUser($postedUser->full_name, $postedUser->email, $postedUser->password);
        

        // add user to db
        $newUser = $this->service->create($tempUser);

        // generate jwt
        $tokenResponse = $this->generateJwt($newUser);       

        $this->respond($tokenResponse);
    }

    public function newUser($full_name, $email, $password) {
        $newUser = new \Models\User();
        $newUser->full_name = $full_name;
        $newUser->email = $email;
        $newUser->password = $password;
        $newUser->address = "";
        $newUser->role = 2;
        $newUser->image = "/img/defaultprofile.jpg";
        return $newUser;
    }

    public function update() {
        $token = $this->checkForJwt();
        if (!$token) return;

        // get id from url
        $id = $this->getIdFromUrl();

        // read user data from request body
        $postedUser = $this->createObjectFromPostedJson("Models\\User");

        $updateOwnAccount = $token->data->id == $id;
        // check if user is admin or updating own account
        if ($token->data->role != 1 && !$updateOwnAccount) {
            $this->respondWithError(401, "Unauthorized");
            return;
        }

        // check if email is already in use by other user than the one being updated
        $user = $this->service->getByEmail($postedUser->email);
        if ($user && $user->id != $id) {
            $this->respondWithError(400, "Email is already in use");
            return;
        }

        // update user
        $this->service->update($id, $postedUser);

        $this->respond(array("message" => "User updated in the server"));
    }

    public function updatePassword() {
        $token = $this->checkForJwt();
        if (!$token) return;

        // get id from /users/{id}/password
        $url = $_SERVER['REQUEST_URI'];
        $arr = explode("/", $url);
        $id = $arr[2];

        $newPassword = $this->createObjectFromPostedJson("Models\\passwordDTO");

        $updateOwnAccount = $token->data->id == $id;
        // check if user is admin or updating own account
        if ($token->data->role != 1 && !$updateOwnAccount) {
            $this->respondWithError(401, "Unauthorized");
            return;
        }

        // hash password
        $newPassword->password = password_hash($newPassword->password, PASSWORD_DEFAULT);
        // $2y$10$SJGxkdiNknRpQppRiVoZa.dLKk5PKYGgxpTwcS7mi3VhebzYgrQIC == test
        
        // update user
        $result = $this->service->updatePassword($id, $newPassword->password);

        // error if password didn't update
        if (!$result) {
            $this->respondWithError(500, "Password didn't update");
            return;
        }

        $this->respond(array("message" => "Password updated"));
    }
}
