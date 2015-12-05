<?php
namespace Lorenum\Muk\Examples;

use Lorenum\Muk\Core\BaseMuk;
use Lorenum\Muk\Request\Request;
use Lorenum\Muk\Parsers\HTMLParser;

class SingleHTMLMuk extends BaseMuk{

    public function beforeRequest(Request $request) {
        //Before the request is made we need to define our connection settings
        $request->setUrl("http://pokemondb.net/pokedex/game/firered-leafgreen");
        $request->setHeaders([
            "User-Agent" => "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36"
        ]);
    }

    public function afterRequest(Request $request) {
        //The HTMLParser sets up the XPath document that we are going to use to extract the result
        $parser = new HTMLParser($request->getResponse()->getBody());
        $result = $parser->query("//*[@class='ent-name']");

        //Add each product to the result set
        foreach($result as $pokemon){
            $this->result[] = $pokemon->nodeValue;
        }
    }
}