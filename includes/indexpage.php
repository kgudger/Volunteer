<?php
/**
* @file indexpage.php
* Purpose: Home Page and Sign In 
* Extends MainPage Class
*
* @author Keith Gudger
* @version 2.1 5/1/14
*
* @note Has processData and showContent, 
* main and checkForm in MainPage class not overwritten.
* CIS-165PH Final project
*/

require_once("includes/mainpage.php");

/**
 * Child class of MainPage used for index page.
 *
 * Implements processData and showContent
 */
class indexPage extends MainPage {

/**
 * Process the data and insert / modify database.
 *
 * @param $uid is user id passed by reference.
 */
function processData(&$uid) {
	$email = $this->formL->getValue("email");
	$pword = $this->formL->getValue("pword");
/**	password_hash() creates a new password hash using a strong 
 * 	one-way hashing algorithm.  Unfortunately it's not supported
 *	for PHP < 5.5, so I'm using crypt with bcrypt and get the 
 *	same results.
 */
	$salt = md5($email);
/*	$options = array('salt' => $salt);
	$phash = password_hash($pword,PASSWORD_BCRYPT,$options);
*/
	$salt = sprintf('$2a$%02d$', 10) . $salt ;
	$phash = crypt($pword,$salt);

    // Process the verified data here.
	$sql = "SELECT VID, FName FROM 
			Volunteers WHERE 
			(email = ?) && (PHash = ?)";
	$stmt = $this->db->prepare($sql);
	$stmt->execute(array($email, $phash));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if (!empty($row)) {
		if (!session_id()) session_start();
		$uid=$row["VID"];
		$_SESSION['user']=$row["FName"];
		$namev = $row['FName'];
		$_SESSION['np']="no";
		$this->sessnp = "no" ;
		$_SESSION["rid"] = setReadID($uid) ; // encrypts uid
					// and returns real random number
		$_SESSION["uid"] = $uid ; // puts encrypted uid in session
	} else {
		$sql = "SELECT NPID, Name FROM 
				NonProfits WHERE 
				(email = ?) && (PHash = ?)";
		$stmt = $this->db->prepare($sql);
		$stmt->execute(array($email, $phash));

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if (!empty($row)) {
			if (!session_id()) session_start();
			$uid=$row["NPID"];
			$_SESSION['np']="yes";
			$this->sessnp = "yes" ;
			$_SESSION['user']=$row["Name"];
			$_SESSION["rid"] = setReadID($uid) ; // encrypts uid
						// and returns real random number
			$_SESSION["uid"] = $uid ; // encrypted uid in session
		} else {
		$msg = "Invalid Log In - Please try again.";
		$this->formL->addError("pword", $pword, $msg);
		}	
	}
}

/**
 * Display the content of the page.
 *
 * @param $title is page title.
 * @param $uid is user id passed by reference.
 */
function showContent($title, &$uid) {
?>

		<div class="summary" id="vn-summary" role="article">
			<p>There are thousands of non-profits all over the U.S. that are looking for volunteers every day. Can't dedicate hours every week to volunteer with one or two organizations?  You found the solution! Sign up here for short-term volunteer opportunities.  We'll let you know by email those opportunities that meet your profile requests.  Sign up and help out those in need in your community. </p>
			<p>Is your non-profit looking for short-term volunteers?  Tell us about your needs and we'll send great volunteers to help you! </p>
		</div>
<br>
		<div class="participation" id="vn-participation" role="article">
			<h3>How It Works.</h3>
			<p>Non-profits often have "one time" or short-term volunteer needs.  Larger non-profits have a group of helpers who are happy to come in occassionally to help out.  Smaller non-profits have a harder time filling short term needs.</p><p>This web app fills that need by signing up volunteers who are specifically looking for short-term assignments.</p>
<p>People who are looking for short term volunteer opportunities sign up on this web site and specify which type of jobs they would like.  As non-profits ask for short-term help, these volunteers get emails telling them about the opportunities.  By clicking on the link in the email, they return to this web site and accept the assignment (if still available.)  The non-profit contact receives an email with the volunteer's information, and the job gets done!</p><ul><li>Volunteers get jobs they like</li><li>Non-profits get the help they need</li><li>Everyone wins!</li></ul>		

</div>
	<aside class="sidebar" role="complementary">
		<div class="loginform">
		<h3>Sign In</h3><br>
	<?php
		echo $this->formL->reportErrors();
		echo $this->formL->start('POST', "", 'name="volunteer"');
		echo "<p>" . $this->formL->formatOnError('email','email') . 
			"</p>"; 
	?>
		<p> <?php	echo $this->formL->makeTextInput('email');?> </p>
		<p> <?php 
		echo "<p>" . $this->formL->formatOnError('pword','password') . "</p>";
		echo "<p>" . $this->formL->makePassword('pword');?>
		</p>
		<br>
		<p id="formbuttons">
		<input class="subbutton" type="submit" name="Submit" value="LogIn">
		</form>
		</p><br><br><br>
		<h3>Or Sign Up!</h3>
		<p id="formbuttons">
		<a id="signup" href="register.php" 
			title="Sign Up Button">
			<button class="loginbutton">Sign Up!</button> </a>
		</p>

		</div>
	</aside>
	</section>
<?php
		$this->formL->finish();
	}
}
?>
