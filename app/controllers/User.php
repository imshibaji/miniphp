<?php
namespace Shibaji\App\Controllers;

use Shibaji\App\Models\User as ModelsUser;
use Shibaji\Core\Request;

class User extends Controller{
    private $userModel;
    public function __construct(){
        // Create a new user
        $this->userModel = new ModelsUser();
        // $userData = [
        //     'username' => 'john_doe',
        //     'email' => 'john.doe@example.com',
        //     'password' => 'hashed_password'
        // ];
        // $userModel->create($userData);

        // // Find and update a user
        // $user = $userModel->find(2); // Assuming user with ID 1 exists
        // print_r($user);
        // if ($user) {
        //     $updatedData = ['username' => 'new_username'];
        //     $userModel->update($user['id'], $updatedData);
        // }

        // // Delete a user
        // $userModel->delete(1); // Delete user with ID 1

    }
    public function index(Request $request)
    {
        // $request->age = '23';

        // // print_r($request->getParams());
        // echo 'User';
        if($request->id){
            $user = $this->userModel->find($request->id ?? 1);
            // print_r($user);
            json($user);
        }else{
            $users = $this->userModel->all();
            // print_r($users);
            json($users);
        }
    }
}