<?php
/* This is an example page calling the phpsecinfo() function */
if ( empty($_SERVER['HTTP_REFERER']) && !strstr($_SERVER['HTTP_REFERER'], 'xoopsinfo') && !isset($GLOBALS['_GET']['xoopsinfo']) ) {
	header("Location: http://" . $_SERVER['HTTP_HOST']);
} else {
	require_once('PhpSecInfo/PhpSecInfo.php');
	phpsecinfo();
}
?>

<?php
/**
 * If you want to capture output and/or customize the look and feel,
 * you need to do slightly more work.
 *
 * Example:
 * <code>
 * require_once('PhpSecInfo/PhpSecInfo.php');
 * // instantiate the class
 * $psi = new PhpSecInfo();
 *
 * // load and run all tests
 * $psi->loadAndRun();
 *
 * // grab the results as a multidimensional array
 * $results = $psi->getResultsAsArray();
 * echo "<pre>"; echo print_r($results, true); echo "</pre>";
 *
 * // grab the standard results output as a string
 * $html = $psi->getOutput();
 *
 * // send it to the browser
 * echo $html;
 * </code>
 */
?>
