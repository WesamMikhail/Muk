<?php
namespace Lorenum\Muk;

use Lorenum\Muk\Core\Muk;
use Lorenum\Muk\Core\Request;
use Lorenum\Muk\Parsers\HTMLParser;

class PaginationHTMLMukSample extends Muk{
    protected $page = 1;

    public function incrementPage(){
        $this->page++;
    }

    public function beforeRequest(Request $request) {
        //Before the request is made we need to define our connection settings
        $request->setUrl("http://www.amazon.com/s/?page=" . $this->page . "&keywords=laptop");
        $request->setHeaders([
            "User-Agent" => "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.12) Gecko/20101026 Firefox/3.6.12"
        ]);
    }

    public function afterRequest(Request $request) {
        $parser = new HTMLParser($request->getResponse()->getBody());
        $result = $parser->query("//*[@class='a-size-medium a-color-null s-inline s-access-title a-text-normal']");

        foreach($result as $product){
            $this->result[] = $product->nodeValue;
        }

        $this->incrementPage();
    }

}