<?php

abstract class BannerType {
	abstract function getName();
	abstract function getForm();
	abstract function render($banner);
}