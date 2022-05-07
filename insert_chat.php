<?php

//insert_chat.php
session_start();
include('connexion.php');
function fetch_user_chat_history($from_user_id, $to_user_id, $link)
{
 $query = "
 SELECT * from messages where (id_utilisateur=$from_user_id AND friend=$to_user_id) OR (id_utilisateur=$to_user_id AND friend=$from_user_id) ORDER BY id_message asc
 ";
 $statement=mysqli_query($link,$query);
 $output = '<ul class="list-unstyled">';
while ($row=mysqli_fetch_array($statement))
 {
  $user_name = '';
  if($row['id_utilisateur'] == $from_user_id)
  {
   $user_name = '<b class="text-success">You</b>';
  }
  else
  {
   $user_name = '<b class="text-danger">'.get_user_name($row['id_utilisateur'], $link).'</b>';
  }
  $output .= '
  <li style="border-bottom:1px dotted #ccc">
   <p>'.$user_name.' - '.$row['message'].'
   </p>
  </li>
  ';
 }
 $output .= '</ul>';
 return $output;
}

function get_user_name($user_id, $link)
{
 $query = "SELECT nom FROM utilisateur WHERE id_utilisateur = '$user_id'";
 $statement=mysqli_query($link,$query);
 while ($row=mysqli_fetch_array($statement))
 {
  return $row['nom'];
 }
}

include('connexion.php');

$friend=$_POST['to_user_id'];
$id_utilisateur=$_SESSION['id'];
$message=$_POST['chat_message'];


$query = "
INSERT INTO messages (id_utilisateur, friend, message) 
VALUES ('$id_utilisateur', '$friend', '$message')
";

$statement =mysqli_query($link,$query);

 echo fetch_user_chat_history($_SESSION['id'], $_POST['to_user_id'], $link);


?>