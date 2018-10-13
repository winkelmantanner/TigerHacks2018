<?php
include_once 'AlbumFunctions.php' ;
include_once 'ArtistFunctions.php' ;
include_once 'DatabaseFunctions.php' ;
include_once 'WebpageFunctions.php' ;

function OutputBrowseAllAlbumsPageBody ( $SearchName )
{
  if ( IsUserLoggedIn ( ) == True )
  {
    OutputBrowseAllAlbumsTop ( ) ;
    OutputBrowseAllAlbumsList ( $SearchName ) ;
  }
  else
  {
    Alert ( "You are not logged in." ) ;
  }
}

function OutputBrowseAllAlbumsTop ( )
{
  $ViewAlbumsTopHTML = '
  <div class="jumbotron text-center">
  <h1>Viewing All Albums</h1> 
<form class="form-inline mr-auto" action="BrowseAllAlbums.php"
method="POST" enctype="multipart/form-data">
    <input class="form-control mr-sm-2" name="SearchAlbumName" type="text" aria-label="Search">
    <input name="submit" class="btn btn-outline-success btn-rounded btn-sm" type="submit" value="Search">
</form>
  </div>' ;

  echo $ViewAlbumsTopHTML ;
}

function GetAllGenres ( )
{
    $SQL = "
SELECT DISTINCT(Genre)
  FROM ALBUM2 ; " ;
  $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
  return $Result ;
}

function GetAlbumsHTML ( $SearchName )
{
  $Result2 = GetAllGenres ( ) ;
  $Row2 = mysqli_fetch_assoc ( $Result2 ) ;
  $AlbumsHTML = "" ;
  while ( $Row2 != Null )
  {
    $Genre = $Row2 [ "Genre" ] ;
    if ( $Genre != NULL )
    {
      $AlbumsHTML = $AlbumsHTML . '
      <div class="container text-center">
        <h1>Genre ' . $Genre . '</h1>
        </div>
        ' ;
    }
    else
    {
      $AlbumsHTML = $AlbumsHTML . '
      <div class="container text-center">
        <h1>(No Genre)</h1>
        </div>
        ' ;
    }
    
    $SQL = "
    SELECT DISTINCT( ALBUM2 . AlbumID ) AS ID
    FROM ALBUM2
    LEFT JOIN ALBUM ON ALBUM2 . AlbumID = ALBUM . AlbumID
    WHERE ALBUM2 . Genre = '$Genre'  ; " ;
    $UpperResult = RunSQLAgainstDefaultDatabase ( $SQL ) ;
    $Row = mysqli_fetch_assoc ( $UpperResult ) ;
    
    while ( $Row != Null )
    {
    
      $SQL = "
      SELECT *
      FROM ALBUM
      WHERE AlbumID = " . $Row [ "ID" ] . "
      AND Name LIKE '%" . $SearchName . "%' ; " ;
      
      $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
      $Row2 = mysqli_fetch_assoc ( $Result ) ;
        
      if ( $Row2 != Null )
      {
      
        $AlbumID = $Row2 [ "AlbumID" ] ;
        $Genres = GetGenres ( $AlbumID ) ;
        
        $AlbumsHTML = $AlbumsHTML . '
       <li class="list-group-item">
       <div class="row">
        <div class="col-sm-6 form-group">
        <a href="ViewSongs.php?AlbumID=' . $AlbumID . '" >
          <img id="AlbumImage" src="' . $Row2 [ "CoverArt" ] . '" class="img-rounded" alt="Failure">
          </a>
          </div>
          <div class="col-sm-6 form-group">
          <a href="ViewSongs.php?AlbumID=' . $AlbumID . '">
          <h3>' . $Row2 [ "Name" ] . '</h3>
          </a>
          <p>Release Date: ' . $Row2 [ "ReleaseDate" ]  . '</p>
          <p>Genres: ' . $Genres  . '</p>
          </div>
          </div>
        </li>
       ' ;
     }
     $Row = mysqli_fetch_assoc ( $UpperResult ) ;
    }
    $Row2 = mysqli_fetch_assoc ( $Result2 ) ;
  }
  
  return $AlbumsHTML ;
}

function OutputBrowseAllAlbumsList ( $SearchCriteria )
{
$ArtistHomeAlbumsHTML = "" ;
$ArtistHomeAlbumsHTML= $ArtistHomeAlbumsHTML . '
<div id="AlbumsContainer" class="container-fluid">
<ul class="list-group">
' ;
$AlbumListHTML = GetAlbumsHTML ( $SearchCriteria ) ;
$ArtistHomeAlbumsHTML = $ArtistHomeAlbumsHTML . $AlbumListHTML ;
$ArtistHomeAlbumsHTML= $ArtistHomeAlbumsHTML . "
</ul>
</div>
" ;
  echo $ArtistHomeAlbumsHTML ;
}

function SearchAlbums ( $AssocArray )
{
  $SearchCriteria = $AssocArray [ 'SearchAlbumName' ] ;
  OutputBrowseAllAlbumsPageBody ( $SearchCriteria ) ;
}

function SubmitData ( )
{
    
  SearchAlbums ( $_POST ) ;
    
}

?>