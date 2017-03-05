
<header class="header-basic-light">
		
			<script type="text/javascript">
					function submitFormWithValue(id){ 
  						document.getElementById(id).name = id;
  						document.forms["navform"].submit();
					}
			</script>
			
			<div class="header-limiter">
				<div class="logo" ><img alt="" src="images/ul3.jpg" width="60" height="55" ></div>
				<h1>Presences<span>&nbsp;&amp;&nbsp;</span>Absences</h1>
				<form id="navform" name="navform" action="Home.php" method="post" id="siteform" >
		 			<!--
		 			<input type="submit" name="addcourse" value="Add Course" >
					<input type="submit" name="addstudent" value="Add Students">
					<input type="submit" name="deletestudent" value="Delete Stud">
					<input type="submit" name="registration" value="Registration">
					<input type="submit" name="help" value="Help">
					
					
					<input type="hidden" id="home" name="" value="" />
					<input type="hidden" id="addcourse" name="" value="" />
					<input type="hidden" id="addstudent" name="" value="" />
					<input type="hidden" id="deletestudent" name="" value="" />
					<input type="hidden" id="registration" name="" value="" />
					<input type="hidden" id="help" name="" value="" />
					  
					-->
				</form>
				<nav>
				<!--
					<a href="javascript:submitFormWithValue('home')">Home</a>
					<a href="javascript:submitFormWithValue('help')" class="selected" >HELP</a>
					<a href="javascript:submitFormWithValue('addcourse')"  >Add Course</a>
					<a href="javascript:submitFormWithValue('addstudent')" >Add Students</a>
					<a href="javascript:submitFormWithValue('deletestudent')" >Delete Stud</a>
					<a href="javascript:submitFormWithValue('registration')" >Registration</a>
				 -->
				 
				 	<a href="Home.php">Home</a>
					<a href="Help.php" class="selected" >HELP</a>
					<a href="AddCourse.php"  >Add Course</a>
					<a href="AddStudent.php" >Add Students</a>
					<a href="DeleteStudent.php" >Delete Stud</a>
					<a href="Registration.php" >Registration</a>
					<a href="Report.php" >Report</a>
				</nav>
			</div>
			
</header>
	