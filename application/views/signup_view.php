<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>SignUp</title>
 <script type="text/javascript">
  app.controller('UserView',function($scope,$http,$interval){

  });
</script>
</head>
<body ng-controller="UserView" ng-app="user"> 
 <h1>Sign Up </h1>
 <?php echo validation_errors(); ?>
 <?php echo form_open('SignUp'); ?>
 <div class="row">
   <div class="col-sm-4"></div>
   <div class="col-sm-4">
     <label for="username">Username:</label>
     <input class="form-control" type="text" size="20" id="username" name="username"/>
     <br/>
     <label for="password">Password:</label>
     <input class="form-control"  type="password" size="20" id="passowrd" name="password"/>
     <br/>
     
     <label for="opt">Choose Role:</label>
     <select class="form-control" name="type" ng-model="users">
       <option value="1" >Lawyer</option>
       <option value="0" >Users</option>
     </select>
       <br/>
       <input class="form-control" type="submit" value="Login"/>
     </form>
     </div>
     </div>
     <a href="<?php echo site_url('Login'); ?>">Click here to Login</a>
   </body>
   </html>