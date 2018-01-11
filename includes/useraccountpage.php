<?php
/**
* @file useraccountpage.php
* Purpose: User Info. 
* Extends MainPage Class
*
* @author Keith Gudger
* @version 2.1 5/1/14
*
* @note Has processData and showContent, 
* main and checkForm in MainPage class not overwritten.
* CIS-165PH Final project
*/

require_once("includes/mainpage.php");
require_once "includes/secure.php";

/**
 * Child class of MainPage used for register page.
 *
 * Implements processData and showContent
 */
class userAccountPage extends MainPage {

/**
 * Process the data and insert / modify database.
 *
 * @param $uid is user id passed by reference.
 */
function processData(&$uid) {
	$jobid = ($this->formL->getValue("jobid"));
    // Process the verified data here.
	if (is_array($jobid)) {
		$sql = "INSERT INTO 
				Status(JID, VID)
				VALUES (?, '$uid')";
		$stmt = $this->db->prepare($sql);
		foreach ( $jobid as $jid ) {
			$stmt->execute(array($jid));
		}
	}
}

/**
 * Display the content of the page.
 *
 * @param $title is page title.
 * @param $uid is user id passed by reference.
 */
function showContent($title, &$uid) {
?>

<div class="preamble" id="CS165-preamble" role="article">
<h3>Here are the jobs you signed up for.</h3><p></p>
<?php
// Make the query
	$sql = "SELECT StartDate, StartTime, Description, NPID, HowMany
			FROM Jobs, Status 
			WHERE Status.VID = '$uid'  
			AND Jobs.JobID = Status.JID
			ORDER BY Jobs.JobID";
	$result = $this->db->query($sql);

	// Create the table
	echo '<table class = "volemail"><tr>';
	echo '<th class="norm">Non-Profit</th>';
	echo '<th class="norm">Job Description</th>';
	echo '<th class="norm">Start Date</th>';
	echo '<th class="norm">Start Time</th>';

	for ( $i = 0 ; $row = $result->fetch(PDO::FETCH_ASSOC); $i++) {
		if ( ($i % 2) == 0 ) // if odd standard background
			echo "<tr>";
		else
			echo '<tr class="alt">' ; // if even, change background

		$npid = $row["NPID"] ;		
		$sql = "SELECT Name FROM NonProfits
				WHERE NPID = '$npid'";
		$npres = $this->db->query($sql);
		$row2 = $npres->fetch(PDO::FETCH_ASSOC);

		tdw($row2, "Name"); // function formats table data
		tdw($row, "Description"); // function formats table data
		tdw($row, "StartDate",1);
		tdw($row, "StartTime",2);
		echo "</tr>"; // last col
	}
	echo "</table>";
?>
<br>
<h3>Here are some jobs you might be interested in.</h3>
<p>Sign up by clicking in the box.</p>
<?php
	echo $this->formL->reportErrors();
	echo $this->formL->start('POST', "", 'name="newjobs"');

// Make the query
	$sql = "SELECT DISTINCT StartDate, StartTime, Description, 
				NPID, JobID
			FROM Jobs
			WHERE (JobID NOT IN 
			(SELECT JID FROM Status WHERE VID = '$uid'))
			AND (TypeID IN
			(SELECT TypeID FROM VPrefs WHERE VID = '$uid'))
			ORDER BY Jobs.JobID";
	$result = $this->db->query($sql);

	// Create the table
	echo '<table class = "volemail"><tr>';
	echo '<th class="norm">Non-Profit</th>';
	echo '<th class="norm">Job Description</th>';
	echo '<th class="norm">Start Date</th>';
	echo '<th class="norm">Start Time</th>';
	echo '<th class="norm">Sign Up!</th></tr>';

	for ( $i = 0 ; $row = $result->fetch(PDO::FETCH_ASSOC); $i++) {
		if ( ($i % 2) == 0 ) // if odd standard background
			echo "<tr>";
		else
			echo '<tr class="alt">' ; // if even, change background

		$npid = $row["NPID"] ;		
		$sql = "SELECT Name, NPID FROM NonProfits
				WHERE NPID = '$npid'";
		$npres = $this->db->query($sql);
		$row2 = $npres->fetch(PDO::FETCH_ASSOC);

		tdw($row2, "Name"); // function formats table data
		tdw($row, "Description"); // function formats table data
		tdw($row, "StartDate",1);
		tdw($row, "StartTime",2);
		echo '<td class="cent">' ;
		echo '<input type="checkbox" name="jobid[]" value="';
		echo $row["JobID"] . '"></td>';
		echo "</tr>"; // last col
	}
?>
<tr><td>&nbsp</td></tr><tr><td>
<input class="subbutton" type="submit" name="Submit" value="Submit">
</td></tr>
</table>
<br>
</form>
</div>

<?php
	}
}
?>

