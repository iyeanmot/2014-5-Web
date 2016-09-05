<? session_start(); ?>

<meta charset="euc-kr">
<?
   session_start();
   $table = root;
   include "../lib/dbconn.php";

   $num = $_GET['num'];
   $sql="select * from $table where num=$num";

   $result=mysql_query($sql, $connect); 
   $row=mysql_fetch_array($result);

   $copied_name[0]=$row[file_copied_0];
   $copied_name[1]=$row[file_copied_1];
   $copied_name[2]=$row[file_copied_2];

   for($i=0; $i<3; $i++)
   {
     if($copied_name[$i])
     {
       $image_name="./data/".$copied_name[$i];
       unlink($image_name);
     }
   }

   $sql="delete from $table where num=$num";
   mysql_query($sql, $connect);
 
   mysql_close();
 
   echo ("
     <script>
       location.href='./list.html?table=$table';
	   window.alert('삭제완료');
     </script>
   ");
 ?>

