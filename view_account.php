<?php
// This script retrieves the records from the logged in user from the users table.
session_start(); // Access the existing session.
require ('mysqli_connect.php');
$page_title = 'Account Information';

$userID=$_SESSION['userID'];
$firstname=$_SESSION['firstname'];
$lastname=$_SESSION['lastname'];



echo "<p id='currname'>Hello $firstname, $lastname. <p id='currname2'>If this is not you, please logout and log back in</p>";
include ('header.html');
echo '<p><h1>View Your Account Information</h1></p>';



echo '<p><a href="edit_user.php?id=' . $userID . '">Click Here To Edit Your Account Information</a></p><p></p>';
// Define the query:
$q = "SELECT userID, lastname, firstname, username, email, age, gender, street, city, state, zipCode, DATE_FORMAT(registrationDate, '%M %d, %Y') AS dr FROM users WHERE userID='$userID'";		
$r = @mysqli_query ($dbc, $q); // Run the query.

// Table header:

echo '<table align="center" cellspacing="10" cellpadding="5" width="100%">';
// Fetch and print all the records....
$bg = '#eeeeee'; 
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee');
		echo '<tr bgcolor="' . $bg . '">
<tr bgcolor="#eeeeee"><td align="left"><b>Last Name:</b></td><td align="left">' . $row['lastname'] . '</td></tr>
<tr bgcolor="#ffffff"><td align="left"><b>First Name:</b><td align="left">' . $row['firstname'] . '</td></tr>
<tr bgcolor="#eeeeee"><td align="left"><b>Username:</b></td><td align="left">' . $row['username'] . '</td></tr>
<tr bgcolor="#ffffff"><td align="left"><b>Email:</b></td><td align="left">' . $row['email'] . '</td></tr>
<tr bgcolor="#eeeeee"><td align="left"><b>Age:</b></td><td align="left">' . $row['age'] . '</td></tr>
<tr bgcolor="#ffffff"><td align="left"><b>Gender:</b></td><td align="left">' . $row['gender'] . '</td></tr>
<tr bgcolor="#eeeeee"><td align="left"><b>Address:</b></td><td align="left">' . $row['street'] . ", " .$row['city'] . ", " .  $row['state'] . ", " . $row['zipCode'] .'</td></tr>
<tr bgcolor="#ffffff"><td align="left"><b>Date Registered:</b></td><td align="left">' . $row['dr'] . '</td></tr>
<tr bgcolor="#eeeeee"><td align="left"><b>User ID:</b></td><td align="left">' . $row['userID'] . '</td></tr>

';
} // End of WHILE loop.
echo '</table>';

mysqli_free_result ($r);
mysqli_close($dbc);
include ('footer.html');
?>