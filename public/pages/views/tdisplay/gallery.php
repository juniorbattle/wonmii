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
  <?php if(!empty($galleries)) : ?>
  <style>
  <?php include_once($config['dir'] . '../core/css/style.general.css'); ?>
  <?php include_once($config['dir'] . '../public/' . $config['actvSsPage'] . '/css/style.css'); ?>
  </style>
  <div class="previewHTML" data-lang="<?php echo $config['mainLang']; ?>">
    <div class="gallery">
      <?php foreach($galleries as $key => $galleryObj): ?>
        <div class="col-md-<?php echo $galleryObj->display; ?>">
          <img class="<?php echo($galleryObj->active)? 'active' : 'inactive'; ?>" src="<?php echo $config['url'] . '../medias/gallery/' .  $config['actvSsPage'] . '/' . $galleryObj->id . '.jpg'; ?>" width="100%" alt="Img Gallery" />
          <div class="actions">
            <a class="btn btn-default" href="<?php echo $config['url']; ?>index.php?idGallery=<?php echo $galleryObj->id; ?>&p=<?php echo $config['actvPage']; ?>&ssp=<?php echo $config['actvSsPage']; ?>#preview"><i class="ti-settings"></i></a>
            <?php if(!$galleryObj->active): ?>
            <a class="btn btn-default" href="<?php echo $config['url']; ?>index.php?action=activeImgGallery&id=<?php echo $galleryObj->id; ?>&value=1&p=<?php echo $config['actvPage']; ?>&ssp=<?php echo $config['actvSsPage']; ?>" title="Active gallery"><i class="ti-check"></i></a>
            <?php else: ?>
            <a class="btn btn-default" href="<?php echo $config['url']; ?>index.php?action=activeImgGallery&id=<?php echo $galleryObj->id; ?>&value=0&p=<?php echo $config['actvPage']; ?>&ssp=<?php echo $config['actvSsPage']; ?>" title="Deactivate gallery"><i class="ti-close"></i></a>
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
  <form name="PreviewPageForm" method="POST" action="<?php echo $config['url'] . 'index.php?p=' . $config['actvPage'] . '&ssp=' . $config['actvSsPage'] . '&action=saveGallery&lang=' . $config['mainLang']; ?>" enctype="multipart/form-data">
    <div class="contentPopUpPage col-md-6 col-md-offset-3">
      <h3><?php echo (!$galleryUptObj->id)? 'Add' : 'Modify'; ?> Gallery</h3>
      <input type="hidden" name="id" class="idGallery" value="<?php echo $galleryUptObj->id; ?>" />
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-6">
            <label>Upload image</label>
            <input style="display:inline;" name="img" type="file" />
          </div>
          <div class="col-md-6">
            <label>Display</label>
            <select class="form-control" name="display">
              <option value="4" <?php if($galleryUptObj->display == 4): ?> selected="selected" <?php endif; ?>>default</option>
              <option value="3" <?php if($galleryUptObj->display == 3): ?> selected="selected" <?php endif; ?>>small</option>
              <option value="6" <?php if($galleryUptObj->display == 6): ?> selected="selected" <?php endif; ?>>medium</option>
              <option value="9" <?php if($galleryUptObj->display == 9): ?> selected="selected" <?php endif; ?>>large</option>
            </select>
          </div>
          <div class="clearfix">&nbsp;</div>
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
