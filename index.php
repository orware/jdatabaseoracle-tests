<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.protostar
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/** @var JDocumentHtml $this */

$app  = JFactory::getApplication();
$user = JFactory::getUser();

// Output as HTML5
$this->setHtml5(true);

// Getting params from template
$params = $app->getTemplate(true)->params;

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = $app->get('sitename');

if($task == "edit" || $layout == "form" )
{
	$fullWidth = 1;
}
else
{
	$fullWidth = 0;
}

// Add JavaScript Frameworks
JHtml::_('bootstrap.framework');

$this->addScriptVersion($this->baseurl . '/templates/' . $this->template . '/js/template.js');

// Add Stylesheets
$this->addStyleSheetVersion($this->baseurl . '/templates/' . $this->template . '/css/template.css');

// Use of Google Font
if ($this->params->get('googleFont'))
{
	$this->addStyleSheet('//fonts.googleapis.com/css?family=' . $this->params->get('googleFontName'));
	$this->addStyleDeclaration("
	h1, h2, h3, h4, h5, h6, .site-title {
		font-family: '" . str_replace('+', ' ', $this->params->get('googleFontName')) . "', sans-serif;
	}");
}

// Template color
if ($this->params->get('templateColor'))
{
	$this->addStyleDeclaration("
	body.site {
		border-top: 3px solid " . $this->params->get('templateColor') . ";
		background-color: " . $this->params->get('templateBackgroundColor') . ";
	}
	a {
		color: " . $this->params->get('templateColor') . ";
	}
	.nav-list > .active > a,
	.nav-list > .active > a:hover,
	.dropdown-menu li > a:hover,
	.dropdown-menu .active > a,
	.dropdown-menu .active > a:hover,
	.nav-pills > .active > a,
	.nav-pills > .active > a:hover,
	.btn-primary {
		background: " . $this->params->get('templateColor') . ";
	}");
}

// Check for a custom CSS file
$userCss = JPATH_SITE . '/templates/' . $this->template . '/css/user.css';

if (file_exists($userCss) && filesize($userCss) > 0)
{
	$this->addStyleSheetVersion($this->baseurl . '/templates/' . $this->template . '/css/user.css');
}

// Load optional RTL Bootstrap CSS
JHtml::_('bootstrap.loadCss', false, $this->direction);

// Adjusting content width
if ($this->countModules('position-7') && $this->countModules('position-8'))
{
	$span = "span6";
}
elseif ($this->countModules('position-7') && !$this->countModules('position-8'))
{
	$span = "span9";
}
elseif (!$this->countModules('position-7') && $this->countModules('position-8'))
{
	$span = "span9";
}
else
{
	$span = "span12";
}

// Logo file or site title param
if ($this->params->get('logoFile'))
{
	$logo = '<img src="' . JUri::root() . $this->params->get('logoFile') . '" alt="' . $sitename . '" />';
}
elseif ($this->params->get('sitetitle'))
{
	$logo = '<span class="site-title" title="' . $sitename . '">' . htmlspecialchars($this->params->get('sitetitle'), ENT_COMPAT, 'UTF-8') . '</span>';
}
else
{
	$logo = '<span class="site-title" title="' . $sitename . '">' . $sitename . '</span>';
}
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<jdoc:include type="head" />
	<!--[if lt IE 9]><script src="<?php echo JUri::root(true); ?>/media/jui/js/html5.js"></script><![endif]-->
</head>
<body class="site <?php echo $option
	. ' view-' . $view
	. ($layout ? ' layout-' . $layout : ' no-layout')
	. ($task ? ' task-' . $task : ' no-task')
	. ($itemid ? ' itemid-' . $itemid : '')
	. ($params->get('fluidContainer') ? ' fluid' : '');
	echo ($this->direction == 'rtl' ? ' rtl' : '');
?>">
	<!-- Body -->
	<div class="body" id="top">
		<div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
			<!-- Header -->
			<header class="header" role="banner">
				<div class="header-inner clearfix">
					<a class="brand pull-left" href="<?php echo $this->baseurl; ?>/">
						<?php echo $logo; ?>
						<?php if ($this->params->get('sitedescription')) : ?>
							<?php echo '<div class="site-description">' . htmlspecialchars($this->params->get('sitedescription'), ENT_COMPAT, 'UTF-8') . '</div>'; ?>
						<?php endif; ?>
					</a>
					<div class="header-search pull-right">
						<jdoc:include type="modules" name="position-0" style="none" />
					</div>
				</div>
			</header>
			<?php if ($this->countModules('position-1')) : ?>
				<nav class="navigation" role="navigation">
					<div class="navbar pull-left">
						<a class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
							<span class="element-invisible"><?php echo JTEXT::_('TPL_PROTOSTAR_TOGGLE_MENU'); ?></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</a>
					</div>
					<div class="nav-collapse">
						<jdoc:include type="modules" name="position-1" style="none" />
					</div>
				</nav>
			<?php endif; ?>
			<jdoc:include type="modules" name="banner" style="xhtml" />
			<div class="row-fluid">
				<?php if ($this->countModules('position-8')) : ?>
					<!-- Begin Sidebar -->
					<div id="sidebar" class="span3">
						<div class="sidebar-nav">
							<jdoc:include type="modules" name="position-8" style="xhtml" />
						</div>
					</div>
					<!-- End Sidebar -->
				<?php endif; ?>
				<main id="content" role="main" class="<?php echo $span; ?>">
					<!-- Begin Content -->
					<jdoc:include type="modules" name="position-3" style="xhtml" />
					<jdoc:include type="message" />
					<jdoc:include type="component" />
					<jdoc:include type="modules" name="position-2" style="none" />
					<!-- End Content -->
				</main>
				<?php if ($this->countModules('position-7')) : ?>
					<div id="aside" class="span3">
						<!-- Begin Right Sidebar -->
						<jdoc:include type="modules" name="position-7" style="well" />
						<!-- End Right Sidebar -->
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<!-- Footer -->
	<footer class="footer" role="contentinfo">
		<div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
			<hr />
			<jdoc:include type="modules" name="footer" style="none" />
			<p class="pull-right">
				<a href="#top" id="back-top">
					<?php echo JText::_('TPL_PROTOSTAR_BACKTOTOP'); ?>
				</a>
			</p>
			<p>
				&copy; <?php echo date('Y'); ?> <?php echo $sitename; ?>
			</p>
		</div>
	</footer>
	<jdoc:include type="modules" name="debug" style="none" />
	<?php
	$options1 = [
		'database' => 'xe',
		'user' => 'hr',
		'password' => '1234',
		'host' => 'localhost',
		'driver' => 'pdooracle',
	];

	$options2 = [
		'database' => 'xe',
		'user' => 'hr',
		'password' => '1234',
		'host' => 'localhost',
		'driver' => 'oracle',
	];
	?>
	<?php $oracle = JDatabase::getInstance($options2); ?>
	<?php

		// Test #1: Basic Query:
		$oracle->setQuery('SELECT * FROM COUNTRIES');
		$rows = $oracle->loadObjectList();

		echo "<pre>";
		echo "Test #1: Basic Query:\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Test #2: Basic Query with Bind Parameter:
		$oracle->setQuery('SELECT * FROM COUNTRIES WHERE COUNTRY_ID = :id');
		$id = 'US';
		$oracle->getQuery()->bind(':id', $id);
		$rows = $oracle->loadObjectList();

		echo "<pre>";
		echo "Test #2: Basic Query with Bind Parameter:\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Test #3: Query Object with Bind Parameter:
		$query = $oracle->getQuery(true);
		$query->setQuery('SELECT * FROM COUNTRIES WHERE COUNTRY_ID = :id');
		$id = 'US';
		$query->bind(':id', $id);

		// Set the Query:
		$oracle->setQuery($query);

		$rows = $oracle->loadObjectList();

		echo "<pre>";
		echo "Test #3: Query Object with Bind Parameter:\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Test #4: Query Object Methods Test with Bind Parameter:
		$query = $oracle->getQuery(true);
		$query->select('*');
		$query->from('COUNTRIES');
		$query->where('COUNTRY_ID = :id');

		$id = 'US';
		$query->bind(':id', $id);

		// Set the Query:
		$oracle->setQuery($query);

		$rows = $oracle->loadObjectList();

		echo "<pre>";
		echo "Test #4: Query Object Methods Test with Bind Parameter:\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Test #5: Reuse Query Object and Change Bind Parameter:
		$id = 'JP';
		$query->bind(':id', $id);

		// Set the Query:
		$oracle->setQuery($query);

		$rows = $oracle->loadObjectList();

		echo "<pre>";
		echo "Test #5: Reuse Query Object and Change Bind Parameter:\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Test #6: getTableColumns('DEPARTMENTS') Uppercase Input:
		$rows = $oracle->getTableColumns('DEPARTMENTS');

		echo "<pre>";
		echo "Test #6: getTableColumns('DEPARTMENTS') Uppercase Input:\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Test #7: getTableColumns('departments') Lowercase Input:
		$rows = $oracle->getTableColumns('departments');

		echo "<pre>";
		echo "Test #7: getTableColumns('departments') Lowercase Input:\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Test #8: Uppercase Field Names in Result Set:
		$oracle->toUpper();
		$oracle->setQuery('SELECT * FROM JOBS');
		$rows = $oracle->loadObjectList();

		echo "<pre>";
		echo "Test #8: Uppercase Field Names in Result Set:\n";
		echo print_r($rows, true);
		echo "</pre>";
		$oracle->toLower();

		// Test #9: loadAssocList() Result Set:
		$oracle->setQuery('SELECT * FROM JOBS');
		$rows = $oracle->loadAssocList();

		echo "<pre>";
		echo "Test #9: loadAssocList() Result Set:\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Test #10: loadRowList() Result Set:
		$oracle->setQuery('SELECT * FROM JOBS');
		$rows = $oracle->loadRowList();

		echo "<pre>";
		echo "Test #10: loadRowList() Result Set:\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Test #11: getTableCreate('departments') Lowercase Input:
		$rows = $oracle->getTableCreate('departments');

		echo "<pre>";
		echo "Test #11: getTableCreate('departments') Lowercase Input:\n";
		echo "NOTE: Returns provided table name(s) as Uppercase Keys in the Result Array\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Test #12: getTableCreate(['jobs', 'job_history']) Multiple Tables Input:
		$rows = $oracle->getTableCreate(['jobs', 'job_history']);

		echo "<pre>";
		echo "Test #12: getTableCreate(['jobs', 'job_history']) Multiple Tables Input:\n";
		echo "NOTE: Returns provided table name(s) as Uppercase Keys in the Result Array\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Test #13: getTableKeys('jobs'):
		$rows = $oracle->getTableKeys('jobs');

		echo "<pre>";
		echo "Test #13: getTableKeys('jobs'):\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Test #14: getTableList() (All Tables):
		$rows = $oracle->getTableList();

		echo "<pre>";
		echo "Test #14: getTableList() (All Tables):\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Test #15: getTableList(null, true) (All Tables with Owners):
		$rows = $oracle->getTableList(null, true);

		echo "<pre>";
		echo "Test #15: getTableList(null, true) (All Tables with Owners):\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Test #16: getTableList('hr') (Tables for HR schema only):
		$rows = $oracle->getTableList('hr');

		echo "<pre>";
		echo "Test #16: getTableList('hr') (Tables for HR schema only):\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Test #17: getVersion() Return Oracle Version:
		$rows = $oracle->getVersion();

		echo "<pre>";
		echo "Test #17: getVersion() Return Oracle Version:\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Test #18: getNumRows() Return Number of Rows Returned by Previous Query:
		$rows = $oracle->getNumRows();

		echo "<pre>";
		echo "Test #18: getNumRows() Return Number of Rows Returned by Previous Query:\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Test #19: getAffectedRows() Return Number of Affected by Previous Query:
		$rows = $oracle->getAffectedRows();

		echo "<pre>";
		echo "Test #19: getAffectedRows() Return Number of Rows Affected by Previous Query:\n";
		echo "NOTE: Since Oracle only provides one function for this, both this and the previous test return the same value:\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Test #20: getIterator() Result Set:
		$oracle->setQuery('SELECT * FROM REGIONS');
		$rows = array();
		$iterator = $oracle->getIterator();
		foreach($iterator as $row)
		{
			$rows[] = $row;
		}
		//unset($iterator);

		echo "<pre>";
		echo "Test #20: getIterator() Result Set:\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Test #21: Execute CREATE TABLE Query:
		$rows = $oracle->getTableCreate('jobs');
		$createTable = $rows['JOBS'];
		$createTable = str_replace('CREATE TABLE "HR"."JOBS"', 'CREATE TABLE "HR"."JOBS2"', $createTable);
		$createTable = str_replace('JOB_', 'JOBS2_', $createTable);

		$oracle->setQuery($createTable);
		try {
			$oracle->execute();
		} catch(JDatabaseExceptionExecuting $e) {
			if ($e->getCode() === 955)
			{
				// Table Already Exists
			}
		}

		$rows = $oracle->getAffectedRows();

		echo "<pre>";
		echo "Test #21: Execute CREATE TABLE Query:\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Test #22: Check Table Was Created Correctly:
		$oracle->setQuery('SELECT * FROM JOBS2');
		$rows = $oracle->loadObjectList();

		echo "<pre>";
		echo "Test #22: Check Table Was Created Correctly:\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Test #23: DROP JOBS2 Table:
		$oracle->dropTable('jobs2');
		$rows = $oracle->getAffectedRows();

		echo "<pre>";
		echo "Test #23: DROP JOBS2 Table:\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Hidden Test: DROP JOBS50 Table:
		$oracle->dropTable('hr.jobs50');
		$rows = $oracle->getAffectedRows();

		// Test #24: Execute CREATE TABLE Query:
		$rows = $oracle->getTableCreate('jobs');
		$createTable = $rows['JOBS'];
		$createTable = str_replace('CREATE TABLE "HR"."JOBS"', 'CREATE TABLE "HR"."JOBS3"', $createTable);
		$createTable = str_replace('JOB_', 'JOBS3_', $createTable);

		$oracle->setQuery($createTable);
		try {
			$oracle->execute();
		} catch(JDatabaseExceptionExecuting $e) {
			if ($e->getCode() === 955)
			{
				// Table Already Exists
			}
		}

		$rows = $oracle->getAffectedRows();

		echo "<pre>";
		echo "Test #24: Execute CREATE TABLE Query:\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Test #25: Execute RENAME TABLE Query:
		$rows = $oracle->renameTable('jobs3', 'jobs50');

		$rows = $oracle->getAffectedRows();

		echo "<pre>";
		echo "Test #25: Execute RENAME TABLE Query:\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Test #26: DROP JOBS50 Table:
		$oracle->dropTable('hr.jobs50');
		$rows = $oracle->getAffectedRows();

		echo "<pre>";
		echo "Test #26: DROP JOBS50 Table:\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Test #27: Get Query Type:
		$oracle->setQuery('SELECT * FROM COUNTRIES');
		$rows = $oracle->getQueryType();

		echo "<pre>";
		echo "Test #27: Get Query Type:\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Hidden Test: DROP REGIONS2 Table:
		$oracle->dropTable('regions2');
		$rows = $oracle->getAffectedRows();

		// Test #28: Create a copy of the Regions Table:
		$rows = $oracle->copyTable('regions', 'regions2');

		$rows = $oracle->getAffectedRows();

		echo "<pre>";
		echo "Test #28: Create a copy of the Regions Table:\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Test #29: Get Regions:
		$oracle->setQuery('SELECT * FROM REGIONS');
		$regions = $oracle->loadObjectList();

		echo "<pre>";
		echo "Test #29: Get Regions:\n";
		echo print_r($regions, true);
		echo "</pre>";

		// Test #30: INSERT Regions in a Transaction into REGIONS2:
		$oracle->transactionStart();
		$query = $oracle->getQuery(true);
		$query->setQuery('INSERT INTO REGIONS2 (
			REGION_ID,
			REGION_NAME
		) VALUES (
			:region_id,
			:region_name
		)');

		foreach($regions as $region)
		{
			// You can do some testing here if paused during debugging
			// by checking the REGIONS2 table after each execute() call
			// and seeing that no records have been added in yet.
			// Once you call transactionCommit() after the loop
			// they all should appear in the table.
			$query->bind(':region_id', $region->region_id);
			$query->bind(':region_name', $region->region_name);

			$oracle->setQuery($query);
			$oracle->execute();
		}

		$oracle->transactionCommit();
		$rows = $oracle->getAffectedRows();

		echo "<pre>";
		echo "Test #30: INSERT Regions in a Transaction into REGIONS2:\n";
		echo "NOTE: All 4 Regions should be in REGIONS2 now:\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Hidden Test: DROP REGIONS3 Table:
		$oracle->dropTable('regions3');
		$rows = $oracle->getAffectedRows();

		// Test #31: Create another copy of the Regions Table:
		$rows = $oracle->copyTable('regions', 'regions3');

		$rows = $oracle->getAffectedRows();

		echo "<pre>";
		echo "Test #31: Create another copy of the Regions Table:\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Test #32: INSERT Regions in a Transaction into REGIONS3:
		$oracle->transactionStart();
		$query = $oracle->getQuery(true);
		$query->setQuery('INSERT INTO REGIONS3 (
			REGION_ID,
			REGION_NAME
		) VALUES (
			:region_id,
			:region_name
		)');

		foreach($regions as $region)
		{
			// Create save point
			// Needs to be performed before setQuery call:
			$oracle->transactionStart(true);

			// You can do some testing here if paused during debugging
			// by checking the REGIONS2 table after each execute() call
			// and seeing that no records have been added in yet.
			// Once you call transactionCommit() after the loop
			// they all should appear in the table.
			$query->bind(':region_id', $region->region_id);
			$query->bind(':region_name', $region->region_name);

			$oracle->setQuery($query);
			$oracle->execute();
		}

		// Undo last two INSERTs:
		$oracle->transactionRollback(true);
		$oracle->transactionRollback(true);

		$oracle->transactionCommit();
		$rows = $oracle->getAffectedRows();

		echo "<pre>";
		echo "Test #32: INSERT Regions in a Transaction into REGIONS3:\n";
		echo "NOTE: Only 2 rows should have been added into REGIONS3 due to the two transactionRollback() calls.\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Test #33: loadObjectList with Key Provided:
		$oracle->setQuery('SELECT * FROM EMPLOYEES', 0, 5);
		$rows = $oracle->loadObjectList('EMPLOYEE_ID');

		echo "<pre>";
		echo "Test #33: loadObjectList with Key Provided:\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Test #34: loadAssocList with Key Provided:
		$oracle->setQuery('SELECT * FROM EMPLOYEES', 0, 5);
		$rows = $oracle->loadAssocList('EMPLOYEE_ID');

		echo "<pre>";
		echo "Test #34: loadAssocList with Key Provided:\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Test #35: loadRowList with Key Provided:
		$oracle->setQuery('SELECT * FROM EMPLOYEES', 0, 5);
		$rows = $oracle->loadRowList(0); // 0 = First Column

		echo "<pre>";
		echo "Test #35: loadRowList with Key Provided:\n";
		echo print_r($rows, true);
		echo "</pre>";

		// Test #36: getIterator() Result Set Uppercase Test:
		$oracle->setQuery('SELECT * FROM REGIONS');
		$rows = array();
		$oracle->toUpper();
		$iterator = $oracle->getIterator();
		foreach($iterator as $row)
		{
			$rows[] = $row;
		}
		//unset($iterator);

		echo "<pre>";
		echo "Test #36: getIterator() Result Set Uppercase Test:\n";
		echo print_r($rows, true);
		echo "</pre>";
		$oracle->toLower();
	?>
</body>
</html>
