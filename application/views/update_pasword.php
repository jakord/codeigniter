<form method="post" action="">
    <input type="text" name="mod_pswd" placeholder="введите новый пароль"><br/>
    <input type="text" name="r_pswd" placeholder="повторите новый пароль"><br/>
    <input type="submit" name="r_submit" value="change password">
</form>
<?php
if(!empty($error)){
    echo $error;}
else{
 echo "пароль обновлен";
}
?>