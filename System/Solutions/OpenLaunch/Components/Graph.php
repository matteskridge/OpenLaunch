<?php
$height = 200;
$minX = pow(time(),2);
$maxX = -pow(time(),2);
$minY = pow(time(),2);
$maxY = -pow(time(),2);
$id = "graph-canvas-".time();

foreach ($data as $key => $value) {
	if ($value["value"] > $maxY)
		$maxY = $value["value"];
	else if ($value["value"] < $minY)
		$minY = $value["value"];

	if ($key < $minX)
		$minX = $key;
	else if ($key > $maxX)
		$maxX = $key;
}
?>
<script type="text/javascript">
$(document).ready(function() {
	var parent = $("#<?php echo $id ?>");
	var canvas = $("#<?php echo $id ?>-canvas");
	var width = 1000;
	var height = 200;
	var size = 10;
	var x2 = 0;
	var y2 = height;

	canvas.drawLine({
		x1: 0, y1: height,
		<?php $i = 2; foreach ($data as $key => $value) { ?>
		x<?php echo $i ?>: ((<?php echo (($key-$minX)/($maxX-$minX)) ?>*width)),
		y<?php echo $i ?>: (height-(<?php echo ($value["value"]/$maxY) ?> * height)),
		<?php $i++; } ?>
		x<?php echo $i ?>: width, y<?php echo $i ?>: height,
			fillStyle: "#A7BFEB",
			closed: true
	});

	<?php foreach ($data as $key => $value) { ?>
	var x = (<?php echo (($key-$minX)/($maxX-$minX)) ?>*width);
	var y = height-(<?php echo ($value["value"]/$maxY) ?> * height);

	canvas.drawEllipse({
		fillStyle: "#0000FF",
		x: x,
		y: y,
		width: size,
		height: size
	});
	canvas.drawLine({
		strokeStyle: "#42639E",
		strokeWidth: 3,
		x1: x, y1: y,
		x2: x2, y2: y2
	});

	x2 = x;
	y2 = y;
	<?php } ?>
});
</script>
<div id="<?php echo $id ?>" style="width:100%;height:<?php echo $height ?>px;">
	<canvas id="<?php echo $id ?>-canvas" width="1000" height="200"></canvas>
</div>