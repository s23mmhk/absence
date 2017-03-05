<html>
<head>
<link rel="stylesheet" type="text/css" href="style/style.css">
</head>
<body>
<?php
	include_once 'Header.php';
	
	
	
		
	// display a K text filed for add students
	if(isset($_POST['display'])){
		
		echo '<section class="modifier">';
		echo '<br><br>';
		echo '<h1>Add New Student</h1>';
		echo '<form action="AddStudent.php" method="post" >';
		echo '<table >';
		echo '<td>ID</td><td>Full Name</td>';
		for($i = 1;$i <= $_POST['nbstud'];$i ++){
			echo '<tr>';
			echo '<td><input type="text" name="idstud'.$i.'" width="50px"></td><td><input type="text" name="namestud'.$i.'" width="200px" required></td>';
			echo '</tr>';
		}
		echo '</table>';
		echo '<input type="hidden" value="'.$_POST['nbstud'].'" name="nb" >';
		echo '<input type="submit" value="ADD STUDENTS" name="addstudents" >';
		echo '</form>';
		echo '</section>';
	}
		
	// save new students in xml file
	else if(isset($_POST['addstudents'])){
		$dom = new DOMDocument();
		$dom->load('XMLFiles/Students.xml');
		$root = $dom->documentElement;
		for($i = 1; $i <= $_POST['nb'];$i ++){
				
			$id = $dom->createElement("id");
			$idtxt = $dom->createTextNode($_POST['idstud'.$i]);
			$id->appendChild($idtxt);
				
			$name = $dom->createElement("name");
			$nametxt = $dom->createTextNode($_POST['namestud'.$i]);
			$name->appendChild($nametxt);
				
			$student = $dom->createElement("student");
			$student->appendChild($id);
			$student->appendChild($name);
				
			$root->appendChild($student);
		}
		$dom->save('XMLFiles/Students.xml');
		echo '<script>alert("add success")</script>';
		header("Location: Home.php");
	}
	// add a new student
	else{
		echo '<section class="modifier">';
		echo '<br><br>';
		echo '<h1>Add New Student</h1>';
		echo '<form action="AddStudent.php" method="post" >';
		echo 'Enter the number of students who are going to be added : ';
		echo '<input type="number" value="1" min="1" name="nbstud" >';
		echo '&nbsp;&nbsp;&nbsp;<input type="submit" value="Display" name="display" />';
		echo '</form>';
		echo '</section>';
	} 
		
?>
</body>
</html>	