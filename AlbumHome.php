<?php
include_once 'GenericPage.php' ;
include_once 'AlbumHomeFunctions.php' ;

function Main ( )
{
  ContinueSession ( ) ;
  OutputGenericPageTop ( ) ;
  OutputAlbumHomePageBody ( ) ;
  OutputGenericPageEnd ( ) ;
}

Main ( )
?>