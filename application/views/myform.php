
<header>
    <nav>
        <ul>
            <li>

                <?php if(empty($user)):?>
                    <a href="<?=base_url()?>auth/authorization">authorization</a>&nbsp;&nbsp;
                    <a href="<?=base_url()?>auth/registration">registration</a>&nbsp;&nbsp;
                <?php else: ?>
                    <a href="<?=base_url()?>auth/personal_cab">enter your personal cabinet</a>&nbsp;&nbsp;
                    <a href="<?=base_url()?>auth/rem_password">rem_password</a>&nbsp;&nbsp;

                <?php endif;?>


            </li>
        </ul>
    </nav>
</header>
<main>
    <article>
        <section>
            <h1 style="text-align: center">Добо пожаловать на сайт <?php if(!empty($user)) {echo  $user ;} else {echo "гость";} ?>!</h1>
        </section>
    </article>

</main>
<footer>

</footer>



