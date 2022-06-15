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
        echo $array['time']." ".$array['text'];
        echo "<br>";
    }
}else{
    echo "<script>alert('查詢失敗');history.go(-1);</script>";
}

mysqli_close($connect);
?>