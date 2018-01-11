<?php
/**
* @file npaccountpage.php
* Purpose: Non-Profit User Info. 
* Extends MainPage Class
*
* @author Keith Gudger
* @copyright  (c) 2014, Keith Gudger, all rights reserved
* @license    http://opensource.org/licenses/BSD-2-Clause
* @version    Release: 1.0
* @package    Volunteer Now!
*
* @note Has processData and showContent, 
* main and checkForm in MainPage class not overwritten.
* CIS-165PH Final project
*/

require_once("includes/mainpage.php");
require_once "includes/secure.php";
include_once "includes/util.php";

/**
 * Child class of MainPage used for non-profit account page.
 *
 * Implements processData and showContent
 */
class npAccountPage extends MainPage {

/**
 * Process the data and insert / modify database.
 *
 * @param $uid is user id passed by reference.
 */
function processData(&$uid) {
	$prefs = $this->formL->getValue("prefs");
	$desc  = $this->formL->getValue("desc");
	$sdate = $this->formL->getValue("sdate");
	$stime = $this->formL->getValue("stime");
	$pdate = $this->formL->getValue("pdate");
	$ptime = $this->formL->getValue("ptime");
	$hmany = $this->formL->getValue("hmany");
    // Process the verified data here.
	$time = time();
	$time = date("Y-m-d H:i:s",($time));
	$sql = "INSERT INTO 
			Jobs(NPID, TypeID, StartDate, StartTime,
				 StopDate, StopTime, HowMany, Description,
				 PostTime)
			VALUES ('$uid', ?, ?, ?,
				 ?, ?, ?, ?, '$time')";
	$stmt = $this->db->prepare($sql);
	$stmt->execute(array($prefs,$sdate,$stime,$pdate,$ptime,
							 $hmany,$desc));
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
<h3>Here are the jobs you have posted.</h3><p></p>
<?php
// Make the query
	$sql = "SELECT StartDate, StartTime, Description, 
				NPID, HowMany, JobID
			FROM Jobs 
			WHERE NPID = '$uid'";
	$result = $this->db->query($sql);

	// Create the table
	echo '<table class = "volemail"><tr>';
	echo '<th class="norm">Job Description</th>';
	echo '<th class="norm">Start Date</th>';
	echo '<th class="norm">Start Time</th>';
	echo '<th class="norm">Volunteers Still Needed</th></tr>';

	for ( $i = 0 ; $row = $result->fetch(PDO::FETCH_ASSOC); $i++) {
		if ( ($i % 2) == 0 ) // if odd standard background
			echo "<tr>";
		else
			echo '<tr class="alt">' ; // if even, change background

		$npid = $row["NPID"] ;		
		tdw($row, "Description"); // function formats table data
		tdw($row, "StartDate",1);
		tdw($row, "StartTime",2);
		$jobid = $row['JobID'];
		$sql = "SELECT COUNT(*) AS Number
				FROM Status 
				WHERE JID = '$jobid'
				GROUP BY JID";
		$numres = $this->db->query($sql);
		$rownum = $numres->fetch(PDO::FETCH_ASSOC);
		
		$needed = $row['HowMany'] - $rownum['Number'];
		echo "<td class=cent>" . $needed . "</td>" ;
		echo "</tr>"; // last col
	}
	echo "</table>";
?>
<br>
<h3>Use this form to enter jobs you would like to fill.</h3>

<?php
	echo $this->formL->reportErrors();
	echo $this->formL->start('POST', "", 'name="newjobs"');
?>
<fieldset>
<legend>Please enter all of the requested information</legend>
<br>
<table>
<tr>
<td>
<?php echo $this->formL->formatOnError('desc','Job Description') . "</td>"; ?>
<td class="inputcell">
<?php echo $this->formL->makeTextInput('desc');?>
</td>
</tr>
<tr>
<td class="labelcell">
<?php echo $this->formL->formatOnError('prefs','Job Type') . "</td>";

	$sql = "SELECT PrefID, Preference FROM 
			JobTypes";
	$result = $this->db->query($sql);

    for ($i = 0; $row = $result->fetch(PDO::FETCH_ASSOC); $i++) {
        echo '<td class="inputcell">' ;
		$checkarray = array($row["Preference"]=>$row["PrefID"]);
		echo $this->formL->makeRadioGroup("prefs", $checkarray);
		echo '</td></tr><tr><td></td>';
	}
?>
</tr><tr><td>
<?php echo $this->formL->formatOnError('sdate','Job Start Date');?>
</td><td>
<?php echo $this->formL->makeDateInput('sdate');?>
</td></tr>
<tr><td>
<?php echo $this->formL->formatOnError('stime','Job Start Time');?>
</td><td>
<?php echo $this->formL->makeTimeInput('stime');?>
</td></tr>
<tr><td>
<?php echo $this->formL->formatOnError('pdate','Job Stop Date');?>
</td><td>
<?php echo $this->formL->makeDateInput('pdate');?>
</td></tr>
<tr><td>
<?php echo $this->formL->formatOnError('ptime','Job Stop Time');?>
</td><td>
<?php echo $this->formL->makeTimeInput('ptime');?>
</td></tr>
<tr><td>
<?php echo $this->formL->formatOnError('hmany','How Many Volunteers?');?>
</td><td>
<?php echo $this->formL->makeNumberInput('hmany',1,10);?>
</td></tr>
<tr><td>&nbsp</td></tr><tr><td></td><td>
<input class="subbutton" type="submit" name="Submit" value="Submit">
</td></tr>
</table>
<br>
</form></fieldset>
</div>

<?php
	}
}
?>

