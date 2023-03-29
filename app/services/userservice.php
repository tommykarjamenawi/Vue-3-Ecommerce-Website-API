<?php
namespace Services;

use Repositories\UserRepository;

class UserService {

    private $repository;

    function __construct()
    {
        $this->repository = new UserRepository();
    }

    public function checkUsernamePassword($email, $password) {
        return $this->repository->checkUsernamePassword($email, $password);
    }

    public function getAll($offset = NULL, $limit = NULL) {
        return $this->repository->getAll($offset, $limit);
    }

    public function getById($id) {
        return $this->repository->getById($id);
    }

    public function getByEmail($email) {
        return $this->repository->getByEmail($email);
    }

    public function create($user) {
        return $this->repository->create($user);
    }

    public function delete($id) {
        $this->repository->delete($id);
    }

    public function update($id, $user) {
        return $this->repository->update($id, $user);
    }

    public function updatePassword($id, $password) {
        return $this->repository->updatePassword($id, $password);
    }
}

?>