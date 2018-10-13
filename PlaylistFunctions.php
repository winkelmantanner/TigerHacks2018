<?php

include_once 'DatabaseFunctions.php' ;

function DoesArtistOwnAlbum ( $ArtistName , $AlbumID )
{
	return True ;
}

function IsAlbumSelectedInURL ( )
{
  $IsVarSet = False ;
  if ( isset ( $_GET [ "AlbumID" ] ) == True )
  {
    $IsVarSet = True ;
  }
  return $IsVarSet ;
}

function GetPlaylistNameFromID ( $PlaylistID )
{
  $SQL = "SELECT Name
  FROM PLAYLIST
  WHERE PlaylistID = " . $PlaylistID ;
  $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
  $Row = mysqli_fetch_assoc ( $Result ) ;
  $Name= $Row [ 'Name' ] ;
  return $Name ;
}

function GetGenres ( $AlbumID )
{
  $SQL = "SELECT *
  FROM ALBUM2
  WHERE AlbumID = " . $AlbumID ;
  
  $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
  
  $Genres = "" ;
  $Row = mysqli_fetch_assoc ( $Result ) ;
  $Genre = $Row [ 'Genre' ] ;
  if ( $Row != Null and $Genre != Null and $Genre != "" )
  {
    $Genres = $Genres . $Genre ;
  }
  else
  {
    $Genres = "(None)" ;
  }
  while ( $Row != Null )
  {
    $Row = mysqli_fetch_assoc ( $Result ) ;
    $Genre = $Row [ 'Genre' ] ;
    if ( $Row != Null and $Genre != Null and $Genre != "" )
    {
      $Genres = $Genres . ", " ;
      $Genres = $Genres . $Genre ;
    }
  }
  return $Genres ;
}

?>