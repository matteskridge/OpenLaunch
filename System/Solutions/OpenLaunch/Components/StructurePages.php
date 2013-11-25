<script type="text/javascript">
	$(document).ready(function() {
		$(".admin-pages").sortable({
			handle: ".admin-page-item-top"
		});
		$(".admin-pages-entries").sortable({
			handle: ".page-sort",
			stop: function() {
				var bits = "";
				var first = true;
				$(".admin-pages-entries").children().each(function() {
					var id = $(this).children(".admin-entry-inner").attr("data-page");
					if (!first)
						bits += ",";
					bits += id;
					first = false;
				});

				$.ajax({
					url: "/admin/index/structure/index/0/reorder/?order=" + bits
				});
			}
		});
		$(".page-delete").click(function() {
			var id = $(this).parent().parent().attr("data-page");
			if (confirm("Really delete this page?")) {
				$(this).parent().parent().parent().animate({opacity: 0, height: "hide"});
				$.ajax({
					url: "/admin/index/structure/index/" + id + "/delete/?sid=<?php echo session_id() ?>",
				});
			}
		});
		$(".page-home").click(function() {
			var id = $(this).parent().parent().attr("data-page");
			if (confirm("Set this as the homepage?")) {
				$.ajax({
					url: "/admin/index/structure/index/" + id + "/home/?sid=<?php echo session_id() ?>",
					success: function() {
						window.location = "/admin/index/structure/";
					}
				});
			}
		});
	})
</script>
<div class="admin-entries">
	<div class="admin-entries-top">
		<div class="admin-entries-top-inner">
			<div class='admin-entries-button'><a href="/admin/index/structure/page/0/">Create Page</a></div>
			<h2>Page Center</h2>
		</div>
	</div>
	<div class='admin-pages-entries'>
		<?php foreach (Page::listAll() as $page) { ?>
			<div class="admin-entry">
				<div class="admin-entry-inner" data-page='<?php echo $page->getId() ?>'>
					<div class="admin-entry-options">
						<img src="/Images/Black/IconFinder/Move.png" class='page-sort' style='cursor:move;' />
						<?php if (!$page->get("home")) { ?><img src="/Images/Black/IconFinder/Home.png" class='page-home' style='cursor:pointer;' /><?php } ?>
						<img src="/Images/Black/IconFinder/Delete.png" class='page-delete' style='cursor:pointer;' />
					</div>
					<div class='admin-entry-inner-main' style='padding-left:<?php echo $page->indention() ?>px;'>
						<a href='/admin/index/structure/page/<?php echo $page->getId() ?>/'><?php echo $page->get("name") ?></a>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>