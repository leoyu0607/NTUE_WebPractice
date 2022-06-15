<?php
$connect = mysqli_connect("localhost","root","root2021","Bei");
if($connect){
    //echo "連接成功";
}else{
    echo "連接失敗";
}
$time = @$_POST['time'];
$text = @$_POST['text'];
$setTime = date("yy-m-d");
$setData = "insert into beiwanglu(time,text,settime)
values('$time','$text','$setTime')
";
if(mysqli_query($connect,$setData)){
    echo "<script>alert('設置成功');window.location.href='note.php';</script>";
}else{
    echo "<script>alert('設置失敗');history.go(-1);</script>";
}
mysqli_close($connect);
?>