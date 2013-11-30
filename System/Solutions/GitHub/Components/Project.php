<div class="github">
	<div class="github-project">
		<div class="github-project-top">
			<div class="github-project-top-item">
				<a href="https://github.com/<?php echo $project->get("githubuser") ?>/<?php echo $project->get("githubproject") ?>/blob/master/LICENSE" target="_blank">
					<img src="/Images/Flat/IconFinder/Refresh.png" />
					<h2>Code License</h2>
					View the GitHub license
				</a>
			</div>
			<div class="github-project-top-item">
				<a href="https://github.com/<?php echo $project->get("githubuser") ?>/<?php echo $project->get("githubproject") ?>/blob/master/README.md" target="_blank">
					<img src="/Images/Flat/IconFinder/Question.png" />
					<h2>Documentation</h2>
					View the GitHub readme
				</a>
			</div>
			<div class="github-project-top-item">
				<a href="http://github.com/<?php echo $project->get("githubuser") ?>/<?php echo $project->get("githubproject") ?>/archive/<?php echo $project->get("production") ?>.zip" target="_blank">
					<img src="/Images/Flat/IconFinder/Play.png" />
					<h2>Download Now</h2>
					Download a Zip file
				</a>
			</div>
		</div>
		<div class="github-project-stats">
			<div class="github-project-stat">
				<a href="https://github.com/<?php echo $project->get("githubuser") ?>/<?php echo $project->get("githubproject") ?>/issues?state=open" target="_blank"><?php echo $project->get("issues") ?> Issues</a>
			</div>
			<div class="github-project-stat">
				<a href="https://github.com/<?php echo $project->get("githubuser") ?>/<?php echo $project->get("githubproject") ?>/" target="_blank"><?php echo $project->get("watchers") ?> Watchers</a>
			</div>
			<div class="github-project-stat">
				<a href="https://github.com/<?php echo $project->get("githubuser") ?>/<?php echo $project->get("githubproject") ?>/fork" target="_blank"><?php echo $project->get("forks") ?> Forks</a>
			</div>
			<div class="github-project-stat">
				<a href="https://github.com/<?php echo $project->get("githubuser") ?>/<?php echo $project->get("githubproject") ?>/branches" target="_blank"><?php echo $project->get("branches") ?> Branches</a>
			</div>
		</div>
		<div class="github-project-main">
			<?php echo Parser::parse($project->get("content")) ?>
		</div>
	</div>
</div>