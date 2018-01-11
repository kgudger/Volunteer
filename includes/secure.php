<?php
/**
* @file secure.php
* Include file for securing pages
*
* @author Ed Parrish
* @author Keith Gudger
* @copyright  (c) 2014, Keith Gudger, all rights reserved
* @license    http://opensource.org/licenses/BSD-2-Clause
* @version    Release: 1.0
* @package    Volunteer Now!
*
* @note CIS-165PH Final project
*/
require_once "redirect.php";
if (!session_id()) session_start();

requireLogin();

/** 
 * allows user to access page if authenticated, otherwise
 * redirects to index page.
 * 
 */
function requireLogin() {
    if (!isAuthenticated()) {
        $_SESSION['refPage'] = $_SERVER['PHP_SELF'];
        redirect("index.php");
    } else {
        if (isset($_SESSION["refPage"])) {
            unset($_SESSION["refPage"]);
        }
        echo "<!-- Validated at ".date('Y-m-d H:i:s')." -->";
    }
}

/**
 *  Checks session for 'user' variable.
 *
 *  @return 1 if current user is authenticated, otherwise 0
 */
function isAuthenticated() {
    if (!isset($_SESSION['user'])) {
        return 0;
    } else {
        return 1;
    }
}
?>
