<?php


namespace app\models;


class NormalizedPluralRule
{
    private $_rule;

    /**
     * NormalizedPluralRule constructor.
     * @param $rule
     */
    public function __construct($rule)
    {
        $rule = $this->removeSamples($rule);
        $rule = $this->removeVisibleFractionDigitsRule($rule);
        $this->_rule = $rule;
    }

    public function getDisplayString()
    {
        $rule = strtr($this->_rule, ['mod' => '%', 'not in' => '!=', 'is not' => '!=', 'is' => '=', 'within' => '=', 'in' => '=']);
        return trim($rule);
    }

    public function getPhp()
    {
        $rule = $this->_rule;
        $rule = $this->replaceAndOrWithPHP($rule);
        $rule = $this->replaceRangesWithPHP($rule);

        $replace = [
            '~ = ~' => ' == ',
            '~( |^|\()(?:n|i)( |$|\))~' => '\1 $n \2',
            '~mod~' => '%',
            '~is not~' => '!=',
            '~is~' => '==',
        ];

        $rule = preg_replace(array_keys($replace), array_values($replace), $rule);
        return trim($rule);
    }

    private function replaceRangesWithPHP($rules)
    {
        return preg_replace_callback('~([^&|!]+)\s*(!?=|in|not in|within)\s*(\d+)\.\.(\d+)~', function($matches) {
            list(, $value, $operator, $rangeStart, $rangeEnd) = $matches;

            $out = ' ';

            if (in_array($operator, ['!=', 'not in'], true)) {
                $out .= '!';
            }

            $out .= "in_array({$value}, range({$rangeStart}, {$rangeEnd}))";
            return $out;
        }, $rules);
    }

    private function replaceAndOrWithPHP($rules)
    {
        return strtr($rules, ['and' => '&&', 'or' => '||']);
    }

    private function removeSamples($rules)
    {
        return preg_replace('~\s*@(integer|decimal).*~', '', $rules);
    }

    private function removeVisibleFractionDigitsRule($rules)
    {
        $replace = [
            '~v = 0 and ~' => '',
            '~ and v = 0~' => '',
            '~ or v = 0~' => '',
            '~v = 0 or ~' => '',
            '~v = 0~' => '',
        ];

        return preg_replace(array_keys($replace), array_values($replace), $rules);
    }
}
