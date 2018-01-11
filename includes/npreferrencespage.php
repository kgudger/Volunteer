<?php
/**
* @file npreferrencespage.php
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
* @note CIS-165PH Final project
*/

require_once("includes/mainpage.php");
require_once "includes/secure.php";
include_once "includes/util.php";

/**
 * Child class of MainPage used for non-profit account page.
 *
 * Implements processData and showContent
 */
class npPrefPage extends MainPage {

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
	$addr1 = $this->formL->getValue("addr1");
	$addr2 = $this->formL->getValue("addr2");
	$city  = $this->formL->getValue("city");
	$state = $this->formL->getValue("state");
	$zipc  = $this->formL->getValue("zipc");
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
	$sql = "UPDATE NonProfits SET 
				ContFname = ?,	ContLName = ?, 
				email = ?, Phone = ?, PHash = '$phash', 
				Address1 = ?, Address2 = ?, City = ?,
				State = ?, Zip = ? 
			WHERE NPID = '$uid'";
	$result = $this->db->prepare($sql);
	$result->execute(array($fname,$lname,$email,$phone,
					 $addr1,$addr2,$city,$state,$zipc));
}

/**
 * Display the content of the page.
 *
 * @param $title is page title.
 * @param $uid is user id passed by reference.
 */
function showContent($title, &$uid) {

	$sql = "SELECT Name, ContLname, ContFname, email, Phone,
			Address1, Address2, City, State, Zip
			FROM  NonProfits WHERE NPID = '$uid'";
	$result = $this->db->query($sql);

	if ( $row = $result->fetch(PDO::FETCH_ASSOC) ) {
		$nname = $row["Name"];
		$fname = $row["ContFname"];
		$lname = $row["ContLname"];
		$email = $row["email"];
		$phone = $row["Phone"];
		$addr1 = $row["Address1"];
		$addr2 = $row["Address2"];
		$city = $row["City"];
		$state = $row["State"];
		$zipc = $row["Zip"];
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
Non-Profit Name:&nbsp</td>
<td>
<?php if (empty($nname)) echo $user; else echo $nname;?>
</td>
</tr>
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
<?php echo $this->formL->formatOnError('addr1','Address Line 1') . "</td>"; ?>
<td class="inputcell">
<?php echo $this->formL->makeTextInput('addr1', $addr1);?>
</td>
</tr>

<tr>
<td class="labelcell">
<?php echo $this->formL->formatOnError('addr2','Address Line 2') . "</td>"; ?>
<td class="inputcell">
<?php echo $this->formL->makeTextInput('addr2', $addr2);?>
</td>
</tr>

<tr>
<td class="labelcell">
<?php echo $this->formL->formatOnError('city','City') . "</td>"; ?>
<td class="inputcell">
<?php echo $this->formL->makeTextInput('city', $city);?>
</td>
</tr>

<tr>
<td class="labelcell">
<?php echo $this->formL->formatOnError('state','State') . "</td>"; ?>
<td class="inputcell">
<?php echo $this->formL->makeTextInput('state', $state);?>
</td>
</tr>

<tr>
<td class="labelcell">
<?php echo $this->formL->formatOnError('zipc','Zip Code') . "</td>"; ?>
<td class="inputcell">
<?php echo $this->formL->makeTextInput('zipc', $zipc);?>
</td>
</tr>

</tr>
<tr><td>&nbsp</td></tr><tr><td></td><td>
<input class="subbutton" type="submit" name="Submit" value="Submit">
</td></tr>
</table>
</fieldset>

</form>
<a id="Return" href="npaccount.php"
title="Return">
<button class="subbutton">OK-Return</button> </a>
</p>
</div>
<?php
$this->formL->finish();
}
}
?>

