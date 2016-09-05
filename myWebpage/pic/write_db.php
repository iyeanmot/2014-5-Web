<?php
    $table = $_GET['table'];
    $mode = $_GET['mode'];
    $num = $_GET['num'];

	include "../lib/dbconn.php";

	if ($mode=="modify")
	{
		$sql = "select * from $table where num=$num";
		$result = mysql_query($sql, $connect);

		$row = mysql_fetch_array($result);       
	
		$item_subject     = $row[subject];
		$item_content     = $row[content];
    $item_tag    = $row[tag];

		$item_file=array($row[file_name_0],$row[file_name_1],$row[file_name_2]);

        //$copied_file=array($row[file_copied_0],$row[file_copied_1],$row[file_copied_2]);
		$copied_file_0 = $row[file_copied_0];
		$copied_file_1 = $row[file_copied_1];
		$copied_file_2 = $row[file_copied_2];
	}
?>