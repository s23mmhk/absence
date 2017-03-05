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

// save new registration to xml file
if(isset($_POST['savereg'])){

	//
	$dom = new DOMDocument();
	
	if(file_exists('XMLFiles/Registration-'.getAcademicYear().'.xml')){
		
		$dom->load('XMLFiles/Registration-'.getAcademicYear().'.xml');
		
	} 
	else {
		
		$xml = new DOMDocument();
		$xml_regs = $xml->createElement("registrations");
		$xml->appendChild( $xml_regs );
	
		$xml->save('XMLFiles/Registration-'.getAcademicYear().'.xml');
		$dom->load('XMLFiles/Registration-'.getAcademicYear().'.xml');
	}
	
	

	$xpath = new DOMXPath($dom);
	$testreg = $xpath->query('/registrations/registration[@courseid="'. $_POST['course'] .'" and @year="'. getAcademicYear() .'" and @lang="'. $_POST['lang'] .'"]');
	$count = 0;
	foreach ($testreg as $tst){
		$count ++;
	}
	if($count == 0){
		$root = $dom->documentElement;
		$reg = $dom->createElement('registration');
			
		//
		$dom2 = new DOMDocument();
		if(file_exists('XMLFiles/presence-'.getAcademicYear().'.xml')){
		
			$dom2->load('XMLFiles/presence-'.getAcademicYear().'.xml');
		
		}
		else {
		
			$xml = new DOMDocument();
			$xml_regs = $xml->createElement("presence");
			$xml->appendChild( $xml_regs );
		
			$xml->save('presence-'.getAcademicYear().'.xml');
			$dom2->load('presence-'.getAcademicYear().'.xml');
		}
		$root2 = $dom2->documentElement;
		$reg2 = $dom2->createElement('registration');
			
		//
		$courseid = $dom->createAttribute('courseid');
		$courseid->value = $_POST['course'];
			
		$year = $dom->createAttribute('year');
		$year->value = $_POST['year'];
			
		$lang = $dom->createAttribute('lang');
		$lang->value = $_POST['lang'];
			
			
		//
		$courseid2 = $dom2->createAttribute('courseid');
		$courseid2->value = $_POST['course'];
			
		$year2 = $dom2->createAttribute('year');
		$year2->value = $_POST['year'];
			
		$lang2 = $dom2->createAttribute('lang');
		$lang2->value = $_POST['lang'];
			
			
		$reg->appendChild($courseid);
		$reg->appendChild($year);
		$reg->appendChild($lang);
			
		$reg2->appendChild($courseid2);
		$reg2->appendChild($year2);
		$reg2->appendChild($lang2);
			
			
			
		$n = $_POST['i'];
		for($i = 1; $i <= $n; $i ++){
			if(isset($_POST['check'.$i])){
					
				$id = $dom->createElement("id");
				$idtxt = $dom->createTextNode($_POST['idstud'.$i]);
				$id->appendChild($idtxt);

				$name = $dom->createElement("name");
				$nametxt = $dom->createTextNode($_POST['namestud'.$i]);
				$name->appendChild($nametxt);

				$student = $dom->createElement("student");
				$student->appendChild($id);
				$student->appendChild($name);
					
				$reg->appendChild($student);
			}
				
		}
			
		$root->appendChild($reg);
		$root2->appendChild($reg2);
			
		$dom->save('XMLFiles/Registration-'.getAcademicYear().'.xml');
		$dom2->save('XMLFiles/presence-'.getAcademicYear().'.xml');
		header("Location: Home.php");
	}
	else {
		echo '<h3>This class already exists</h3>';
	}



}
	
// edit a registration
else if(isset($_POST['editreg'])){
	
	
	
	//
	$dom = new DOMDocument();
	if(file_exists('XMLFiles/Registration-'.getAcademicYear().'.xml')){
	
		$dom->load('XMLFiles/Registration-'.getAcademicYear().'.xml');
	
	}
	else {
	
		$xml = new DOMDocument();
		$xml_regs = $xml->createElement("registrations");
		$xml->appendChild( $xml_regs );
	
		$xml->save('XMLFiles/Registration-'.getAcademicYear().'.xml');
		$dom->load('XMLFiles/Registration-'.getAcademicYear().'.xml');
	}

	$xpath = new DOMXPath($dom);
	$testreg = $xpath->query('/registrations/registration[@courseid="'. $_POST['course'] .'" and @year="'. getAcademicYear() .'" and @lang="'. $_POST['lang'] .'"]');
	$count = 0;
	foreach ($testreg as $tst){
		$count ++;
	}
	if($count > 0){
		$root = $dom->documentElement;
		$regs = $dom->getElementsByTagName('registration');
		$reg;
		foreach ($regs as $reg){
			if($reg->getAttribute('year')== $_POST['year'] && $reg->getAttribute('courseid') == $_POST['course'] && $reg->getAttribute('lang') == $_POST['lang']){
				break;
			}
		}
			

		$n = $_POST['i'];
		for($i = 1; $i <= $n; $i ++){
			if(isset($_POST['check'.$i])){

				$id = $dom->createElement("id");
				$idtxt = $dom->createTextNode($_POST['idstud'.$i]);
				$id->appendChild($idtxt);

				$name = $dom->createElement("name");
				$nametxt = $dom->createTextNode($_POST['namestud'.$i]);
				$name->appendChild($nametxt);

				$student = $dom->createElement("student");
				$student->appendChild($id);
				$student->appendChild($name);

				$reg->appendChild($student);
			}
				
		}
			
		$dom->save('Registration-'.getAcademicYear().'.xml');
			
			
			
		$dom2 = new DOMDocument();
		if(file_exists('XMLFiles/presence-'.getAcademicYear().'.xml')){
		
			$dom2->load('XMLFiles/presence-'.getAcademicYear().'.xml');
		
		}
		else {
		
			$xml = new DOMDocument();
			$xml_regs = $xml->createElement("presence");
			$xml->appendChild( $xml_regs );
		
			$xml->save('XMLFiles/presence-'.getAcademicYear().'.xml');
			$dom2->load('XMLFiles/presence-'.getAcademicYear().'.xml');
		}
		$root2 = $dom2->documentElement;
		$regs2 = $dom2->getElementsByTagName('registration');
		$reg2;
		foreach ($regs2 as $reg2){
			if($reg2->getAttribute('year')== $_POST['year'] && $reg2->getAttribute('courseid') == $_POST['course'] && $reg2->getAttribute('lang') == $_POST['lang']){
				break;
			}
		}
			
		$lects = $reg2->getElementsByTagName('lecture');
			
		foreach ($lects as $lect){
			$n = $_POST['i'];
			for($i = 1; $i <= $n; $i ++){
				if(isset($_POST['check'.$i])){ echo 'now'.$i.'<br>';
					
				$id = $dom2->createElement("id");
				$idtxt = $dom2->createTextNode($_POST['idstud'.$i]);
				$id->appendChild($idtxt);
					
				$name = $dom2->createElement("name");
				$nametxt = $dom2->createTextNode($_POST['namestud'.$i]);
				$name->appendChild($nametxt);
					
				$isp = $dom2->createElement("isPresence");
				$isptxt = $dom2->createTextNode("false");
				$isp->appendChild($isptxt);


					
				$student = $dom2->createElement("student");
				$student->appendChild($id);
				$student->appendChild($name);
				$student->appendChild($isp);
					
				$lect->appendChild($student);
				}

			}
		}

		$dom2->save('presence-'.getAcademicYear().'.xml');
		header("Location: Home.php");
	}
	else {
		echo '<h3>This class not exists</h3>';
	}
}
else {
	// registration for student
	
	
	echo '<section class="modifier">';
	echo '<br><br>';
	echo '<h1>Registration</h1>';
	
	echo '<form action="Registration.php" method="post" >';
	echo 'Select a course : ';
	echo '<select name="course" >';
	
	$dom = new DOMDocument();
	$dom->load('XMLFiles/Courses.xml');
	$courses = $dom->getElementsByTagName('course');
	
	foreach ($courses as $c){
		echo '<option value="'.$c->firstChild->nodeValue.'">'.$c->firstChild->nodeValue.'</option>';
	}
	
	echo '</select>';
	echo '<br><br>';
	echo 'Enter the academic year : '; // pattern="^\d{4}-\d{4}$"
	echo '<input type="text" name="year" value="'. getAcademicYear() .'"  readonly>';
	echo '<br><br>';
	echo 'Select the language of class : ';
	echo '<select name="lang">';
	echo '<option value="none">None</option>';
	echo '<option value="french">French</option>';
	echo '<option value="english">English</option>';
	echo '</select>';
	echo '<span style="color:red;"> &nbsp; Select None if the lang of class is English and French at the same time</span>';
	echo '<br><br>';
	
	
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
	
	
	echo '<table border="1" cellspacing="0">';
	echo '<tr><td>ID</td><td>Name</td><td>select student</td></tr>';
	$i = 1;
	foreach ($students as $stud){
		echo '<tr>';
		echo '<td><input type="text" name="idstud'.$i.'" value="'. $stud->firstChild->nodeValue .'" style="border: none;background-color: transparent;border-color: transparent;" readonly /></td>';
		echo '<td><input type="text" name="namestud'.$i.'" value="'. $stud->lastChild->nodeValue .'" style="border: none;background-color: transparent;border-color: transparent;" readonly /></td>';
		echo '<td><input type="checkbox" name="check'. $i .'" ></td>';
		echo '</tr>';
		$i ++;
	}
	echo '</table>';
	
	echo '<input type="hidden" name="i" value="'.$i.'">';
	
	echo '<br>';
	echo '<input type="submit" value="Edit" name="editreg">';
	echo '<input type="submit" value="Save" name="savereg">';
	echo '</form>';
	echo '</section>';
}
?>
</body>
</html>	