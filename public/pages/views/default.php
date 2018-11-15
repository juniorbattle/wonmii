<div class="col-md-12">
  <a href="<?php echo $config['url']; ?><?php echo $config['actvPage']; ?>/new" class="btn btn-default"><i class="ti-plus"></i> New page</a>
</div>
<div class="wpages">
 <?php foreach($pages as $pageObj): ?>
   <div class="col-md-4 col-md-offset-4">
     <div class="wpage <?php echo($pageObj->active)? 'active' : 'inactive'; ?>">
       <span class="wpageTitle"><?php echo $pageObj->name; ?></span>
       <div class="wpagesActions">
         <?php if($pageObj->isOrdreFirst()): ?>
         <span class="btn btn-default disabled" title="Up"><i class="ti-angle-up"></i></span>
         <?php else: ?>
         <a class="btn btn-default" href="<?php echo $config['url']; ?>index.php?action=upOrdrePage&p=<?php echo $config['actvPage']; ?>&ssp=<?php echo $pageObj->name; ?>" title="Up"><i class="ti-angle-up"></i></a>
         <?php endif; ?>
         <?php if($pageObj->isOrdreLast()): ?>
         <span class="btn btn-default disabled" title="Down"><i class="ti-angle-down"></i></span>
         <?php else: ?>
         <a class="btn btn-default" href="<?php echo $config['url']; ?>index.php?action=downOrdrePage&p=<?php echo $config['actvPage']; ?>&ssp=<?php echo $pageObj->name; ?>" title="Down"><i class="ti-angle-down"></i></a>
         <?php endif; ?>
         <a class="btn btn-default" href="<?php echo $config['url']; ?><?php echo $config['actvPage']; ?>/<?php echo $pageObj->name; ?>" title="Modify page"><i class="ti-settings"></i></a>
         <?php if(!$pageObj->inMenu): ?>
         <a class="btn btn-default" href="<?php echo $config['url']; ?>index.php?action=pageInMenu&value=1&p=<?php echo $config['actvPage']; ?>&ssp=<?php echo $pageObj->name; ?>" title="Add in menu"><i class="ti-import"></i></a>
         <?php else: ?>
         <a class="btn btn-default" href="<?php echo $config['url']; ?>index.php?action=pageInMenu&value=0&p=<?php echo $config['actvPage']; ?>&ssp=<?php echo $pageObj->name; ?>" title="Remove in menu"><i class="ti-export"></i></a>
         <?php endif; ?>
         <?php if(!$pageObj->active): ?>
         <a class="btn btn-default" href="<?php echo $config['url']; ?>index.php?action=activePage&value=1&p=<?php echo $config['actvPage']; ?>&ssp=<?php echo $pageObj->name; ?>" title="Active page"><i class="ti-check"></i></a>
         <?php else: ?>
         <a class="btn btn-default" href="<?php echo $config['url']; ?>index.php?action=activePage&value=0&p=<?php echo $config['actvPage']; ?>&ssp=<?php echo $pageObj->name; ?>" title="Deactivate page"><i class="ti-close"></i></a>
         <?php endif; ?>
       </div>
     </div>
   </div>
   <div class="clearfix"></div>
 <?php endforeach; ?>
</div>
