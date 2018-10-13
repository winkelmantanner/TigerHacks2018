<?php
include_once 'PlaylistFunctions.php' ;
include_once 'ArtistFunctions.php' ;
include_once 'DatabaseFunctions.php' ;
include_once 'WebpageFunctions.php' ;

function OutputPlaylistHomePageBody ( )
{
  if ( IsUserLoggedIn ( ) == True )
  {
    $PlaylistID = $_GET [ "PlaylistID" ] ;
    OutputPlaylistHomeTop ( ) ;
    OutputPlaylistHomeList ( ) ;
  }
  else
  {
    Alert ( "You are not logged in." ) ;
  }
}

function OutputPlaylistHomeTop ( )
{
  $PlaylistID = $_GET [ "PlaylistID" ] ;
  $PlaylistName = GetPlaylistNameFromID ( $PlaylistID ) ;
  $ViewSongsTopHTML = '
  <div class="jumbotron text-center">
  <h1>Viewing ' . $PlaylistName . '\'s Songs</h1> 
  </div>' ;

  echo $ViewSongsTopHTML ;
}

function GetSongsHTML ( )
{
  $PlaylistID = $_GET [ "PlaylistID" ] ;
  $SQL = "
SELECT *
  FROM PLAYLIST
  RIGHT JOIN CONTAINS ON PLAYLIST . PlaylistID = CONTAINS . PlaylistID
  RIGHT JOIN SONG ON CONTAINS . SongID = SONG . SongID
  WHERE PLAYLIST . PlaylistID = '$PlaylistID' ; " ;
  
  $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
  
  $SongsHTML = "" ;
  
  $Row = mysqli_fetch_assoc ( $Result ) ;
  while ( $Row != Null )
  {
    $SongID = $Row [ "SongID" ] ;
    
    $SongsHTML = $SongsHTML . '
   <li class="list-group-item">
   <div class="row">
      <div class="col-sm-6 form-group">
      <a href="PlaySong.php?SongID=' . $SongID . '">
      <h3>' . $Row [ "Name" ] . '</h3>
      </a>
      <p>Number of Plays: ' . $Row [ "NumberPlays" ]  . '</p>
      <p>Length: ' . $Row [ "Length" ]  . '</p>
      </div>
      </div>
    </li>
   ' ;
   $Row = mysqli_fetch_assoc ( $Result ) ;
  }
  
  return $SongsHTML ;
}

function OutputPlaylistHomeList ( )
{
$ViewSongsListHTML = "" ;
$ViewSongsListHTML= $ViewSongsListHTML . '
<div id="AlbumsContainer" class="container-fluid">
<ul class="list-group">
' ;
$SongsListHTML = GetSongsHTML ( ) ;
$ViewSongsListHTML = $ViewSongsListHTML . $SongsListHTML ;
$ViewSongsListHTML= $ViewSongsListHTML . "
</ul>
</div>
" ;
  echo $ViewSongsListHTML ;
}
?>