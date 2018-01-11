<?php
/**
* @file useraccount.php
* Purpose: User Info.
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

include_once("includes/useraccountpage.php");

/**
 * The checkArray defines what checkForm does so you don't
 * have to overwrite it in the derived class. */

/**
 * In this case the form doesn't get checked as it's only
 * a checkbox input that's selected. */

/// a new instance of the derived class (from MainPage)
$uaccP = new userAccountPage($db,$sessvar) ;
/// and ... start it up!  
$uaccP->main("Welcome $user", $uid);
/**
 * There are 2 choices for redirection dependent on the sessvar
 * above which one gets taken.
 * For this page, no redirection at all. */

?>
