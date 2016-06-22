<!DOCTYPE html >
<html lang="pl-PL">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="defaultstyle.css" media="screen" />
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
			$conn-> query("SET NAMES 'utf8'");
			
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
					
					// echo 'Wynikowe zapytanie: '.$sqlQuery.'<br>'; // Remove after testing
				
					$queryResult = $conn->query($sqlQuery);
					if(! $queryResult) die('Nie można pobrać danych.');
					
					$rowsNumber = $queryResult->num_rows;
					
					echo '<table>';
					echo '<tr><td>Imie</td><td>Nazwisko</td><td>PESEL</td><td>Kierunek</td><td>Grupa</td><td>Status</td></tr>';
					for($i=0 ; $i<$rowsNumber ; ++$i) {
						$queryResult->data_seek($i);
						$row = $queryResult->fetch_array(MYSQLI_ASSOC);
						echo '<tr><td>'.$row['Imie'].'</td><td>'.$row['Nazwisko'].'</td><td>'.$row['PESEL'].'</td><td>'.$row['Kierunek'].'</td><td>'.$row['Grupa'].'</td><td>'.$row['Status'].'</td></tr>';		
					}
					echo '</table>';
					
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
					
					// echo 'Wynikowe zapytanie: '.$sqlQuery.'<br>'; // Remove after testing
				
					$queryResult = $conn->query($sqlQuery);
					if(! $queryResult) die('Nie można pobrać danych.');
					
					$rowsNumber = $queryResult->num_rows;
					
					echo '<table>';
					echo '<tr><td>Tytul</td><td>Imie</td><td>Nazwisko</td></tr>';
					for($i=0 ; $i<$rowsNumber ; ++$i) {
						$queryResult->data_seek($i);
						$row = $queryResult->fetch_array(MYSQLI_ASSOC);
						echo '<tr><td>'.$row['Tytul'].'</td><td>'.$row['Imie'].'</td><td>'.$row['Nazwisko'].'</td></tr>';
					}
					echo '</table>';
					
					$queryResult->close();
				}
				else if(isset($_POST['gradeSearch'])) {
					$sqlQuery = "SELECT o.Wartosc, o.DataWystawienia,o.NumerAlbumu, p.Nazwa as Przedmiot FROM ocenakoncowa o join przedmiot p on o.ID_Przedmiotu = p.ID_Przedmiotu";
					$fieldsInOrder = array("Wartosc", "DataWystawienia"); // Order as in corresponding html form
					
					foreach(array_combine($fieldsInOrder, $_POST['gradeForm']) as $column => $form) {
						if(isset($form) && !empty($form)) {
							addQuerySeparator($sqlQuery);
							$sqlQuery .= "$column='$form'";
						}
					}
					
					// echo 'Wynikowe zapytanie: '.$sqlQuery.'<br>'; // Remove after testing
				
					$queryResult = $conn->query($sqlQuery);
					if(! $queryResult) die('Nie można pobrać danych.');
					
					$rowsNumber = $queryResult->num_rows;
					
					echo '<table>';
					echo '<tr><td>Wartość</td><td>Data Wystawienia</td><td>Numer Albumu</td><td>Przedmiot</td></tr>';
					for($i=0 ; $i<$rowsNumber ; ++$i) {
						$queryResult->data_seek($i);
						$row = $queryResult->fetch_array(MYSQLI_ASSOC);
						echo '<tr><td>'.$row['Wartosc'].'</td><td>'.$row['DataWystawienia'].'</td><td>'.$row['NumerAlbumu'].'</td><td>'.$row['Przedmiot'].'</td></tr>';
					}
					echo '</table>';
					
					$queryResult->close();
				}
				else if(isset($_POST['subjectSearch'])) {
					$sqlQuery = "select p.Nazwa, p.ECTS, p.SposobZaliczenia, p.Semestr, tp.NazwaTypu as TypPrzedmiotu from przedmiot p join typprzedmiotu tp on p.ID_TypuPrzedmiotu = tp.ID_TypuPrzedmiotu";
					$fieldsInOrder = array("Nazwa", "ECTS", "SposobZaliczenia", "Semestr"); // Order as in corresponding html form
					
					foreach(array_combine($fieldsInOrder, $_POST['subjectForm']) as $column => $form) {
						if(isset($form) && !empty($form) && $form != "ANY") {
							addQuerySeparator($sqlQuery);
							$sqlQuery .= "$column='$form'";
						}
					}
					
					// echo 'Wynikowe zapytanie: '.$sqlQuery.'<br>'; // Remove after testing
				
					$queryResult = $conn->query($sqlQuery);
					if(! $queryResult) die('Nie można pobrać danych.');
					
					$rowsNumber = $queryResult->num_rows;
					
					echo '<table>';
					echo '<tr><td>Nazwa</td><td>ECTS</td><td>Sposób Zaliczenia</td><td>Semestr</td><td>Typ Przedmiotu</td></tr>';		
					for($i=0 ; $i<$rowsNumber ; ++$i) {
						$queryResult->data_seek($i);
						$row = $queryResult->fetch_array(MYSQLI_ASSOC);
			
						echo '<tr><td>'.$row['Nazwa'].'</td><td>'.$row['ECTS'].'</td><td>'.$row['SposobZaliczenia'].'</td><td>'.$row['Semestr'].'</td><td>'.$row['TypPrzedmiotu'].'</td></tr>';
					}
					echo '</table>';
					
					$queryResult->close();
				}
				else if(isset($_POST['classSearch'])) {
					$sqlQuery = 
					"
					SELECT z.Godzina, z.NumerSali, z.DzienTygodnia, tz.NazwaTypuZajec as TypZajec, CONCAT(pr.tytul,' ',pr.Imie,' ', pr.Nazwisko)as Prowadzacy, p.Nazwa as Przedmiot from zajecia z join typzajec tz on z.ID_TypuZajec = tz.ID_TypuZajec join prowadzacy pr on z.ID_Prowadzacego = pr.ID_Prowadzacego join przedmiot p on z.ID_Przedmiotu = p.ID_Przedmiotu
					";
					$fieldsInOrder = array("Godzina", "NumerSali", "DzienTygodnia"); // Order as in corresponding html form
					
					foreach(array_combine($fieldsInOrder, $_POST['classForm']) as $column => $form) {
						if(isset($form) && !empty($form) && $form != "ANY") {
							addQuerySeparator($sqlQuery);
							$sqlQuery .= "$column='$form'";
						}
					}
					
					// echo 'Wynikowe zapytanie: '.$sqlQuery.'<br>'; // Remove after testing
				
					$queryResult = $conn->query($sqlQuery);
					if(! $queryResult) die('Nie można pobrać danych.');
					
					$rowsNumber = $queryResult->num_rows;
					
					echo '<table>';
					echo '<tr><td>Godzina</td><td>Numer Sali</td><td>Dzień Tygodnia</td><td>Typ Zajęć</td><td>Prowadzacy </td><td>Przedmiot</td></tr>';
					for($i=0 ; $i<$rowsNumber ; ++$i) {
						$queryResult->data_seek($i);
						$row = $queryResult->fetch_array(MYSQLI_ASSOC);
						
						echo '<tr><td>'.$row['Godzina'].'</td><td>'.$row['NumerSali'].'</td><td>'.$row['DzienTygodnia'].'</td><td>'.$row['TypZajec'].'</td><td>'.$row['Prowadzacy'].'</td><td>'.$row['Przedmiot'].'</td></tr>';
					}
					echo '</table>';
					
					$queryResult->close();
				}
			}
			$conn->close();
		?>
	</body>
</html>