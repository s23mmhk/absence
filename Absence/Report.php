<html>
<head>
<link rel="stylesheet" type="text/css" href="style/style.css">
</head>
<body>
<?php
	include_once 'Header.php';
	// function to get the current academic year
	function getAcademicYear(){
		$y = date('Y');;
		$m = (int)date('m');
		if($m >= 1 && $m < 8){
			return ($y - 1)."-".$y;
		}
		else {
			return $y ."-".($y + 1);
				
		}
	}
	
	if(isset($_POST['display'])){
		echo '<section class="modifier">';
		echo '<br><br>';
		echo '<h1>Report</h1>';
		
		$id = $_POST['student'];
		
		
		$dom = new DOMDocument();
		if(file_exists('XMLFiles/presence-'.getAcademicYear().'.xml')){
				
			$dom->load('XMLFiles/presence-'.getAcademicYear().'.xml');
				
		}
		else {
				
			$xml = new DOMDocument();
			$xml_regs = $xml->createElement("presence");
			$xml->appendChild( $xml_regs );
				
			$xml->save('XMLFiles/presence-'.getAcademicYear().'.xml');
			$dom->load('XMLFiles/presence-'.getAcademicYear().'.xml');
		}
		
		$regs = $dom->getElementsByTagName('registration');
		
		foreach ($regs as $reg){
			$t = 0;
			$exit = false;
			if($reg->firstChild == null) continue;
			
			$firstLec = $reg->getElementsByTagName('lecture')[0];
			$name;
			$stds = $firstLec->getElementsByTagName('student');
			foreach ($stds as $std){
				if($std->firstChild->nodeValue == $id){
					$name = $std->firstChild->nextSibling->nodeValue;
					$exit = true;
				}
			}
			
			
			if($exit){
				echo '<h3>'. $reg->getAttribute('courseid') .'</h3>';
				echo '<table id="t01" border="1"  cellspacing="0" >';
				echo '<tr>';
				echo '<th>ID</th>';
				echo '<th>Name</th>';
				$lects = $reg->getElementsByTagName('lecture');
				foreach ($lects as $lect){
					echo '<th style="width:100px; text-align:center;" >';
					$originalDate = $lect->getAttribute('date');
					$Date1 = date("d-m-Y", strtotime($originalDate));
					echo $Date1;
						
					echo '</th>';
				}
				echo '</tr>';
				echo '<tr>';
				echo '<td>'.$id.'</td>';
				echo '<td>'.$name.'</td>';
				
				
				$lects = $reg->getElementsByTagName('lecture');
				foreach ($lects as $lect){
					$ad_Doc = new DOMDocument();
					$cloned = $lect->cloneNode(TRUE);
					$ad_Doc->appendChild($ad_Doc->importNode($cloned, True));
					$xpath = new DOMXPath($ad_Doc);
					$std = $xpath->query('/lecture/student[id="'. $id  .'"]');
					
					if($std->item(0)->lastChild->nodeValue == "true"){
						echo '<td><img src="images/true.png" width="30" height="30" style="margin-left: 35px; margin-right: 35px;"></td>';
					}
					else{
						echo '<td>';
						echo '<img src="images/red-x.png" width="30" height="30" style="margin-left: 35px; margin-right: 35px;">';
						echo '</td>';
					}
					$t ++;
				}
				echo '</tr>';
				echo '</table>';
				if($t >= 12){
					echo '<style> table#t01{ width: 1400px; overflow-x: scroll; display:block;} </style>';
				}
			}
		}
		
		echo '</section>';
	}
	else {
		echo '<section class="modifier">';
		echo '<br><br>';
		echo '<h1>Report</h1>';
		
		echo '<form action="Report.php" method="post" >';
		
		$dom = new DOMDocument();
		$dom->load('XMLFiles/Students.xml');
		$students = $dom->getElementsByTagName('student');
		
		// $students is a DOMNodeList, not an array.
		// This is the reason for your usort() warning.
		
		// Copies DOMNode elements in the DOMNodeList to an array.
		$students = iterator_to_array($students);
		
		// a function for sorting by name
		function sort_by_name_value($a, $b)
		{
			return (int) strcmp($a->lastChild->nodeValue, $b->lastChild->nodeValue);
		}
		
		// Now usort()
		usort($students, 'sort_by_name_value');
		
		echo 'Select a student : ';
		echo '<select name="student">';
		foreach ($students as $stud){
			echo '<option value="'. $stud->firstChild->nodeValue .'">'. $stud->lastChild->nodeValue .'</option>';
		}
		echo '</select>';
		
		echo '&nbsp;&nbsp;&nbsp;<input type="submit" value="Display" name="display">';
		
		echo '</form>';
		echo '</section>';
	}

?>
</body>
</html>