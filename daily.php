<?php
/**
* @file daily.php
* Purpose: Remove old jobs from db.
*
* Any jobs whose end date is before now should be deleted
* daily.  Also need to delete the jobs from the status table.
*
* @author Keith Gudger
* @version 1.1 05/11/14
*
* @note CIS-165PH  Final Project
*/
require_once("includes/dbconvars.php");

/// Open the connection
try {
	$db = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpwd);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
	echo "Unable to connect: " . $e->getMessage() ."<p>";
	die();
}

/* first get today's date, then find the jobs which have completed.
 * With those Job IDs, delete all the volunteer assignments 
 * in the Status table.
 */
$ntime = time();
$tdate = date("Y-m-d",$ntime);

$sql = "DELETE FROM Status
		WHERE JID IN 
		(SELECT JobID FROM Jobs
			WHERE StopDate < '$tdate' )";

$result = $db->prepare($sql);
$result->execute();

/* Now just delete the jobs that are finished */
$sql = "DELETE FROM Jobs
			WHERE StopDate < '$tdate' ";

$result = $db->prepare($sql);
$result->execute();

?>
