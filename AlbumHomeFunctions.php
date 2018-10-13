<?php
include_once 'ArtistFunctions.php' ;
include_once 'AlbumFunctions.php' ;
include_once 'WebpageFunctions.php' ;

function OutputAlbumHomePageBody ( )
{
  if ( IsAlbumSelectedInURL ( ) == True )
  {
    $AlbumID = $_GET [ "AlbumID" ] ;
    if ( IsArtistLoggedIn ( ) )
    {
      $ArtistName = $_SESSION [ "ArtistName" ] ;
      if ( DoesArtistOwnAlbum ( $ArtistName , $AlbumID ) == True )
      {
        OutputSongUploadButton ( ) ;
        OutputAlbumHomeSongs ( $AlbumID ) ;
      }
      else
      {
        HTMLAlert ( "You do not own this album." ) ;
        header ( "index.php" ) ;
        exit ;
      }
    }
    else
    {
      HTMLAlert ( "You are not logged in." ) ;
      header ( "index.php" ) ;
      exit ;
    }
  }
  else
  {
    HTMLAlert ( "No album selected." ) ;
    header ( "index.php" ) ;
    exit ;
  }
}


function OutputSongUploadButton ( )
{
  $AlbumID = $_GET [ "AlbumID" ] ;
  $UploadSongButtonHTML = '<div class="container-fluid text-center">
<a class="btn btn-primary float-right" href="SongUpload.php?AlbumID=' . $AlbumID . '">Upload Song</a>
</div>
    ' ;
    
  echo $UploadSongButtonHTML ;
}


function GetSongsHTML ( $AlbumID )
{
  $ArtistName = $_SESSION [ "ArtistName" ] ;
  $SQL = "
SELECT *
  FROM ALBUM
  RIGHT JOIN BELONG_TO ON ALBUM . AlbumID = BELONG_TO . AlbumID
  RIGHT JOIN SONG ON BELONG_TO . SongID = SONG . SongID
  WHERE ALBUM . AlbumID = '$AlbumID' ; " ;
  
  $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
  
  $AlbumsHTML = "" ;
  
  $Row = mysqli_fetch_assoc ( $Result ) ;
  while ( $Row != Null )
  {
    $SongID = $Row [ "SongID" ] ;
    
    $AlbumsHTML = $AlbumsHTML . '
   <li class="list-group-item">
   <div class="row">
    <div class="col-sm-6 form-group">
    <a href="AlbumHome.php?AlbumID=' . $AlbumID . '">
      <h3 id="SongName">' . $Row [ "Name" ] . '</h3>
      </a>
      </div>
      <div class="col-sm-6 form-group">
      <p>Length: ' . $Row [ "Length" ]  . '</p>
      <p>Number of Plays: ' . $Row [ "NumberPlays" ]  . '</p>
      </div>
      </div>
    </li>
   ' ;
   $Row = mysqli_fetch_assoc ( $Result ) ;
  }
  
  return $AlbumsHTML ;
}

function OutputAlbumHomeSongs ( $AlbumID )
{
$ArtistHomeAlbumsHTML = "" ;
$ArtistHomeAlbumsHTML= $ArtistHomeAlbumsHTML . '
<div class="container-fluid">
<ul class="list-group">
' ;
$AlbumListHTML = GetSongsHTML ( $AlbumID ) ;
$ArtistHomeAlbumsHTML = $ArtistHomeAlbumsHTML . $AlbumListHTML ;
$ArtistHomeAlbumsHTML= $ArtistHomeAlbumsHTML . "
</ul>
</div>
" ;

  echo $ArtistHomeAlbumsHTML ;
}

?>