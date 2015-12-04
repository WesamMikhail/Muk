<?php
namespace Lorenum\Muk;

use Lorenum\Muk\Core\Muk;
use Lorenum\Muk\Core\Request;
use Lorenum\Muk\Parsers\HTMLParser;

class PaginationHTMLMukSample extends Muk{
    protected $page = 1;

    public function beforeRequest(Request $request) {
        //Before the request is made we need to define our connection settings
        $request->setUrl("http://www.amazon.com/s/?page=" . $this->page . "&keywords=laptop");
        $request->setHeaders([
            "User-Agent" => "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.12) Gecko/20101026 Firefox/3.6.12"
        ]);
    }

    public function afterRequest(Request $request) {
        //The HTMLParser sets up the XPath document that we are going to use to extract the result
        $parser = new HTMLParser($request->getResponse()->getBody());
        $result = $parser->query("//*[@class='a-size-medium a-color-null s-inline s-access-title a-text-normal']");

        //Add each product to the result set
        foreach($result as $product){
            $this->result[] = $product->nodeValue;
        }

        //Increment the page counter in order to construct the correct URL for the next round-trip
        $this->page++;
    }

}