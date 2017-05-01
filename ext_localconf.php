<?php
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['determineId-PostProc'][] = Webenergy\MhHttpbl\Hooks\FrontendHooks::class . '->checkBlacklist';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all'][] = Webenergy\MhHttpbl\Hooks\FrontendHooks::class . '->addHoneyPot';