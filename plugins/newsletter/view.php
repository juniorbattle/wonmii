<div class="newsletter" style="background-image:url('<?php echo $config["url_base"]; ?>Images/couverture/home/image/couverture_image.jpg');">
	<div>
		<span class="closeNewsletter"><i class="fa fa-times" aria-hidden="true"></i></span>
		<span class="openNewsletter"><i class="fa fa-envelope" aria-hidden="true"></i></span>
		<h3 align="center"><?php echo $TXT_suiveznous; ?></h3>
		<form id="form_newsletter" action="<?php echo $config["url_base"]; ?>scripts/mail.php" method="POST">
			<input type="hidden" name="action" value="newsletter">
			<input class="form-control" type="text" name="nom" id="nom" placeholder="<?php echo $TXT_votrenom; ?>">
			<input class="form-control" type="text" name="email" id="email" placeholder="<?php echo $TXT_votremail; ?>">
			<input type="hidden" name="message" id="message" value="<?php echo $TXT_inscriptionnewsletter; ?>" />
			<div align="center">
			<button class="btn btn-general" type="submit"><?php echo $TXT_joindre_newsletter; ?></button>
			</div>
		</form>
		<div class="validation-newsletter" align="center"><?php echo $TXT_confirm_inscription; ?></div>
		<div class="socialsnetworks" align="center">
			<?php if(array_key_exists('fb',$pluginSocialsNetworksObj->extra) && $pluginSocialsNetworksObj->extra['fb'] != ''): ?><a href="<?php echo $pluginSocialsNetworksObj->extra['fb']; ?>" target="_blank"><i class="fa fa-facebook-official fa-lg"></i> </a><?php endif; ?>
			<?php if(array_key_exists('ig',$pluginSocialsNetworksObj->extra) && $pluginSocialsNetworksObj->extra['ig'] != ''): ?><a href="<?php echo $pluginSocialsNetworksObj->extra['ig']; ?>" target="_blank"><i class="fa fa-instagram fa-lg"></i> </a><?php endif; ?>
			<?php if(array_key_exists('tw',$pluginSocialsNetworksObj->extra) && $pluginSocialsNetworksObj->extra['tw'] != ''): ?><a href="<?php echo $pluginSocialsNetworksObj->extra['tw']; ?>" target="_blank"><i class="fa fa-twitter fa-lg"></i> </a><?php endif; ?> 
		</div>	
	</div>		
</div>