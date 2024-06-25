<?php
namespace Shibaji\Models;

use App\Models\User;

class Auth
{
    private $userModel;
    private $sessionKey = 'user_id';

    public function __construct(User $user)
    {
        session_start();
        $this->userModel = $user;
    }

    public function register($username, $password)
    {
        // Hash the password before storing it
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        // Prepare user data
        $userData = [
            'username' => $username,
            'password' => $hashedPassword,
        ];
        
        // Create a new user
        return $this->userModel->create($userData);
    }

    public function login($username, $password)
    {
        // Find user by username
        $user = $this->userModel->findBy('username', $username);
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION[$this->sessionKey] = $user['id'];
            return true;
        }

        return false;
    }

    public function logout()
    {
        unset($_SESSION[$this->sessionKey]);
    }

    public function check()
    {
        return isset($_SESSION[$this->sessionKey]);
    }

    public function user()
    {
        if ($this->check()) {
            return $this->userModel->find($_SESSION[$this->sessionKey]);
        }

        return null;
    }
}