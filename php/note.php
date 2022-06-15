<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>備忘錄</title>
    <style>
        body{
            font-size: larger;
            font-weight: lighter;
        }
        .bei{
            color:#7F1714;
        }
    </style>
</head>
<body>
    <div>
        <center>
            <div class=bei>
                <h2>備忘錄</h2>
                <form action = "note.php" method = "post">
                    時間：<input type = "date" name = "time"><br>
                    事件：<textarea name = "text"></textarea><br>
                    <input type = "submit" value = "提 交">
                </form>
            </div>
            <a href="lookup.php">查詢</a>
    </center>
    </div>
    <div>
        <center>
            <h1>
                <?php
                $connect = mysqli_connect("localhost","root","root2021","Bei");
                if($connect){
                    //echo "連接成功";
                }else{
                    echo "連接失敗";
                }
                $sel = "select = from beiwanglu";
                $selc = mysqli_query($connect,$sel);
                if($selc){
                    while($array = mysqli_fetch_array($selc)){
                        if(date("yy-m-d")==$array['time']){
                            echo "今天是".$array['time']."該".$array['text']."了";
                        }
                        echo "<br>";
                    }
                }else{
                    echo "<script>alert('查詢失敗');history.go(-1);</script>";
                }

                mysqli_close($connect);
                ?>    
            </h1>
        </center>
    </div>
    
</body>
</html>