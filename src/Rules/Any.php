<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;
use GetSky\ParserExpressions\RuleInterface;

/**
 * It rule consumes any character in the string.
 *
 * @package GetSky\ParserExpressions\Rules
 * @author  Alexander Getmanskii <alexander.get87@gmail.com>
 */
class Any implements RuleInterface
{

    protected $name = 'ANY';

    /**
     * {@inheritdoc}
     */
    public function scan(Context $context)
    {
        $index = $context->getCursor();
        $value = $context->value();

        if ($value === false) {
            $context->error($this, $index);
            return false;
        }

        $result = new Result($this->name);
        $result->setValue($value, $index);

        return $result;
    }
}
