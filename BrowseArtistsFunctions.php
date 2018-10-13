<?php
include_once 'ArtistFunctions.php' ;
include_once 'DatabaseFunctions.php' ;
include_once 'WebpageFunctions.php' ;

function OutputBrowseArtistsPageBody ( )
{
  if ( IsUserLoggedIn ( ) == True )
  {
    OutputArtistHomeTop ( ) ;
    OutputArtistsListHTML ( ) ;
  }
  else
  {
    Alert ( "You are not logged in." ) ;
    header ( "Location:index.php" ) ;
    exit ( ) ;
  }
}

function OutputArtistHomeTop ( )
{
  $ArtistHomeHTML = '
  <div class="jumbotron text-center">
  <h1>Browse Artists by rank</h1> 
  </div>' ;

  echo $ArtistHomeHTML ;
}

function ComparePlays($a, $b)
{
  return $a [ "NumberPlays" ] < $b [ "NumberPlays" ] ;
}

function GetAlbumsHTML ( )
{
  $SQL = "
  SELECT ArtistName
  FROM ARTIST ;" ;
  
  $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
  
  $ArtistStats = array ( ) ;
  
  $Row = mysqli_fetch_assoc ( $Result ) ;
  $Count = 0 ;
  while ( $Row != Null )
  {
    $Row [ "NumberPlays" ] = GetArtistTotalPlays ( $Row [ "ArtistName" ] ) ;
    $ArtistStats [ ] = $Row ;
    $Count = $Count + 1 ;
    $Row = mysqli_fetch_assoc ( $Result ) ;
  }
  
  usort ( $ArtistStats , 'ComparePlays' ) ;
  
  $ArtistsHTML = "" ;
  $Count = 0 ;
  while ( $Count < count ( $ArtistStats ) )
  {
    $ArtistName = $ArtistStats [ $Count ] [ "ArtistName" ] ;
    $Plays = $ArtistStats [ $Count ] [ "NumberPlays" ] ;
    $Rank = GetArtistRankFromPlays ( $Plays ) ;
    
    $ArtistsHTML = $ArtistsHTML . '
   <li class="list-group-item">
   <div class="row">
      <div class="col-sm-6 form-group">
      <a href="ViewAlbums.php?ArtistName=' . $ArtistName . '">
      <h3>' . $ArtistName . '</h3>
      </a>
      <p>Rank: ' . $Rank . '</p>
      <p>Total Song Plays: ' . $Plays . '</p>
      </div>
      </div>
    </li>
   ' ;
   $Row = mysqli_fetch_assoc ( $Result ) ;
   $Count = $Count + 1 ;
  }
  
  return $ArtistsHTML ;
}

function OutputArtistsListHTML ( )
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