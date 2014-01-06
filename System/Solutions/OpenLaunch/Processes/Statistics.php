<?php

class Statistics {
	public function run($name) {
		if ($name == "platform.stop.9") {
			self::record();
		}
	}

	public static function getReportToday() {
		return self::getReport(time()-86400, time());
	}

	public static function getReport($start, $end) {
		$report = array();
		$report["summary"] = array();
		$report["summary"]["views"] = PageView::count("PageView", array("`cs_created` > $start", "`cs_created` < $end"));
		$report["summary"]["visitors"] = PageView::count("PageView", array("`cs_created` > $start", "`cs_created` < $end"), "ipaddress");
		return $report;
	}

	public static function getWeekGraph($start = null, $mode = "visitors") {
		if ($start == null) {
			$start = (strtotime("midnight")+86400)-(86400*7);
			$start = time()-(86400*7);
		}
		return self::getGraph($start, time(), 7, $mode);
	}

	public static function getGraph($start, $end, $subs, $mode) {
		$data = array();
		$interval = ($end-$start)/$subs;

		for ($now = $start; $now < $end; $now += $interval) {
			$data[$now] = array(
				"label" => "test",
				"value" => self::getGraphValue($now, $now+$interval, $mode)
			);
		}

		return Component::get("OpenLaunch.Graph", array(
			"data" => $data
		));
	}

	public static function getGraphValue($start, $end, $mode) {
		if ($mode == "visitors") {
			return PageView::count("PageView", array("`cs_created`>'$start'", "`cs_created`<'$end'"),"ipaddress");
		} else if ($mode == "views") {
			return PageView::count("PageView", array("`cs_created`>'$start'", "`cs_created`<'$end'"));
		}
	}

	public static function record() {
		if (Page::getPage() != null) PageView::create("PageView", array(
			"user" => Session::getPerson(),
			"page" => Page::getPage(),
			"browser" => Request::getBrowser(),
			"platform" => Request::getPlatform(),
			"ipaddress" => Request::getIPAddress(),
			"form" => Request::getForm()
		));
	}
}