<?php
$connect = mysqli_connect("localhost","root","root2021","Bei");
if($connect){
    //echo "連接成功";
}else{
    echo "連接失敗";
}
mysqli_close($connect);
?>