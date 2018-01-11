<?php
/**
* @file npaccount.php
* Purpose: Non Profit User Information
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

include_once("includes/npaccountpage.php");

/** The checkArray defines what checkForm does so you don't
 *  have to overwrite it in the derived class. */

$checkArray = array(
	array("isEmpty","desc", "Please enter the job description."),
	array("isEmpty","prefs", "Please enter a job type."),
	array("isNotDate","sdate", "Please enter a valid date."),
	array("isNotTime","stime", "Please enter a valid time."),
	array("isNotDate","pdate", "Please enter a valid date."),
	array("isNotTime","ptime", "Please enter a valid time."),
	array("isNotNumeric","hmany", "Please enter a valid number."));

// a new instance of the derived class (from MainPage)
$npaccP = new npAccountPage($db,$sessvar,$checkArray) ;
// and ... start it up!  
$npaccP->main("Welcome $user", $uid);
/** There are 2 choices for redirection dependent on the sessvar
 *  above which one gets taken.
 *  For this page, no redirection at all. */

?>
