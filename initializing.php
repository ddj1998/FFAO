<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.js"></script>
<script type="text/javascript">
	<?php
	$conn = new mysqli("localhost", "root", "", "document");
	$conn->query("UPDATE register SET value = 1");
	?>

	window.location.href = "/competition/rreq.php?name=Lubowen"


	<?php
		$conn = new mysqli("localhost", "root", "", "document");
		$score1 = $conn->query("SELECT * FROM logining WHERE name = 'Lubowen'")->fetch_assoc();
		$score2 = $conn->query("SELECT * FROM logining WHERE name = 'Lujinwen'")->fetch_assoc();

		$conn->query("INSERT INTO history VALUES(CURRENT_TIMESTAMP(), {$score1['score']}, {$score2['score']})");
		$conn->query("UPDATE logining SET score = 0");

		echo "right";
	?>

</script>