<?php

class fromdb
{
    const servername = "localhost:3306";
    const username = "english";
    const password = "123456";
    const dbname = "english";

    public function getwords(){

        // 创建连接
        $conn = new mysqli(self::servername, self::username, self::password, self::dbname);
        // 检测连接
        if ($conn->connect_error) {
            die("连接失败: " . $conn->connect_error);
        } 

        // 防止出现中文乱码
        $conn->query('SET NAMES UTF8');

        // 获取最大随机种子
        $sql = "SELECT MAX(seeds) AS max_seeds FROM words";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) 
            {
                $max_seeds = $row["max_seeds"];
            }
        }
        $random_seeds=rand(1,$max_seeds);

        $sql = "SELECT words FROM words WHERE seeds=$random_seeds";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) 
            {
                $words_selected = $row["words"];
            }
        }
        $conn->close();
        return $words_selected;
    }

    public function check($wd){
        // 创建连接
        $conn = new mysqli(self::servername, self::username, self::password, self::dbname);
        // 检测连接
        if ($conn->connect_error) {
            die("连接失败: " . $conn->connect_error);
        } 
        // 防止出现中文乱码
        $conn->query('SET NAMES UTF8');
        $sql = "select 1 from words where words = '$wd' limit 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            return True;
        }
        else{
            return False;
        }
    }

    public function getinfo($wd){
        // 创建连接
        $conn = new mysqli(self::servername, self::username, self::password, self::dbname);
        // 检测连接
        if ($conn->connect_error) {
            die("连接失败: " . $conn->connect_error);
        } 
        // 防止出现中文乱码
        $conn->query('SET NAMES UTF8');

        $sql = "SELECT meaning_en FROM `words` WHERE words='$wd'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) 
            {
                $meaning_en = $row["meaning_en"];
            }
        }

        $sql = "SELECT meaning_ch FROM `words` WHERE words='$wd'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) 
            {
                $meaning_ch = $row["meaning_ch"];
            }
        }

        $sql = "SELECT sentences FROM `words` WHERE words='$wd'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) 
            {
                $sentences = $row["sentences"];
            }
        }
        $info = $wd.'是'.$meaning_en.'的意思，即'.$meaning_ch.PHP_EOL.
        '例句：'.$sentences.PHP_EOL;
        return $info;
    }

}
?>