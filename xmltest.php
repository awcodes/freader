<?php

/**
 * The only reliable way of determining if a child exists
 * in SimpleXMLElement is to use count(). All other methods
 * do not work reliably in global or local NS.
 *
 * NOTE: Error suppresion on @count() is used to suppress
 *   "PHP Warning:  count(): Node no longer exists"
 */
if (!class_exists('SimpleXMLElement')) die("Bonkers");

$xml = new SimpleXMLElement('
    <xml xmlns:abstract="urn:my.org:abstract">
        <abstract:node>foo</abstract:node>
        <bar>123</bar>
    </xml>
');

var_dump(gettype($xml->node));
var_dump(isset($xml->node));
var_dump(empty($xml->node));
var_dump(is_null($xml->node));
var_dump(@count($xml->node));
var_dump(@count($xml->node->children()));
echo "----------------------\n";
var_dump(gettype($xml->bar));
var_dump(isset($xml->bar));
var_dump(empty($xml->bar));
var_dump(is_null($xml->bar));
var_dump(@count($xml->bar));
var_dump(@count($xml->bar->children()));
echo "----------------------\n";
var_dump(gettype($xml->children('abstract', true)->node));
var_dump(isset($xml->children('abstract', true)->node));
var_dump(empty($xml->children('abstract', true)->node));
var_dump(is_null($xml->children('abstract', true)->node));
var_dump(@count($xml->children('abstract', true)->node));
var_dump(@count($xml->children('abstract', true)->node->children()));
echo "----------------------\n";
var_dump(gettype($xml->children('abstract', true)->bar));
var_dump(isset($xml->children('abstract', true)->bar));
var_dump(empty($xml->children('abstract', true)->bar));
var_dump(is_null($xml->children('abstract', true)->bar));
var_dump(@count($xml->children('abstract', true)->bar));
var_dump(@count($xml->children('abstract', true)->bar->children()));
