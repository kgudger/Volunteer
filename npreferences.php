<?php
/**
* @file npreferences.php
* Purpose: Allow Non Profit user to change preferences.
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

include_once("includes/npreferrencespage.php");

/**
 * The checkArray defines what checkForm does so you don't
 * have to overwrite it in the derived class. */

$checkArray = array(
	array("isEmpty","fname", "Please enter your first name."),
	array("isEmpty","lname", "Please enter your last name."),
	array("isInvalidEmail","email", "Please enter your email address."),
	array("isEmpty","phone", "Please enter your phone number."),
	array("isEmpty","pword", "Please enter a valid password."),
	array("isEmpty","addr1", "Please enter an address."),
	array("isEmpty","city", "Please enter your city."),
	array("isEmpty","state", "Please enter your state."),
	array("isEmpty","zipc", "Please enter a valid zip code."));

/// a new instance of the derived class (from MainPage)
$npaccP = new npPrefPage($db,$sessvar,$checkArray) ;
/// and ... start it up!  
$npaccP->main("Welcome $user", $uid);
/**
 * There are 2 choices for redirection dependent on the sessvar
 * above which one gets taken.
 * For this page, no redirection at all. */
?>
