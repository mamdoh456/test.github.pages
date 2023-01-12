<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<title>Form Login</title>
 <link rel="stylesheet" href="<?php echo base_url();?>/css/bootstrap/css/bootstrap.min.css">
 <link rel="stylesheet" href="<?php echo base_url();?>/dist/css/AdminLTE.min.css">
<style>

body

{

font-family:Calibri;

margin:50px;

}

#form-login{

margin:auto;

width:500px;

padding:10px;

border:1px #ccc solid;

font-size:18px;

font-weight:bold;

color:#FF6600;

}

.inputan

{

padding:3px;

font-family:Calibri;

border:1px solid #ccc;

}

.tombol

{

padding:5px;

background:#FF6600;

color:#FFF;

font-weight:bold;

font-family:Calibri;

font-size:15px;

border:#eee 1px solid;

}

.error

{

color:#FF6600;

font-size:11px;

}

</style>

</head>

<body class="login-page">
    <div class="login-box">
        <div class="login-box-body">
        <form action="<?php echo base_url();?>login/login_form" method="post" name="login" id="login">
        	<p class="login-box-msg">Sign in </p>
            <input type="text" class="form-control" placeholder="Username" size="20" id="username" name="username" value="<?php echo set_value('username');?>" autofocus="autofocus"> <?php echo form_error('username');?>
            <div class="clearfix">&nbsp;</div>
             <input type="password" size="40" name="password" class="form-control" placeholder="Password" value="<?php echo set_value('password');?>"> <?php echo form_error('password');?>
             <div class="clearfix">&nbsp;</div>
            <input type="submit" class="btn btn-primary btn-block float_right" name="login" value="Login"> 
        </form>
        </div>
     </div>
     
     <script>
	 	
	 </script>
     
</body>


</html>

