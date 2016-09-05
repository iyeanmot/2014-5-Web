<?
session_start();
?>
<meta charset="euc-kr">
<?
	$num = $_GET['num'];
?>
<meta charset="euc-kr">
<?
   if(!$reply_name) {
     echo("
	   <script>
	     window.alert('이름을 입력하세요.')
	     history.go(-1)
	   </script>
	 ");
	 exit;
   }
   
   if(!$reply_content) {
     echo("
	   <script>
	     window.alert('내용을 입력하세요.')
	     history.go(-1)
	   </script>
	 ");
	 exit;
   }
   
   include "../lib/dbconn.php";       // dbconn.php 파일을 불러옴

	$sql = "select * from member where id='$userid'";
	$result = mysql_query($sql, $connect);
	$row = mysql_fetch_array($result);

	$name = $row[name];

   $regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장

   // 레코드 삽입 명령
   $sql = "insert into root_reply (parent, id, content, regist_day) ";
   $sql .= "values($num, '$reply_name', '$reply_content', '$regist_day')"; 
   
   mysql_query($sql, $connect);  

   $sql = "select * from root where num = $num";
   $result = mysql_query($sql, $connect);
   $row = mysql_fetch_array($result); 
   $rep_cnt = $row[rep] + 1;

   $sql = "UPDATE root SET rep = $rep_cnt where num = $num";
      
   mysql_query($sql, $connect);  // $sql 에 저장된 명령 실행

   mysql_close();                // DB 연결 끊기
   
   echo "
	   <script>
	    location.href = 'list.html?table=$table&page=$page';
	   </script>
	";
?>

   
