# Eskridge Web Framework

The Eskridge Web Framework is a revolutionary model-view-controller
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

## Installation

1. Acquire access to a webserver or localhost server.
2. Either fork this project on github, or download the source.
3. Place the source into the root directory of a domain name on the server.
4. Create the database configuration file: System/Data/database.php (see below).
5. Create the website configuration file: System/Data/website.php (see below).
6. Copy the database structure below and paste it as an SQL query into phpMyAmin, SQL Query browser, or similar.

Sample database config file:

	$settings["database.server"] = "localhost";
	$settings["database.name"] = "framework";
	$settings["database.user"] = "root";
	$settings["database.password"] = "root";

Sample website config file:

	$settings["website.name"] = "Name";
	$settings["website.theme"] = "Framework-Open-Blue";
	$settings["website.organization"] = "Eskridge";

Sample database structure:

	CREATE TABLE IF NOT EXISTS `LoginSession` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `cs_created` int(24) NOT NULL,
	  `cs_modified` int(24) NOT NULL,
	  `user` int(11) NOT NULL,
	  `cookie` varchar(256) NOT NULL,
	  `sessionid` varchar(256) NOT NULL,
	  `browser` varchar(48) NOT NULL,
	  `platform` varchar(48) NOT NULL,
	  `ipaddress` varchar(48) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=175 ;

	CREATE TABLE IF NOT EXISTS `Person` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `cs_created` int(24) NOT NULL,
	  `cs_modified` int(24) NOT NULL,
	  `prefix` varchar(10) NOT NULL,
	  `first` varchar(48) NOT NULL,
	  `middle` varchar(48) NOT NULL,
	  `last` varchar(48) NOT NULL,
	  `suffix` varchar(24) NOT NULL,
	  `nickname` varchar(48) NOT NULL,
	  `email` varchar(128) NOT NULL,
	  `phone` varchar(24) NOT NULL,
	  `street` varchar(48) NOT NULL,
	  `suite` varchar(48) NOT NULL,
	  `city` varchar(48) NOT NULL,
	  `province` varchar(48) NOT NULL,
	  `country` varchar(48) NOT NULL,
	  `website` varchar(128) NOT NULL,
	  `organization` varchar(48) NOT NULL,
	  `facebook` varchar(48) NOT NULL,
	  `twitter` varchar(48) NOT NULL,
	  `openid` varchar(1024) NOT NULL,
	  `office` varchar(128) NOT NULL,
	  `building` int(11) NOT NULL,
	  `profile` text NOT NULL,
	  `roles` varchar(20000) NOT NULL,
	  `ipaddress` varchar(64) NOT NULL,
	  `zip` varchar(24) NOT NULL,
	  `ban` int(1) NOT NULL,
	  `confirmed` int(1) DEFAULT NULL,
	  `confirmkey` varchar(128) DEFAULT NULL,
	  `signature` varchar(128) DEFAULT NULL,
	  `unique` varchar(128) DEFAULT NULL,
	  `type` varchar(128) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

	CREATE TABLE IF NOT EXISTS `Role` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `cs_created` int(24) NOT NULL,
	  `cs_modified` int(24) NOT NULL,
	  `name` varchar(128) NOT NULL,
	  `permissions` varchar(30000) NOT NULL,
	  `category` varchar(128) NOT NULL,
	  `allmembers` int(1) NOT NULL,
	  `allguests` int(1) NOT NULL,
	  `allemployees` int(1) NOT NULL,
	  `icon` varchar(128) DEFAULT NULL,
	  `importance` int(32) DEFAULT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

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

The Eskridge Web Framework has a concept of controllers which is almost
identical to most MVC frameworks. Here is an example controller.

    <?php
    public class HelpController extends AppController {
		public function index() {
			// This is an action, mounted at http://example.com/help/index/, or just /help/

			// How to pass data to the view
			$this->variable = "value";

			// How to trigger a 404
			return new NotFoundError();

			// How to redirect the user
			return new Redirect("http://google.com/");
			return new Redirect("/controller/action/arg1/arg2/");

			// How to send a non-HTML response
			return json_encode($arr);
			// or simply
			return "Hello, World!"
		}

		public function view($id) {
			// This function includes an argument.
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

Here is a sample model.

	<?php
	class Idea extends Model {
		public function getStructure() {
			return array(
				"name" => "string", // Short string (~128 characters)
				"description => "string+", // Long string (~30,000 characters),
				"likes" => "integer" // An integer value
				"score" => "number" // A decimal value, such as 123.4, or simply 123
				"tags" => "list" // A list of strings
				"author" => "Person" // The name of another model
			);
		}
	}
	?>

Here are a few examples of manipulating this model:

	<?php

	// Finding an instance
	$idea = new Idea($id);
	$idea = new Idea(array("name" => "Old Name"));

	// Setting data
	$idea->set("name", "New Name");
	$idea->set("tags", array("tag1", "tag2"));

	// Getting data
	echo $idea->get("name");
	print_r($idea->get("tags"));

	// Finding multiple instances
	$ideas = Idea::findAll("Idea", array("name" => "New Name"));
	$ideas = Idea::findAll("Idea", array("`likes`>".mysql_real_escape_string($minimum).""));

	// Looping over multiple instances
	foreach ($ideas as $idea) { echo $idea->get("name") }

	// Get Modified time. Format: "2 days ago," "3 months ago," etc.
	$idea->getModified();
	$idea->getCreated();

	// Create a new model
	Idea::create("Idea", array("name" => "New Idea"));

	// Delete a model
	$idea->delete();
	?>

The framework does NOT create tables for you, but doing this yourself is
easy enough. Download phpMyAdmin, create a database (enter the config in
System/Data/Settings/database.php), and create tables with the same name
as the exact model, and the logical field types. (string is a VARCHAR(128), but
nothing will go wrong if you make it TEXT or VARCHAR(64)) Make sure to create
an id (Primary key, auto-increment), cs_modified (a timestamp stored as an int)
and cs_created (a timestamp stored as an int).

Here is a sample SQL statement, although phpMyAdmin's GUI works just as well.

	CREATE TABLE IF NOT EXISTS `Comment` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `cs_created` int(24) NOT NULL,
	  `cs_modified` int(24) NOT NULL,
	  `modeltype` varchar(128) NOT NULL,
	  `model` int(11) NOT NULL,
	  `user` int(11) NOT NULL,
	  `content` varchar(40000) NOT NULL,
	  `hidden` int(1) NOT NULL,
	  `locked` int(1) NOT NULL,
	  `element` int(11) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

### Files

The CSFramework provides a file class not unlike's Java's. All path are
relative the the framework home directory unless otherwise specified.

	$file = new File("System/Data");

	// Writing to a file
	$file->write("Hello, World!");
	$file->append("World!");

	// Reading from a file
	echo $file->read(); // "Hello, World!"

	// Listing file children
	print_r($file->listSubs());

	// Navigating
	$file = new File("System");
	$tmp = $file->getSub("Data")->getSub("Temporary");
	$data = $tmp->getParent();

	// Getting name and other info
	$file = new File("System/Data/example.php");
	echo $file->getName(); // example.php
	echo $file->getExtensionlessName(); // example
	echo $file->getPath(); // System/Data/example.php

	// Deleting a file
	echo $file->read();

### Forms and Fields

To create a form that uses strong XSS security protection, simply (in the body of
a controller's action):

	$form = new Form("newsletter-signup");
	$form->add(new TextField("name", "Your Name"));
	$form->add(new TextField("email", "Your Email", "", array("email")));
	$this->form = $form->getHtml();

To include this in a view, use this:

	<?php echo $form ?>

To process the input (include this in a controller after the form declaration):

	if ($form->sent()) {
		$signup = Subscription::create("Subscription", $form->getData());
	}

Forms are automatically validated. Notice the array given in the first example
in this section. This array contains validation flags, which set down
requirements. Here are a few examples:

* email: A valid email address
* password: A valid password.
* empty: This field must be empty
* noempty: Anything, as long as it's something
* zipcode: A valid US Postal Service zip code.
* float: A float, such as 123.4
* integer: An integer, such as 0
* ip: An IP Address, such as 127.0.0.1
* phone: A phone number
* link: A web address
* length:5,15: A length between 5 and fifteen (or two other numbers)
* equals:fieldname: Must be the same as another form field in this form.

There is also a shorthand for creating or editing a model using a form:

	// Edit an existing model, and include its data in the form.
	$subscription = new Subscription($id);
	$form = new Form("subscription");
	$form->add(new TextField("email", "Email"));
	$form->controls($subscription);
	$this->form = $form->getHtml();

	// Create a new model
	$form = new Form("subscription");
	$form->add(new TextField("email", "Email"));
	$form->controls("Subscription");
	$this->form = $form->getHtml();

### Anything else

These are the features which come out of the box. You can easily add your own
simply by defining a new plugin type. Simply give the plugin a name, such as
Controllers, create a directory by that name inside any solution, ask other developers
to do likewise, and you can list all instances of this plugin type by using the
code up in the Plugin section of this document.

## Creating a Project

To start building a project with the framework, simply clone or fork the
project from GitHub, create a folder for your code under System/Solutions,
and start coding. To preview your project, you will need to set up a MySQL
database and php server. WAMPServer & MAMP are two high-quality products for
setting these enviornments up easily on your development server.

## Licensing

This framework is licensed under the MIT license. Feel free to make any modifications
you like, or to use it within your own code, whether it is commercial or not.
Do not remove any copyright notices, although we do not include any notices
which are visible to the end-user.

## Contributions & Ownership

This project is owned by Eskridge Technology. If you'd like to make changes
to this framework, then create a fork of it on github. You are free to do whatever
you like with this form, so long as it follows the MIT license. If you want your
changes merged into our project, contact us with a link to your fork, and we will
consider merging the changes. While you retain ownership of any changes we merge,
by giving us permissions to merge changes, you are licensing them under the MIT
license.