<?php
/**
 * @file header.php
 * Header file for CIS 165 PH Final project
 *
 * @author Keith Gudger
 * @copyright  (c) 2014, Keith Gudger, all rights reserved
 * @license    http://opensource.org/licenses/BSD-2-Clause
 * @version    Release: 1.0
 * @package    Volunteer Now!
 */
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<meta name="author" content="Keith Gudger">
	<meta name="description" content="Volunteer Now! is a web application dedicated to helping non-profits fill temporary volunteer needs.">
	<meta name="robots" content="all">
<link rel="icon" href="favicon.ico" type="image/x-icon"/>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
<?php if (isset($other)) echo $other; ?>
<title><?php echo $title ?></title>
<link href="style/volunteer.css" rel="stylesheet" type="text/css">
</head>

<body id="volunteer-now">
	<section class="intro" id="vn-intro">
		<header class="headstyle" role="banner">
			<img src="images/vol-happy.jpg" alt="Happy Volunteers!" width=33%><img src="images/vol-hands.jpg" alt="Happy Volunteers!" width=33%><img src="images/volunteers_happy.jpg" alt="Happy Volunteers!" width=33%><br><br>
			<a href="index.php"><h1>Volunteer Now!</h1></a>
			<h2><?php print "$title";?></h2>
		</header>


