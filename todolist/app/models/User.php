<?php
namespace Aries\Dbmodel\Models;

use Aries\Dbmodel\Includes\Database;

class User extends Database {
    private $db;

    public function __construct() {
        parent::__construct(); // Call the parent constructor to establish the connection
        $this->db = $this->getConnection(); // Get the connection instance
    }

    // Get all users
    public function getUsers() {
        $sql = "SELECT * FROM users";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Get user by ID
    public function getUser($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // Create a new user
    public function createUser($data) {
        $sql = "INSERT INTO users (first_name, last_name, username, password) VALUES (:first_name, :last_name, :username, :password)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'password' => $data['password']
        ]);
        return $this->db->lastInsertId();
    }

    // Update user information
    public function updateUser($data) {
        $sql = "UPDATE users SET first_name = :first_name, last_name = :last_name, username = :username, password = :password WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $data['id'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'password' => $data['password']
        ]);
        return "Record UPDATED successfully";
    }

    // Delete user by ID
    public function deleteUser($id) {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);
        return "Record DELETED successfully";
    }

    // Get user by username for login
    public function getUserByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
