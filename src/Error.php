<?php
/**
 * @author  Alexander Getmansky <getmansk_y@yandex.ru>
 * @package GetSky\ParserExpressions
 */
namespace GetSky\ParserExpressions;

/**
 * It is a error result for parsing string.
 */
class Error implements ErrorInterface
{

    protected $rule;

    protected $index;

    protected $text;

    protected $changed = false;

    /**
     * {@inheritdoc}
     */
    public function update(RuleInterface $rule, $index, $text)
    {
        $this->changed = true;
        $this->index = $index;
        $this->rule = $rule;
        $this->text = $text;
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->index = null;
        $this->rule = null;
        $this->text = null;
    }

    /**
     * {@inheritdoc}
     */
    public function isChanged()
    {
        return $this->changed;
    }

    /**
     * Displays a text description of the error
     *
     * @return string
     */
    public function __toString()
    {
        return "Error on {$this->index} symbol near '{$this->text}'.";
    }
}