<?php
 $uu = url("reset")."?code=".$code;
 ?>
 
<center><img src="http://etukng.tobi-demos.tk/img/logo.png" width="150" height="150"/></center>
<h3 style="background: #ff5722; color: #fff; padding: 10px 15px;">Reset your password</h3>
<p>Hello {{$name}},</p><br>
<p>Here is the link to reset your password: <a href="{{$uu}}">Click here</a></p><br>

<p>Alternatively, you can copy and paste the link below in your browser:<br>
<a href="{{$uu}}">{{$uu}}</a>
</p>
<br>

<p style="color:red;"><b>NOTE:</b> If you did not initiate this request kindly ignore this message.</p><br><br>
