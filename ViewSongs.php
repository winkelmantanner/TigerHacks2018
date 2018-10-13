<?php
include_once 'GenericPage.php' ;
include_once 'ViewSongsFunctions.php' ;

function Main ( )
{
  ContinueSession ( ) ;
  OutputGenericPageTop ( ) ;
  OutputViewSongsPageBody ( ) ;
  OutputGenericPageEnd ( ) ;
}

Main ( )
?>