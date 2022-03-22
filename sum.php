<?php
	$conn = new mysqli ("localhost", "root", "", "document");
	$sum3 = $conn->query("SELECT * FROM logining WHERE name = '{$_GET['name']}'")->fetch_assoc()['count'];
	$sum1 = $conn->query ("SELECT * FROM logining WHERE name = 'Lujinwen'")->fetch_assoc()['score'];
	$sum2 = $conn->query ("SELECT * FROM logining WHERE name = 'Lubowen'")->fetch_assoc()['score'];

	echo "var sum1 = {$sum1};var sum2 = {$sum2};var sum3 = $sum3";
?>