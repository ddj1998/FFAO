<?php
	$conn = new mysqli ("localhost", "root", "", "document");

	$name = $_GET['name'];

	echo $conn->query ("SELECT * FROM register WHERE name = '$name'")->fetch_assoc()['value'];

?>