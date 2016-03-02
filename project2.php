<h1>Assignment2<h1>
<h3>Wei Hu<h3>
<hr>

<?php
#<table>
#<tr>
#<td><a href="captaint_p2_browse.php?sortby=authors">Author(s)</a>
#<td><a href="captaint_p2_browse.php?sortby=title">Title</a>
#<td><a href="captaint_p2_browse.php?sortby=publication">Publication</a>
#<td><a href="captaint_p2_browse.php?sortby=year">Year</a>
#<td><a href="captaint_p2_browse.php?sortby=type">Type</a>
#</tr>

	if(isset($_GET['currentpage'])){
		$currentpage = $_GET['currentpage'];
	}else {
		$currentpage = 1;
	}
	
	if(isset($_GET['sortby'])){
			$sort = $_GET['sortby'];
	}else {
			$sort = "itemnum";
	}

	echo "<table>";
    echo "<tr>";
	echo "<td>";
	echo "<a href=\"captaint_p2_browse.php?sortby=authors&currentpage=$currentpage\">Author(s)</a>";
	echo "<td>";
	echo "<a href=\"captaint_p2_browse.php?sortby=title&currentpage=$currentpage\">Title</a>";
	echo "<td>";
	echo "<a href=\"captaint_p2_browse.php?sortby=publication&currentpage=$currentpage\">Publication</a>";
	echo "<td>";
	echo "<a href=\"captaint_p2_browse.php?sortby=year&currentpage=$currentpage\">Year</a>";
	echo "<td>";
	echo "<a href=\"captaint_p2_browse.php?sortby=type&currentpage=$currentpage\">Type</a>";
    echo "</tr>";
	
	require "dbconnect_iproc.php";
	
	switch ($sort) {
		case "authors":
			$sql = "select authors, title, publication, year, type, url from bigrecords 
					order by authors limit ?, 25";
			break;
		case "title":
			$sql = "select authors, title, publication, year, type, url from bigrecords 
					order by title limit ?, 25";
			break;
		case "publication":
			$sql = "select authors, title, publication, year, type, url from bigrecords
					order by publication limit ?, 25";
			break;
		case "year":
			$sql = "select authors, title, publication, year, type, url from bigrecords
					order by year limit ?, 25";
			break;
		case "type":
			$sql = "select authors, title, publication, year, type, url from bigrecords
					order by type limit ?, 25";
			break;
		default:
			$sql = "select authors, title, publication, year, type, url from bigrecords
					order by itemnum limit ?, 25";
			break;
		
	}
	
	if ($stmt = mysqli_prepare($db, $sql)) {
		$limit = ($currentpage-1)*25;
		mysqli_stmt_bind_param($stmt,'i',$limit);	
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt,$authors,$title,$publication,$year,$type,$url);
		while(mysqli_stmt_fetch($stmt)){
			echo "<tr>";
			echo "<td>".$authors."</td>";
			echo "<td>"."<a href="."\"".$url."\">".$title."</a>"."</td>";
			echo "<td>".$publication."</td>";
			echo "<td>".$year."</td>";
			echo "<td>".$type."</td>";			
			echo "</tr>";
		}
		echo "</table>";
		echo "<hr>";
		
	}else {
		echo "prepare failed";
	}
	mysqli_stmt_close(); 
	mysqli_close();
	
	$query = "select count(title) as recordnum from bigrecords";
	if ($result = mysqli_query($db,$query)){
		while ($row = mysqli_fetch_assoc($result)) {
			$count = $row['recordnum'];
		}
	}
	
	echo "<center>";
	if ($p%25!=0) {
		for ($p=1;$p<=$count/25+1;$p++) {
			if ($p==$currentpage) {
				echo " &#91 ".$p." &#93 ";
			}else {
				echo "<a href="."\"captaint_p2_browse.php?sortby=$sort&currentpage=$p\">".$p."</a>";
				echo "\r";
			}
		}
	}else {
		for ($p=1;$p<=$count/25;$p++) {
			if ($p==$currentpage) {
				echo " &#91 ".$p." &#93 ";
			}else {
				echo "<a href="."\"captaint_p2_browse.php?sortby=$sort&currentpage=$p\">".$p."</a>";
				echo "\r";
			}
		}
	}
	echo "<center>"
	
?>
