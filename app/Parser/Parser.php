<?php namespace Gistvote\Parser;

class Parser
{
    /**
     * @var array
     */
    protected $transformers;

    /**
     * Adds a transformer to the parser
     *
     * @param Transformer $transformer
     */
    public function push(Transformer $transformer)
    {
        $this->transformers[] = $transformer;
    }

    /**
     * Runs the content through all of the transformers
     *
     * @param $content
     * @return mixed
     */
    public function transform($content)
    {
        return array_reduce($this->transformers, function ($content, $transformer) {
            return $transformer->transform($content);
        }, $content);
    }
}
