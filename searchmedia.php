<?php 
// This script searches for a book in the database
session_start(); // Access the existing session.
require ('mysqli_connect.php');

$userID=$_SESSION['userID'];
$firstname=$_SESSION['firstname'];
$lastname=$_SESSION['lastname'];


$page_title = 'Search Media List';

echo "<p id='currname'>Hello $firstname, $lastname. <p id='currname2'>If this is not you, please logout and log back in</p></p>";
include('header.html');
// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
	$errors = array(); // Initialize an error array.
	
	// Check for a title:
	if (empty($_POST['search'])) {
		$errors[] = 'You forgot to enter the title.';
	} else {
		$search = mysqli_real_escape_string($dbc, trim($_POST['search']));
	}


	if (empty($errors)) { // If everything's OK.
	



// Define the query:
$q = "SELECT * FROM media WHERE title LIKE '%" . $search . "%' OR dfirstname LIKE '%" . $search . "%' OR dlastname LIKE '%" . $search  ."%' OR mType LIKE '%" . $search . "%' OR genre LIKE '%" . $search . "%'";		
$result = @mysqli_query ($dbc, $q); // Run the query.
if($result){

echo '<p></p><p><h1>Media Search Results</h1></p>';
// Table header:
echo '<table align="center" cellspacing="10" cellpadding="5" width="100%">
<tr>
	<td align="left"><b>Title</b></td>
	<td align="left"><b>Director Name</b></td>
	<td align="left"><b>Year Made</b></td>
	<td align="left"><b>Genre</b></td>
	<td align="left"><b>Media Type</b></td>
	<td align="left"><b>Media Time Duration</b></td>
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
		<td align="left">' . $row['title'] . '</td>
		<td align="left">' . $row['dlastname'] .','. $row['dfirstname'] .'</td>
		<td align="left">' . $row['pubyr'] . '</td>
		<td align="left">' . $row['genre'] . '</td>
		<td align="left">' . $rowz['mType'] . '</td>
		<td align="left">' . $rowz['mdhrs'] .  ':'.$rowz['mdmin'] . '</td>

	</tr>
	';
} // End of WHILE loop.
}
}//end mediaID while loop
echo '</table>';
mysqli_free_result ($r);
mysqli_close($dbc);
		
		} else { // If it did not run OK.
			
			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">Media could not be searched due to a system error. We apologize for any inconvenience.</p>'; 
			
			// Debugging message:
			echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
			mysqli_close($dbc); // Close the database connection.			
		} // End of if ($r) IF.
		
		// Include the footer and quit the script:
		include ('footer.html'); 
		exit();
		
	} else { // Report the errors.
	
		echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p><p><br /></p>';
		
	} // End of if (empty($errors)) IF.
	
	mysqli_close($dbc); // Close the database connection.

} // End of the main Submit conditional.
?>
<p></p><p><h1>Search Your Media List</h1></p>
<form action="searchmedia.php" method="post">
	<p>Search Media: <input type="text" placeholder="title or genre or director name or media type" name="search" size="35" maxlength="60"  value="<?php if (isset($_POST['search'])) echo $_POST['search']; ?>" /> &nbsp&nbsp&nbsp&nbsp<input type="submit" name="submit" value="Search Media" /></p>
</form>
<p></p>
<?php include ('footer.html');?>