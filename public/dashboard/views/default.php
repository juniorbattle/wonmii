<div class="col-md-4 col-md-offset-4">
    <div class="header-user">
      <?php if(file_exists($config["dir"] . "../core/img/company/logo_company.png")): ?>
      <span class="logoCompany"><img width="100" src="<?php echo $config["url"] . '../core/img/company/logo_company.png'; ?>" title="Logo Company" /></span>
      <?php else: ?>
      <span><i class="ti-user"></i></span>
      <?php endif; ?>
    </div>
    <div class="content-user">
      <h3 align="center"><?php echo $companyObj->name; ?></h3>
      <p align="center"><i><?php echo $companyObj->domain; ?></i></p>
      <br/><hr/><br/>
      <p><?php echo $companyObj->mailingAddress; ?></p>
      <br/>
      <p><?php echo $companyObj->phone; ?></p>
      <p><?php echo $companyObj->email; ?></p>
      <p><?php echo $companyObj->email2; ?></p>
      <br/>
      <?php if($companyObj->socialsNetworks): ?>
        <?php foreach($companyObj->socialsNetworks as $key => $socialnetwork): ?>
          <?php if($socialnetwork): ?><p><i class="ti-<?php echo $key; ?>"></i> <?php echo $socialnetwork; ?></p><?php endif; ?>
        <?php endforeach; ?>
      <?php endif; ?>
      <br/><hr/><br/>
      <p><b>Website <?php echo $companyObj->statusWebsite; ?></b></p>
      <p><b><?php echo count(PAGE::GetAll()); ?></b> page created</p>
      <p><b><?php echo count(LANGUE::GetAll()); ?></b> languages actived</p>
    </div>
</div>
<div class="clearfix"></div>
