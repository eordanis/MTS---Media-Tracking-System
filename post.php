<?php 
require ('mysqli_connect.php');
session_start();
 $errors = array(); // Initialize an error array.

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Validate the username
	if (empty($_POST['username'])) {
	$errors[]= "- You forgot to enter your username."; die ;
	} else {
		$u=$_POST['username'];
	}
	
	
	// Validate the password:
	if (empty($_POST['password'])) {
		$errors[]= "- You forgot to enter your password."; die ;
	} else {
		$p=$_POST['password'];
	}
	
}//end form submission

	if ((!empty($u))&&(!empty($p))){
		
		//query database for records matching username and password
		$q = "SELECT * FROM users WHERE username='$u' AND password='$p'";		
		$r = @mysqli_query ($dbc, $q); // Run the query.
		
		// Check the result:
		if (mysqli_num_rows($r) == 1) {
			while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
				$firstname = $row['firstname'];
				$_SESSION['firstname'] = $row['firstname'];
				$lastname = $row['lastname'];
				$_SESSION['lastname'] = $row['lastname'];
				$userID = $row['userID'];
				$_SESSION['userID'] = $row['userID'];
				

					
			}//end fetch results while
						
				//IF USERNAME AND PASSWORD ARE CORRECT SET THE LOG-IN SESSION
				include ('header.html'); 
				echo "<p></p>";
				echo "<p><br>Welcome $firstname , $lastname</b></p>";
				include ('footer.html');
						
		}//end if password and username match
			
			else if (mysqli_num_rows($r) == 0){ //if there are no matches
			     
				
				//check for username match 
				$lq="SELECT username FROM users WHERE username = '$u'";
				$lr=@mysqli_query ($dbc, $lq); // Run the query.
			
				if(mysqli_num_rows($lr)==0){
					$errors[] =  "<br>- The username does not exist on file.</br>"; 	
				}
						//check for username & password match 
						$lpq="SELECT username, password FROM users WHERE username = '$u' AND password != '$p'";
						$lpr=@mysqli_query ($dbc, $lpq); // Run the query.
			
						if(mysqli_num_rows($lpr)==1){
						$errors[] = "<br>- The password does not match what is on file.</br>"; 
						}
				
				// Report the errors.
				include ('lrheader.html');
		echo "<br>";
		echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " $msg";
		}
		echo '</p><p><b>Please try again.</b></p>';
?>	

<br>

		<h2> Welcome to the Electronic Media Tracking System...</h2> 
		<form action= "post.php" method="post">
		<p><br>Username: &nbsp&nbsp<input type="text" name="username" id="username" placeholder="username" required="required"></p>
		<p><br>Password: &nbsp&nbsp<input type="password" name="password" id="password" placeholder="password" required="required">&nbsp&nbsp<input type="submit" value="Submit"></p>
		<p><a href="register.php">Click Here To Register</a></p>
		<br>			
<?php 				
				include ('footer.html');
			}	//end else if there are no matches
																																																																																																																																																
	}//end if $u and $p is not empty
	
mysqli_free_result ($r);
mysqli_close($dbc);
?>