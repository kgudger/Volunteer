<?php
/**
* @file preferences.php
* Purpose: Allow user to change preferences.
*
* @author Keith Gudger
* @version 1.1 04/15/14
*
* @note CIS-165PH  Final Project
*/

/**
 * dbstart.php opens the database and gets the user variables
 */
require_once("includes/dbstart.php");

include_once("includes/preferrencespage.php");

/**
 * The checkArray defines what checkForm does so you don't
 * have to overwrite it in the derived class. */

$checkArray = array(
	array("isEmpty","fname", "Please enter your first name."),
	array("isEmpty","lname", "Please enter your last name."),
	array("isInvalidEmail","email", "Please enter your email address."),
	array("isEmpty","phone", "Please enter your phone number."),
	array("isEmpty","pword", "Please enter a valid password."),
	array("isEmpty","prefs", "Please select your job preferences."));

/// a new instance of the derived class (from MainPage)
$npaccP = new userPrefPage($db,$sessvar,$checkArray) ;
/// and ... start it up!  
$npaccP->main("Welcome $user", $uid);
/**
 * There are 2 choices for redirection dependent on the sessvar
 * above which one gets taken.
 * For this page, no redirection at all. */

?>
