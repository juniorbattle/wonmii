<h3>
  <span class="showPop" data-value="open"><i class="ti-plus"></i></span>
  Preview/Update
  <?php foreach($langues as $key => $langue): ?>
    <a class="<?php echo($langue==$config['mainLang'])? 'active' : ''; ?>" href="<?php echo $config['url'] . 'index.php?p=' . $config['actvPage'] . '&ssp=' . $config['actvSsPage'] . '&lang=' . $langue . '#preview'; ?>" title="Change in <?php echo $langue; ?>">
      <img width="15" src="<?php echo $config['url'] . 'core/img/lang/' . $langue . '.png'; ?>" alt="<?php echo $langue; ?>" />
    </a>
  <?php endforeach; ?>
</h3>
<div id="containerPreviewPage" class="frontoffice">
  <?php if(!empty($blogs)) : ?>
  <style>
  <?php include_once($config['dir'] . '../core/css/style.general.css'); ?>
  <?php include_once($config['dir'] . '../public/' . $config['actvSsPage'] . '/css/style.css'); ?>
  </style>
  <div class="previewHTML" data-lang="<?php echo $config['mainLang']; ?>">
    <div class="blog">
      <?php foreach($blogs as $key => $blogObj): ?>
        <?php $blogStrings = ($blogObj->id && !empty($blogObj->GetStrings()))? $blogObj->GetStrings() : null; ?>
        <div class="col-md-<?php echo $blogObj->display; ?>">
          <div class="contentBlog <?php echo($blogObj->active)? 'active' : 'inactive'; ?>">
            <img src="<?php echo $config['url'] . '../medias/blog/' .  $config['actvSsPage'] . '/' . $blogObj->id . '.jpg'; ?>" width="100%" alt="Img Gallery" />
            <h2><?php echo $blogStrings[$config['mainLang']]['name']; ?></h2>
            <div><?php echo $blogStrings[$config['mainLang']]['content']; ?></div>
          </div>
          <div class="actions">
            <a class="btn btn-default" href="<?php echo $config['url']; ?>index.php?idBlog=<?php echo $blogObj->id; ?>&p=<?php echo $config['actvPage']; ?>&ssp=<?php echo $config['actvSsPage']; ?>#preview"><i class="ti-settings"></i></a>
            <?php if(!$blogObj->active): ?>
            <a class="btn btn-default" href="<?php echo $config['url']; ?>index.php?action=activeBlog&id=<?php echo $blogObj->id; ?>&value=1&p=<?php echo $config['actvPage']; ?>&ssp=<?php echo $config['actvSsPage']; ?>" title="Active gallery"><i class="ti-check"></i></a>
            <?php else: ?>
            <a class="btn btn-default" href="<?php echo $config['url']; ?>index.php?action=activeBlog&id=<?php echo $blogObj->id; ?>&value=0&p=<?php echo $config['actvPage']; ?>&ssp=<?php echo $config['actvSsPage']; ?>" title="Deactivate gallery"><i class="ti-close"></i></a>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
      <div class="clearfix">&nbsp;</div>
      <div class="clearfix">&nbsp;</div>
    </div>
  </div>
  <?php else: ?>
    <div class="align-center noPreview"><p>Preview unavailbale...</p></div>
  <?php endif; ?>
</div>
<div class="popUpPage">
  <?php $blogUptStrings = ($blogUptObj->id && !empty($blogUptObj->GetStrings()))? $blogUptObj->GetStrings() : null; ?>
  <form name="PreviewPageForm" method="POST" action="<?php echo $config['url'] . 'index.php?p=' . $config['actvPage'] . '&ssp=' . $config['actvSsPage'] . '&action=saveBlog&lang=' . $config['mainLang']; ?>" enctype="multipart/form-data">
    <div class="contentPopUpPage col-md-6 col-md-offset-3">
      <h3><?php echo (!$blogUptObj->id)? 'Add' : 'Modify'; ?> Blog</h3>
      <input type="hidden" name="id" class="idBlog" value="<?php echo $blogUptObj->id; ?>" />
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-6">
            <label>Upload image</label>
            <input style="display:inline;" name="img" type="file" />
          </div>
          <div class="col-md-6">
            <label>Display</label>
            <select class="form-control" name="display">
              <option value="4" <?php if($blogUptObj->display == 4): ?> selected="selected" <?php endif; ?>>default</option>
              <option value="3" <?php if($blogUptObj->display == 3): ?> selected="selected" <?php endif; ?>>small</option>
              <option value="6" <?php if($blogUptObj->display == 6): ?> selected="selected" <?php endif; ?>>medium</option>
              <option value="9" <?php if($blogUptObj->display == 9): ?> selected="selected" <?php endif; ?>>large</option>
            </select>
          </div>
          <div class="clearfix">&nbsp;</div>
          <hr/>
          <div class="clearfix">&nbsp;</div>
          <div class="col-md-12">
            <?php foreach($langues as $key => $langue): ?>
              <span class="actvLangContent pinLang <?php echo($langue==$config['mainLang'])? 'active' : ''; ?>" data-value="<?php echo $langue; ?>"><img width="15" src="<?php echo $config['url'] . 'core/img/lang/' . $langue . '.png" alt="' . $langue; ?>"/></span>
            <?php endforeach; ?>
          </div>
          <div class="clearfix">&nbsp;</div>
          <?php foreach($langues as $key => $langue): ?>
            <div class="blogTextContent <?php echo $langue; ?> <?php if($langue!=$config['mainLang']): ?> hide <?php endif; ?>">
              <div class="col-md-4">
                <label>name</label>
                <input type="text" name="name[<?php echo $langue; ?>]" value="<?php echo $blogUptStrings[$langue]['name']; ?>" class="form-control" />
              </div>
              <div class="clearfix">&nbsp;</div>
              <div class="clearfix">&nbsp;</div>
              <div class="col-md-12">
                <label>Content</label>
                <textarea name="content[<?php echo $langue; ?>]" class="editable medium-editor-textarea contentBlog"><?php echo $blogUptStrings[$langue]['content']; ?></textarea>
              </div>
              <div class="clearfix">&nbsp;</div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="clearfix">&nbsp;</div>
      <hr/>
      <div class="validateForm align-center">
        <button class="btn btn-default" type="validate">Save</button>
        <a class="removePopUp btn btn-default"  href="<?php echo $config['url']; ?>index.php?p=<?php echo $config['actvPage']; ?>&ssp=<?php echo $config['actvSsPage']; ?>#preview" type="reset">Cancel</a>
      </div>
    </div>
    <div class="clearfix"></div>
  </form>
</div>
