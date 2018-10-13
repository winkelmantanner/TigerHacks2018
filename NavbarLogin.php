<?php
  include_once 'GlobalScript.php' ;
  include_once 'SessionFunctions.php' ;
  include_once 'ArtistFunctions.php' ;
  include_once 'UserFunctions.php' ;
  
  function AddLoginToNavbar ( )
  {
    if ( IsArtistLoggedIn ( ) == True )
    {
      $ArtistName = $_SESSION [ 'ArtistName' ] ;
      $Password = $_SESSION [ 'Password' ] ;
      echo "<li class=\"dropdown\">
  <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">
  <span id=\"LoginDisplay\" >$ArtistName : Artist</span>
  <span class=\"caret\"></span></a>
  <ul class=\"dropdown-menu\">
    <li><a href=\"ArtistHome.php\">My Homepage</a></li>
    <li><a href=\"ArtistLogout.php\">Log Out</a></li>
  </ul>
</li>" ;
    }
    else if ( IsUserLoggedIn ( ) == True )
    {
      $Username = $_SESSION [ 'Username' ] ;
      $Password = $_SESSION [ 'Password' ] ;
      echo "<li class=\"dropdown\">
  <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">
  <span id=\"LoginDisplay\" >$Username : User</span>
  <span class=\"caret\"></span></a>
  <ul class=\"dropdown-menu\">
    <li><a href=\"UserHome.php\">My Homepage</a></li>
    <li><a href=\"UserLogout.php\">Log Out</a></li>
  </ul>
</li>" ;
    }
  }
?>