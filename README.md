# CreationShare Web Framework

The CreationShare Web Framework is a revolutionary model-view-controller
framework which enables an incredible degree of connectivity between
different code modules within a website, while allowing such modules to remain
independent from each other. The framework also provides a standardized
authentication mechanism using standard-compliant password-based-key-derivation
and OpenID.

## Requirements

* A web server
  * PHP 5.3
    * GD graphics library
  * Apache 2 with mod_rewrite

## Essential Concepts

### Processes

Everything within the framework revolves around the Platform class. Platform will
run Processes, which can hook themselves to platform.start, platform.main,
and platform.stop. For more precise ordering, use platform.start.1, or platform.start.2, etc
(up to platform.start.9). All that the platform fundamentally does is run all
processes. Otherwise, everything else is a utility.

### Solutions

A "Solution" is a module of code which is independent from all other modules
of code, but able to communicate with other code modules.

This communication is enabled through the concept of a plugin.

### Plugins

Each solution contains several folders, each representing a different
"type" of plugin. The folders are populated with different instances of
that type of plugin. Examples of plugins include: controllers, models,
themes, settings, control panel tabs, etc. The platform enables you to list
all plugins of a given type using the following code. Plugins of that type
will be listed from every solution which has been included in the code.

	foreach (Platform::getSolutions("PluginTypeName") as $solution) {
		foreach ($solution->getFile()->listSubs() as $item) {

		}
	}

For example, to list all controllers:

	foreach (Platform::getSolutions("Controllers") as $solution) {
		foreach ($solution->getFile()->listSubs() as $item) {
			echo $item->getName();
		}
	}

This code gives you access to the solution's name (through the $solution variable)
and the plugin's file path. A plugin can technically be any file, such as a
directory, or more commonly, a PHP class. If you want to use PHP classes, simply
do this:

	foreach (Platform::getSolutions("Controllers") as $solution) {
		foreach ($solution->getFile()->listSubs() as $item) {
			$classname = $item->getExtensionlessName();
			$item->import();
			$controller = new $classname();
		}
	}

### Controllers

The CreationShare Web Framework has a concept of controllers which is almost
identical to most MVC frameworks. Here is an example controller.

    <?php
    public class HelpController extends AppController {
		public function index() {
			// This is an action

			// How to pass data to the view
			$this->variable = "value";

			// How to trigger a 404
			return new NotFoundError();

			// How to send a non-HTML response
			return json_encode($arr);
			// or simply
			return "Hello, World!"
		}
	}
    ?>

Here is the file structure you should use, relative to System/Solutions/YourWebsiteName

* Controllers/
  * ExampleController/
    * ExampleController.php
    * action1.php
    * action2.php

action1.php and action2.php are examples of views for a controller's actions.

### Views

Here is a sample view. Refer to the above section for how to write a controller;s
action and pass in variables

	<div class="help">
		<?php echo $variableName ?>
	</div>

### Models

## Creating a Project

To start building a project with the framework, simply clone or fork the
project from GitHub, create a folder for your code under System/Solutions,
and start coding. To preview your project, you will need to set up a MySQL
database and php server. WAMPServer & MAMP are two high-quality products for
setting these enviornments up easily on your development server.