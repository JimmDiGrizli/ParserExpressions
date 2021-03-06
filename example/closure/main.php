<?php

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Error;
use GetSky\ParserExpressions\Runner;

require_once '../../vendor/autoload.php';
require_once 'ActionParser.php';

$parser = new ActionParser();
$runner = new Runner($parser->closure());

$runner->run('foo')->toArray();
/*
 * echo $parser->action . PHP_EOL;
 * It\'s foo-action!
 */

$runner->run('bar')->toArray();
/*
 * echo $parser->action . PHP_EOL;
 * It\'s bar-action!
 */


