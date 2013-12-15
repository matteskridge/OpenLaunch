
<div class="admin-entries-top">
	<div class="admin-entries-top-inner">
		<h2>People Center</h2>
	</div>
</div>
<div class="admin-people">
    <?php foreach (Person::findAll("Person") as $person) { ?><a href="admin/index/community/person/<?php echo $person->get("id") ?>/"><div class="admin-person" style="background-image:url(<?php echo $person->getAvatarLink() ?>)">
        <div class="admin-person-details">
            <?php echo $person->getShortName() ?>
        </div>
    </div></a><?php } ?>
</div>
