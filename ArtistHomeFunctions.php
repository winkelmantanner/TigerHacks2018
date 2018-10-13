<?php
include_once 'ArtistFunctions.php' ;
include_once 'AlbumFunctions.php' ;
include_once 'DatabaseFunctions.php' ;
include_once 'WebpageFunctions.php' ;

function OutputArtistHomePageBody ( )
{
  if ( IsArtistLoggedIn ( ) == True )
  {
    OutputArtistHomeTop ( ) ;
    OutputArtistCreateAlbumButton ( ) ;
    OutputArtistHomeAlbums ( ) ;
  }
  else
  {
    Alert ( "You are not logged in." ) ;
    header ( "Location:index.php" ) ;
    exit ;
  }
}

function OutputArtistHomeTop ( )
{
  $ArtistName = $_SESSION [ 'ArtistName' ] ;
  $Password = $_SESSION [ 'Password' ] ;
  $TotalPlays = GetArtistTotalPlays ( $ArtistName ) ;
  $Rank = GetArtistRankFromPlays ( $TotalPlays ) ;
  $ArtistHomeHTML = '
  <div class="jumbotron text-center">
  <h1>Wecome, ' . $ArtistName . '</h1> 
  <p>You are rank ' . $Rank . '</p> 
  <p>You have ' . $TotalPlays . ' total song plays</p> 
  </div>' ;

  echo $ArtistHomeHTML ;
}

function OutputArtistCreateAlbumButton ( )
{
  $CreateAlbumButtonHTML = '<div class="container-fluid text-center">
  <div class="col-sm-4 form-group">
<a class="btn btn-primary float-right" href="AlbumCreate.php">Create Album</a>
</div>
  <div class="col-sm-4 form-group">
  <a class="btn btn-primary float-right" href="ArtistDelete.php">Delete Artist (you)</a>
  </div>
  <div class="col-sm-4 form-group">
  <a class="btn btn-primary float-right" href="ArtistModify.php">Modify Artist (you)</a>
  </div>
</div>
    ' ;
    
  echo $CreateAlbumButtonHTML ;
}

function GetAlbumsHTML ( )
{
  $ArtistName = $_SESSION [ "ArtistName" ] ;
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
    <a href="AlbumHome.php?AlbumID=' . $AlbumID . '" >
      <img id="AlbumImage" src="' . $Row [ "CoverArt" ] . '" class="img-rounded" alt="Failure">
      </a>
      </div>
      <div class="col-sm-6 form-group">
      <a href="AlbumHome.php?AlbumID=' . $AlbumID . '">
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

function OutputArtistHomeAlbums ( )
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
/*
$ArtistHomeAlbumsHTML = '
<div id="ArtistHomeAlbums" class="container-fluid">
  <div class="container">
  <h2 class="text-center">Your Albums</h2>

  <div class="row">
    <div class="col-md-4">
      <p>Fan? Drop a note.</p>
      <p><span class="glyphicon glyphicon-map-marker"></span>Chicago, US</p>
      <p><span class="glyphicon glyphicon-phone"></span>Phone: +00 1515151515</p>
      <p><span class="glyphicon glyphicon-envelope"></span>Email: mail@mail.com</p>
    </div>
    <div class="col-md-8">
      <div class="row">
        <div class="col-sm-6 form-group">
          <input class="form-control" id="name" name="name" placeholder="Name" type="text" required>
        </div>
        <div class="col-sm-6 form-group">
          <input class="form-control" id="email" name="email" placeholder="Email" type="email" required>
        </div>
      </div>
      <textarea class="form-control" id="comments" name="comments" placeholder="Comment" rows="5"></textarea>
      <br>
      <div class="row">
        <div class="col-md-12 form-group">
          <button class="btn pull-right" type="submit">Send</button>
        </div>
      </div>
    </div>
  </div>
  <br>
  <h3 class="text-center">From The Blog</h3>  
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Mike</a></li>
    <li><a data-toggle="tab" href="#menu1">Chandler</a></li>
    <li><a data-toggle="tab" href="#menu2">Peter</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <h2>Mike Ross, Manager</h2>
      <p>Man, we\'ve been on the road for some time now. Looking forward to lorem ipsum.</p>
    </div>
    <div id="menu1" class="tab-pane fade">
      <h2>Chandler Bing, Guitarist</h2>
      <p>Always a pleasure people! Hope you enjoyed it as much as I did. Could I BE.. any more pleased?</p>
    </div>
    <div id="menu2" class="tab-pane fade">
      <h2>Peter Griffin, Bass player</h2>
      <p>I mean, sometimes I enjoy the show, but other times I enjoy other things.</p>
    </div>
  </div>
  </div>
</div> ' ;
*/
  echo $ArtistHomeAlbumsHTML ;
}
?>