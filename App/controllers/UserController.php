<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;
use Session;

class UserController
{
  protected $db;

  public function __construct()
  {
    $config = require basePath('config/db.php');
    $this->db = new Database($config);
  }

  /**
   * Show login page
   * 
   * @return void
   */
  public function login()
  {
    loadView('users/login');
  }

  /**
   * Show login page
   * 
   * @return void
   */
  public function create()
  {
    loadView('users/create');
  }

  /**
   * Store user in database
   * 
   * @return void
   */
  public function store()
  {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $password = $_POST['password'];
    $password_confirmation = $_POST['password_confirmation'];

    $errors = [];

    if (!Validation::email($email)) {
      $errors['email'] = 'Please enter a valid email address';
    }
    if (!Validation::string($name, 2, 50)) {
      $errors['name'] = 'Name should be at least 2 characters';
    }
    if (!Validation::string($password, 6, 50)) {
      $errors['passsword'] = 'Password should be at least 6 characters';
    }
    if (!Validation::match($password, $password_confirmation)) {
      $errors['passsword_confirmation'] = 'Password do not match';
    }

    if (!empty($errors)) {
      loadView('users/create', [
        'errors' => $errors,
        'user' => [
          'name' => $name,
          'email' => $email,
          'city' => $city,
          'state' => $state
        ]
      ]);
      exit;
    }

    $params = [
      'email' => $email
    ];

    $user = $this->db->query('SELECT * FROM workopia.users WHERE email = :email', $params)->fetch();

    if ($user) {
      $errors['email'] = 'That email already exists';
      loadView('users/create', [
        'errors' => $errors
      ]);
    }

    $params = [
      'name' => $name,
      'email' => $email,
      'city' => $city,
      'state' => $state,
      'password' => password_hash($password, PASSWORD_DEFAULT)
    ];

    $this->db->query('INSERT INTO workopia.users(name, email, city, state, password) VALUES (:name, :email, :city, :state, :password)', $params);

    // Get user id
    $userId = $this->db->conn->lastInsertId();

    Session::set('user', [
      'id' => $userId,
      'name' => $name,
      'email' => $email,
      'city' => $city,
      'state' => $state
    ]);

    redirect('/');
  }

  /**
   * Logout a user and kill session
   * 
   * @return void
   */
  public function logout()
  {
    Session::clearAll();

    $params = session_get_cookie_params();
    setcookie('PHPSESHID', '', time() - 86400, $params['path'], $params['domain']);

    redirect('/');
  }

  /**
   * Authenticate a user with email and password
   * 
   * @return void
   */
  public function authenticate()
  {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $errors = [];

    // Validation

    if (!Validation::email($email)) {
      $errors['email'] = 'Please enter a valid email';
    }

    if (!Validation::string($password, 6)) {
      $errors['password'] = 'Password must be at least 6 characters';
    }

    if (!empty($errors)) {
      loadView('users/login', [
        'errors' => $errors
      ]);
      exit;
    }

    //Check for user
    $params = [
      'email' => $email
    ];

    $user = $this->db->query('SELECT * FROM workopia.users WHERE email = :email', $params)->fetch();

    if (!$user) {
      $errors['email'] = 'Incorrect credentials';
      loadView('users/login', [
        'errors' => $errors
      ]);
      exit;
    }

    // Check if password correct
    if (!password_verify($password, $user->password)) {
      $errors['email'] = 'Incorrect credentials';
      loadView('users/login', [
        'errors' => $errors
      ]);
      exit;
    }

    // Set user session
    Session::set('user', [
      'id' => $user->id,
      'name' => $user->name,
      'email' => $user->email,
      'city' => $user->city,
      'state' => $user->state
    ]);

    redirect('/');
  }
}
