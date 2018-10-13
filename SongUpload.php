<?php

include_once 'SessionFunctions.php' ;
include_once 'WebpageFunctions.php' ;
include_once 'GenericPage.php' ;
include_once 'SongUploadFunctions.php' ;
include_once 'AlbumFunctions.php' ;

function Main ( )
{
  ContinueSession ( ) ;  
  if ( IsAlbumSelectedInURL ( ) == True )
  {
    $AlbumID = $_GET [ "AlbumID" ] ;
    if ( IsArtistLoggedIn ( ) )
    {
      $ArtistName = $_SESSION [ "ArtistName" ] ;
      if ( DoesArtistOwnAlbum ( $ArtistName , $AlbumID ) == True )
      {
        if ( IsSubmitted ( ) )
        {
          SubmitData ( ) ;
        }
        else
        {
          OutputGenericPageTop ( ) ;
          OutputSongUploadPageBody ( ) ;
          OutputGenericPageEnd ( ) ;
        }
      }
      else
      {
        Alert ( "You do not own this album." ) ;
        header ( "index.php" ) ;
        exit ;
      }
    }
  }
}

Main ( ) ;
?>