<?php
	if (!isset($_SESSION['role'])) {
		# code...
		header('Location: login.php?enter');
	}
?>