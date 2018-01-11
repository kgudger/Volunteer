<?php
/**
 * @file footer.php
 * Footer file for CIS 165 PH Final project
 *
 * @copyright  (c) 2014, Keith Gudger, all rights reserved
 * @license    http://opensource.org/licenses/BSD-2-Clause
 * @version    Release: 1.0
 * @package    Volunteer Now!
 */
?>
	</section>
</div>

<footer>
<a href="index.php" title="Home Page">Home Page</a>
&nbsp;
<a href="about.php" title="About Us">About Us</a>
&nbsp;
<a href="privacy.php" title="Privacy">Privacy Policy</a>
&nbsp;
<?php
if (!session_id()) session_start();
if ((!empty($_SESSION['np'])) && ( $_SESSION['np'] == "yes" ))
   echo '<a href="npaccount.php" title="Account">Job Listings</a>';
else
   echo '<a href="useraccount.php" title="Account">Job Listings</a>';
?>
&nbsp;
<?php
if (!session_id()) session_start();
if ((!empty($_SESSION['np'])) && ( $_SESSION['np'] == "yes" ))
   echo '<a href="npreferences.php" title="Account">Account Settings</a>';
else
   echo '<a href="preferences.php" title="Account">Account Settings</a>';
?>
&nbsp;
<a href="logout.php" title="Log Out">Log Out</a>
&nbsp;
</footer>
</body>
</html>
