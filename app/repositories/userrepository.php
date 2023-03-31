<?php

namespace Repositories;

use PDO;
use PDOException;
use Repositories\Repository;
use Models\User;

class UserRepository extends Repository
{
    function checkUsernamePassword($email, $password)
    {
        try {
            // retrieve the user with the given username
            $stmt = $this->connection->prepare("SELECT id, full_name, email, password, address, role, image FROM USERS WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\User');
            $user = $stmt->fetch();

            // verify if the password matches the hash in the database
            $result = $this->verifyPassword($password, $user->password);

            if (!$result)
                return false;

            // do not pass the password hash to the caller
            $user->password = "";

            return $user;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    // hash the password (currently uses bcrypt)
    function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    // verify the password hash
    function verifyPassword($input, $hash)
    {
        return password_verify($input, $hash);
    }

    function getAll($offset, $limit) {
        try {
            $query = "SELECT id, full_name, email, password, address, role, image FROM USERS";
            if (isset($limit) && isset($offset)) {
                $query .= " LIMIT :limit OFFSET :offset";
            }
            $stmt = $this->connection->prepare($query);
            if (isset($limit) && isset($offset)) {
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            }
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\User');
            $users = $stmt->fetchAll();

            return $users;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function getById($id) {
        try {
            $stmt = $this->connection->prepare("SELECT id, full_name, email, password, address, role, image FROM USERS WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\User');
            $user = $stmt->fetch();

            return $user;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function getByEmail($email) {
        try {
            $stmt = $this->connection->prepare("SELECT id, full_name, email, password, address, role, image FROM USERS WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\User');
            $user = $stmt->fetch();

            return $user;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function create($user) {
        try {
            $stmt = $this->connection->prepare("INSERT INTO USERS (full_name, email, password, address, role, image) VALUES (:full_name, :email, :password, :address, :role, :image)");
            $stmt->bindParam(':full_name', $user->full_name);
            $stmt->bindParam(':email', $user->email);
            $stmt->bindParam(':password', $user->password);
            $stmt->bindParam(':address', $user->address);
            $stmt->bindParam(':role', $user->role);
            $stmt->bindParam(':image', $user->image);
            $stmt->execute();

            // return $this->connection->lastInsertId();
            return $this->getByEmail($user->email);
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function delete($id) {
        try {
            $stmt = $this->connection->prepare("DELETE FROM USERS WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            // return $stmt->rowCount();
        } catch (PDOException $e) {
            echo $e;
        }
    }

    // for normal users
    function update($id, $user) {
        try {
            $stmt = $this->connection->prepare("UPDATE USERS SET full_name = :full_name, email = :email, address = :address WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':full_name', $user->full_name);
            $stmt->bindParam(':email', $user->email);
            $stmt->bindParam(':address', $user->address);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function updatePassword($id, $password) {
        try {
            $stmt = $this->connection->prepare("UPDATE USERS SET password = :password WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':password', $password);
            $stmt->execute();

            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo $e;
        }
    }
}
