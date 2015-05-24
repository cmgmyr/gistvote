<?php namespace Gistvote\Gists;

use Illuminate\Support\Facades\Config;

class GistFile
{
    public $name;
    public $language;
    public $content;

    public function __construct($name, $language, $content)
    {
        $this->name = $name;
        $this->language = $language;
        $this->content = $content;
    }

    public function snippet($lines = 10)
    {
        $content = $this->content;

        // split content by lines
        $contents = explode(PHP_EOL, $content);

        $newContents = array_slice($contents, 0, $lines);

        return implode(PHP_EOL, $newContents);
    }

    public function syntaxLanguage()
    {
        $syntax = strtolower($this->language);

        if ($syntax == '' || !in_array($syntax, Config::get('prismjs'))) {
            $syntax = 'bash';
        }

        return $syntax;
    }
}
