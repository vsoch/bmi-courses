<?php

// Error reporting:
error_reporting(E_ALL^E_NOTICE);

// Including the DB connection file:
define("INCLUDE_CHECK",1);
require 'connect.php';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<!--HEAD-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Vanessa's BMI Class Schedule Proposal</title>

<!-- Here are links to stylesheets and jquery-->
<link rel="stylesheet" type="text/css" href="styles.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="script.js"></script>
</head>

<!-- BODY-->
<body>

<div id="main">
	<h1>Biomedical Informatics Class Schedule, 2011-2013</h1>
	<p class="instructions">...click outside the box to close the class descriptions</p>
    
    <div id= "sidebar">
    <p class="header">REQUIREMENTS (54 credits)</p>
<br />
	<p class="heading">SEMINAR REQUIREMENT</p>
		<ul><li>BIOMEDIN 201 (SuF11)(Sp12) (3)</li>
			<li>BIOMEDIN 200 (F12)         (1)</li></ul>
            <p class="total">TOTAL: 4</p><br />
	<p class="heading">CORE BMI (17)</p>
		<ul><li>BIOMEDIN 214 (F11)         (4)</li>
			<li>BIOMEDIN 210 (W12)         (3)</li>
			<li>BIOMEDIN 217 (Sp12)        (4)</li>
			<li>BIOMEDIN 211 (W13)         (3)</li>
			<li>BIOMEDIN 212 (Sp13)        (3)</li></ul>
            <p class="total">TOTAL: 17</p><br />
	<p class="heading">COMP SCI (9)</p><ul>
			<li>CS 108 (F11)               (4)</li>
			<li>CS 161 (F12)               (5)</li></ul>
            <p class="total">TOTAL: 9</p><br />
	<p class="heading">PROB, STAT, DEC (9)</p>
		<ul><li>STATS 202 (Su12)           (3)</li>
			<li>CS 228 (W13)               (4)</li>
            <li><strong>NEED A CLASS HERE</strong></li></ul>
            <p class="total">TOTAL: 7</p><br />
	<p class="heading">BIOMEDICAL DOMAIN KNOWLEDGE (6)</p>
		<ul><li>NBIO 206 (W12)              (8)</li>
		<li>BIOMEDIN 260 (Sp12)         (4)</li></ul><br />
        <p class="total">TOTAL: 12</p><br />
	<p class="heading">SOCIAL AND ETHICAL ISSUES (4)</p>
		<ul><li>MED  255 (W12)             (1)</li>
		<li><strong>NEED A CLASS HERE </strong></li></ul><br />
        <p class="total">TOTAL: 1</p><br />
	<p class="heading">ROTATION</p>
		<ul><li>BIOMEDIN 299 (Su11)        (9)</li></ul>
        <p class="total">TOTAL: 9</p><br />
        <p class="grandtotal">GRAND TOTAL: 59</p><br />
</div>
<div id="timelineLimiter"> <!-- Hides the overflowing timelineScroll div -->
	    <div id="timelineScroll"> <!-- Contains the timeline and expands to fit -->

		<?php
        
        // We first select all the events from the database ordered by date:
        
        $dates = array();
        $res = mysql_query("SELECT * FROM timeline ORDER BY date_event ASC");
		
        while($row=mysql_fetch_assoc($res))
        {
			// Store the events in an array, grouped by years:
            $dates[date('Y',strtotime($row['date_event']))][] = $row;
        }
        
        $colors = array('green','blue','cream');
		$scrollPoints = '';
		
        $i=0;
        foreach($dates as $year=>$array)
        {
			// Loop through the years:
            echo '
            <div class="event">
                <div class="eventHeading '.$colors[$i++%3].'">'.$year.'</div>
                <ul class="eventList">
                ';
        
            foreach($array as $event)
            {
				// Loop through the events in the current year:
				
                echo '<li class="'.$event['type'].'">
				<span class="icon" title="'.ucfirst($event['type']).'"></span>
				'.htmlspecialchars($event['title']).'
				
				<div class="content">
					<div class="body">'.($event['type']=='image'?'<div style="text-align:center"><img src="'.$event['body'].'" alt="Image" /></div>':nl2br($event['body'])).'</div>
					<div class="title">'.htmlspecialchars($event['title']).'</div>
					<div class="date">'.date("F j, Y",strtotime($event['date_event'])).'</div>
				</div>
				
				</li>';
            }
            
            echo '</ul></div>';
			
			// Generate a list of years for the time line scroll bar:
			$scrollPoints.='<div class="scrollPoints">'.$year.'</div>';
        }
        
        ?>
	    
        <div class="clear"></div>
        </div>
        
        <div id="scroll"> <!-- The year time line -->
            <div id="centered"> <!-- Sized by jQuery to fit all the years -->
	            <div id="highlight"></div> <!-- The light blue highlight shown behind the years -->
	            <?php echo $scrollPoints ?> <!-- This PHP variable holds the years that have events -->
                <div class="clear"></div>
            </div>
        </div>
        
        <div id="slider"> <!-- The slider container -->
        	<div id="bar"> <!-- The bar that can be dragged -->
            	<div id="barLeft"></div>  <!-- Left arrow of the bar -->
                <div id="barRight"></div>  <!-- Right arrow, both are styled with CSS -->
          </div>
        </div>
        
    </div> 
</div>
</body>
</html>
