<? session_start(); ?>

<meta charset="euc-kr">
<?
  $table = "root";
  // ���� ���� ���ε�
  $files=$_FILES["upfile"];
  $count=count($files["name"]);
		
  $upload_dir='./data/';

  for($i=0; $i<$count; $i++)
  {
    $upfile_name[$i]=$files["name"][$i];
    $upfile_tmp_name[$i]=$files["tmp_name"][$i];
    $upfile_type[$i]=$files["type"][$i];
    $upfile_size[$i]=$files["size"][$i];
    $upfile_error[$i]=$files["error"][$i];

    $file=explode(".", $upfile_name[$i]);
    $file_name=$file[0];
    $file_ext=$file[1];

    if(!$upfile_error[$i])
    {
      $new_file_name=date("Y_m_d_H_i_s");
      $new_file_name=$new_file_name."_".$i;
      $copied_file_name[$i]=$new_file_name.".".$file_ext; 
      $uploaded_file[$i]=$upload_dir.$copied_file_name[$i];

      if($upfile_size[$i]>1000000)
      {
        echo("
          <script>
            alert('���ε� ���� ũ�Ⱑ ������ �뷮(1MB)�� �ʰ��մϴ�!<br>                       ���� ũ�⸦ üũ���ּ���! ');
            history.go(-1)
          </script>
        ");
        exit;
      }
    
      if(($upfile_type[$i]!="image/gif") && ($upfile_type[$i]!="image/jpeg")
          && ($upfile_type[$i]!="image/pjpeg"))
      {
        echo("
          <script>
            alert('JPG�� GIF �̹��� ���ϸ� ���ε� �����մϴ�!');
            history.go(-1)
          </script>
        ");
        exit;
      }

      if(!move_uploaded_file($upfile_tmp_name[$i], $uploaded_file[$i]))
      {
        echo("
          <script>
            alert('������ ������ ���丮�� �����ϴµ� �����߽��ϴ�.');
            history.go(-1)
          </script>
        ");
        exit;
      }
    }
  }                                   // for�� ����(32��)

  include "../lib/dbconn.php";        // dcnn.php ������ �ҷ���

  if($mode=="modify")                               // ���� �� ����
  {
    $num_checked=count($_POST['del_file']);
    $position=$_POST['del_file'];

    for($i=0; $i<$num_checked; $i++)                // ���� ǥ���� �׸�
    {
      $index=$position[$i];
      $del_ok[$index]="y";
    }

    $sql="select * from $table where num=$num";     // ������ ���ڵ� �˻�
    $result=mysql_query($sql);
    $row=mysql_fetch_array($result);

    for($i=0; $i<$count; $i++)
    {
      $field_org_name="file_name_".$i;
      $field_real_name="file_copied_".$i;

      $org_name_value=$upfile_name[$i];
      $org_real_value=$copied_file_name[$i];
      if($del_ok[$i]=="y")
      {
        $delete_field="file_copied_".$i;
        $delete_name=$row[$delete_field];
        $delete_path="./data/".$delete_name;

        unlink($delete_path);

        $sql="update $table set $field_org_name='$org_name_value',                 $field_real_name='$org_real_value' where num=$num";
        mysql_query($sql, $connect);         // $sql�� ����� ���� ����
      }
      else
      {
        if(!$upfile_error[$i])
        {
          $sql="update $table set $field_org_name='$org_name_value',                   $field_real_name='$org_real_value' where num=$num";
          mysql_query($sql, $connect);           // $sql�� ����� ���� ����
        }
      }
    }                                            //end of for��
    $sql="update $table set subject='$subject', content='$content'
          where num=$num";
    mysql_query($sql, $connect);                 // $sql�� ����� ���� ����
  }
  else                                // ���� �ۼ��Ǵ� �� ����
  {
    if($html_ok=="y")
    {
      $is_html="y";
    }
    else
    {
      $is_html="";
      $content=htmlspecialchars($content);
    }
	$regist_day=date("Y-m-d (H:i)");
    $sql="insert into $table (subject, content, 
         regist_day, rep, is_html, ";
    $sql.="file_name_0, file_name_1, file_name_2, 
          file_copied_0, file_copied_1, file_copied_2) ";
    $sql.="values('$subject', '$content', '$regist_day', 0, '$is_html', ";
    $sql.="'$upfile_name[0]', '$upfile_name[1]', '$upfile_name[2]',
    '$copied_file_name[0]', '$copied_file_name[1]', '$copied_file_name[2]')";
    mysql_query($sql, $connect);      // $sql �� ����� ���� ����
  }
  mysql_close();                      // �����ͺ��̽� ���� ���� 
  echo ("
    <script>
      location.href='list.html?table=$table&page=$page';
    </script>
  ");
?>
