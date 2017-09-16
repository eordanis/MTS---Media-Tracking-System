<?php
// This page is for deleting a book record.
// This page is accessed through viewmedia.php.
$page_title = 'Delete Media';


session_start(); // Access the existing session.
$firstname=$_SESSION['firstname'];
$lastname=$_SESSION['lastname'];
echo "<p id='currname'>Hello $firstname, $lastname. <p id='currname2'>If this is not you, please logout and log back in</p></p>";
include ('header.html');

// Check for a media ID, through GET or POST:
if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // From view_books.php
	$id = $_GET['id'];
} elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form submission.
	$id = $_POST['id'];
} else { // No valid ID, kill the script.
	echo '<p class="error">This page has been accessed in error.</p>';
	include ('footer.html'); 
	exit();
}

require ('mysqli_connect.php');
echo '<p></p><p><h1>Delete Media</h1></p>';
// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if ($_POST['sure'] == 'Yes') { // Delete the record.

		// Make the query:
		$q = "DELETE FROM media WHERE mediaID=$id LIMIT 1";		
		$r = @mysqli_query ($dbc, $q);
		if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

			// Print a message:
			echo '<p>The media has been deleted.</p>';	

		} else { // If the query did not run OK.
			echo '<p class="error">The media could not be deleted due to a system error.</p>'; // Public message.
			echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>'; // Debugging message.
		}
	
	} else { // No confirmation of deletion.
		echo '<p>The media has NOT been deleted.</p>';	
	}

} else { // Show the form.

	// Retrieve the media information:
	$q = "SELECT CONCAT(title, '( ', mType ,' - ', pubyr , genre ,')') FROM media WHERE mediaID=$id";
	$r = @mysqli_query ($dbc, $q);

	if (mysqli_num_rows($r) == 1) { // Valid media ID, show the form.

		// Get the media information:
		$row = mysqli_fetch_array ($r, MYSQLI_NUM);
		
		// Display the record being deleted:
		echo "<h3><p>Title: $row[0]</p></h3>";
		
		// Create the form:
		echo '<form action="deletemedia.php" method="post">
			<p>Are you sure you want to delete this media?&nbsp&nbsp<input type="radio" name="sure" value="Yes">&nbsp&nbspYes&nbsp&nbsp<input type="radio" name="sure" value="No" checked="checked">&nbsp&nbspNo&nbsp&nbsp<input type="submit" name="submit" value="Submit" /><input type="hidden" name="id" value="' . $id . '" /></p>
		</form>';
		
		//echo '<form action="deletemedia.php" method="post">
	//<input type="radio" name="sure" value="Yes" /> Yes 
	//<input type="radio" name="sure" value="No" checked="checked" /> No
	//<input type="submit" name="submit" value="Submit" />
	//<input type="hidden" name="id" value="' . $id . '" />
	//</form>';
	
	} else { // Not a valid book ID.
		echo '<p class="error">This page has been accessed in error.</p>';
	}

} // End of the main submission conditional.

mysqli_close($dbc);
		
include ('footer.html');
?>