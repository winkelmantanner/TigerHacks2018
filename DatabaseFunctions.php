<?php
const SERVER_NAME = "localhost" ;
const USER_NAME = "root" ;
const PASS_WORD = "" ;
const DATABASE_NAME = "CS2300ProjectDB" ;

function RunSQL ( $Connection , $SQL )
{
    $Result = mysqli_query( $Connection , $SQL ) ;
    echo mysqli_error ( $Connection ) ;
    return $Result ;
}

function GetLargestValueInTable ( $TableName , $ColumnName )
{
  $SQL = "
  SELECT MAX($ColumnName) AS OutputMaxValue
FROM $TableName; " ;
  
  $Result = RunSQLAgainstDefaultDatabase ( $SQL ) ;
  
  $FirstRow = mysqli_fetch_assoc ( $Result ) ;
  
  $LargestValue = $FirstRow [ "OutputMaxValue" ] ;
  
  return $LargestValue ;
}

function CreateConnectionToServer ( $Server , $User, $Password )
{
    $Connection = mysqli_connect( $Server , $User , $Password ) ;
    return $Connection ;
}

function CreateConnectionToDatabase ( $Server , $User, $Password , $Database )
{
    $Connection = mysqli_connect ( $Server , $User , $Password , $Database ) ;
    return $Connection ;
}

function CreateDefaultConnectionToServer ( )
{
    $Connection = mysqli_connect( SERVER_NAME , USER_NAME , PASS_WORD ) ;
    return $Connection ;
}

function CreateDefaultConnectionToDatabase ( )
{
    $Connection = mysqli_connect ( SERVER_NAME , USER_NAME , PASS_WORD , DATABASE_NAME ) ;
    return $Connection ;
}

function CloseConnectionToServer ( $ServerConnection )
{
    mysqli_close ( $ServerConnection ) ;
}

function CloseConnectionToDatabase ( $Connection )
{
    mysqli_close ( $Connection ) ;
}

function RunSQLAgainstDefaultDatabase ( $SQL )
{
    $Connection = CreateDefaultConnectionToDatabase ( ) ;
    $Result = RunSQL ( $Connection , $SQL ) ;
    CloseConnectionToDatabase ( $Connection ) ;
    return $Result ;
}

function GetNumberRowsInResults ( $Result )
{
    $NumberRows = mysqli_num_rows ( $Result ) ;
    return $NumberRows ;
}

?>