<form method="post" action="index.php">
    <input type="text" name="string" ><br/><br/>
    <input type="submit" name="send" value="count">
</form>

<a href="labirint.php">Задачка с лабиринтом</a>
<?php
$str=trim($_POST['string']);
$button=isset($_POST['send']);

if($button==TRUE){
    echo "Your Answer: &nbsp;".  calculator($str);
}

function calculator($str){
    $str = preg_replace("/[^0-9+\-.*\/()]/", "" , $str);
    if ( $str == "" ) {
        $res= "line should not be empty";
    }
    else {
        eval("\$res=" . $str . ";" );
    }
    return $res;
}