 create table pic (
 num int not null auto_increment,
 subject char(100) not null,
 content text not null,
 regist_day char(20),
 tag char(20),
 is_html char(1),
 primary key(num)
 );
