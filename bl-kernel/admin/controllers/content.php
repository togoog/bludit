<?php defined('BLUDIT') or die('Bludit CMS.');

// ============================================================================
// Check role
// ============================================================================

checkRole(array('admin', 'editor'));

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

// List of published pages
$onlyPublished = true;
$amountOfItems = ITEMS_PER_PAGE_ADMIN;
$pageNumber = $url->pageNumber();
$published = $dbPages->getList($pageNumber, $amountOfItems, $onlyPublished);

// Check if out of range the pageNumber
if (empty($published) && $url->pageNumber()>1) {
	Redirect::page('content');
}

$drafts = $dbPages->getDraftDB(true);
$scheduled = $dbPages->getScheduledDB(true);
$static = $dbPages->getStaticDB(true);
$sticky = $dbPages->getStickyDB(true);

// Title of the page
$layout['title'] .= ' - '.$Language->g('Manage content');