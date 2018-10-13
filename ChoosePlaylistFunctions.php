<?php
include_once 'UserFunctions.php' ;
include_once 'DatabaseFunctions.php' ;
include_once 'WebpageFunctions.php' ;

function OutputChoosePlaylistPageBody ( )
{
  if ( IsUserLoggedIn ( ) == True )
  {
    OutputChoosePlaylistsLists ( ) ;
  }
  else
  {
    Alert ( "You are not logged in." ) ;
    print_r ( $_SESSION ) ;
  }
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
  
  $SongID = $_GET [ "SongID" ] ;
  
  $Row = mysqli_fetch_assoc ( $Result ) ;
  while ( $Row != Null )
  {
    $PlaylistID = $Row [ "PlaylistID" ] ;
    
    $PlaylistsHTML = $PlaylistsHTML . '
   <li class="list-group-item">
   <div class="row">
    <div class="col-sm-6 form-group">
    <a href="AddSongToPlaylist.php?PlaylistID=' . $PlaylistID . '&SongID=' . $SongID . '" >
      <img id="PlaylistImage" src="' . $Row [ "Thumbnail" ] . '" class="img-rounded" alt="Failure">
      </a>
      </div>
      <div class="col-sm-6 form-group">
      <a href="AddSongToPlaylist.php?PlaylistID=' . $PlaylistID . '&SongID=' . $SongID . '">
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

function OutputChoosePlaylistsLists ( )
{
  $ChoosePlaylistsHTML = "" ;
  $ChoosePlaylistsHTML= $ChoosePlaylistsHTML . '
  <div class="container-fluid">
  <ul class="list-group">
  ' ;
  $PlaylistListHTML = GetPlaylistsHTML ( ) ;
  $ChoosePlaylistsHTML = $ChoosePlaylistsHTML . $PlaylistListHTML ;
  $ChoosePlaylistsHTML= $ChoosePlaylistsHTML . "
  </ul>
  </div>
  " ;
  echo $ChoosePlaylistsHTML ;
}
?>