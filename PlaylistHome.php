<?php
include_once 'GenericPage.php' ;
include_once 'PlaylistHomeFunctions.php' ;

function Main ( )
{
  ContinueSession ( ) ;
  OutputGenericPageTop ( ) ;
  OutputPlaylistHomePageBody ( ) ;
  OutputGenericPageEnd ( ) ;
}

Main ( )
?>