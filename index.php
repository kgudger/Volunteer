<?php
/**
* @file index.php
* Purpose: Home Page and Sign In
*
* @author Keith Gudger
* @copyright  (c) 2014, Keith Gudger, all rights reserved
* @license    http://opensource.org/licenses/BSD-2-Clause
* @version    Release: 1.0
* @package    Volunteer Now!
*
* @note CIS-165PH Final project
*/

/**
 * dbstart.php opens the database and gets the user variables
 */
require_once("includes/dbstart.php");

include_once("includes/indexpage.php");

/**
 * The checkArray defines what checkForm does so you don't
 * have to overwrite it in the derived class. */
$checkArray = array(
	array("isInvalidEmail","email", "Please enter your email address."),
	array("isEmpty","pword", "Please enter your password."));

/// a new instance of the derived class (from MainPage)
$indP = new indexPage($db,$sessvar,$checkArray) ;
/// and ... start it up!  
$indP->main("Short-Term Volunteer Help", $uid, "useraccount.php",
				"npaccount.php");
/**
 * There are 2 choices for redirection dependent on the sessvar
 * above which one gets taken.*/
?>
