<?php echo "<?xml" ?> version="1.0" encoding="UTF-8" <?php echo "?>" ?>

<rss version="2.0">
	<channel>
		<title>RSS Title</title>
		<description>This is an example of an RSS feed</description>
		<link>http://<?php echo Request::getDomain() ?>/</link>
		<lastBuildDate><?php echo gmdate("r") ?></lastBuildDate>
		<language>en-us</language>
		<pubDate><?php echo gmdate("r") ?></pubDate>
		<ttl>1800</ttl>
		<?php foreach ($items as $item) { ?>
		
		<item>
			<?php if ($item->get("name") != "") { ?><title><?php echo $item->get("name") ?></title><?php } ?>
			
			<link>http://<?php echo Request::getDomain() ?></link>
			<pubDate><?php echo gmdate("r", $item->get("cs_created")) ?></pubDate>
			<?php if ($item->get("content") != "") { ?><description><?php echo $item->get("content") ?></description><?php } ?>
		</item>
		<?php } ?>

	</channel>
</rss>