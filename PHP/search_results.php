<!DOCTYPE html >
<html lang="pl-PL">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Wirtualny dziekanat - Wyniki wyszukiwania</title>
	</head>
	<body>
		<h1>Wirtualny dziekanat - Wyniki wyszukiwania</h1>
		<?php
			function addQuerySeparator(&$q) {
				if(strpos($q, 'where') == false) $q .= " where ";
				else $q .= " and ";
			}
		
			// Connect with database:
			header('Content-Type:text/html; charset=UTF-8');
			
			require_once 'login.php';
			$conn = new mysqli($hostname, $username, $pw, $DBname);
			
			if($conn->connect_error) die($conn->connect_error);
			
			
			// Search for results:
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				if(isset($_POST['studentSearch'])) {			
					$sqlQuery = "select * from student";
					$fieldsInOrder = array("Imie", "Nazwisko", "PESEL", "Kierunek", "Grupa", "Status"); // Order as in corresponding html form
					
					foreach(array_combine($fieldsInOrder, $_POST['studentForm']) as $column => $form) {
						if(isset($form) && !empty($form) && $form != "ANY") {
							addQuerySeparator($sqlQuery);
							$sqlQuery .= "$column='$form'";
						}
					}
					
					echo 'QUERY: '.$sqlQuery.'<br>'; // Remove after testing
				
					$queryResult = $conn->query($sqlQuery);
					if(! $queryResult) die('Nie można pobrać danych.');
					
					$rowsNumber = $queryResult->num_rows;
					
					for($i=0 ; $i<$rowsNumber ; ++$i) {
						$queryResult->data_seek($i);
						$row = $queryResult->fetch_array(MYSQLI_ASSOC);
						
						echo 'STUDENT: '.$row['Imie'].' '.$row['Nazwisko'].' '.$row['PESEL'].' KIERUNEK: '.$row['Kierunek'].' GRUPA: '.$row['Grupa'].' STATUS: '.$row['Status'].'<br>';		
					}
					
					$queryResult->close();
				}
				else if(isset($_POST['tutorSearch'])) {
					$sqlQuery = "select * from prowadzacy";
					$fieldsInOrder = array("Imie", "Nazwisko", "Tytul"); // Order as in corresponding html form
					
					foreach(array_combine($fieldsInOrder, $_POST['tutorForm']) as $column => $form) {
						if(isset($form) && !empty($form)) {
							addQuerySeparator($sqlQuery);
							$sqlQuery .= "$column='$form'";
						}
					}
					
					echo 'QUERY: '.$sqlQuery.'<br>'; // Remove after testing
				
					$queryResult = $conn->query($sqlQuery);
					if(! $queryResult) die('Nie można pobrać danych.');
					
					$rowsNumber = $queryResult->num_rows;
					
					for($i=0 ; $i<$rowsNumber ; ++$i) {
						$queryResult->data_seek($i);
						$row = $queryResult->fetch_array(MYSQLI_ASSOC);
						
						echo 'PROWADZĄCY: '.$row['Tytul'].' '.$row['Imie'].' '.$row['Nazwisko'].'<br>';		
					}
					
					$queryResult->close();
				}

				else if(isset($_POST['gradeSearch'])) {
					$sqlQuery = "select * from ocenakoncowa";
					$fieldsInOrder = array("Wartosc", "DataWystawienia"); // Order as in corresponding html form
					
					foreach(array_combine($fieldsInOrder, $_POST['gradeForm']) as $column => $form) {
						if(isset($form) && !empty($form)) {
							addQuerySeparator($sqlQuery);
							$sqlQuery .= "$column='$form'";
						}
					}
					
					echo 'QUERY: '.$sqlQuery.'<br>'; // Remove after testing
				
					$queryResult = $conn->query($sqlQuery);
					if(! $queryResult) die('Nie można pobrać danych.');
					
					$rowsNumber = $queryResult->num_rows;
					
					for($i=0 ; $i<$rowsNumber ; ++$i) {
						$queryResult->data_seek($i);
						$row = $queryResult->fetch_array(MYSQLI_ASSOC);
						
						echo 'OCENA: '.$row['Wartosc'].' '.$row['DataWystawienia'].' Numer albumu: '.$row['NumerAlbumu'].' ID Przedmiotu: '.$row['ID_Przedmiotu'].'<br>';		
					}
					
					$queryResult->close();
				}
				else if(isset($_POST['subjectSearch'])) {
					$sqlQuery = "select * from przedmiot";
					$fieldsInOrder = array("Nazwa", "ECTS", "SposobZaliczenia", "Semestr"); // Order as in corresponding html form
					
					foreach(array_combine($fieldsInOrder, $_POST['subjectForm']) as $column => $form) {
						if(isset($form) && !empty($form) && $form != "ANY") {
							addQuerySeparator($sqlQuery);
							$sqlQuery .= "$column='$form'";
						}
					}
					
					echo 'QUERY: '.$sqlQuery.'<br>'; // Remove after testing
				
					$queryResult = $conn->query($sqlQuery);
					if(! $queryResult) die('Nie można pobrać danych.');
					
					$rowsNumber = $queryResult->num_rows;
					
					for($i=0 ; $i<$rowsNumber ; ++$i) {
						$queryResult->data_seek($i);
						$row = $queryResult->fetch_array(MYSQLI_ASSOC);
						
						echo 'PRZEDMIOT: '.$row['Nazwa'].' ECTS: '.$row['ECTS'].' '.$row['SposobZaliczenia'].' SEMESTR: '.$row['Semestr'].' ID Typu przedmiotu: '.$row['ID_TypuPrzedmiotu'].'<br>';		
					}
					
					$queryResult->close();
				}
				else if(isset($_POST['classSearch'])) {
					$sqlQuery = "select * from zajecia";
					$fieldsInOrder = array("Godzina", "NumerSali", "DzienTygodnia"); // Order as in corresponding html form
					
					foreach(array_combine($fieldsInOrder, $_POST['classForm']) as $column => $form) {
						if(isset($form) && !empty($form) && $form != "ANY") {
							addQuerySeparator($sqlQuery);
							$sqlQuery .= "$column='$form'";
						}
					}
					
					echo 'QUERY: '.$sqlQuery.'<br>'; // Remove after testing
				
					$queryResult = $conn->query($sqlQuery);
					if(! $queryResult) die('Nie można pobrać danych.');
					
					$rowsNumber = $queryResult->num_rows;
					
					for($i=0 ; $i<$rowsNumber ; ++$i) {
						$queryResult->data_seek($i);
						$row = $queryResult->fetch_array(MYSQLI_ASSOC);
						
						echo 'ZAJĘCIA: '.$row['Godzina'].' '.$row['NumerSali'].' '.$row['DzienTygodnia'].' ID_TypuZajec: '.$row['ID_TypuZajec'].' ID_Prowadzacego: '.$row['ID_Prowadzacego'].' ID_Przedmiotu: '.$row['ID_Przedmiotu'].'<br>';		
					}
					
					$queryResult->close();
				}
			}
			$conn->close();
		?>
	</body>
</html>
