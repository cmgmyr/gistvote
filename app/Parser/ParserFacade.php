<?php namespace Gistvote\Parser;

use Illuminate\Support\Facades\Facade;

class ParserFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Parser::class;
    }
}
