   <form method="post"  style="margin: 10% 0 0 40%">
       <input type="text" size="25" placeholder="login" name="login" ><?=form_error('login')?> <br/>
       <input type="text" size="25" placeholder="password" name="password"  ><?=form_error('password')?><br/>
       <input type="text" size="25" placeholder="repeat password" name="r_password"><?=form_error('r_password')?> <br/>
       <input type="email"size="25"  placeholder="email" name="email"><?=form_error('email')?><br/>
       <input type="submit" name="send" value="registration">
   </form>
   <a href="/auth/rem_password">востановить пароль</a>