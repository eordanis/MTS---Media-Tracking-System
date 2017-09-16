<?php 
// This script performs an INSERT query to add a record to the media table.
$page_title = 'Add Media';

session_start(); // Access the existing session.
$firstname=$_SESSION['firstname'];
$lastname=$_SESSION['lastname'];

echo "<br><p id='currname'>Hello $firstname, $lastname. <p id='currname2'>If this is not you, please logout and log back in</p></p>";
include ('header.html');
// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require ('mysqli_connect.php'); // Connect to the db.
		
	$errors = array(); // Initialize an error array.
	
	// Check for a title:
	if (empty($_POST['title'])) {
		$errors[] = 'You forgot to enter the title.';
	} else {
		$title = mysqli_real_escape_string($dbc, trim($_POST['title']));
	}
	
	// Check for a media type:
	if (empty($_POST['mType'])) {
		$errors[] = 'You forgot select a media Type.';
	} else {
		$mType = mysqli_real_escape_string($dbc, trim($_POST['mType']));
	}

	// Check for an year:
	if (empty($_POST['pubyr'])) {
		$errors[] = 'You forgot to enter the year.';
	} else {
		$pubyr = mysqli_real_escape_string($dbc, trim($_POST['pubyr']));
	}

	// Check for a genre:
	if (empty($_POST['genre'])) {
		$errors[] = 'You forgot to select a genre.';
	} else {
   					
   		 //if(isset($_POST['genre'])){
       // $genre = $_POST['genre'];
   		// }
       	// assign each post value to variable array
	for($i=0;$i<count($_POST["genre"]);$i++)  {
  		$genre[$i]=$_POST["genre"][$i];
		}
    $genreC= implode(", ", $genre);
	}		
   	
		$dfirstname = mysqli_real_escape_string($dbc, trim($_POST['dfirstname']));
		$dlastname = mysqli_real_escape_string($dbc, trim($_POST['dlastname']));
		$quantity = mysqli_real_escape_string($dbc, trim($_POST['quantity']));
		$location = mysqli_real_escape_string($dbc, trim($_POST['location']));
		$mdhrs = mysqli_real_escape_string($dbc, trim($_POST['mdhrs']));
		$mdmin = mysqli_real_escape_string($dbc, trim($_POST['mdmin']));

	if (empty($errors)) { // If everything's OK.
	
		// Register the user in the database...
		$userID=$_SESSION['userID'];
		// Make the query:
		$q = "INSERT INTO media (userID, mType, title, dfirstname, dlastname, pubyr, quantity, genre, location, mdhrs, mdmin) VALUES ( '$userID', '$mType',  '$title', '$dfirstname', '$dlastname', '$pubyr', '$quantity', '$genreC', '$location', '$mdhrs', '$mdmin')";
		$r = @mysqli_query ($dbc, $q); // Run the query.
		if ($r) { // If it ran OK.
		
			// Print a message:
			echo '<br><h1>Thank you!</h1>
		<p>You now added a new media to your collection.</p><p><br /></p>';	
		
		} else { // If it did not run OK.
			
			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">Media could not be added due to a system error. We apologize for any inconvenience.</p>'; 
			
			// Debugging message:
			echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';

  				echo "$genreC";

    
				
		} // End of if ($r) IF.
		
		mysqli_close($dbc); // Close the database connection.

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
<p></p><p><h1>Add Media</h1></p>
<form action="addmedia.php" method="post">
	<p><b>Select Media Type:</b>
			<select name="mType" required="required" >
					<option selected value="">---Please Select a Media Type---</option>
 		 <option value="DVD">DVD</option>
  		<option value="Blueray">Blueray</option>
  		<option value="VHS">VHS</option>
  		<option value="Recorded">Recorded</option>
</select></p>
	<p><b>Media Title:</b> <input type="text" placeholder="eg. Boxtrolls " name="title" size="30" maxlength="60" required="required" value="<?php if (isset($_POST['title'])) echo $_POST['title']; ?>" /></p>
	<p><b>Director First Name:</b> <input type="text" pattern="^[A-Za-z]{1,49}$"placeholder="eg. Steven" name="dfirstname" size="15" maxlength="30"  value="<?php if (isset($_POST['dfirstname'])) echo $_POST['dfirstname']; ?>" /></p>
	<p><b>Director Last Name:</b> <input type="text" pattern="^[A-Za-z]{1,49}$" placeholder="eg. Spielburg" name="dlastname" size="15" maxlength="30"  value="<?php if (isset($_POST['dlastname'])) echo $_POST['dlastname']; ?>" /></p>
	<p><b>Year Made:</b> <input type="text" pattern="^[0-9]{4}$"placeholder="1998" name="pubyr" size="4" maxlength="4"  required="required" value="<?php if (isset($_POST['pubyr'])) echo $_POST['pubyr']; ?>" /></p>
	<p><b>Quantity:</b> <input type="text" pattern="^[0-9]{1,2}$" placeholder="eg. 2" name="quantity" size="2" maxlength="2"  value="<?php if (isset($_POST['quantity'])) echo $_POST['quantity']; ?>"  /> </p>
	<p><b>Genre: (check all that apply)</b></p>
	<p><input type="checkbox" name="genre[]" value="Action" />&nbsp&nbsp&nbsp&nbspAction&nbsp&nbsp&nbsp&nbsp<input type="checkbox" name="genre[]" value="Adventure" />&nbsp&nbsp&nbsp&nbspAdventure&nbsp&nbsp&nbsp&nbsp
	<input type="checkbox" name="genre[]" value="Anime" />&nbsp&nbsp&nbsp&nbspAnime&nbsp&nbsp&nbsp&nbsp<input type="checkbox" name="genre[]" value="Cartoon" />&nbsp&nbsp&nbsp&nbspCartoon&nbsp&nbsp&nbsp&nbsp
	<input type="checkbox" name="genre[]" value="Comedy" />&nbsp&nbsp&nbsp&nbspComedy&nbsp&nbsp&nbsp&nbsp<input type="checkbox" name="genre[]" value="Documentary" />&nbsp&nbsp&nbsp&nbspDocumentary&nbsp&nbsp&nbsp&nbsp
	<input type="checkbox" name="genre[]" value="Drama" />&nbsp&nbsp&nbsp&nbspDrama&nbsp&nbsp&nbsp&nbsp</p><p><input type="checkbox" name="genre[]" value="Family" />&nbsp&nbsp&nbsp&nbspFamily&nbsp&nbsp&nbsp&nbsp
	<input type="checkbox" name="genre[]" value="Fantasy" />&nbsp&nbsp&nbsp&nbspFantasy&nbsp&nbsp&nbsp&nbsp<input type="checkbox" name="genre[]" value="Foreign" />&nbsp&nbsp&nbsp&nbspForeign&nbsp&nbsp&nbsp&nbsp
	<input type="checkbox" name="genre[]" value="Horror" />&nbsp&nbsp&nbsp&nbspHorror&nbsp&nbsp&nbsp&nbsp<input type="checkbox" name="genre[]" value="Musical" />&nbsp&nbsp&nbsp&nbspMusical&nbsp&nbsp&nbsp&nbsp
	<input type="checkbox" name="genre[]" value="Sci-Fi" />&nbsp&nbsp&nbsp&nbspSci-Fi&nbsp&nbsp&nbsp&nbsp<input type="checkbox" name="genre[]" value="Sports" />&nbsp&nbsp&nbsp&nbspSports&nbsp&nbsp&nbsp&nbsp
	<input type="checkbox" name="genre[]" value="Television Series" />&nbsp&nbsp&nbsp&nbspTV<br /></p>
	<p><b>Media Location: </b><input type="text"  placeholder="eg. Livingroom 1st DVD Shelf " name="location" size="30" maxlength="50"  value="<?php if (isset($_POST['location'])) echo $_POST['location']; ?>" /></p>
	<p><b>Media Time Duration:</b> <input type="text" pattern="^[0-9]{1,2}$" placeholder="1 " name="mdhrs" size="2" maxlength="2"  value="<?php if (isset($_POST['mdhrs'])) echo $_POST['mdhrs']; ?>" /> Hrs <input type="text" pattern="^[0-9]{1,2}$" placeholder="43" name="mdmin" size="2" maxlength="2"  value="<?php if (isset($_POST['mdmin'])) echo $_POST['mdmin']; ?>" /> Min </p>


	<p><input type="submit" name="submit" value="Add Media" /></p>
</form>
<?php include ('footer.html'); ?>