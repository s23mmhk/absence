<html>
<head>
<link rel="stylesheet" type="text/css" href="style/style.css">
</head>
<body>
<?php
	
	include_once 'Header.php';

	// save the new course in xml file
	if(isset($_POST['savecourse'])){
		$dom = new DOMDocument();
		$dom->load('XMLFiles/Courses.xml');
		$root = $dom->documentElement;
		
		$xpath = new DOMXPath($dom);
		$crs = $xpath->query('/courses/course[id="'. $_POST['idcourse'] .'" and name="'. $_POST['namecourse'] .'"]');
		$count = 0;
		foreach ($crs as $tst){
			$count ++;
		}
		if($count == 0){
			$id = $dom->createElement("id");
			$idtxt = $dom->createTextNode($_POST['idcourse']);
			$id->appendChild($idtxt);
				
			$name = $dom->createElement("name");
			$nametxt = $dom->createTextNode($_POST['namecourse']);
			$name->appendChild($nametxt);
			
			$course = $dom->createElement("course");
			$course->appendChild($id);
			$course->appendChild($name);
			
			$root->appendChild($course);
			
			$dom->save('XMLFiles/Courses.xml');
			echo '<script>alert("add success")</script>';
			header("Location: Home.php");
		}
		else {
			echo '<script>alert("This course already exists");</script>';
			header("Location: AddCourse.php");
		}
	
		

	}
	else {
		echo '<section class="modifier">';
		echo '<br><br>';
		echo '<h1>Add New Course</h1>';
		echo '<form action="AddCourse.php" method="post" >';
		echo '<table>';
		echo '<tr>';
		echo '<td>';
		echo 'Course Id : ';
		echo '</td>';
		echo '<td>';
		echo '<input type="text" name="idcourse" width="100" required>';
		echo '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>';
		echo 'Course Name : ';
		echo '</td>';
		echo '<td>';
		echo '<input type="text" name="namecourse" width="300" required>';
		echo '<td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td></td>';
		echo '<td>';
		echo '<input type="submit" value="SAVE COURSE" name="savecourse" >';
		echo '</td>';
		echo '</tr>';
		echo '<table>';
		echo '</form>';
		echo '</section>';
	}
	
?>
</body>
</html>	