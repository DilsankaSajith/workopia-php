<?php

namespace Framework\Middleware;

use Session;

class Autorize
{
  /**
   * Check if user is authenticated
   * 
   * @return bool
   */
  public function isAuthenticated()
  {
    return Session::has('user');
  }

  /**
   * Handle the user's requests
   * 
   * @param string $role
   * @return void
   */
  public function handle($role)
  {
    if ($role === 'guest' && $this->isAuthenticated()) {
      return redirect('/');
    } elseif ($role === 'auth' && !$this->isAuthenticated()) {
      return redirect('/auth/login');
    }
  }
}
