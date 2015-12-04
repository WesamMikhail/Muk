<?php
namespace Lorenum\Muk;

use Lorenum\Muk\Core\Muk;
use Lorenum\Muk\Core\Request;
use Lorenum\Muk\Parsers\HTMLParser;

class SingleHTMLMukSample extends Muk{

    public function beforeRequest(Request $request) {
        //Before the request is made we need to define our connection settings
        $request->setUrl("http://pokemondb.net/pokedex/game/firered-leafgreen");
        $request->setHeaders([
            "User-Agent" => "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.12) Gecko/20101026 Firefox/3.6.12"
        ]);
    }

    public function afterRequest(Request $request) {
        $parser = new HTMLParser($request->getResponse()->getBody());
        $result = $parser->query("//*[@class='ent-name']");

        foreach($result as $pokemon){
            $this->result[] = $pokemon->nodeValue;
        }
    }

}