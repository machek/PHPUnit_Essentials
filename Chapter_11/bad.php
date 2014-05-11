<?
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $conn = mysql_connect($dbhost, $dbuser, $dbpass);
    mysql_select_db('mydb');
?>
<html>
<head>
    <title>Super Page</title>
</head>
<body>
<form action="" method="post">
    <input name="column1" type="text">
    <input type="submit" value="Submit">
</form>
<?
    if($_POST['column1']){
        $sql = "INSERT INTO table1 (column1) VALUES ('".$_POST['column1']."')";
        mysql_query( $sql);
    }
?>
<table>
    <tr>
        <th>Id</th>
        <th>Column1</th>
    </tr>
    <?
    $query=mysql_query("SELECT * FROM table1");
    while($r = mysql_fetch_assoc($query)) {
       echo "<tr><td>".$r['id'].'</td><td>'.$r['column1']."</td></tr>";
    }
    ?>
</table>
</body>
</html>
<?
mysql_close($conn);
?>