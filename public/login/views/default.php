<div class="content-login col-md-4 col-md-offset-4">
  <h1>Log In</h1>
  <div class="bar">&nbsp;</div>
  <form name="logForm" method="POST" action="<?php echo $config['url'] . 'index.php?p=' . $config['actvPage'] . '&action=log'; ?>">
    <div class="row">
      <div class="contentGroup">
        <div class="formGroup">
          <i class="form-pin ti-user"></i>
          <input type="text" class="form-control" name="username" placeholder="Username"/>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="contentGroup">
        <div class="formGroup">
          <i class="form-pin ti-lock"></i>
          <input type="password" class="form-control" name="password" placeholder="Password"/>
        </div>
      </div>
      <div class="clearfix">&nbsp;</div>
      <div class="col-md-12 align-right"><a href="<?php echo $config['url'] . 'resetpassword'; ?>">Forgot password ?</a></div>
      <div class="clearfix">&nbsp;</div>
      <div class="contentGroup">
        <button class="btn btn-default btn-primary">Log In</button>
      </div>
      <div class="clearfix">&nbsp;</div>
      <div class="col-md-12">Not a member yet? <a href="<?php echo $config['url'] . 'signup'; ?>">Sign up</div>
      <div class="clearfix"></div>
    </div>
  </form>
</div>
