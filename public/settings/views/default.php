<div class="col-md-6 col-md-offset-3">
  <div class="contentLoginConnect">
    <form name="loginConnectForm" method="POST" action="<?php echo $config['url'] . 'index.php?p=' . $config['actvPage'] . '&action=SaveLoginConnect'; ?>" enctype="multipart/form-data">
      <label>Login to access Woncreative</label>
      <div class="contentForm">
        <div class="col-md-6">
          <label>Login</label>
          <input type="text" class="form-control" id="login" name="login" value="<?php echo $companyObj->loginWoncreative; ?>" />
        </div>
        <div class="col-md-6">
          <label>Password</label>
          <input type="password" class="form-control" id="password" name="password" value="<?php echo $companyObj->passwordWoncreative; ?>" />
        </div>
        <div class="clearfix"></div>
      </div>
      <button class="btn btn-default">Save</button>
    </form>
  </div>
</div>
<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
<div class="col-md-6 col-md-offset-3">
  <div class="contentStatusWebsite">
    <form name="statusWebsiteForm" method="POST" action="<?php echo $config['url'] . 'index.php?p=' . $config['actvPage'] . '&action=SaveStatusWebsite'; ?>" enctype="multipart/form-data">
      <label>Website status</label>
      <div class="contentForm">
        <div class="col-md-12">
          <select class="form-control" id="status" name="status">
            <option value="online" <?php if($companyObj->statusWebsite == 'online'): ?>selected="selected"<?php endif; ?>>Online</option>
            <option value="progress" <?php if($companyObj->statusWebsite == 'progress'): ?>selected="selected"<?php endif; ?>>In progress</option>
            <option value="offline" <?php if($companyObj->statusWebsite == 'offline'): ?>selected="selected"<?php endif; ?>>Offline</option>
          </select>
        </div>
        <div class="clearfix"></div>
      </div>
      <button class="btn btn-default">Save</button>
    </form>
  </div>
</div>
<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
<div class="col-md-6 col-md-offset-3">
  <div class="contentMultilingual">
    <form name="multilingualForm" method="POST" action="<?php echo $config['url'] . 'index.php?p=' . $config['actvPage'] . '&action=SaveMultilingual'; ?>" enctype="multipart/form-data">
      <label>Multilingual</label>
      <div class="contentForm">
        <?php
        $count = 0;
        foreach($langues as $key => $langue) {
          if($count > 0 && $count%3 == 0) { echo '<div class="hidden-xs hidden-sm clearfix">&nbsp;</div>'; }
          if($count > 0 && $count%2 == 0) { echo '<div class="clearfix hidden-md hidden-lg">&nbsp;</div>'; }
          echo '<div class="col-xs-6 col-sm-6 col-md-4">';
            echo '<div class="contentLangue">';
            echo '<img width="20" src="' . $config['url'] . 'core/img/lang/' . $langue['libelle'] . '.png" alt="' . $langue['libelle'] . '"/>';
            echo '<span style="width:50px;display:inline-block;margin:-25px 0 0 5px;">' . strtoupper($langue['libelle']) . '</span>';
            echo '</div>';
            if($langue['active'] == 1) {
              $hide = (count(LANGUE::GetLanguesActives()) <= 1)? 'hide' : null;
              echo '<a href="' . $config['url'] . 'index.php?p=' . $config['actvPage'] . '&action=ActiveLang&value=0&lang=' . $langue['libelle'] . '" class="btn btn-default ' . $hide . '"><i class="ti-close"></i></a>';
            } else {
              echo '<a href="' . $config['url'] . 'index.php?p=' . $config['actvPage'] . '&action=ActiveLang&value=1&lang=' . $langue['libelle'] . '" class="btn btn-default"><i class="ti-check"></i></a>';
            }
            $hide = ($langue['active'] == 0)? 'hide' : null;
            if($langue['main'] == 1) {
              echo '<span class="btn btn-default active ' . $hide . '" style="cursor:default;"><i class="ti-star"></i></span>';
            } else {
              echo '<a href="' . $config['url'] . 'index.php?p=' . $config['actvPage'] . '&action=MainLang&lang=' . $langue['libelle'] . '" class="btn btn-default ' . $hide . '"><i class="ti-star"></i></a>';
            }
          echo '</div>';
          $count++;
        }
        echo '<div class="clearfix">&nbsp;</div>';
        ?>
      </div>
      <div class="clearfix">&nbsp;</div>
    </form>
  </div>
</div>
<div class="clearfix"></div>
