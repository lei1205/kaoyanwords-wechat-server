您输入的单词为：<?php echo $_POST["words"]; ?><br>
英文解释为：<?php echo $_POST["meaning_en"]; ?><br>
中文解释为：<?php echo $_POST["meaning_ch"]; ?><br>
例句为：<?php echo $_POST["sentences"]; ?><br>
<br>

<?php
$p1 = $_POST["words"];
$p2 = $_POST["meaning_en"];
$p3 = $_POST["meaning_ch"];
$p4 = $_POST["sentences"];

$servername = "localhost:3306";
$username = "english";
$password = "123456";
$dbname = "english";
 
// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 
$conn->query('SET NAMES UTF8');

$sql = "select 1 from words where words = '$p1' limit 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    die("该单词已收录！");
}
if (empty($p1)) {
    die("未输入单词！");
} 

$sql = "INSERT INTO words (words, meaning_en, meaning_ch, sentences)
VALUES ('$p1', '$p2', '$p3','$p4')";
if ($conn->query($sql) === TRUE) {
    echo "新记录插入成功";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
 
$conn->close();
?>