<?php

function StartSession ( )
{
  session_start ( ) ;
}

function ContinueSession ( )
{
  session_start ( ) ;
}

function SessionDeleteCookies ( )
{
  if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
}

function EndSession ( )
{
  session_unset ( ) ;
  SessionDeleteCookies ( ) ;
  session_destroy ( ) ;
}

?>