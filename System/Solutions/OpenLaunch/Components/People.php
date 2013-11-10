
<div class="admin-people">
    <?php foreach (Person::findAll("Person") as $person) { ?><a href="/admin/index/community/person/<?php echo $person->get("id") ?>/"><div class="admin-person" style="background-image:url(<?php echo $person->getAvatarLink() ?>)">
        <div class="admin-person-details">
            <?php echo $person->getName() ?>
        </div>
    </div></a><?php } ?>
</div>
