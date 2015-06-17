<?php namespace Gistvote\Gists;

use Illuminate\Support\Facades\Config;

class GistFile
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $language;

    /**
     * @var string
     */
    public $content;

    /**
     * @param $name
     * @param $language
     * @param $content
     */
    public function __construct($name, $language, $content)
    {
        $this->name = $name;
        $this->language = $language;
        $this->content = $content;
    }

    /**
     * Returns a snippet of the content by the number of given lines
     *
     * @param int $lines
     * @return string
     */
    public function snippet($lines = 10)
    {
        $content = $this->content;

        // split content by lines
        $contents = explode(PHP_EOL, $content);

        $newContents = array_slice($contents, 0, $lines);

        return implode(PHP_EOL, $newContents);
    }

    /**
     * Returns the syntax language for highlighting
     *
     * @return string
     */
    public function syntaxLanguage()
    {
        $syntax = strtolower($this->language);

        if ($syntax == '' || !in_array($syntax, Config::get('prismjs'))) {
            $syntax = 'bash';
        }

        return $syntax;
    }

    /**
     * Renders an HTML version of the file's snippet
     *
     * @return string
     */
    public function renderSnippetHtml()
    {
        return '<pre><code class="language-' . $this->syntaxLanguage() . ' line-numbers">' . $this->snippet() . '</code></pre>';
    }
}
