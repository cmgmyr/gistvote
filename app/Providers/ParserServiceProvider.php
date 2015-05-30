<?php namespace Gistvote\Providers;

use Gistvote\Parser\MarkdownTransformer;
use Gistvote\Parser\Parser;
use Illuminate\Support\ServiceProvider;

class ParserServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Parser::class, function () {
            $parser = new Parser;

            $parser->push(new MarkdownTransformer);

            return $parser;
        });
    }
}
