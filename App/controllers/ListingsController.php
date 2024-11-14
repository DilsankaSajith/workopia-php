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
    inspectAndDie(Validation::match(1, 1));
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
}
