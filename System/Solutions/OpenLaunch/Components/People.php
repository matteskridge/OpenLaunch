
<div class="admin-people">
    <?php foreach (Person::findAll("Person") as $person) { ?><div class="admin-person" style="background-image:url(<?php echo $person->getAvatarLink() ?>)">
        <div class="admin-person-details">
            <?php echo $person->getName() ?>
        </div>
    </div><?php } ?>
</div>
