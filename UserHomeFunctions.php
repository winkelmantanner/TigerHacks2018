<?php
include_once 'UserFunctions.php' ;
include_once 'DatabaseFunctions.php' ;
include_once 'WebpageFunctions.php' ;

function OutputUserHomePageBody ( )
{
  if ( IsUserLoggedIn ( ) == True )
  {
    OutputUserHomeTop ( ) ;
    OutputUserCreateButtons ( ) ;
    OutputUserHomePlaylists ( ) ;
  }
  else
  {
    Alert ( "You are not logged in." ) ;
    print_r ( $_SESSION ) ;
  }
}


function OutputUserHomeTop ( )
{
  $Username = $_SESSION [ 'Username' ] ;
  $Password = $_SESSION [ 'Password' ] ;
  $ArtistHomeHTML = '
  <div class="jumbotron text-center">
  <h1>Wecome, ' . $Username . '</h1> 
  <p>Here are your playlists</p> 
  </div>' ;

  echo $ArtistHomeHTML ;
}

function OutputUserCreateButtons ( )
{
  $ButtonsHTML = '<div class="container-fluid text-center">
<a class="btn btn-primary float-right" href="PlaylistCreate.php">Create Playlist</a>
<a class="btn btn-primary" href="BrowseAllAlbums.php">Browse All Albums</a>
<a class="btn btn-primary float-left" href="BrowseArtists.php">Browse Artists</a>
</div>
    ' ;
    
  echo $ButtonsHTML ;
}

function GetPlaylistsHTML ( )
{
  $Username = $_SESSION [ "Username" ] ;
  $SQL = "
  SELECT *
  FROM USER
  RIGHT JOIN SUBSCRIBE ON USER . Username = SUBSCRIBE . Username
  RIGHT JOIN PLAYLIST ON SUBSCRIBE . PlaylistID = PLAYLIST . PlaylistID
  WHERE USER . Username = '$Username' ; " ;
  
  $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
  
  $PlaylistsHTML = "" ;
  
  $Row = mysqli_fetch_assoc ( $Result ) ;
  while ( $Row != Null )
  {
    $PlaylistID = $Row [ "PlaylistID" ] ;
    
    $PlaylistsHTML = $PlaylistsHTML . '
   <li class="list-group-item">
   <div class="row">
    <div class="col-sm-6 form-group">
    <a href="PlaylistHome.php?PlaylistID=' . $PlaylistID . '" >
      <img id="PlaylistImage" src="' . $Row [ "Thumbnail" ] . '" class="img-rounded" alt="Failure">
      </a>
      </div>
      <div class="col-sm-6 form-group">
      <a href="PlaylistHome.php?PlaylistID=' . $PlaylistID . '">
      <h3>' . $Row [ "Name" ] . '</h3>
      </a>
      </div>
      </div>
    </li>
   ' ;
   $Row = mysqli_fetch_assoc ( $Result ) ;
  }
  
  return $PlaylistsHTML ;
}

function OutputUserHomePlaylists ( )
{
  $UserHomePlaylistsHTML = "" ;
  $UserHomePlaylistsHTML= $UserHomePlaylistsHTML . '
  <div class="container-fluid">
  <ul class="list-group">
  ' ;
  $PlaylistListHTML = GetPlaylistsHTML ( ) ;
  $UserHomePlaylistsHTML = $UserHomePlaylistsHTML . $PlaylistListHTML ;
  $UserHomePlaylistsHTML= $UserHomePlaylistsHTML . "
  </ul>
  </div>
  " ;
  echo $UserHomePlaylistsHTML ;
}
?>