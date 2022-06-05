<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cal-110916040</title>
    <!--
        姓名:游博丞
        學號:110916040
        操作說明:
        1.如一般按鍵式計算機一般輸入數字(運算元1)
        2.若數字為0，按下減號會作為負號
        3.點按運算子
        4.輸入數字(運算元2)
        5.點按'='
        6.輸出結果
        自評分數:65
    -->
</head>
<body>
<!--變數宣告-->
<?php
$LastCal = "";//上一輪算式
$LastOpr = "";//上一輪運算子
$Lastresult = "";//上一輪結果
$hasUsed = false;//bool上一輪結果是否存在
$Number1 = 0.0;//float運算元1
$Number2 = 0.0;//float運算元2
$funct = 0;//int運算子(1(add)、2(subtract)、3(multiply)、4(divide))
$floatUsed = false;//bool是否用到小數點
$floatCount = 1;//int小數點後第幾位
$neNum = false;//bool是否用到負號
$result = 0.0;//float
?>
<!--二次以後的初始化-->
<?php
if(isset($_POST["re_LastCal"])) $LastCal = $_POST["re_LastCal"];
if(isset($_POST["re_LastOpr"])) $LastOpr = $_POST["re_LastOpr"];
if(isset($_POST["re_Lastresult"])) $Lastresult = $_POST["re_Lastresult"];
if(isset($_POST["re_hasUsed"])) $hasUsed = $_POST["re_hasUsed"];
if(isset($_POST["re_Number1"])) $Number1 = $_POST["re_Number1"];
if(isset($_POST["re_Number2"])) $Number2 = $_POST["re_Number2"];
if(isset($_POST["re_funct"])) $funct = $_POST["re_funct"];
if(isset($_POST["re_floatUsed"])) $floatUsed = $_POST["re_floatUsed"];
if(isset($_POST["re_neNum"])) $neNum = $_POST["re_neNum"];
if(isset($_POST["re_result"])) $result = $_POST["re_result"];
?>
<!--顯示數字的函式-->
<?php
function printInt($btnState){
    $IntNum = (float)$btnState;
    global $result;
    if($GLOBALS['neNum']==true) {$IntNum = (-1)*$IntNum;}
    if($result==0) {
        $result = $IntNum;
    }
    else {
        $result = $result*10 + $IntNum;
    }
}
function printFloat($btnState){
    $floatNum = (float)$btnState;
    if($GLOBALS['neNum']==true) {$floatNum = (-1)*$floatNum;}
    for ($i=0; $i<$GLOBALS['floatCount']; $i++){$floatNum = $floatNum*0.1;}
    $GLOBALS['floatCount']++;
    $GLOBALS['result'] = round(($GLOBALS['result'] + $floatNum),3);
}
?>
<!--運算部分-->
<?php
//清除上一輪
if($hasUsed) {
    switch($funct){
        case 1:$LastOpr = " + "; break;
        case 2:$LastOpr = " - "; break;
        case 3:$LastOpr = " * "; break;
        case 4:$LastOpr = " / "; break;
        default:$LastOpr = "   ";
    }
    $LastCal = "${Number1}"."${LastOpr}"."${Number2}"." = ";
    $Lastresult = $result;
    $Number1 =0; $Number2 =0; $funct =0; $result = 0;
    $floatUsed = false; $floatCount = 1;
    $hasUsed = false; $neNum = false;
}
//運算式
try{
    if(isset($_POST["btn"])) {
        $Button = $_POST["btn"];
        //清除資料(初始化)
        if($Button=="C"){
            $Number1 = $Number2 = $funct = $result = 0;
            $neNum = false;
            $floatUsed = false; $floatCount = 1;
        }
        //運算子按鈕->存第一個數字及運算元
        elseif($Button=="+"){
            $Number1 = $result; $funct = 1;
            $neNum = false; $result = 0;
            $floatUsed = false; $floatCount = 1;
        }
        elseif($Button=="-"){
            //負號
            if($result == 0){
                $neNum = true;
            }
            //減號
            else{
                $Number1 = $result; $funct = 2;
                $neNum = false; $result = 0;
                $floatUsed = false; $floatCount = 1;
            }
        }
        elseif($Button=="*"){
            $Number1 = $result; $funct = 3;
            $neNum = false; $result = 0;
            $floatUsed = false; $floatCount = 1;
        }
        elseif($Button=="/"){
            $Number1 = $result; $funct = 4;
            $neNum = false; $result = 0;
            $floatUsed = false; $floatCount = 1;
        }
        //等號按鈕->存第二個數字並計算(四捨五入至小數點後第3位)
        elseif($Button=="="){
            $Number2 = $result;
            switch($funct){
                case 1:$result = round(($Number1+$Number2),3);break;
                case 2:$result = round(($Number1-$Number2),3);break;
                case 3:$result = round(($Number1*$Number2),3);break;
                case 4:$result = round(($Number1/$Number2),3);break;
                default: 
            }
            $hasUsed = true;
        }
        //數字處理
        else {
            if($floatUsed){
                if($Button=="."){}
                else printFloat($Button);
            }
            else{
                if($Button=="."){$floatUsed = true;}//第一次按下小數點
                else printInt($Button);
            }
        }
    }
}
//捕捉例外並歸零
catch (DivisionByZeroError $error){
    $ShowError = $error->getMessage();
    $Number1 =0; $Number2 =0; $funct =0; $result = 0;
    $floatUsed = false; $floatCount = 1;
    $hasUsed = false;
}
catch (Exception $error){
    $Number1 =0; $Number2 =0; $funct =0; $result = 0;
    $floatUsed = false; $floatCount = 1;
    $hasUsed = false;
}
?>
<!--頁面設計-->
<div style="text-align:center;">
    <br><br>
    <font size="16" color="7F1734" style="text-shadow:3px 3px 3px #cccccc;" face="shadow">
        Calculator
    </font>
</div><br>
<center>
    <font size="4" color="7F1734" face="shadow">
        <!--顯示當前算式-->
        <?php
        if(isset($ShowError)){
            echo $ShowError;
        }
        else{
            if ($Number1 != 0) {echo "${Number1}";}
            echo " ";
            if ($funct != 0) {
                switch ($funct) {
                    case 1:echo " + ";break;
                    case 2:echo " - ";break;
                    case 3:echo " * ";break;
                    case 4:echo " / ";break;
                    default: 
                }
            }
            echo " ";
            if ($Number2 != 0) {echo "${Number2}";}
        }
        ?>
    </font>
    <br>
    <table>
        <tr>
            <form action="cal-110916040.php" method="post">
                <!--計算機設計-->
                <td>
                    <table align="center" border="3">
                        <!--顯示當前數字-->
                        <tr>
                            <td align='right' valign="middle" colspan="4" style="height:40px">
                                <font size="6" color="7F1734" face="shadow">
                                    <!--顯示當前數字result-->
                                    <?php
                                    if(($neNum==true) && ($result==0.0))echo "-";//顯示-0.0
                                    echo "${result}";
                                    ?>
                                </font>
                            </td>
                        </tr>
                        <!--按鍵區域789+-->
                        <tr>
                            <td align='center' valign="middle">
                                <input style="height:50px;width:50px;"
                                       type="submit" name="btn" value="7">
                            </td>
                            <td align='center' valign="middle">
                                <input style="height:50px;width:50px;"
                                       type="submit" name="btn" value="8">
                            </td>
                            <td align='center' valign="middle">
                                <input style="height:50px;width:50px;"
                                       type="submit" name="btn" value="9">
                            </td>
                            <td align='center' valign="middle">
                                <input style="height:50px;width:50px;"
                                       type="submit" name="btn" value="+">
                            </td>
                        </tr>
                        <!--按鍵區域456--->
                        <tr>
                            <td align='center' valign="middle">
                                <input style="height:50px;width:50px;"
                                       type="submit" name="btn" value="4">
                            </td>
                            <td align='center' valign="middle">
                                <input style="height:50px;width:50px;"
                                       type="submit" name="btn" value="5">
                            </td>
                            <td align='center' valign="middle">
                                <input style="height:50px;width:50px;"
                                       type="submit" name="btn" value="6">
                            </td>
                            <td align='center' valign="middle">
                                <input style="height:50px;width:50px;"
                                       type="submit" name="btn" value="-">
                            </td>
                        </tr>
                        <!--按鍵區域123*-->
                        <tr>
                            <td align='center' valign="middle">
                                <input style="height:50px;width:50px;"
                                       type="submit" name="btn" value="1">
                            </td>
                            <td align='center' valign="middle">
                                <input style="height:50px;width:50px;"
                                       type="submit" name="btn" value="2">
                            </td>
                            <td align='center' valign="middle">
                                <input style="height:50px;width:50px;"
                                       type="submit" name="btn" value="3">
                            </td>
                            <td align='center' valign="middle">
                                <input style="height:50px;width:50px;"
                                       type="submit" name="btn" value="*">
                            </td>
                        </tr>
                        <!--按鍵區域C0./-->
                        <tr>
                            <td align='center' valign="middle">
                                <input style="height:50px;width:50px;"
                                       type="submit" name="btn" value="C">
                            </td>
                            <td align='center' valign="middle">
                                <input style="height:50px;width:50px;"
                                       type="submit" name="btn" value="0">
                            </td>
                            <td align='center' valign="middle">
                                <input style="height:50px;width:50px;"
                                       type="submit" name="btn" value=".">
                            </td>
                            <td align='center' valign="middle">
                                <input style="height:50px;width:50px;"
                                       type="submit" name="btn" value="/">
                            </td>
                        </tr>
                        <!--按鍵區域=-->
                        <tr>
                            <td align='center' valign="middle" colspan="4">
                                <input style="height:50px;width:220px;"
                                       type="submit" name="btn" value="=">
                            </td>
                        </tr>
                    </table>
                </td>
                <!--將此次的執行結果回傳-->
                <input type="hidden" name="re_LastCal" value="<?php echo $LastCal ?>">
                <input type="hidden" name="re_LastOpr" value="<?php echo $LastOpr ?>">
                <input type="hidden" name="re_Lastresult" value="<?php echo $Lastresult ?>">
                <input type="hidden" name="re_hasUsed" value="<?php echo $hasUsed ?>">
                <input type="hidden" name="re_Number1" value="<?php echo $Number1 ?>">
                <input type="hidden" name="re_Number2" value="<?php echo $Number2 ?>">
                <input type="hidden" name="re_funct" value="<?php echo $funct ?>">
                <input type="hidden" name="re_floatUsed" value="<?php echo $floatUsed ?>">
                <input type="hidden" name="re_floatCount" value="<?php echo $floatCount ?>">
                <input type="hidden" name="re_neNum" value="<?php echo $neNum ?>">
                <input type="hidden" name="re_result" value="<?php echo $result ?>">
            </form>
        </tr>
    </table>
</center>
    
</body>
</html>