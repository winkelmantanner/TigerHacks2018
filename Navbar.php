<?php
include_once 'NavbarLogin.php' ;

function OutputNavbar ( )
{
  PrintMainPartOfNavbar ( ) ;
  AddLoginToNavbar ( ) ;
  CloseNavbar ( ) ;
}

function PrintMainPartOfNavbar ( )
{
  $NavbarText = '
  <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" id="mynav" href="index.php">Fake New Finder</a>
    </div>
    ' ;
  echo $NavbarText ;
}

function CloseNavbar ( )
{
  $CloseNavbarString = '
  </div>
</nav>' ;
  echo $CloseNavbarString ;
}

?>