<?php
	$h = 'pearl.ils.unc.edu';
	$u = '*******';
	$p = '*******';
	$dbname = '******';
	$db = mysqli_connect($h,$u,$p,$dbname);
	if (mysqli_connect_errno()) {
		echo "Connect failed" . mysqli_connect_error();
		exit();
	}
?>
