<?php
include_once 'AlbumFunctions.php' ;
include_once 'ArtistFunctions.php' ;
include_once 'DatabaseFunctions.php' ;
include_once 'WebpageFunctions.php' ;

function OutputViewAlbumsPageBody ( )
{
  if ( IsUserLoggedIn ( ) == True )
  {
    $ArtistName = $_GET [ "ArtistName" ] ;
    OutputViewAlbumsTop ( ) ;
    OutputViewAlbumsList ( ) ;
  }
  else
  {
    Alert ( "You are not logged in." ) ;
  }
}

function OutputViewAlbumsTop ( )
{
  $ArtistName = $_GET [ "ArtistName" ] ;
  $ViewAlbumsTopHTML = '
  <div class="jumbotron text-center">
  <h1>Viewing ' . $ArtistName . '\'s Albums</h1> 
  </div>' ;

  echo $ViewAlbumsTopHTML ;
}

function GetAlbumsHTML ( )
{
  $ArtistName = $_GET [ "ArtistName" ] ;
  $SQL = "
SELECT *
  FROM ARTIST
  RIGHT JOIN OWNS ON ARTIST . ArtistName = OWNS . ArtistName
  RIGHT JOIN ALBUM ON OWNS . AlbumID = ALBUM . AlbumID
  WHERE ARTIST . ArtistName = '$ArtistName' ; " ;
  
  $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
  
  $AlbumsHTML = "" ;
  
  $Row = mysqli_fetch_assoc ( $Result ) ;
  while ( $Row != Null )
  {
    $AlbumID = $Row [ "AlbumID" ] ;
    $Genres = GetGenres ( $AlbumID ) ;
    
    $AlbumsHTML = $AlbumsHTML . '
   <li class="list-group-item">
   <div class="row">
    <div class="col-sm-6 form-group">
    <a href="ViewSongs.php?AlbumID=' . $AlbumID . '" >
      <img id="AlbumImage" src="' . $Row [ "CoverArt" ] . '" class="img-rounded" alt="Failure">
      </a>
      </div>
      <div class="col-sm-6 form-group">
      <a href="ViewSongs.php?AlbumID=' . $AlbumID . '">
      <h3>' . $Row [ "Name" ] . '</h3>
      </a>
      <p>Release Date: ' . $Row [ "ReleaseDate" ]  . '</p>
      <p>Genres: ' . $Genres  . '</p>
      </div>
      </div>
    </li>
   ' ;
   $Row = mysqli_fetch_assoc ( $Result ) ;
  }
  
  return $AlbumsHTML ;
}

function OutputViewAlbumsList ( )
{
$ArtistHomeAlbumsHTML = "" ;
$ArtistHomeAlbumsHTML= $ArtistHomeAlbumsHTML . '
<div id="AlbumsContainer" class="container-fluid">
<ul class="list-group">
' ;
$AlbumListHTML = GetAlbumsHTML ( ) ;
$ArtistHomeAlbumsHTML = $ArtistHomeAlbumsHTML . $AlbumListHTML ;
$ArtistHomeAlbumsHTML= $ArtistHomeAlbumsHTML . "
</ul>
</div>
" ;
  echo $ArtistHomeAlbumsHTML ;
}
?>