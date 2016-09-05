 create table root (
 num int not null auto_increment,
 subject char(100) not null,
 content text not null,
 regist_day char(20),
 rep int,
 is_html char(1),
 primary key(num)
 );
