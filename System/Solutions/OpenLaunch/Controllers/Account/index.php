<?php foreach ($items as $panel) { ?>
<?php echo Component::get("OpenLaunch.AccountPanelMenu", array("panel" => $panel)) ?>
<?php } ?>