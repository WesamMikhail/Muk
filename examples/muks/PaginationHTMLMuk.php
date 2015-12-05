<?php
namespace Lorenum\Muk\Examples;

use Lorenum\Muk\Core\LoopMuk;
use Lorenum\Muk\Request\Request;
use Lorenum\Muk\Parsers\HTMLParser;

class PaginationHTMLMuk extends LoopMuk{
    protected $page = 1;

    public function beforeRequest(Request $request) {
        //Before the request is made we need to define our connection settings
        $request->setUrl("http://www.dustinhome.se/group/hardvara/datorer-surfplattor/barbara-datorer/professionella/page-" . $this->page);
        $request->setHeaders([
            "User-Agent" => "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36"
        ]);
    }

    public function afterRequest(Request $request) {
        //The HTMLParser sets up the XPath document that we are going to use to extract the result
        $parser = new HTMLParser($request->getResponse()->getBody());
        $result = $parser->query("//a[@class='productTitle']");

        //Add each product to the result set
        foreach($result as $product){
            $this->result[] = trim($product->nodeValue);
        }

        //Increment the page counter in order to construct the correct URL for the next round-trip
        $this->page++;
    }

}