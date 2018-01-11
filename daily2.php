<?php
/**
* @file daily2.php
* Purpose: Remove old jobs from db.
*
* Any jobs posted in the last 24 hours get emailed to those
* Volunteers who are interested in jobs of this "type".
*
* @author Keith Gudger
* @version 1.1 05/11/14
*
* @note CIS-165PH  Final Project
*/
require_once("includes/dbconvars.php");
require_once 'vendor/mandrill/mandrill/src/Mandrill.php';
include_once("includes/util.php");

/// Open the connection
try {
	$db = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpwd);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
	echo "Unable to connect: " . $e->getMessage() ."<p>";
	die();
}

/* first get today's date, then find the jobs which were posted
 * since yesterday.
 * With those Job IDs, email anyone with those job interests.
 */
$ntime = time() - (60 * 60 * 24) ;
$tdate = date("Y-m-d",$ntime);
echo "yesterday's date is $tdate<br>";

/* Gets all the volunteer VIDs who have a preference
 * matching a job posted in the last 24 hrs. 
 */
$sql = "SELECT DISTINCT VID FROM VPrefs, Jobs
		WHERE (PostTime > '$tdate') 
		AND (VPrefs.TypeID = Jobs.TypeID)
		GROUP BY VPrefs.VID" ;

$result = $db->prepare($sql);
$result->execute();
$volarray = $result->fetchAll(PDO::FETCH_COLUMN, 0);
// $volarray has just the VIDs we need
//print_r($volarray);

/* Now get Volunteer info from the Volunteer table for those
 * volunteers who have expressed an interest in these types
 * of jobs 
 */
$sql = "SELECT DISTINCT FName, email 
		FROM Volunteers
		WHERE VID = ? ";

$res1 = $db->prepare($sql);


foreach ( $volarray as $volid ) {

	/* Now we need to compose an email to each of these volunteers
	 * with the job information in it.
	 */
	$res1->execute(array($volid));
	$row1 = $res1->fetch(PDO::FETCH_ASSOC);
	$rfname = $row1['FName'];
	$remail = $row1['email'];
	echo "$rfname: $remail<br>";

	$htmlm  = "<html><head><title>Volunteer Now! email</title>";
	$htmlm .= "</head><body><p>Hello $rfname!  ";
	$htmlm .= "Here are some new Volunteer Opportunities 
we thought you might be interested in:</p>";

	/* Using the JobID from the above SELECT, get the Non-Profit
	 * name from the NonProfits table and other info about the 
	 * specific job from the Jobs table
	 */
	$sql = "SELECT DISTINCT NonProfits.Name AS NName, 
			Jobs.Description AS Descr, Jobs.StartDate AS SDate,
				Jobs.StartTime as STime
			FROM Jobs, NonProfits
			WHERE (Jobs.PostTime > '$tdate')
			AND (NonProfits.NPID = Jobs.NPID)
			AND (Jobs.TypeID IN 
				(SELECT TypeID FROM VPrefs
					WHERE VID = '$volid'))";
	$res2 = $db->prepare($sql);
	$res2->execute();
	while ($row2 = $res2->fetch(PDO::FETCH_ASSOC)) {

		$nname = $row2['NName'];
		$desc  = $row2['Descr'];
		$sdate = change_date($row2['SDate']);
		$stime = change_time($row2['STime']);

		$htmlm .= '<table border="1" ><tr>';

		$htmlm .= "<td>Non-Profit</td><td>$nname</td></tr>";
		$htmlm .= "<tr><td>Job Description</td><td>$desc</td></tr>";
		$htmlm .= "<tr><td>Start Date</td><td>$sdate</td></tr>";
		$htmlm .= "<tr><td>Start Time</td><td>$stime</td></tr>";
		$htmlm .= "</table><p></p>";
	}
	$htmlm .= "<p>Thank you for your interest in Volunteer Now!</p>";
	$htmlm .= "<a href=home.secure.loosescre.ws/~keith/Volunteer><b>Click here to visit the web site and sign up!</b></a>";
	$htmlm .= "<br></body></html>";

	// Using Mandrill APIs for email 

        $mandrill = new Mandrill('UYJO55_uJMOb7BEhsra_yg');
        $message = array(
        'html' => $htmlm,
        'subject' => 'Volunter Now! email',
        'from_email' => 'kgudger@gmail.com',
        'from_name' => 'Keith Gudger',
        'to' => array(
            array(
                'email' => $remail,
                'name' => $rfname,
                'type' => 'to'
            )
        ),
        'headers' => array('Reply-To' => 'kgudger@gmail.com')
    );
    $async = false;
    $ip_pool = 'Main Pool';
//    $send_at = 'example send_at';
    $result = $mandrill->messages->send($message, $async, $ip_pool/*,$send_at*/);
	$resdata = $result[status];
	echo "Result is $resdata<br>";

	echo $htmlm ;
}

?>
