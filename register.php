<?php
/**
* @file register.php
* Purpose: New User Registration Form
*
* @author Keith Gudger
* @copyright  (c) 2014, Keith Gudger, all rights reserved
* @license    http://opensource.org/licenses/BSD-2-Clause
* @version    Release: 1.0
* @package    Volunteer Now!
*
* @note CIS-165PH  Final Project
*/

/**
 * dbstart.php opens the database and gets the user variables
 */
require_once("includes/dbstart.php");

include_once("includes/registerpage.php");

/** The checkArray defines what checkForm does so you don't
 *  have to overwrite it in the derived class. */
$checkArray = array(
	array("isEmpty","nonp", "Please check one option."),
	array("isEmpty","fname", "Please enter your first name."),
	array("isEmpty","lname", "Please enter your last name."),
	array("isInvalidEmail","email", "Please enter your email address."),
	array("isEmpty","phone", "Please enter your phone number."),
	array("isEmpty","pword", "Please enter a valid password."),
	array("isInvalidCaptcha","captcha","Invalid CAPTCHA, Please try again."));

/// need to check if this is a non-profit and add appropriate checks
if (!empty($_REQUEST["nonp"]) && ($_REQUEST["nonp"] == "1")) {
	array_push($checkArray, 
	array("isEmpty","npname", "Please enter the non-profit name."));
	array_push($checkArray, 
	array("isEmpty","addr1", "Please enter an address."));
	array_push($checkArray, 
	array("isEmpty","city", "Please enter your city."));
	array_push($checkArray, 
	array("isEmpty","state", "Please enter your state."));
	array_push($checkArray, 
	array("isEmpty","zipc", "Please enter a valid zip code."));
} else { /// if not, add preferences check
	array_push($checkArray,
		array("isEmpty","prefs", "Please select your job preferences."));
}

/// a new instance of the derived class (from MainPage)
$indP = new registerPage($db,$sessvar,$checkArray) ;
/// and ... start it up!  
$indP->main("New Member Sign Up Page", $uid, "useraccount.php", "npaccount.php");
/** There are 2 choices for redirection dependent on the sessvar
 *  above which one gets taken.*/
?>
