<?
	include "../lib/dbconn.php";

	$sql="delete from root_reply where num = $replynum";
	mysql_query($sql, $connect);

   $sql = "select * from root where num = $num";
   $result = mysql_query($sql, $connect);
   $row = mysql_fetch_array($result); 
   $rep_cnt = $row[rep] - 1;

   $sql = "UPDATE root SET rep = $rep_cnt where num = $num";
      
   mysql_query($sql, $connect);

mysql_close();

echo ("
<script>
location.href = './list.html?table=$table';
</script>
");
?>
