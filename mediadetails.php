<?php
// This script retrieves details pretaining to a specific media
session_start(); // Access the existing session.
require ('mysqli_connect.php');

$page_title = 'Media Information';
$userID=$_SESSION['userID'];
$mediaID = $_GET['id'];

$firstname=$_SESSION['firstname'];
$lastname=$_SESSION['lastname'];
echo "<p id='currname'>Hello $firstname, $lastname. <p id='currname2'>If this is not you, please logout and log back in</p></p>";

include ('header.html');

echo '<p></p><p><h1>View Media Details</h1></p>';


// Define the query:
$q ="SELECT * FROM media WHERE mediaID='$mediaID'";		
$r = @mysqli_query ($dbc, $q); // Run the query.

// Table header:

echo '<table align="center" cellspacing="10" cellpadding="5" width="100%">';
// Fetch and print all the records....
$bg = '#eeeeee'; 
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee');
		echo '<tr bgcolor="' . $bg . '">
<tr bgcolor="#eeeeee"><td align="left"><b>Title:</b></td><td align="left">' . $row['title'] . '</td></tr>
<tr bgcolor="#ffffff"><td align="left"><b>Director First Name:</b><td align="left">' . $row['dfirstname'] . '</td></tr>
<tr bgcolor="#eeeeee"><td align="left"><b>Director Last Name:</b><td align="left">' . $row['dlastname'] . '</td></tr>
<tr bgcolor="#ffffff"><td align="left"><b>Year Made:</b></td><td align="left">' . $row['pubyr'] . '</td></tr>
<tr bgcolor="#eeeeee"><td align="left"><b>Genre:</b></td><td align="left">' . $row['genre'] . '</td></tr>
<tr bgcolor="#ffffff"><td align="left"><b>Quantity:</b></td><td align="left">' . $row['quantity'] . '</td></tr>
<tr bgcolor="#eeeeee"><td align="left"><b>Media Type:</b></td><td align="left">' . $row['mType'] . '</td></tr>
<tr bgcolor="#ffffff"><td align="left"><b>Location:</b></td><td align="left">' . $row['location'] . '</td></tr>
<tr bgcolor="#eeeeee"><td align="left"><b>Media Time Duration:</b></td><td align="left">' . $row['mdhrs'] .  ':'.$row['mdmin'] . '</td></tr>

	';
} // End of WHILE loop.

echo '</table>';
mysqli_free_result ($r);
mysqli_close($dbc);
include ('footer.html');
?>