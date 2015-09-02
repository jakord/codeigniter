<a href="<?=base_url()?>auth/registration">registration</a><br/>

<?php if(empty($user)):?>
 <a href="<?=base_url()?>auth/authorization">authorization</a><br/>
<?php endif;?>
<a href="<?=base_url()?>auth/rem_password">rem_password</a><br/>


<?php
if(!empty($user)) {
    echo "<br/><br/><br/>вы авторизироались как". $user ;
}

?>
