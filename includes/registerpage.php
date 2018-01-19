<?php
/**
* @file registerpage.php
* Purpose: New User Registration Form 
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

/**
 * Child class of MainPage used for register page.
 *
 * Implements processData and showContent
 */
class registerPage extends MainPage {

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

	if ($this->formL->getValue("nonp") == 0) { // individual sign up
                $sess_np = "no";
		$prefs = $this->formL->getValue("prefs");
		// Process the verified data here.
		$sql = "INSERT INTO 
				Volunteers(FName, Lname, email, Phone, PHash)
				VALUES ( ?, ?, ?, ?, ? )";
		$result = $this->db->prepare($sql);
		$result->execute(array($fname,$lname,$email,$phone,$phash));

		$vid = $this->db->lastInsertId(); // should be last inserted VID

		$sql = "INSERT INTO 
				VPrefs(VID, TypeID)
				VALUES ('$vid', ? )";
		$result = $this->db->prepare($sql);
		foreach ($prefs as $pref1) {
			$result->execute($pref1);
		}
	}
	else {
                $sess_np = "yes";
		$npname = $this->formL->getValue("npname");
		$addr1  = $this->formL->getValue("addr1");
		$addr2 	= $this->formL->getValue("addr2");
		$city   = $this->formL->getValue("city");
		$state  = $this->formL->getValue("state");
		$zipc   = $this->formL->getValue("zipc");

		$sql = "INSERT INTO 
				NonProfits(Name, ContLName, ContFName, email, Phone,
							 PHash, Address1, Address2, City,
							 State, Zip)
				VALUES ( ?, ?, ?, ?, ?,
						'$phash', ?, ?, ?, ?, ?)";
		$result = $this->db->prepare($sql);
		$result->execute(array($npname, $lname,$fname,$email,$phone,
						 $addr1,$addr2,$city,$state,$zipc));
		$vid = $this->db->lastInsertId(); // should be last inserted NPID
	}
        if (!session_id()) session_start();
        $uid=$vid;
        $_SESSION['user']=$fname;
        $_SESSION['np']=$sess_np;
        $this->sessnp = $sess_np ;
        $_SESSION["rid"] = setReadID($uid) ; // encrypts uid
        // and returns real random number
        $_SESSION["uid"] = $uid ; // puts encrypted uid in session

}

/**
 * Display the content of the page.
 *
 * @param $title is page title.
 * @param $uid is user id passed by reference.
 */
function showContent($title, &$uid) {
// Put HTML after the closing PHP tag
?>
<br>
<div class="preamble" id="CS165-preamble" role="article">
<h3>Please input your information.</h3><p></p>
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
<?php echo $this->formL->makeTextInput('fname');?>
</td>
</tr>
<tr>
<td class="labelcell">
<?php echo$this->formL->formatOnError('lname','Last Name') . "</td>"; ?><td class="inputcell">
<?php echo $this->formL->makeTextInput('lname');?>
</td>
</tr>

<tr>
<td class="labelcell">
<?php echo $this->formL->formatOnError('email','email') . "</td>"; ?>
<td class="inputcell">
<?php echo $this->formL->makeTextInput('email');?>
</td>
</tr>

<tr>
<td class="labelcell">
<?php echo $this->formL->formatOnError('phone','Phone') . "</td>"; ?>
<td class="inputcell">
<?php echo $this->formL->makeTextInput('phone');?>
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
<?php echo $this->formL->formatOnError('nonp','Member Type') . "</td>"; ?>
<td class="inputcell">
<?php 
$radiolist = array("Individual"=>0,"Non Profit"=>1);
echo $this->formL->makeRadioGroup('nonp', $radiolist,"");?>
</td>
</tr>
</table>
<table id=ind_tab>
<tr>
<td class="labelcell">
<?php echo $this->formL->formatOnError('prefs','Job Preferences (Individual Only)') . "</td></tr><tr>";

	$sql = "SELECT PrefID, Preference FROM 
			JobTypes";
	$result = $this->db->query($sql);

    for ($i = 0; $row = $result->fetch(PDO::FETCH_ASSOC); $i++) {
        echo '<td class="inputcell">' ;
		$checkarray = array($row["Preference"]=>$row["PrefID"]);
		echo $this->formL->makeCheckBoxes("prefs", $checkarray);
		echo '</td></tr><tr>';
	}
?>
</tr>
<tr>
</table>
<table id=nonp_tab>
<td class="labelcell">
Further Information (Non-Profits Only)</td></tr>
<tr>
<td>
<?php echo $this->formL->formatOnError('npname','Non-Profit Name') . "</td>"; ?>
<td class="inputcell">
<?php echo $this->formL->makeTextInput('npname');?>
</td>
</tr>
<tr>
<td>
<?php echo $this->formL->formatOnError('addr1','Non-Profit Address Line 1') . "</td>"; ?>
<td class="inputcell">
<?php echo $this->formL->makeTextInput('addr1');?>
</td>
</tr>
<tr>
<td>
<?php echo $this->formL->formatOnError('addr2','Non-Profit Address Line 2') . "</td>"; ?>
<td class="inputcell">
<?php echo $this->formL->makeTextInput('addr2');?>
</td>
</tr>
<tr>
<td>
<?php echo $this->formL->formatOnError('city','Non-Profit City') . "</td>"; ?>
<td class="inputcell">
<?php echo $this->formL->makeTextInput('city');?>
</td>
</tr>
<tr>
<td>
<?php echo $this->formL->formatOnError('state','Non-Profit State') . "</td>"; ?>
<td class="inputcell">
<?php echo $this->formL->makeTextInput('state');?>
</td>
</tr>
<tr>
<td>
<?php echo $this->formL->formatOnError('zipc','Non-Profit Zip Code') . "</td>"; ?>
<td class="inputcell">
<?php echo $this->formL->makeTextInput('zipc');?>
</td>
</tr>
</table>
<div class="inputcell">
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<div class="captcha_wrapper">
	<div class="g-recaptcha" data-sitekey="6Lesg0AUAAAAAI1LPzdtTX-_MnOL7-UPfVom25og"></div>
</div>

<?php /*
//require_once('recaptcha-php-1.11/recaptchalib.php');
$publickey = "6Le9yfASAAAAAD3k437b9QzxPYlPfgln_nhIP-M3"; 
	// got this from the signup page
echo recaptcha_get_html($publickey,"",true); */
?>
</div>
</fieldset>

<p id="formbuttons">
<input class="subbutton" type="submit" name="Submit" value="Submit">
</p>
</form>
</div>
<script type='text/javascript'>
	window.onload=function() {
		var chkd = document.getElementsByName("nonp");
		for (var i = 0, len = chkd.length; i < len; i++) {
			chkd[i].setAttribute("onchange", "Toggle_tables()");
		}
		Toggle_tables();
	};
	function Toggle_tables(){
		is_checked = document.getElementsByName("nonp");
		if (is_checked[0].checked) {
			//alert("Button 0 is checked");
			document.getElementById("ind_tab").style.display = "unset";
		} else {
			document.getElementById("ind_tab").style.display = "none";
		}
		if (is_checked[1].checked) {
			//alert("Button 1 is checked");
			document.getElementById("nonp_tab").style.display = "unset";
		} else {
			document.getElementById("nonp_tab").style.display = "none";
		}
	};
	
</script>
<?php
$this->formL->finish();
}
}
?>

