<h3>
  <span class="showCode" data-value="open"><i class="ti-shortcode"></i></span>
  Preview/Update
  <?php foreach($langues as $key => $langue): ?>
    <a class="<?php echo($langue==$config['mainLang'])? 'active' : ''; ?>" href="<?php echo $config['url'] . 'index.php?p=' . $config['actvPage'] . '&ssp=' . $config['actvSsPage'] . '&lang=' . $langue . '#preview'; ?>" title="Change in <?php echo $langue; ?>">
      <img width="15" src="<?php echo $config['url'] . 'core/img/lang/' . $langue . '.png'; ?>" alt="<?php echo $langue; ?>" />
    </a>
  <?php endforeach; ?>
</h3>
<div id="containerPreviewPage" class="frontoffice">
  <?php if(!empty($tabStrings) && array_key_exists('content', $tabStrings[$config['mainLang']])) : ?>
  <style>
  <?php include_once($config['dir'] . 'front/core/css/style.general.css'); ?>
  <?php include_once($config['dir'] . 'front/pages/' . $config['actvSsPage'] . '/css/style.css'); ?>
  </style>
  <div class="editable previewHTML" data-lang="<?php echo $config['mainLang']; ?>">
    <?php echo $tabStrings[$config['mainLang']]['content']; ?>
  </div>
  <?php else: ?>
    <div class="align-center noPreview"><p>Preview unavailbale...</p></div>
  <?php endif; ?>
</div>
<div class="codePreviewPage">
  <form name="PreviewPageForm" method="POST" action="<?php echo $config['url'] . 'index.php?p=' . $config['actvPage'] . '&ssp=' . $config['actvSsPage'] . '&action=savePreviewPage&lang=' . $config['mainLang']; ?>" enctype="multipart/form-data">
    <div class="contentCodePreviewPage col-md-6 col-md-offset-3">
      <h3>Code</h3>
      <textarea name="code" class="code"></textarea>
      <div class="validateForm align-center">
        <button class="btn btn-default" type="validate">Save</button>
        <button class="removeCodePreview btn btn-default" type="reset">Cancel</button>
      </div>
    </div>
    <div class="clearfix"></div>
  </form>
</div>
<hr/>
<div class="validateForm  align-center">
  <button class="btn btn-default savePreviewDesign">Save</button>
</div>
