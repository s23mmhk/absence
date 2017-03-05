<html>
	<head>
		<title>Presences</title>
		<link rel="stylesheet" type="text/css" href="style/style.css">

	</head>
	<body>
		<?php 
			include_once 'Header.php';
		?>
		
		<?php 
					
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
			
		?>		

		
		<section class="modifier">
			<?php 	
				
				// display prersence table
				if(isset($_POST['displaypresence'])){
					
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
					
					$xpathp = new DOMXPath($dom);
					$regs = $xpathp->query('/presence/registration[@courseid="'. $_POST['course'] .'" and @year="'. getAcademicYear() .'" and @lang="'. $_POST['lang'] .'"]');
					
					$count = 0;
					foreach ($regs as $reg){
						$count ++;
					}
					
					if($count == 0){
						echo '<form action="Home.php" method="post" >';
						echo '<h3>No registration in this course</h3>';
						echo '<input type="submit" value="Back">';
						echo '</form>';
					}
					elseif ($count == 1){
						
						$dom = new DOMDocument();
						$dom->load('XMLFiles/Registration-'.getAcademicYear().'.xml');
						
						$xpathr = new DOMXPath($dom);
						$stds = $xpathr->query('/registrations/registration[@courseid="'. $_POST['course'] .'" and @year="'. getAcademicYear() .'" and @lang="'. $_POST['lang'] .'"]/student');
						
						
						$students = array();
						foreach ($stds as $std){
							$students[$std->firstChild->nodeValue] = $std->lastChild->nodeValue;
						}
						
						$pres = array();
						$ad_Doc = new DOMDocument();
						$cloned = $regs->item(0)->cloneNode(TRUE);
						$ad_Doc->appendChild($ad_Doc->importNode($cloned, True));
						$xpath = new DOMXPath($ad_Doc);
						foreach ($students as $k => $v){
							$arr = array();
							$arr[] = $k;
							$arr[] = $v;
							$isPresences = $xpath->query('/registration/lecture/student[id="'. $k .'" and name="'. $v .'"]/isPresence');
							foreach ($isPresences as $isPresence){
								$arr[] = $isPresence->nodeValue;
							}
							$pres[] = $arr;
						}
						
						//
						$report = array();
						$abs[] = array();
						$nba;
						$t;
						$index = 0;
						foreach ($pres as $pre){
							$nba = 0;
							$t = 0;
							foreach ($pre as $pr){
								if($pr == "true" || $pr == "false"){
									$t ++;
									if($pr == "false"){
										$nba ++;
									}
								}
							}
							$abs[$index] = $nba;
							$report[$index] = 'Absence '.$nba.' from '.$t.' lecture.';
							$index ++;
						}
						
						$lectures = $xpath->query('/registration/lecture');
						echo '<form action="Home.php" method="post" >';
						
						echo '<input type="hidden" name="course" value="'. $_POST['course'] .'">';
						echo '<input type="hidden" name="lang" value="'. $_POST['lang'] .'">';
						
						echo '<table id="t01" border="1"  cellspacing="0" >';
						echo '<tr>';
						echo '<th>ID</th>';
						echo '<th>Name</th>';
						foreach ($lectures as $lecture){
							echo '<th style="width:100px; text-align:center;" >';
							$originalDate = $lecture->getAttribute('date');
							$Date1 = date("d-m-Y", strtotime($originalDate));
							echo $Date1;
							
							echo '</th>';
						}
						date_default_timezone_set('Asia/Beirut');
						echo '<th style="width:100px; text-align:center;"><input type="date" name="date"></th>';
						echo '</tr>';
						$j = 0;
						foreach ($pres as $pre){
							$i = 0;
							echo '<tr>';
							foreach ($pre as $pr){
								if($pr == "true"){
									echo '<td>';
									echo '<img src="images/true.png" width="30" height="30" style="margin-left: 35px; margin-right: 35px;">';
									echo '</td>';
								}
								elseif ($pr == "false"){
									echo '<td>';
									echo '<img src="images/red-x.png" width="30" height="30" style="margin-left: 35px; margin-right: 35px;">';
									echo '</td>';
								}
								else{
									if($i == 0){
										echo '<td><input type="hidden" name="id[]" value="'. $pr .'" >'. $pr .'</td>';
									}
									elseif ($i == 1){
										if($abs[$j] >= 3){
											echo '<td  class="dropdown" style="background-color: #ff5f5f;"><input type="hidden" name="name[]" value="'. $pr .'" >'. $pr ;
											echo '<div class="dropdown-content">';
											echo '<p>'.$report[$j].'</p>';
											echo '</div>';
											echo '</td>';
										}
										else {
											echo '<td  class="dropdown" ><input type="hidden" name="name[]" value="'. $pr .'" >'. $pr ;
											echo '<div class="dropdown-content">';
											echo '<p>'.$report[$j].'</p>';
											echo '</div>';
											echo '</td>';
										}
										
									}
								}
								$i ++;
							}
							echo '<td><input type="checkbox" name="check'.$j.'"  style="margin-left: 35px; margin-right: 35px;" checked></td>';
							echo '</tr>';
							$j ++;
						}
						echo '</table>';
						if($t >= 12){
							echo '<style> table#t01{ width: 1400px; overflow-x: scroll; display:block;} </style>';
						}
						
						
						echo '<br>';
						echo '<input type="submit" name="back" value="Back">';
						echo '<input type="submit" name="savepresence" value="Save">';
						echo '</form>';
							
					}
				}
				else {
					// save new presence to xml file
					if (isset($_POST['savepresence'])){
						
						
						
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
						$reg;
						foreach ($regs as $reg){
							if($reg->getAttribute('year')== getAcademicYear() && $reg->getAttribute('courseid') == $_POST['course'] && $reg->getAttribute('lang') == $_POST['lang']){
								break;
							}
						}
						
						$lec = $dom->createElement('lecture');
						date_default_timezone_set('Asia/Beirut');
						$originalDate = $_POST['date'];
						$Date1 = date("d-m-Y", strtotime($originalDate));
						$date = $dom->createAttribute('date');
						$date->value = $Date1;
						$lec->appendChild($date);
						
						$identis = $_POST['id'];
						$names = $_POST['name'];
						$j = 0;
						foreach ($identis as $idd){
							$id = $dom->createElement("id");
							$idtxt = $dom->createTextNode($idd);
							$id->appendChild($idtxt);
							
							$name = $dom->createElement("name");
							$nametxt = $dom->createTextNode($names[$j]);
							$name->appendChild($nametxt);
							
							$pre = $dom->createElement("isPresence");
							$pretxt;
							if(isset($_POST['check'.$j])){
								$pretxt = $dom->createTextNode('true');
							}
							else {
								$pretxt = $dom->createTextNode('false');
							}
							$pre->appendChild($pretxt);
							
							$student = $dom->createElement("student");
							$student->appendChild($id);
							$student->appendChild($name);
							$student->appendChild($pre);
							
							$lec->appendChild($student);
							
							$j ++;
						}
						
						
						$reg->appendChild($lec);
						$dom->save('presence-'.getAcademicYear().'.xml');
						
					}
					
					// an area for enter the course for display presence table
					echo '<br><br>';
					echo '<h1>Management of absences</h1>';
					echo '<form action="Home.php" method="post" >';
					echo '<table border="0">';
					echo '<tr>';
					echo '<td>Select a course : </td>';
					echo '<td>';
					echo '<select name="course" >';
					
					$dom = new DOMDocument();
					$dom->load('XMLFiles/Courses.xml');
					$courses = $dom->getElementsByTagName('course');
					
					foreach ($courses as $c){
						echo '<option value="'.$c->firstChild->nodeValue.'">'.$c->firstChild->nodeValue.'</option>';
					}
						
					echo '</select>';
					echo '</td>';
					echo '</tr>';
					echo '<tr>';
					echo '<td>Select the language of class : </td>';
					echo '<td>';
					echo '<select name="lang">';
					echo '<option value="none">None</option>';
					echo '<option value="french">French</option>';
					echo '<option value="english">English</option>';
					echo '</select>';			
					echo '</td>';
					echo '</tr>';
					echo '<tr><td></td>';
					echo '<td><input type="submit" value="Display" name="displaypresence" /></td>';
					echo '</tr>';
					echo '</table>';
					
					echo '</form>';
				}
			?>
		</section>
	
	</body>
</html>