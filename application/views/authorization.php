
<form method="post" action="" style="margin: 10% 0 0 40%">
    <input type="text" size="25" name="auth_on_log" placeholder="login "><br/>
    <input type="submit" name="auth">
</form>


<?php
if(!empty($login)){
    foreach($login as $item){
        echo $item['login'];
    }
}

?>
