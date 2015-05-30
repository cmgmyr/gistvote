<?php namespace Gistvote\Parser;

use Michelf\MarkdownExtra;

class MarkdownTransformer implements Transformer
{
    /**
     * Transforms the given content from markdown to html
     *
     * @param string $content
     * @return string
     */
    public function transform($content)
    {
        return MarkdownExtra::defaultTransform($content);
    }
}
