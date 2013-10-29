<?php

function panelSortByOrder($a, $b) {
	if ($a == $b) {
        return 0;
    }
    return ($a->getOrder() < $b->getOrder()) ? -1 : 1;
}

function sortByOrder($a, $b) {
	if ($a == $b) {
        return 0;
    }
    return ($a->getOrder() < $b->getOrder()) ? -1 : 1;
}