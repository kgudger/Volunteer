<?php
/**
* @file about.php
* Purpose: About page
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
class aboutPage extends MainPage {
/**
 * Display the content of the page.
 *
 * @param $title is page title.
 * @param $uid is user id passed by reference.
 */
function showContent($title, &$uid) {
?>

	<div class="summary" id="vn-summary" role="article">
	<p>Volunteer Now! is about helping local non-profits with short term volunteer needs.  Sign up here for short-term volunteer opportunities.  We'll let you know by email those opportunities that meet your profile requests.  Sign up and help out those in need in your community. </p>
			<p>Do you represent a non-profit looking for short-term volunteers?  Tell us about your needs and we'll send great volunteers to help you.</p>
		</div>
<br>
		<div class="participation" id="vn-participation" role="article">
			<h3>Contact Information.</h3>
			<p></p><ul><li>Webmaster: Keith Gudger</li><li>P. O. Box 336; Soquel CA 95073</li><li>831-708-8697</li><li>keith (at) sploids (dot) com</li></ul>		

</div>
</section>
<?php
}
}

/// a new instance of the derived class (from MainPage)
$aboutP = new aboutPage($db,$sessvar) ;
/// and ... start it up!  
$aboutP->main("About Volunteer Now!", $uid);
/**
 * There are 2 choices for redirection dependent on the sessvar
 * above which one gets taken.
 * For this page, no redirection at all. */

?>
