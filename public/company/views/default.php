<div class="col-md-4">
  <div class="contentLogo">
    <form name="logoForm" method="POST" action="<?php echo $config['url'] . 'index.php?p=' . $config['actvPage'] . '&action=SaveLogo'; ?>" enctype="multipart/form-data">
      <label>Logo website</label>
      <div class="contentForm">
        <?php if(file_exists($config["dir"] . "../core/img/company/logo_company.png")): ?>
        <div><img width="100" src="<?php echo $config["url"] . '../core/img/company/logo_company.png'; ?>" title="Logo Company" /></div>
        <div class="clearfix">&nbsp;</div>
        <hr/>
        <div class="clearfix">&nbsp;</div>
        <?php endif; ?>
        <input style="display:inline;" name="logo" type="file">
      </div>
      <button class="btn btn-default">Save</button>
    </form>
  </div>
</div>
<div class="col-md-8">
  <div class="contentCompany">
    <h3>Company informations</h3>
    <form name="companyForm" id="companyForm" method="POST" action="<?php echo $config['url'] . 'index.php?p=' . $config['actvPage'] . '&action=Save'; ?>" enctype="multipart/form-data" novalidate="novalidate">
      <div class="col-md-6">
        <label>Company name</label>
        <input class="form-control" id="nom" name="name" value="<?php echo $companyObj->name; ?>" type="text">
      </div>
      <div class="clearfix">&nbsp;</div>
      <div class="clearfix">&nbsp;</div>
      <div class="col-md-6">
        <label>Domain</label>
        <input class="form-control" id="domain" name="domain" value="<?php echo $companyObj->domain; ?>" type="text">
      </div>
      <div class="clearfix">&nbsp;</div>
      <div class="clearfix">&nbsp;</div>
      <div class="col-md-6">
        <label>Email</label>
        <input class="form-control" id="email" name="email" value="<?php echo $companyObj->email; ?>" type="text">
      </div>
      <div class="col-md-6">
        <label>Email 2</label>
        <input class="form-control" id="email2" name="email2" value="<?php echo $companyObj->email2; ?>" type="text">
      </div>
      <div class="clearfix">&nbsp;</div>
      <div class="col-md-6">
        <label>Email to receive contact form</label>
        <input class="form-control" id="email_contact" name="email_contact" value="<?php echo $companyObj->emailForContact; ?>" type="text">
      </div>
      <div class="clearfix">&nbsp;</div>
      <div class="clearfix">&nbsp;</div>
      <div class="col-md-6">
        <label>Phone</label>
        <input class="form-control" id="phone" name="phone" value="<?php echo $companyObj->phone; ?>" type="text">
      </div>
      <div class="col-md-6">
        <label>Mailing address</label>
        <input class="form-control" id="mailing_address" name="mailing_address" value="<?php echo $companyObj->mailingAddress; ?>" type="text">
      </div>
      <div class="clearfix">&nbsp;</div>
      <hr>
      <div class="clearfix">&nbsp;</div>
      <div class="col-md-6">
        <label>Facebook</label>
        <input class="form-control" name="socialsnetworks[facebook]" value="<?php echo $companyObj->socialsNetworks['facebook']; ?>" type="text">
      </div>
      <div class="col-md-6">
        <label>Twitter</label>
        <input class="form-control" name="socialsnetworks[twitter]" value="<?php echo $companyObj->socialsNetworks['twitter']; ?>" type="text">
      </div>
      <div class="clearfix">&nbsp;</div>
      <div class="col-md-6">
        <label>Instagram</label>
        <input class="form-control" name="socialsnetworks[instagram]" value="<?php echo $companyObj->socialsNetworks['instagram']; ?>" type="text">
      </div>
      <div class="col-md-6">
        <label>Linkedin</label>
        <input class="form-control" name="socialsnetworks[linkedin]" value="<?php echo $companyObj->socialsNetworks['linkedin']; ?>" type="text">
      </div>
      <div class="clearfix">&nbsp;</div>
      <hr>
      <div class="clearfix">&nbsp;</div>
      <div class="col-md-12">
        <label>Description</label>
        <textarea class="form-control" id="description" name="description"><?php echo $companyObj->description; ?></textarea>
      </div>
      <div class="clearfix">&nbsp;</div>
      <div class="col-md-12">
        <label>Keywords</label>
        <textarea class="form-control" id="keywords" name="keywords"><?php echo $companyObj->keywords; ?></textarea>
      </div>
      <div class="clearfix">&nbsp;</div>
      <div align="center"><button class="btn btn-default">Save</button></div>
      <div class="clearfix"></div>
    </form>
  </div>
</div>
<div class="clearfix"></div>
