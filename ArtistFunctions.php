<?php

include_once 'DatabaseFunctions.php' ;

function DoArtistCredentialsExists ( )
{
  $DoExists = False ;
  if ( isset ( $_SESSION [ "ArtistName" ] ) )
  {
    if ( isset ( $_SESSION [ "Password" ] ) )
    {
      $DoExists = True ;
    }
  }
  return $DoExists ;
}

function IsArtistInTable ( $ArtistName , $Password )
{
  $IsArtistInTable = False ;
  $SQL = "SELECT * FROM ARTIST WHERE ArtistName = '$ArtistName' 
AND Password = '$Password'" ;
  $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
  $NumberRows = GetNumberRowsInResults ( $Result ) ;
  if ( $NumberRows > 0 )
  {
    $IsArtistInTable = True ;
  }
  return $IsArtistInTable ;
}

function IsArtistLoggedIn ( )
{
  $IsLoggedIn = False ;
  
  if ( DoArtistCredentialsExists ( ) == True )
  {
    $AttemptArtistName = $_SESSION [ "ArtistName" ] ;
    $AttemptPassword = $_SESSION [ "Password" ] ;
    if ( IsArtistInTable ( $AttemptArtistName , $AttemptPassword ) == True )
    {
      $IsLoggedIn = True ;
    }
  }
  
  return $IsLoggedIn ;
}

function GetArtistTotalPlays ( $ArtistName )
{
    $SQL = "
SELECT SUM( COALESCE( SONG . NumberPlays , 0 ) ) AS ArtistTotalPlays
FROM ARTIST
LEFT JOIN OWNS ON ARTIST . ArtistName = OWNS . ArtistName
LEFT JOIN ALBUM ON OWNS . AlbumID = ALBUM . AlbumID
LEFT JOIN BELONG_TO ON ALBUM . AlbumID = BELONG_TO . AlbumID
LEFT JOIN SONG ON BELONG_TO . SongID = SONG . SongID
WHERE ARTIST . ArtistName = '" . $ArtistName . "' " ;

$Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;

$FirstRow = mysqli_fetch_assoc ( $Result ) ;

$TotalPlays = $FirstRow [ "ArtistTotalPlays" ] ;

return $TotalPlays ;

}

function GetArtistRankFromPlays ( $InArtistTotalPlays )
{
      $SQL = "
SELECT COUNT( PLAY_TOTALS . ThisArtistName ) AS ArtistMorePlays
FROM (
  SELECT ARTIST . ArtistName AS ThisArtistName ,
  SUM( COALESCE( SONG . NumberPlays , 0 ) ) AS ArtistTotalPlays
  FROM ARTIST
  LEFT JOIN OWNS ON ARTIST . ArtistName = OWNS . ArtistName
  LEFT JOIN ALBUM ON OWNS . AlbumID = ALBUM . AlbumID
  LEFT JOIN BELONG_TO ON ALBUM . AlbumID = BELONG_TO . AlbumID
  LEFT JOIN SONG ON BELONG_TO . SongID = SONG . SongID
  GROUP BY ARTIST . ArtistName
) AS PLAY_TOTALS
WHERE ArtistTotalPlays > " . $InArtistTotalPlays . "" ;

$Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;

$FirstRow = mysqli_fetch_assoc ( $Result ) ;

$Rank = $FirstRow [ "ArtistMorePlays" ] + 1 ;

return $Rank ;
}

function GetArtistRank ( $ArtistName )
{
  $ArtistTotalPlays = GetArtistTotalPlays ( $ArtistName ) ;
  $Rank = GetArtistRankFromPlays ( $ArtistTotalPlays ) ;
  return $Rank ;
}

?>