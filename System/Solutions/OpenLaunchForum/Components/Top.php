<?php
$forums = Forum::count("Forum");
$discussions = ForumTopic::count("ForumTopic");
$replies = Comment::count("Comment", array("modeltype" => "ForumTopic"));
$users = Person::count("Person");
?>
<div class="forum-tools">
    <div class="forum-tool"><a href="<?php echo $page->getLink() ?>"><?php echo $forums ?> Forums</a></div>
    <div class="forum-tool"><a href="<?php echo $page->getLink("discussions") ?>"><?php echo $discussions ?> Discussions</a></div>
    <div class="forum-tool"><a href="<?php echo $page->getLink("replies") ?>"><?php echo $replies ?> Replies</a></div>
    <div class="forum-tool"><a href="<?php echo $page->getLink("people") ?>"><?php echo $users ?> People</a></div>
</div>