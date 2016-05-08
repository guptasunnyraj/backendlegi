<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
   <title>Login</title>
  
 </head>
 <body>
   <h1>Login</h1>
   <?php echo validation_errors(); ?>
   <?php echo form_open('VerifyLogin'); ?>
   <div class="row">
   <div class="col-sm-4"></div>
   <div class="col-sm-4">
     <label for="username">Username:</label>
     <input class="form-control" type="text" size="20" id="username" name="username"/>
     <br/>
     <label for="password">Password:</label>
     <input class="form-control"  type="password" size="20" id="passowrd" name="password"/>
     <br/>
     <input class="form-control" type="submit" value="Login"/>
   </form></div></div>
   <a href="<?php echo site_url('Sign'); ?>">Click here to Sign Up</a>
 </body>
</html>