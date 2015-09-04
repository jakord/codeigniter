<?php if(empty($pass)):?>
<form METHOD="post" action="">
    <input type="text" name="userPhone"  placeholder="пример(моб)80930281386"><br/>
    <input type="submit" name="send" value="number">
</form>
<?php endif?>

<?php if(!empty($pass)):?>
    <form METHOD="post" action="">
        <input type="text" name="num_pass"  placeholder="введите код из номера"><br/>
        <input type="submit" name="num_p" value="send">
    </form>
<?php endif?>