<form method="post" action="" style="margin: 10% 0 0 40%">
    <input type="text" size="25" name="login" placeholder="login" required><br/>
    <input type="submit" name="rem_pas" value="remember">
</form>
<?php
foreach($login as $item){
    echo $item['password'];
}
?>