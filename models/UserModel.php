<?php
class UserModel
{
    private $db;

    public function __construct()
    {
        // Get database connection
        require_once 'models/Database.php';
        $this->db = Database::getInstance();
    }

    // Get all users
    public function getAllUsers()
    {
        $sql = "SELECT * FROM stk_users ORDER BY userId DESC";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    // Get user by ID
    public function getUserById($id)
    {
        $id = $this->db->escape($id);
        $sql = "SELECT * FROM stk_users WHERE userId = '$id'";
        $result = $this->db->query($sql);
        return mysqli_fetch_assoc($result);
    }

    // In UserModel.php - add this method
    public function getUsersForDropdown()
    {
        $sql = "SELECT userId, firstName, lastName FROM stk_users ORDER BY firstName";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    // Create user
    public function createUser($data)
    {
        $firstName = $this->db->escape($data['firstname']);
        $lastName = $this->db->escape($data['lastname']);
        $telephone = $this->db->escape($data['telephone']);
        $gender = $this->db->escape($data['gender']);
        $nationality = $this->db->escape($data['nationality']);
        $username = $this->db->escape($data['username']);
        $email = $this->db->escape($data['email']);
        $password = $this->db->escape($data['password']);

        $sql = "INSERT INTO stk_users 
                (firstName, lastName, telephone, gender, nationality, username, email, password) 
                VALUES 
                ('$firstName', '$lastName', '$telephone', '$gender', '$nationality', '$username', '$email', '$password')";

        return $this->db->query($sql);
    }

    // Update user
    public function updateUser($id, $data)
    {
        $id = $this->db->escape($id);
        $firstName = $this->db->escape($data['firstname']);
        $lastName = $this->db->escape($data['lastname']);
        $telephone = $this->db->escape($data['telephone']);
        $gender = $this->db->escape($data['gender']);
        $nationality = $this->db->escape($data['nationality']);
        $username = $this->db->escape($data['username']);
        $email = $this->db->escape($data['email']);
        $password = $this->db->escape($data['password']);

        $sql = "UPDATE stk_users SET 
                firstName = '$firstName',
                lastName = '$lastName',
                telephone = '$telephone',
                gender = '$gender',
                nationality = '$nationality',
                username = '$username',
                email = '$email',
                password = '$password'
                WHERE userId = '$id'";

        return $this->db->query($sql);
    }

    // Delete user
    public function deleteUser($id)
    {
        $id = $this->db->escape($id);
        $sql = "DELETE FROM stk_users WHERE userId = '$id'";
        return $this->db->query($sql);
    }

    // Search users by username
    public function searchUsers($searchTerm)
    {
        $searchTerm = $this->db->escape($searchTerm);
        $sql = "SELECT * FROM stk_users WHERE username LIKE '%$searchTerm%'";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }
}
