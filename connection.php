<?php
$con=mysql_connect("localhost","root","")or die("could not connect database");
$db=mysql_select_db('projectmanagement',$con)or die("could not connect database");
?>