<?php
include_once 'GenericPage.php' ;
include_once 'PlaySongFunctions.php' ;

function Main ( )
{
  ContinueSession ( ) ;
  OutputGenericPageTop ( ) ;
  OutputPlaySongPageBody ( ) ;
  OutputGenericPageEnd ( ) ;
}

Main ( )
?>