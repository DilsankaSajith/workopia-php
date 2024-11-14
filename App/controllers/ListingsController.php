<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;

class ListingsController
{
  protected $db;

  public function __construct()
  {
    $config = require basePath('config/db.php');
    $this->db = new Database($config);
  }
  public function index()
  {
    $listings = $this->db->query('SELECT * FROM workopia.listings ')->fetchAll();

    loadView('/listings/index', [
      'listings' => $listings
    ]);
  }

  public function create()
  {
    loadView('listings/create');
  }

  public function show($params)
  {

    // $id = $_GET['id'] ?? "";
    $id = $params['id'] ?? "";

    $params = [
      'id' => $id
    ];

    $listing = $this->db->query('SELECT * FROM workopia.listings WHERE id = :id', $params)->fetch();

    if (!$listing) {
      ErrorController::notFound('Listing not found');
      return;
    }

    loadView('listings/show', [
      'listing' => $listing
    ]);
  }

  /**
   * Store data in database
   * 
   * @return void
   */
  public function store()
  {
    $allowedFields = ['title', 'description', 'salary', 'tags', 'company', 'address', 'city', 'state', 'phone', 'email', 'requirements', 'benefits'];

    $newListingData = array_intersect_key($_POST, array_flip($allowedFields));

    $newListingData['user_id'] = 1;

    $newListingData = array_map('sanitize', $newListingData);

    $requiredFields = ['title', 'description', 'email', 'city', 'state'];

    $errors = [];

    foreach ($requiredFields as $field) {
      if (empty($newListingData[$field]) || !Validation::string($newListingData[$field])) {
        $errors[$field] = ucfirst($field) . ' is required';
      };
    }

    if (!empty($errors)) {
      // Reload the view with errors
      loadView('listings/create', [
        'errors' => $errors,
        'listings' => $newListingData
      ]);
    } else {
      echo 'Succesed...';
    }
  }
}
