<div class="configPage">
  <div class="col-md-3">
    <div class="contentConfigResume">
      <h3><?php echo($pageObj->name)? $pageObj->name : '...'; ?></h3>
      <div class="contentGroup">
        <div class="col-md-5 libelle">Name</div>
        <div class="col-md-7 align-right">
          <div class="row">
          <?php foreach($langues as $key => $langue): ?>
            <span><?php echo '<img class="form-pin" width="10" src="' . $config['url'] . 'core/img/lang/' . $langue . '.png" alt="' . $langue . '"/>'; ?> <?php echo(!empty($tabStrings))? $tabStrings[$langue]['name'] : '..'; ?></span><br/>
          <?php endforeach; ?>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
      <hr/>
      <div class="contentGroup">
        <div class="col-md-5 libelle">Display</div>
        <?php if($pageObj->display): ?>
          <div class="col-md-7 align-right"><?php echo $pageObj->display; ?></div>
        <?php else: ?>
          <div class="col-md-7 align-right">...</div>
        <?php endif; ?>
        <div class="clearfix"></div>
      </div>
      <hr/>
      <div class="contentGroup">
        <div class="col-md-5 libelle">Active</div>
        <div class="col-md-7 align-right"><?php echo($pageObj->active)? 'Yes' : 'No'; ?></div>
        <div class="clearfix"></div>
      </div>
      <hr/>
      <div class="contentGroup">
        <div class="col-md-5 libelle">Menu</div>
        <div class="col-md-7 align-right"><?php echo($pageObj->inMenu)? 'Yes' : 'No'; ?></div>
        <div class="clearfix"></div>
      </div>
      <hr/>
      <div class="contentGroup">
        <div class="col-md-5 libelle">Plugins</div>
        <div class="col-md-7 align-right">
          <?php if($pageObj->plugins): ?>
            <?php foreach($pageObj->plugins as $libellePlugin => $plugin): ?>
            <span><?php echo $libellePlugin; ?></span>
            <?php endforeach; ?>
          <?php else: ?>
            <span>...</span>
          <?php endif; ?>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
  <div class="col-md-9">
    <div class="contentConfigPage">
      <h3>Page Setting</h3>
      <form name="configPageForm" method="POST" action="<?php echo $config['url'] . 'index.php?p=' . $config['actvPage'] . '&ssp=' . $config['actvSsPage'] . '&action=SaveConfigPage'; ?>">
        <div class="col-md-3"><input type="hidden" name="namePage" value="<?php echo $pageObj->name; ?>" /></div>
        <div class="clearfix"></div>
        <div class="contentGroup col-md-12">
          <label>Name Page</label>
          <div class="clearfix"></div>
          <?php foreach($langues as $key => $langue) {
            echo '<div class="row">';
            echo '<div class="formGroup col-md-4">';
            echo '<img class="form-pin" width="20" src="' . $config['url'] . 'core/img/lang/' . $langue . '.png" alt="' . $langue . '"/>';
            echo '<input type="text" class="form-control" name="name[' . $langue . ']" value="' . $tabStrings[$langue]['name'] . '" />';
            echo '</div>';
            echo '</div>';
          } ?>
          <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        <div class="contentGroup col-md-12">
          <label>Description Page</label>
          <div class="clearfix"></div>
          <?php foreach($langues as $key => $langue) {
            echo '<div class="row">';
            echo '<div class="formGroup col-md-4">';
            echo '<img class="form-pin" width="20" src="' . $config['url'] . 'core/img/lang/' . $langue . '.png" alt="' . $langue . '"/>';
            echo '<input type="text" class="form-control" name="description[' . $langue . ']" value="' . $tabStrings[$langue]['description'] . '" />';
            echo '</div>';
            echo '</div>';
          } ?>
          <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        <hr/>
        <div class="contentGroup col-md-4">
          <div class="clearfix">&nbsp;</div>
          <input name="active" type="checkbox" <?php if($pageObj->active): ?>checked="checked"<?php endif; ?> />
          <label>Active</label>
        </div>
        <div class="contentGroup col-md-4">
          <div class="clearfix">&nbsp;</div>
          <input name="inmenu" type="checkbox" <?php if($pageObj->inMenu): ?>checked="checked"<?php endif; ?>/>
          <label>In menu</label>
        </div>
        <div class="contentGroup col-md-4">
          <label>Display Type</label>
          <div class="clearfix"></div>
          <select name="display" class="form-control">
              <option <?php if($pageObj->display == 'basic'): ?>selected="selected"<?php endif; ?>>basic</option>
              <?php /*
              <option <?php if($pageObj->display == 'gallery'): ?>selected="selected"<?php endif; ?>>gallery</option>
              <option <?php if($pageObj->display == 'blog'): ?>selected="selected"<?php endif; ?>>blog</option>
              */ ?>>
          </select>
        </div>
        <div class="clearfix"></div>
        <hr/>
        <div class="contentGroup col-md-12">
          <label><b>Plugins</b></label>
          <div class="clearfix">&nbsp;</div>
          <?php foreach(scandir($config['dir'] . 'plugins/') as $folder): ?>
            <?php if($folder != '.' && $folder != '..'): ?>
            <div class="row">
              <div class="col-md-4">
                <input name="plugins[<?php echo $folder; ?>][active]" type="checkbox" <?php if($pageObj->plugins && isset($pageObj->plugins[$folder]['active']) && $pageObj->plugins[$folder]['active']): ?>checked="checked"<?php endif; ?> />
                <label><?php echo $folder; ?></label>
              </div>
              <div class="col-md-4 align-right">
                <label>Plugin position on website</label>
              </div>
              <div class="col-md-4">
                <select name="plugins[<?php echo $folder; ?>][position]" class="form-control">
                    <option <?php if($pageObj->plugins[$folder]['position'] == 'top'): ?>selected="selected"<?php endif; ?>>top</option>
                    <option <?php if($pageObj->plugins[$folder]['position'] == 'bottom'): ?>selected="selected"<?php endif; ?>>bottom</option>
                    <option <?php if($pageObj->plugins[$folder]['position'] == 'popup'): ?>selected="selected"<?php endif; ?>>popup</option>
                </select>
              </div>
              <div class="clearfix"></div>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
        </div>
        <div class="clearfix"></div>
        <hr/>
        <div class="validateForm align-center">
          <button class="btn btn-default" type="validate">Save</button>
        </div>
      </form>
    </div>
  <div class="clearfix"></div>
</div>
<div class="clearfix"></div>
<?php if($pageObj->id): ?>
<hr/>
<div id="preview" class="previewPage">
  <?php include_once($config['dir'] . 'public/pages/views/tdisplay/' . $pageObj->display . '.php'); ?>
</div>
<?php endif; ?>
</div>
