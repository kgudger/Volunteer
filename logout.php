<?php
/**
* @file logout.php
* Logout page removes session and cookie data
*
* @author Ed Parrish
* @author Keith Gudger
* @copyright  (c) 2014, Keith Gudger, all rights reserved
* @license    http://opensource.org/licenses/BSD-2-Clause
* @version    Release: 1.0
* @package    Volunteer Now!
*
* @note CIS-165PH Final Project
*/

ob_start();
if (!session_id()) session_start();

main("Volunteer Now! Secure Logout");

/** 
 * Control the operation of the page.
 *
 * @param title is the page title.
 */
function main($title = "") {
    $redirect = "index.php";
    $other = "<meta http-equiv=\"Refresh\"";
    $other .= "content=\"5;URL=$redirect\">\n";
    $user = "";
    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
    }
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 86400, '/');
    }
    session_destroy();
    include("includes/header.php");
    showContent($title, $redirect, $user);
    include("includes/footer.php");
}

// Display the content of the page
function showContent($title, $redirect, $user) {
    $msg = $user;
    if (!$user) {
        $msg = "You are";
    }
    echo<<<HTML
<p>$msg logged out securely.</p></p>
<p>Click <a href="$redirect">here</a> to continue.</p>
HTML;
}
?>
