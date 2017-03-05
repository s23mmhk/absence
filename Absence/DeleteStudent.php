<html>
<head>
<link rel="stylesheet" type="text/css" href="style/style.css">
</head>
<body>
<?php
include_once 'Header.php';



// delete student
if(isset($_POST['deletestd'])){
	$n = $_POST['i'];
	$dom = new DOMDocument();
	$dom->load('XMLFiles/Students.xml');
	$root = $dom->documentElement;
	for($i = 1; $i <= $n; $i ++){
		if(isset($_POST['check'.$i])){
			$stds = $dom->getElementsByTagName('student');
			foreach ($stds as $std){
				if($std->firstChild->nodeValue == $_POST['idstud'.$i] && $std->lastChild->nodeValue == $_POST['namestud'.$i]){
					$root->removeChild($std);
				}
			}

		}
	}
	$dom->save('XMLFiles/Students.xml');
	header("Location: Home.php");
}
else {
	// enter a student for delete
	echo '<section class="modifier">';
	echo '<br><br>';
	echo '<h1>Delete Student</h1>';
	echo '<form action="DeleteStudent.php" method="post" >';
	$dom = new DOMDocument();
	$dom->load('XMLFiles/Students.xml');
	$students = $dom->getElementsByTagName('student');
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
	echo '<input type="submit" value="Delete" name="deletestd">';
	echo '</form>';
	echo '</section>';
}
	
?>
</body>
</html>	