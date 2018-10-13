<?php

include_once 'SessionFunctions.php' ;
include_once 'WebpageFunctions.php' ;
include_once 'GenericPage.php' ;
include_once 'AlbumCreateFunctions.php' ;

function Main ( )
{
  ContinueSession ( ) ;
  if ( IsSubmitted ( ) )
	{
	  SubmitData ( ) ;
	}
	else
	{
	  OutputGenericPageTop ( ) ;
	  OutputAlbumCreatePageBody ( ) ;
	  OutputGenericPageEnd ( ) ;
	}
}

Main ( ) ;
?>