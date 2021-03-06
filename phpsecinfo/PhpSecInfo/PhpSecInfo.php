<?php declare(strict_types=1);

/**
 * Main class file
 * @author Ed Finkler <coj@funkatron.com>
 */

/**
 * The default language setting.
 * Use or add your favorite language. Current choice: fr, en
 * Add a choice with PHP case for translations of this page
 * Add a line with a new language value in the Test.php file
 * Untranslated strings will be replaced by English strings : en
 *
 * Le paramètre de langue par défaut.
 * Utiliser ou ajouter votre langue préférée. Choix possible actuellement : fr, en
 * Ajouter un choix avec PHP case pour les traductions de cette page
 * Ajouter une ligne avec une nouvelle valeur de langue dans le fichier Test.php
 * Les chaînes non traduites seront remplacées par les chaînes en anglais : en
 */
define('PHPSECINFO_LANG_DEFAULT', 'en');

/**
 * Displays the current version of PhpSecInfo
 *
 * Afficher la version courante de PhpSecInfo : 3.0.1 (0.2.1 + v2.0.2)
 */
define('PHPSECINFO_VERSION', '3.0.2');

/**
 * A YYYY.MM.DD date string to indicate "build" date
 */
define('PHPSECINFO_BUILD', date('d-m-Y'));

/**
 * Homepage for phpsecinfo project
 */
define('PHPSECINFO_URL', 'http://phpsec.org/projects/phpsecinfo/');

/**
 * This is the main class for the phpsecinfo system.
 * It's responsible for
 * dynamically loading tests, running those tests, and generating the results output
 *
 * Example:
 * <code>
 * <?php require_once('PhpSecInfo/PhpSecInfo.php'); ?>
 * <?php phpsecinfo(); ?>
 * </code>
 *
 * If you want to capture the output, or just grab the test results and display them
 * in your own way, you'll need to do slightly more work.
 *
 * Example :
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
 *
 * The procedural function "phpsecinfo" is defined below this class.
 *
 * @see    phpsecinfo()
 *
 * @author Ed Finkler <coj@funkatron.com>
 *
 *         see CHANGELOG for changes
 */
class PhpSecInfo
{
    /**
     * An array of tests to run
     *
     * @public array PhpSecInfo_Test
     */

    public $tests_to_run = [];

    /**
     * An array of results.
     * Each result is an associative array:
     * <code>
     * $result['result'] = PHPSECINFO_TEST_RESULT_NOTICE;
     * $result['message'] = "a string describing the test results and what they mean";
     * </code>
     *
     * @public array
     */

    public $test_results = [];

    /**
     * An array of tests that were not run
     *
     * <code>
     * $result['result'] = PHPSECINFO_TEST_RESULT_NOTRUN;
     * $result['message'] = "a string explaining why the test was not run";
     * </code>
     *
     * @public array
     */

    public $tests_not_run = [];

    /**
     * The language code used.
     * Defaults to PHPSECINFO_LANG_DEFAULT, which
     * is 'en'
     *
     * @public string
     * @see    PHPSECINFO_LANG_DEFAULT
     */

    public $language = PHPSECINFO_LANG_DEFAULT;

    /**
     * An array of integers recording the number of test results in each category.
     * Categories can include
     * some or all of the PHPSECINFO_TEST_* constants. Constants are the keys, # of results are the values.
     *
     * @public array
     */

    public $result_counts = [];

    /**
     * The number of tests that have been run
     *
     * @public integer
     */

    public $num_tests_run = 0;

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * recurses through the Test subdir and includes classes in each test group subdir,
     * then builds an array of classnames for the tests that will be run
     */
    public function loadTests()
    {
        $test_root = dir(__DIR__ . DIRECTORY_SEPARATOR . 'Test');

        // echo "<pre>"; echo print_r($test_root, true); echo "</pre>";

        while (false !== ($entry = $test_root->read())) {
            if (is_dir($test_root->path . DIRECTORY_SEPARATOR . $entry) && !preg_match('|^\.(.*)$|', $entry)) {
                $test_dirs[] = $entry;
            }
        }

        // echo "<pre>"; echo print_r($test_dirs, true); echo "</pre>";

        // include_once all files in each test dir
        foreach ($test_dirs as $test_dir) {
            $this_dir = dir($test_root->path . DIRECTORY_SEPARATOR . $test_dir);

            while (false !== ($entry = $this_dir->read())) {
                if (!is_dir($this_dir->path . DIRECTORY_SEPARATOR . $entry)) {
                    require_once $this_dir->path . DIRECTORY_SEPARATOR . $entry;

                    $classNames[] = 'PhpSecInfo_Test_' . $test_dir . '_' . basename($entry, '.php');
                }
            }
        }

        // store Class Names
        // modded this to not throw a PHP5 STRICT notice, although I don't like passing by value here
        // pour ne pas lancer une notification PHP5 STRICT, bien que je n'aime pas passer par valeur ici
        $this->tests_to_run = $classNames;
    }

    /**
     * This runs the tests in the tests_to_run array and
     * places returned data in the following arrays/scalars:
     * - $this->test_results
     * - $this->result_counts
     * - $this->num_tests_run
     * - $this->tests_not_run;
     */
    public function runTests()
    {
        // initialize a bunch of arrays
        $this->test_results = [];

        $this->result_counts = [];

        $this->result_counts[PHPSECINFO_TEST_RESULT_NOTRUN] = 0;

        $this->num_tests_run = 0;

        foreach ($this->tests_to_run as $testClass) {
            /**
             * @public $test PhpSecInfo_Test
             */

            $test = new $testClass();

            if ($test->isTestable()) {
                $test->test();

                $rs = [
                    'result'            => $test->getResult(),
                    'message'           => $test->getMessage(),
                    'value_current'     => $test->getCurrentTestValue(),
                    'value_recommended' => $test->getRecommendedTestValue(),
                    'moreinfo_url'      => $test->getMoreInfoURL(),
                ];

                $this->test_results[$test->getTestGroup()][$test->getTestName()] = $rs;

                // Initialize if not yet set
                if (!isset($this->result_counts[$rs['result']])) {
                    $this->result_counts[$rs['result']] = 0;
                }

                $this->result_counts[$rs['result']]++;

                $this->num_tests_run++;
            } else {
                $rs = [
                    'result'            => $test->getResult(),
                    'message'           => $test->getMessage(),
                    'value_current'     => null,
                    'value_recommended' => null,
                    'moreinfo_url'      => $test->getMoreInfoURL(),
                ];

                $this->result_counts[PHPSECINFO_TEST_RESULT_NOTRUN]++;

                $this->tests_not_run[$test->getTestGroup() . '::' . $test->getTestName()] = $rs;
            }
        }
    }

    /**
     * This is the main output method.
     * The look and feel mimics phpinfo()
     * @param string $page_title
     */
    public function renderOutput($page_title = 'PHP Security Information')
    {
        /**
         * We need to use PhpSecInfo_Test::getBooleanIniValue() below
         *
         * @see PhpSecInfo_Test::getBooleanIniValue()
         */

        if (!class_exists('PhpSecInfo_Test')) {
            include(__DIR__ . DIRECTORY_SEPARATOR . 'Test' . DIRECTORY_SEPARATOR . 'Test.php');
        } ?>
        <!-- XHTML 1.0 Transitional -->
        <!-- <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd"> -->
        <!-- HTML5 -->
        <!DOCTYPE html>
        <html>
        <head>
            <title><?php echo $page_title ?></title>
            <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
            <meta name="robots" content="noindex,nofollow"/>
            <style type="text/css">
                .phpblue {
                    #777BB4

                }

                /*
                    #706464
                    #C7C6B3
                    #7B8489
                    #646B70
                    */
                BODY {
                    background-color: #C7C6B3;
                    color: #333333;
                    margin: 0;
                    padding: 0;
                    text-align: center;
                }

                BODY, TD, TH, H1, H2 {
                    font-family: Helvetica, Arial, Sans-serif;
                }

                DIV.logo {
                    float: right;
                }

                A:link, A:hover, A:visited {
                    color: #000099;
                    text-decoration: none;
                }

                A:hover {
                    text-decoration: underline !important;
                }

                DIV.container {
                    text-align: center;
                    width: 650px;
                    margin-left: auto;
                    margin-right: auto;
                }

                DIV.header {
                    width: 100%;
                    text-align: left;
                    border-collapse: collapse;
                }

                DIV.header {
                    background-color: #4C5B74;
                    color: white;
                    border-bottom: 3px solid #333333;
                    padding: .5em;
                }

                DIV.header H1, DIV.header H2 {
                    padding: 0;
                    margin: 0;
                }

                DIV.header H2 {
                    font-size: 1em;
                }

                DIV.header a:link, DIV.header a:visited, DIV.header a:hover {
                    color: #ffff99;
                }

                H2.result-header {
                    margin: 1em 0 .5em 0;
                }

                TABLE.results {
                    border-collapse: collapse;
                    width: 100%;
                    text-align: left;
                }

                TD, TH {
                    padding: 0.5em;
                    border: 2px solid #333333;
                }

                TR.header {
                    background-color: #706464;
                    color: white;
                }

                TD.label {
                    text-align: top;
                    font-weight: bold;
                    background-color: #7B8489;
                    border: 2px solid #333333;
                }

                TD.value {
                    border: 2px solid #333333
                }

                .centered {
                    text-align: center;
                }

                .centered TABLE {
                    text-align: left;
                }

                .centered TH {
                    text-align: center;
                }

                .result {
                    font-size: 1.2em;
                    font-weight: bold;
                    margin-bottom: .5em;
                }

                .message {
                    line-height: 1.4em;
                }

                TABLE.values {
                    padding: .5em;
                    margin: .5em;
                    text-align: left;
                    margin: none;
                    width: 90%;
                }

                TABLE.values TD {
                    font-size: .9em;
                    border: none;
                    padding: .4em;
                }

                TABLE.values TD.label {
                    font-weight: bold;
                    text-align: right;
                    width: 45%;
                }

                DIV.moreinfo {
                    text-align: right;
                }

                .value-ok {
                    background-color: #009900;
                    color: #ffffff;
                }

                .value-ok a:link, .value-ok a:hover, .value-ok a:visited {
                    color: #FFFF99;
                    font-weight: bold;
                    background-color: transparent;
                    text-decoration: none;
                }

                .value-ok table td {
                    background-color: #33AA33;
                    color: #ffffff;
                }

                .value-notice {
                    background-color: #FFA500;
                    color: #000000;
                }

                .value-notice a:link, .value-notice a:hover, .value-notice a:visited {
                    color: #000099;
                    font-weight: bold;
                    background-color: transparent;
                    text-decoration: none;
                }

                .value-notice td {
                    background-color: #FFC933;
                    color: #000000;
                }

                .value-warn {
                    background-color: #990000;
                    color: #ffffff;
                }

                .value-warn a:link, .value-warn a:hover, .value-warn a:visited {
                    color: #FFFF99;
                    font-weight: bold;
                    background-color: transparent;
                    text-decoration: none;
                }

                .value-warn td {
                    background-color: #AA3333;
                    color: #ffffff;
                }

                .value-notrun {
                    background-color: #cccccc;
                    color: #000000;
                }

                .value-notrun a:link, .value-notrun a:hover, .value-notrun a:visited {
                    color: #000099;
                    font-weight: bold;
                    background-color: transparent;
                    text-decoration: none;
                }

                .value-notrun td {
                    background-color: #dddddd;
                    color: #000000;
                }

                .value-error {
                    background-color: #F6AE15;
                    color: #000000;
                    font-weight: bold;
                }

                .value-error td {
                    background-color: #F6AE15;
                    color: #000000;
                }
            </style>
        </head>
        <body>
        <div class="header">
            <h1><a href="<?php echo PHPSECINFO_URL ?>" target="_phpsec"><?php echo $page_title ?></a></h1>
            <h2><?php
                // Affiche "Version xxx"
                switch (PHPSECINFO_LANG_DEFAULT) {
                    case 'fr':
                        echo 'Version ';
                        echo PHPSECINFO_VERSION;

                        break;
                    default:
                        echo 'Version ';
                        echo PHPSECINFO_VERSION;

                        break;
                } ?> - <?php
                // Affiche "Last update"
                switch (PHPSECINFO_LANG_DEFAULT) {
                    case 'fr':
                        echo 'Dernière mise à jour du';

                        break;
                    default:
                        echo 'Last update the';

                        break;
                } ?> <?php echo PHPSECINFO_BUILD ?> - <a href="https://github.com/ZerooCool/phpsecinfo/"
                                                         target="_PhpSecInfo"><?php
                    // Affiche "Participate from Github"
                    switch (PHPSECINFO_LANG_DEFAULT) {
                        case 'fr':
                            echo 'Participer depuis Github';

                            break;
                        default:
                            echo 'Participate from Github';

                            break;
                    } ?></a> - <a href="PhpSecInfo/phpinfo.php"><?php
                    // Affiche "See phpinfo ()"
                    switch (PHPSECINFO_LANG_DEFAULT) {
                        case 'fr':
                            echo 'Consulter phpinfo()';

                            break;
                        default:
                            echo 'See phpinfo ()';

                            break;
                    } ?></a>
            </h2>
        </div>

        <div class="container">
            <?php
            foreach ($this->test_results as $group_name => $group_results) {
                $this->_outputRenderTable($group_name, $group_results);
            }

            $this->_outputRenderNotRunTable();

            $this->_outputRenderStatsTable(); ?>
        </div>
        </body>
        </html>
        <?php
    }

    /**
     * This is a helper method that makes it easy to output tables of test results
     * for a given test group
     *
     * @param string $group_name
     * @param array  $group_results
     * @return bool
     */
    public function _outputRenderTable($group_name, $group_results)
    {
        // exit out if $group_results was empty or not an array. This sorta seems a little hacky...
        if (!is_array($group_results) || count($group_results) < 1) {
            return false;
        }

        // Commenté via le code de BigDeej
        // https://github.com/bigdeej/PhpSecInfo/tree/master/PhpSecInfo/Test/Core
        // ksort($group_results);
        ?>
        <h2 class="result-header"><?php echo htmlspecialchars($group_name, ENT_QUOTES) ?></h2>

        <table class="results">
            <tr class="header">
                <th><?php
                    // Affiche "Check"
                    switch (PHPSECINFO_LANG_DEFAULT) {
                        case 'fr':
                            echo 'Vérifier';

                            break;
                        default:
                            echo 'Check';

                            break;
                    } ?></th>
                <th><?php
                    // Affiche "Result"
                    switch (PHPSECINFO_LANG_DEFAULT) {
                        case 'fr':
                            echo 'Résultat';

                            break;
                        default:
                            echo 'Result';

                            break;
                    } ?></th>
            </tr>
            <?php foreach ($group_results as $test_name => $test_results) :
                ?>
                <tr>
                    <td class="label"><?php echo htmlspecialchars($test_name, ENT_QUOTES) ?></td>
                    <td
                            class="value <?php echo $this->_outputGetCssClassFromResult($test_results['result']) ?>">
                        <?php if ('Test Results Summary' != $group_name) :
                            ?>
                            <div class="result"><?php echo $this->_outputGetResultTypeFromCode($test_results['result']) ?></div>
                        <?php endif; ?>
                        <div class="message"><?php echo $test_results['message'] ?></div>

                        <?php if (isset($test_results['value_current']) || isset($test_results['value_recommended'])) :
                            ?>
                            <table class="values">
                                <?php if (isset($test_results['value_current'])) :
                                    ?>
                                    <tr>
                                        <td class="label"><?php
                                            // Affiche "Current Value"
                                            switch (PHPSECINFO_LANG_DEFAULT) {
                                                case 'fr':
                                                    echo 'Valeur actuelle';

                                                    break;
                                                default:
                                                    echo 'Current Value';

                                                    break;
                                            } ?></td>

                                        <!-- <td><?php echo $test_results['value_current'] ?></td>  -->
                                        <!-- https://github.com/bigdeej/PhpSecInfo/tree/master/PhpSecInfo/Test/Core -->
                                        <td><?php echo wordwrap($test_results['value_current'], 55, '<br />', true) ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset($test_results['value_recommended'])) :
                                    ?>
                                    <tr>
                                        <td class="label"><?php
                                            // Affiche "Recommended Value"
                                            switch (PHPSECINFO_LANG_DEFAULT) {
                                                case 'fr':
                                                    echo 'Valeur recommandée';

                                                    break;
                                                default:
                                                    echo 'Recommended Value';

                                                    break;
                                            } ?></td>
                                        <td><?php echo $test_results['value_recommended'] ?></td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                        <?php endif; ?>
                        <?php if (isset($test_results['moreinfo_url']) && $test_results['moreinfo_url']) :
                            ?>
                            <div class="moreinfo">
                                <a href="<?php echo $test_results['moreinfo_url']; ?>"
                                   target="_blank"><?php
                                    // Affiche "More information &raquo;"
                                    switch (PHPSECINFO_LANG_DEFAULT) {
                                        case 'fr':
                                            echo 'Plus d\'information &raquo;';

                                            break;
                                        default:
                                            echo 'More information &raquo;';

                                            break;
                                    } ?></a>
                            </div>
                        <?php endif; ?>
                    </td>
                </tr>

            <?php endforeach; ?>
        </table>
        <br/>

        <?php
        return true;
    }

    /**
     * This outputs a table containing a summary of the test results (counts and % in each result type)
     *
     * @see PHPSecInfo::_outputRenderTable()
     * @see PHPSecInfo::_outputGetResultTypeFromCode()
     */
    public function _outputRenderStatsTable()
    {
        // Add by
        // https://github.com/bigdeej/PhpSecInfo/tree/master/PhpSecInfo/Test/Core
        $score = 100;

        foreach ($this->result_counts as $code => $val) {
            if (PHPSECINFO_TEST_RESULT_NOTRUN != $code) {
                $percentage = round($val / $this->num_tests_run * 100, 2);

                // Add by
                // https://github.com/bigdeej/PhpSecInfo/tree/master/PhpSecInfo/Test/Core
                if (PHPSECINFO_TEST_RESULT_NOTICE == $code) {
                    $score -= $percentage / 2;
                } elseif (PHPSECINFO_TEST_RESULT_WARN == $code) {
                    $score -= $percentage;
                }

                $stats[$this->_outputGetResultTypeFromCode($code)] = [
                    'count'   => $val,
                    'result'  => $code,
                    'message' => "$val out of {$this->num_tests_run} ($percentage%)",
                ];
            }
        }

        $this->_outputRenderTable('Test Results Summary', $stats);
    }

    /**
     * This outputs a table containing a summary or test that were not executed, and the reasons why they were skipped
     *
     * @see PHPSecInfo::_outputRenderTable()
     */
    public function _outputRenderNotRunTable()
    {
        $this->_outputRenderTable('Tests Not Run', $this->tests_not_run);
    }

    /**
     * This is a helper function that returns a CSS class corresponding to
     * the result code the test returned.
     * This allows us to color-code results
     *
     * @param int $code
     * @return string
     */
    public function _outputGetCssClassFromResult($code)
    {
        switch ($code) {
            case PHPSECINFO_TEST_RESULT_OK:
                return 'value-ok';
            case PHPSECINFO_TEST_RESULT_NOTICE:
                return 'value-notice';
            case PHPSECINFO_TEST_RESULT_WARN:
                return 'value-warn';
            case PHPSECINFO_TEST_RESULT_NOTRUN:
                return 'value-notrun';
            case PHPSECINFO_TEST_RESULT_ERROR:
                return 'value-error';
            default:
                return 'value-notrun';
        }
    }

    /**
     * This is a helper function that returns a label string corresponding to
     * the result code the test returned.
     * This is mainly used for the Test
     * Results Summary table.
     *
     * @param int $code
     * @return string
     * @see PHPSecInfo::_outputRenderStatsTable()
     */
    public function _outputGetResultTypeFromCode($code)
    {
        switch ($code) {
            case PHPSECINFO_TEST_RESULT_OK:
                return 'Pass';
            case PHPSECINFO_TEST_RESULT_NOTICE:
                return 'Notice';
            case PHPSECINFO_TEST_RESULT_WARN:
                return 'Warning';
            case PHPSECINFO_TEST_RESULT_NOTRUN:
                return 'Not Run';
            case PHPSECINFO_TEST_RESULT_ERROR:
                return 'Error';
            default:
                return 'Invalid Result Code';
        }
    }

    /**
     * Loads and runs all the tests
     * As loading, then running, is a pretty common process, this saves a extra method call
     *
     * @since 0.1.1
     */
    public function loadAndRun()
    {
        $this->loadTests();

        $this->runTests();
    }

    /**
     * Returns an associative array of test data.
     * Four keys are set:
     * - test_results (array)
     * - tests_not_run (array)
     * - result_counts (array)
     * - num_tests_run (integer)
     *
     * Note that this must be called after tests are loaded and run
     *
     * @return array
     */
    public function getResultsAsArray()
    {
        $results = [];

        $results['test_results'] = $this->test_results;

        $results['tests_not_run'] = $this->tests_not_run;

        $results['result_counts'] = $this->result_counts;

        $results['num_tests_run'] = $this->num_tests_run;

        return $results;
    }

    /**
     * Returns the standard output as a string instead of echoing it to the browser
     * Note that this must be called after tests are loaded and run
     *
     * @return string
     */
    public function getOutput()
    {
        ob_start();

        $this->renderOutput();

        return ob_get_clean();
    }
}

/**
 * A globally-available function that runs the tests and creates the result page
 */
function phpsecinfo()
{
    // modded this to not throw a PHP5 STRICT notice, although I don't like passing by value here
    $psi = new PhpSecInfo();

    $psi->loadAndRun();

    $psi->renderOutput();
}
