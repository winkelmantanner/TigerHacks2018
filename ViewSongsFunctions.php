<?php
include_once 'AlbumFunctions.php' ;
include_once 'ArtistFunctions.php' ;
include_once 'DatabaseFunctions.php' ;
include_once 'WebpageFunctions.php' ;

function OutputViewSongsPageBody ( )
{
  if ( IsUserLoggedIn ( ) == True )
  {
    $AlbumID = $_GET [ "AlbumID" ] ;
    OutputViewSongsTop ( ) ;
    OutputViewSongsList ( ) ;
  }
  else
  {
    Alert ( "You are not logged in." ) ;
  }
}

function OutputViewSongsTop ( )
{
  $AlbumID = $_GET [ "AlbumID" ] ;
  $AlbumName = GetAlbumNameFromID ( $AlbumID ) ;
  $ViewSongsTopHTML = '
  <div class="jumbotron text-center">
  <h1>Viewing ' . $AlbumName . '\'s Songs</h1> 
  </div>' ;

  echo $ViewSongsTopHTML ;
}

function GetSongsHTML ( )
{
  $AlbumID = $_GET [ "AlbumID" ] ;
  $SQL = "
SELECT *
  FROM ALBUM
  RIGHT JOIN BELONG_TO ON ALBUM . AlbumID = BELONG_TO . AlbumID
  RIGHT JOIN SONG ON BELONG_TO . SongID = SONG . SongID
  WHERE ALBUM . AlbumID = '$AlbumID' ; " ;
  
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

function OutputViewSongsList ( )
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