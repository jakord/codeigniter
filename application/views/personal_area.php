<header>
    <nav>
        <ul>
            <li>
                <a href="<?=base_url()?>auth/rem_password">rem_password</a>&nbsp;&nbsp;
                <a href="<?=base_url()?>auth/upload">uplaod_file</a>&nbsp;&nbsp;
                <a href="<?=base_url()?>auth/crop">crop_foto</a>&nbsp;&nbsp;
                <a href="<?=base_url()?>auth/crop">add country and city</a>&nbsp;&nbsp;
                <a></a>
            </li>
        </ul>
    </nav>
</header>
 <main>
     <form action="" method="post">
         <?php foreach ($info as $item)?>
         <?if(empty($item['city']) && empty($item['country'])):?>
         <select name="countr" style="float: left;margin-right: 40px;">
             <option value="Ukraine">Украина</option>
             <option value="Russia">Россия</option>
             <option value="Belarus">Беларусь</option>
         </select><br/>
         <p><input type="submit" name="country" value="Отправить"></p>
     </form>
     <?if(!empty($value)):?>
         <form action="" method="post">
             <select name="cite" >
                 <?php foreach ($value as $v):?>
                     <option value="<?php echo$v['city_en'];?>"><?php echo $v['citi'];?></option>
                 <?php endforeach?>
             </select>
             <p><input type="submit" name="city_btn" value="Отправить"></p>
         </form>
     <?php endif;?>
         <?php endif;?>

     <p>привет ты в своем личном кабинете <?php echo $this->session->userdata('username');?></p>

 </main>
<footer>

</footer>