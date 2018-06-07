<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<form action="/auth/login" method="post">
<input type="text" name="username"><br>
<input type="password" name="password" id=""><br>
<input type="hidden" name="token" value="{token}"><br>
<input type="submit" value="Login"><br><br>

</form>
<h2>新規ユーザ登録</h2>
<br>
<form action="/auth/register" method="post">
<input type="text" name="username"><br>
<input type="password" name="password" id=""><br>
<input type="repassword" name="repassword" id=""><br>
<input type="hidden" name="token" value="{token}"><br>
<input type="submit" value="Register">

</form>

