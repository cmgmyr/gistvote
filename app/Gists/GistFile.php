<?php

namespace Gistvote\Gists;

use Gistvote\Services\GitHub;
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
     * @var Gist
     */
    private $gist;

    /**
     * @param Gist $gist
     * @param $name
     * @param $language
     * @param $content
     */
    public function __construct(Gist $gist, $name, $language, $content)
    {
        $this->gist = $gist;
        $this->name = $name;
        $this->language = $language;
        $this->content = htmlentities($content);
    }

    /**
     * Returns a snippet of the content by the number of given lines.
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
     * Returns the syntax language for highlighting.
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
     * Renders an HTML version of the file's snippet.
     *
     * @return string
     */
    public function renderSnippetHtml()
    {
        return $this->renderHtml($this->snippet());
    }

    /**
     * Renders an HTML version of the file's content.
     *
     * @return string
     */
    public function renderFileHtml()
    {
        return $this->renderHtml($this->content);
    }

    /**
     * Renders the correctly formatted HTML for the file.
     *
     * @param $content
     * @return string
     */
    public function renderHtml($content)
    {
        $language = $this->syntaxLanguage();

        if ($language == 'markdown') {
            $markdown = (new GitHub($this->gist->user))->parseMarkdown($content);

            return '<div class="markdown">' . $markdown . '</div>';
        }

        return '<pre><code class="language-' . $language . ' line-numbers">' . $content . '</code></pre>';
    }
}
