<?php defined('BLUDIT') or die('Bludit CMS.');

// ============================================================================
// Check role
// ============================================================================

checkRole(array('admin'));

// ============================================================================
// Functions
// ============================================================================

// ============================================================================
// Main before POST
// ============================================================================

// ============================================================================
// POST Method
// ============================================================================

// ============================================================================
// Main after POST
// ============================================================================
$themeDirname = $layout['parameters'];

if (Sanitize::pathFile(PATH_THEMES.$themeDirname)) {
	$site->set(array('theme'=>$themeDirname));

	// Add to syslog
	$syslog->add(array(
		'dictionaryKey'=>'new-theme-configured',
		'notes'=>$themeDirname
	));

	// Create an alert
	Alert::set( $Language->g('The changes have been saved') );
}

// Redirect
Redirect::page('themes');
