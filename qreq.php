<?php
	$conn = new mysqli ("localhost", "root", "", "document");

	$result = $conn->query ("SELECT * FROM question");

	echo json_encode($result->fetch_assoc());
?>