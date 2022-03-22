<?php
	$conn = new mysqli ("localhost", "root", "", "document");
	$answered = $conn->query ("SELECT SUM(value) FROM register")->fetch_assoc()['SUM(value)'];
	$isnot = $conn->query ("SELECT * FROM register WHERE name = '{$_GET['name']}'")->fetch_assoc()['value'];

	if ($isnot)
	{
		while ($answered != 2)
		{
			$answered = $conn->query ("SELECT SUM(value) FROM register")->fetch_assoc()['SUM(value)'];
			usleep (300);
		}

		$conn->query ("UPDATE register SET value = 0");
		$conn->query("UPDATE logining SET count = 0");

		$q1 = rand (1, 99);
		$q2 = rand (1, 99);
		$qm1 = rand (0, 2);
		$qm2 = rand (0, 2);
		$symbol = rand (2, 4);

		$conn->query ("UPDATE question SET qm = {$symbol} + {$qm1} + {$qm2}");

		$n = 1;
		for ($n = 1; $qm1 > 0; $qm1 --)
		{
			$n = $n * 10;
		}
		$qm1 = $n;
		$q1 = $q1 / $qm1;

		$n = 1;
		for ($n = 1; $qm2 > 0; $qm2 --)
		{
			$n = $n * 10;
		}
		$qm2 = $n;

		$conn->query ("UPDATE question SET q1 = '$q1'");
		$conn->query ("UPDATE question SET q2 = '$q2'");
		$conn->query ("UPDATE question SET symbol = '$symbol'");

	}

	echo 0;
?>