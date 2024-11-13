<?php

namespace App\Controllers;

use Framework\Database;

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

  public function show()
  {

    $id = $_GET['id'] ?? "";

    $params = [
      'id' => $id
    ];

    $listing = $this->db->query('SELECT * FROM workopia.listings WHERE id = :id', $params)->fetch();

    loadView('listings/show', [
      'listing' => $listing
    ]);
  }
}
