<?php
/**
* @file preferrencespage.php
* Purpose: User Preferences Page. 
* Extends MainPage Class
*
* @author Keith Gudger
* @copyright  (c) 2014, Keith Gudger, all rights reserved
* @license    http://opensource.org/licenses/BSD-2-Clause
* @version    Release: 1.0
* @package    Volunteer Now!
*
* @note Has processData and showContent, 
* main and checkForm in MainPage class not overwritten.
* CIS-165PH Final project
*/

require_once("includes/mainpage.php");
require_once "includes/secure.php";
include_once "includes/util.php";

/**
 * Child class of MainPage used for user preferrences page.
 *
 * Implements processData and showContent
 */
class userPrefPage extends MainPage {

/**
 * Process the data and insert / modify database.
 *
 * @param $uid is user id passed by reference.
 */
function processData(&$uid) {
	$fname = $this->formL->getValue("fname");
	$lname = $this->formL->getValue("lname");
	$email = $this->formL->getValue("email");
	$phone = $this->formL->getValue("phone");
	$pword = $this->formL->getValue("pword");
	$prefs = $this->formL->getValue("prefs");
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
	$sql = "UPDATE Volunteers SET 
				LName=?, Fname=?,
				email=?, Phone=?,
				PHash='$phash'
			WHERE VID = '$uid'";
	$result = $this->db->prepare($sql);
	$result->execute(array($lname,$fname,$email,$phone));

    // First I'll delete all the old preferences here.
	$sql = "DELETE FROM VPrefs
			WHERE VID = '$uid'";
	$result = $this->db->prepare($sql);
	$result->execute();

/** Then insert all the new ones here.  I was not deleting
 *	the old one and using "INSERT ... ON DUPLICATE KEY UPDATE"
 *	but I think this is easier (and it removes any preferences
 *	the volunteer has decided they don't want anymore. 
 */
	foreach ($prefs as $pref1) {
		$sql = "INSERT INTO 
				VPrefs(VID, TypeID)
				VALUES ('$uid', ? )";
		$result = $this->db->prepare($sql);
		$result->execute(array($pref1));
	}
}

/**
 * Display the content of the page.
 *
 * @param $title is page title.
 * @param $uid is user id passed by reference.
 */
function showContent($title, &$uid) {

	$sql = "SELECT Lname, Fname, email, Phone FROM  
			Volunteers WHERE VID = '$uid'";
	$result = $this->db->query($sql);

	$row = $result->fetch(PDO::FETCH_ASSOC);
	if ( $row ) {
//		var_dump($row);
		$fname = $row["Fname"];
		$lname = $row["Lname"];
		$email = $row["email"];
		$phone = $row["Phone"];
	}
// Put HTML after the closing PHP tag
?>

<div class="preamble" id="CS165-preamble" role="article">
<h3>Please update your information.</h3><p></p>
<?php
	echo $this->formL->reportErrors();
	echo $this->formL->start('POST', "", 'name="registration"');
?>
<fieldset>
<legend>Please enter your information</legend>
<br>
<table>
<tr>
<td>
<?php echo $this->formL->formatOnError('fname','First Name') . "</td>"; ?>
<td class="inputcell">
<?php echo $this->formL->makeTextInput('fname', $fname);?>
</td>
</tr>
<tr>
<td class="labelcell">
<?php echo$this->formL->formatOnError('lname','Last Name') . "</td>"; ?><td class="inputcell">
<?php echo $this->formL->makeTextInput('lname', $lname);?>
</td>
</tr>

<tr>
<td class="labelcell">
<?php echo $this->formL->formatOnError('email','email') . "</td>"; ?>
<td class="inputcell">
<?php echo $this->formL->makeTextInput('email', $email);?>
</td>
</tr>

<tr>
<td class="labelcell">
<?php echo $this->formL->formatOnError('phone','Phone') . "</td>"; ?>
<td class="inputcell">
<?php echo $this->formL->makeTextInput('phone', $phone);?>
</td>
</tr>

<tr>
<td class="labelcell">
<?php echo $this->formL->formatOnError('pword','Password') . "</td>"; ?>
<td class="inputcell">
<?php echo $this->formL->makePassword('pword');?>
</td>
</tr>

<tr>
<td class="labelcell">
<?php echo $this->formL->formatOnError('prefs','Job Preferences') . "</td>";

	$sql = "SELECT PrefID, Preference FROM 
			JobTypes";
	$result = $this->db->query($sql);
	$sql = "SELECT TypeID FROM VPrefs
			WHERE VID = $uid";
	$res2 = $this->db->query($sql);
	$selectl = array();
	for ($i = 0; $row = $res2->fetch(PDO::FETCH_ASSOC); $i++) {
		$selectl[] .= $row["TypeID"];
	}	//	var_dump($selectl);
    for ($i = 0; $row = $result->fetch(PDO::FETCH_ASSOC); $i++) {
        echo '<td class="inputcell">' ;
		$checkarray = array($row["Preference"]=>$row["PrefID"]);
		echo $this->formL->makeCheckBoxes("prefs", $checkarray,$selectl);
		echo '</td></tr><tr><td></td>';
	}
?>
</tr>
<tr><td>&nbsp</td></tr><tr><td></td><td>
<input class="subbutton" type="submit" name="Submit" value="Submit">
</td></tr>
</table>
</fieldset>

</form>
<a id="Return" href="useraccount.php"
title="Return">
<button class="subbutton">OK-Return</button> </a>
</p>
</div>

<?php
$this->formL->finish();
//mysql_free_result($result);
}
}
?>

