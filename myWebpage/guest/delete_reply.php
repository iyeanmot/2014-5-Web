<?
	include "../lib/dbconn.php";

	$sql="delete from memo_ripple where num = $replynum";
	mysql_query($sql, $connect);

mysql_close();

echo ("
<script>
location.href = './list.html?table=$table';
</script>
");
?>
