<?php
include_once 'UserFunctions.php' ;
include_once 'SongFunctions.php' ;
include_once 'AlbumFunctions.php' ;
include_once 'ArtistFunctions.php' ;
include_once 'DatabaseFunctions.php' ;
include_once 'WebpageFunctions.php' ;

function OutputPlaySongPageBody ( )
{
  if ( IsUserLoggedIn ( ) == True )
  {
    $SongID = $_GET [ "SongID" ] ;
    IncrementNumberPlays ( $SongID ) ;
    OutputPlaySongBodyHTML ( ) ;
    OutputAddToPlaylistButton ( ) ;
  }
  else
  {
    Alert ( "You are not logged in." ) ;
    header ( "Location: index.php" ) ;
    exit ;
  }
}

function OutputPlaySongBodyHTML ( )
{
  $SongID = $_GET [ "SongID" ] ;
  $SQL = "SELECT *
  FROM SONG
  WHERE SongID = $SongID ;" ;
  $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
  $Row = mysqli_fetch_assoc ( $Result ) ;
  $Name= $Row [ 'Name' ] ;
  
  $PlaySongHTML = '
  <h1>Playing ' . $Name . ' </h1>
  <video width="320" height="240" controls>
  <source src="' . $Row [ 'FilePath' ] . '" type="video/mp4">
  </video>
  <br>
  <p>Number of Plays: ' . $Row [ 'NumberPlays' ] . '</p>
  <br>
  <p>Length: ' . $Row [ 'Length' ] . '</p>
  ' ;
  echo $PlaySongHTML ;
}

function OutputAddToPlaylistButton ( )
{
  if ( GetNumberOfPlaylistsOfUser ( ) > 0 )
  {
    $SongID = $_GET [ "SongID" ] ;
    $PlaylistButtonHTML = '<div class="container-fluid text-center">
  <a class="btn btn-primary float-right" href="ChoosePlaylist.php?SongID=' . $SongID . '">Insert Song to Playlist</a>
  </div>
      ' ;
    
    echo $PlaylistButtonHTML ;
  }
}


?>