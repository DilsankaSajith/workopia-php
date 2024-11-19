<?php

namespace Framework;

use Session;

class Authorization
{
  /**
   * Check if current logged in user owned a resource
   * 
   * @param string $resourceId
   * @return bool
   */
  public static function isOwner($resourceId)
  {
    $sessionUser = Session::get('user');
    if ($sessionUser !== null && isset($sessionUser['id'])) {
      $sessionUserId = $sessionUser['id'];
      return $sessionUserId == $resourceId;
    }

    return false;
  }
}
