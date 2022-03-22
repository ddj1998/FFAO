<?php
	$conn = new mysqli ("localhost", "root", "", "document");
	$name = $_GET['name'];

	$question = $conn->query ("SELECT * FROM question")->fetch_assoc();
	$answered = $conn->query ("SELECT SUM(value) FROM register")->fetch_assoc()['SUM(value)'];
	$isnot = $conn->query ("SELECT * FROM register WHERE name = '$name'")->fetch_assoc()['value'];

	$symbol = $question['symbol'];
	$qm = $question['qm'];

	switch ($symbol) {
		case 1: $correct = $question['q1'] + $question['q2'];
			break;
		case 2: $correct = $question['q1'] - $question['q2'];
			break;
		case 3: $correct = $question['q1'] * $question['q2'];
			break;
		case 4: $correct = $question['q2'];
			break;
	}

	function add_1()
	{
		global $conn, $name;
		$conn->query("UPDATE logining SET count = count + 1 WHERE name = '$name'");
	}

	function add_score($times)
	{
		global $conn, $name;
		$count = $conn->query("SELECT * FROM logining WHERE name = '$name'")->fetch_assoc()['count'];
		$conn->query("UPDATE register SET value = 1 WHERE name = '$name'");

		$score = $times - $count;

		$conn->query("UPDATE logining SET score = score + $score WHERE name = '$name'");
	}

	if($isnot == 1)
	{
		echo 2;
	}

	else
	{
		if (strval ($correct) == $_GET['answer'])
		{
			if($answered == 0)
			{
				add_1();
				add_score($qm);
				echo 0;
			}

			else if($answered == 1)
			{
				add_1();
				add_score($qm / 2);
				echo 0;
			}
		}

		else
		{
			add_1();
			echo 1;
		}
	}
?>