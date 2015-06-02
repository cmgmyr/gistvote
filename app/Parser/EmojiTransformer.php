<?php namespace Gistvote\Parser;

use Emojione\Emojione;

class EmojiTransformer implements Transformer
{
    /**
     * Transforms the given content from markdown to html
     *
     * @param string $content
     * @return string
     */
    public function transform($content)
    {
        return Emojione::toImage($content);
    }
}
