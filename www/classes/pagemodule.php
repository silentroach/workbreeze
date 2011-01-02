<?php

class PageModule extends Module {

	/**
	 * Don't use ajax checks
	 */
	protected function isAjax() {
		return false;
	}

}
