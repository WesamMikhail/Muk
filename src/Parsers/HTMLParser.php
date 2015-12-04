<?php
namespace Lorenum\Muk\Parsers;

use Lorenum\Muk\Exceptions\InvalidHTML;

use DOMDocument;
use DOMXPath;

/**
 * Class HTMLParser
 * Uses Xpath to parse the document
 *
 * @package Lorenum\Muk\Parsers
 */
class HTMLParser{
    protected $haystack;
    protected $document;
    protected $xpath;

    public function __construct($haystack){
        $this->haystack = $haystack;

        $this->document = new DOMDocument();
        libxml_use_internal_errors(true);

        if (!$this->document->loadHTML($haystack))
            throw new InvalidHTML;

        $this->xpath = new DOMXPath($this->document);
    }

    /**
     * @param $expression
     * @param null $node
     * @return \DOMNodeList
     */
    public function query($expression, $node = null){
        return $this->xpath->query($expression, $node);
    }
}