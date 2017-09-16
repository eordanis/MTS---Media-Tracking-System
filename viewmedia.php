<?php
// This script retrieves the records from the logged in user from the loan table.
session_start(); // Access the existing session.
require ('mysqli_connect.php');


$userID=$_SESSION['userID'];
$firstname=$_SESSION['firstname'];
$lastname=$_SESSION['lastname'];
echo "<p id='currname'>Hello $firstname, $lastname. <p id='currname2'>If this is not you, please logout and log back in</p></p>";
include ('header.html');

$page_title = 'Media List';

echo '<p></p><p><h1>View Your Media List</h1></p>';


// Number of records to show per page:
$display = 10;

// Determine how many pages there are...
if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.
	$pages = $_GET['p'];
} else { // Need to determine.
 	// Count the number of records:
	$q = "SELECT COUNT(userID) FROM media";
	$r = @mysqli_query ($dbc, $q);
	$row = @mysqli_fetch_array ($r, MYSQLI_NUM);
	$records = $row[0];
	// Calculate the number of pages...
	if ($records > $display) { // More than 1 page.
		$pages = ceil ($records/$display);
	} else {
		$pages = 1;
	}
} // End of p IF.

// Determine where in the database to start returning results...
if (isset($_GET['s']) && is_numeric($_GET['s'])) {
	$start = $_GET['s'];
} else {
	$start = 0;
}


// Determine the sort...
// Default is by title
$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 't';

// Determine the sorting order:
switch ($sort) {
	case 'dl':
		$order_by = 'dlastname ASC';
		break;
	case 'pubyr':
		$order_by = 'pubyr ASC';
		break;
	case 't':
		$order_by = 'title ASC';
		break;
	case 'g':
		$order_by = 'genre ASC';
		break;
	case 'mt':
		$order_by = 'mType ASC';
		break;
	default:
		$order_by = 'title ASC';
		$sort = 't';
		break;
}


// Define the query:
$q = "SELECT * FROM media WHERE userID='$userID' ORDER BY $order_by LIMIT $start, $display";		
$result = @mysqli_query ($dbc, $q); // Run the query.
if($result){


// Table header:
echo '<table align="center" cellspacing="10" cellpadding="5" width="100%">
<tr>
	<td align="left"><b>Details</b></td>
	<td align="left"><b><a href="viewmedia.php?sort=t">Title</a></b></td>
	<td align="left"><b><a href="viewmedia.php?sort=dl">Director Name</a></b></td>
	<td align="left"><b><a href="viewmedia.php?sort=pubyr">Year Made</a></b></td>
	<td align="left"><b><a href="viewmedia.php?sort=g">Genre</a></b></td>
	<td align="left"><b><a href="viewmedia.php?sort=mt">Media Type</a></b></td>
	<td align="left"><b>Media Time Duration</b></td>
	<td align="left"><b>Delete</b></td>
</tr>
';

// Fetch and print all the records....
while ($rowz = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
$q = "SELECT * FROM media WHERE mediaID='$rowz[mediaID]'";		
$r = @mysqli_query ($dbc, $q); // Run the query.
if($r){
$bg = '#eeeeee'; 
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee');
		echo '<tr bgcolor="' . $bg . '">
		<td align="left"><a href="mediadetails.php?id=' . $row['mediaID'] . '">Details </a></td>
		<td align="left">' . $row['title'] . '</td>
		<td align="left">' . $row['dlastname'] .', '. $row['dfirstname'] .'</td>
		<td align="left">' . $row['pubyr'] . '</td>
		<td align="left">' . $row['genre'] . '</td>
		<td align="left">' . $row['mType'] . '</td>
		<td align="left">' . $row['mdhrs'].':'.$row['mdmin'].'</td>
		<td align="left"><a href="deletemedia.php?id='.$row['mediaID'].'"> Delete </a></td>
	</tr>
	';
} // End of WHILE loop.
}
}//end mediaID while loop
echo '</table>';

}//end if $result is not empty

mysqli_free_result ($r);
mysqli_close($dbc);


// Make the links to other pages, if necessary.
if ($pages > 1) {
	
	echo '<br /><p>';
	$current_page = ($start/$display) + 1;
	
	// If it's not the first page, make a Previous button:
	if ($current_page != 1) {
		echo '<a href="viewmedia.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '">Previous</a> ';
	}
	
	// Make all the numbered pages:
	for ($i = 1; $i <= $pages; $i++) {
		if ($i != $current_page) {
			echo '<a href="viewmedia.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
		} else {
			echo $i . ' ';
		}
	} // End of FOR loop.
	
	// If it's not the last page, make a Next button:
	if ($current_page != $pages) {
		echo '<a href="viewmedia.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">Next</a>';
	}
	
	echo '</p>'; // Close the paragraph.
	
} // End of links section.
	

include ('footer.html');
?>