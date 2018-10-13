<?php
include_once 'GenericPage.php' ;
include_once 'UserHomeFunctions.php' ;

function Main ( )
{
  ContinueSession ( ) ;
  OutputGenericPageTop ( ) ;
  OutputUserHomePageBody ( ) ;
  OutputGenericPageEnd ( ) ;
}

Main ( )
?>