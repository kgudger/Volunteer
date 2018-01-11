<?php
/**
* @file about.php
* Purpose: Privacy policy page
*
* @author Keith Gudger
* @copyright  (c) 2014, Keith Gudger, all rights reserved
* @license    http://opensource.org/licenses/BSD-2-Clause
* @version    Release: 1.0
* @package    Volunteer Now!
*
* @note CIS-165PH Final Project
*/

/**
 * dbstart.php opens the database and gets the user variables
 */
require_once("includes/dbstart.php");

require_once("includes/mainpage.php");

/**
 * Child class of MainPage used for user preferrences page.
 *
 * Implements processData and showContent
 */
class privacyPage extends MainPage {
/**
 * Display the content of the page.
 *
 * @param $title is page title.
 * @param $uid is user id passed by reference.
 */
function showContent($title, &$uid) {
?>

	<div class="summary" id="vn-summary" role="article">
	<h3>How We Collect and Use Information</h3>
	<p>We collect the following types of information about you.</p>
	<h4>Information you provide us directly:</h4><p>
We ask for certain information such as your real name, phone number and e-mail address when you register for an account, or if you correspond with us. We may also retain any information you provide when selecting job postings. We use this information to operate, maintain, and provide to you the features and functionality of the Service. Nothing you provide will be published publicly. Once published your username and / or real name may not be able to be removed.  We do give the non-profits your information when you accept one of their job invitations.</p>
	<h4>Information we may receive from third parties:</h4><p>
We do not receive any information about you from third parties.</p>
	<h4>Cookies information:</h4><p>
When you visit this web site, we may send one or more cookies — a small text file containing a string of alphanumeric characters — to your computer that uniquely identifies your browser and lets us help you log in faster and enhance your navigation through the site. A persistent cookie remains on your hard drive after you close your browser. Cookies may be used by your browser on  subsequent visits to the site. Persistent cookies can be removed by following your web browser’s directions. You can reset your web browser to refuse all cookies or to indicate when a cookie is being sent. However, some features of this site may not function properly if the ability to accept cookies is disabled. </p>
	<h4>Sharing of Your Information</h4><p>
We will not rent or sell your information to third parties outside Volunteer Now.</p>
	<h4>Keeping your information safe:</h4><p>
We care about the security of your information, and use commercially reasonable safeguards to preserve the integrity and security of all information we collect. To protect your privacy and security, we take reasonable steps (such as requesting a unique password) to verify your identity before granting you access to your account. You are responsible for maintaining the secrecy of your unique password and account information, and for controlling access to your email communications at all times. However, we cannot ensure or warrant the security of any information you transmit to us or guarantee that information on this site may not be accessed, disclosed, altered, or destroyed.</p><p>
	<u>Compromise of information:</u><br>
In the event that any information under our control is compromised as a result of a breach of security, we will take reasonable steps to investigate the situation and where appropriate, notify those individuals whose information may have been compromised and take other steps, in accordance with any applicable laws and regulations.</p>

		</div>
<br>
</section>
<?php
}
}

/// a new instance of the derived class (from MainPage)
$aboutP = new privacyPage($db,$sessvar) ;
/// and ... start it up!  
$aboutP->main("Volunteer Now! Privacy Policies", $uid);
/**
 * There are 2 choices for redirection dependent on the sessvar
 * above which one gets taken.
 * For this page, no redirection at all. */

?>
