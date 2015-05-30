<?php namespace Gistvote\Parser;

interface Transformer
{
    /**
     * Transforms the given content
     *
     * @param string $content
     * @return string
     */
    public function transform($content);
}
