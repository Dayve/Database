<!DOCTYPE html >
<html lang="pl-PL">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="defaultstyle.css" media="screen" />
		<title>Wirtualny dziekanat - Potwierdzenie dodania wpisu</title>
	</head>
	<body>
		<h1>Wirtualny dziekanat - Potwierdzenie dodania wpisu</h1>
		<?php
			// Connect with database:
			header('Content-Type:text/html; charset=UTF-8');
			
			require_once 'login.php';
			$conn = new mysqli($hostname, $username, $pw, $DBname);
			
			if($conn->connect_error) die($conn->connect_error);
			
			// Add a new row:
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				if(isset($_POST['studentAdd'])) {
					$sqlQuery = "call dodajStudenta(";				// Query for calling the procedure
					$numTxtFields = count($_POST['studentForm']);	// Number of text fields in the form
					
					for($i=0 ; $i<$numTxtFields ; ++$i) {
						$txtFieldContent = $_POST['studentForm'][$i];
						
						if(isset($txtFieldContent) && !empty($txtFieldContent)) {
							$sqlQuery .= "'$txtFieldContent'";
							if($i != $numTxtFields-1) $sqlQuery .= ", "; // Separate arguments with a comma, but don't put it at the end
						}
						else {
							exit("Nie wszystkie pola zostały wypełnione.");
						}
					}
					$sqlQuery .= ")";
					
					// echo 'Wynikowe zapytanie: '.$sqlQuery.'<br>'; // Remove after testing
				
					$queryResult = $conn->query($sqlQuery);
					if(! $queryResult) die('Nie można wywołać procedury.');
					else echo 'Dodano studenta do bazy danych.';
				}
				else if(isset($_POST['tutorAdd'])) {
					$sqlQuery = "call dodajProwadzacego(";		// Query for calling the procedure
					$numTxtFields = count($_POST['tutorForm']);	// Number of text fields in the form
					
					for($i=0 ; $i<$numTxtFields ; ++$i) {
						$txtFieldContent = $_POST['tutorForm'][$i];
						
						if(isset($txtFieldContent) && !empty($txtFieldContent)) {
							$sqlQuery .= "'$txtFieldContent'";
							if($i != $numTxtFields-1) $sqlQuery .= ", "; // Separate arguments with a comma, but don't put it at the end
						}
						else {
							exit("Nie wszystkie pola zostały wypełnione.");
						}
					}
					$sqlQuery .= ")";
					
					// echo 'Wynikowe zapytanie: '.$sqlQuery.'<br>'; // Remove after testing
				
					$queryResult = $conn->query($sqlQuery);
					if(! $queryResult) die('Nie można wywołać procedury.');
					else echo 'Dodano prowadzącego do bazy danych.';
				}
				else if(isset($_POST['gradeAdd'])) {
					$sqlQuery = "call dodajOceneKoncowa(";		// Query for calling the procedure
					$numTxtFields = count($_POST['gradeForm']);	// Number of text fields in the form
					
					for($i=0 ; $i<$numTxtFields ; ++$i) {
						$txtFieldContent = $_POST['gradeForm'][$i];
						
						if(isset($txtFieldContent) && !empty($txtFieldContent)) {
							$sqlQuery .= "'$txtFieldContent'";
							if($i != $numTxtFields-1) $sqlQuery .= ", "; // Separate arguments with a comma, but don't put it at the end
						}
						else {
							exit("Nie wszystkie pola zostały wypełnione.");
						}
					}
					$sqlQuery .= ")";
					
					// echo 'Wynikowe zapytanie: '.$sqlQuery.'<br>'; // Remove after testing
				
					$queryResult = $conn->query($sqlQuery);
					if(! $queryResult) die('Nie można wywołać procedury.');
					else echo 'Dodano ocenę końcową do bazy danych.';
				}
				else if(isset($_POST['subjectAdd'])) {
					$sqlQuery = "call dodajPrzedmiot(";				// Query for calling the procedure
					$numTxtFields = count($_POST['subjectForm']);	// Number of text fields in the form
					
					for($i=0 ; $i<$numTxtFields ; ++$i) {
						$txtFieldContent = $_POST['subjectForm'][$i];
						
						if(isset($txtFieldContent) && !empty($txtFieldContent)) {
							$sqlQuery .= "'$txtFieldContent'";
							if($i != $numTxtFields-1) $sqlQuery .= ", "; // Separate arguments with a comma, but don't put it at the end
						}
						else {
							exit("Nie wszystkie pola zostały wypełnione.");
						}
					}
					$sqlQuery .= ")";
					
					// echo 'Wynikowe zapytanie: '.$sqlQuery.'<br>'; // Remove after testing
				
					$queryResult = $conn->query($sqlQuery);
					if(! $queryResult) die('Nie można wywołać procedury.');
					else echo 'Dodano przedmiot do bazy danych.';
				}
				else if(isset($_POST['classAdd'])) {
					$sqlQuery = "call dodajZajecia(";			// Query for calling the procedure
					$numTxtFields = count($_POST['classForm']);	// Number of text fields in the form
					
					for($i=0 ; $i<$numTxtFields ; ++$i) {
						$txtFieldContent = $_POST['classForm'][$i];
						
						if(isset($txtFieldContent) && !empty($txtFieldContent)) {
							$sqlQuery .= "'$txtFieldContent'";
							if($i != $numTxtFields-1) $sqlQuery .= ", "; // Separate arguments with a comma, but don't put it at the end
						}
						else {
							exit("Nie wszystkie pola zostały wypełnione.");
						}
					}
					$sqlQuery .= ")";
					
					// echo 'Wynikowe zapytanie: '.$sqlQuery.'<br>'; // Remove after testing
				
					$queryResult = $conn->query($sqlQuery);
					if(! $queryResult) die('Nie można wywołać procedury.');
					else echo 'Dodano zajęcia do bazy danych.';
				}
			}
			
			$conn->close();
		?>
	</body>
</html>
