<?php
include_once 'GenericPage.php' ;
include_once 'ViewAlbumsFunctions.php' ;

function Main ( )
{
  ContinueSession ( ) ;
  OutputGenericPageTop ( ) ;
  OutputViewAlbumsPageBody ( ) ;
  OutputGenericPageEnd ( ) ;
}

Main ( )
?>