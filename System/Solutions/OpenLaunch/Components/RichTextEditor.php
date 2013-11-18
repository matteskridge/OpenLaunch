<script type="text/javascript">
$(document).ready(function() {
	tinymce.init({
		selector: "#<?php echo $id ?>",
		oninit : "setPlainText",
		plugins: [
			"advlist autolink lists link image charmap print preview anchor",
			"searchreplace visualblocks code fullscreen",
			"insertdatetime media table contextmenu paste emoticons"
		],
		toolbar: "undo redo | styleselect | bold italic | bullist numlist outdent indent | link image | hr emoticons",
		menubar: false,
		statusbar: false,
		content_css: "/Styles/Editor.css"
	});
	$("#<?php echo $id ?>").height($("#<?php echo $id ?>").parent().height());
	
	$("#<?php echo $id ?>").closest("form").submit(function() {
		var editor = tinyMCE.get('<?php echo $id ?>');
		var content = editor.getContent();
		content = toMarkdown(content);
		
		$("#<?php echo $id ?>-final").val(content);
	});
});
</script>
<div id="<?php echo $id ?>" style="height:300px;"><?php echo html_entity_decode($content) ?></div>
<textarea style="display:none;" id="<?php echo $id ?>-final" name="<?php echo $id ?>"></textarea>