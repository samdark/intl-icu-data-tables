<?php
namespace app\models;

use NumberFormatter;
use yii\base\Object;

/**
 * NumberFormatterInfo provides info for Number Formatting tab
 *
 * @author Carsten Brandt <mail@cebe.cc>
 */
class NumberFormatterInfo extends Object
{
    /**
     * @var array
     * @see http://php.net/manual/en/class.numberformatter.php#intl.numberformatter-constants
     */
    public static $types = [
//        NumberFormatter::PATTERN_DECIMAL => ['PATTERN_DECIMAL', 'Decimal format defined by pattern.'],
//        NumberFormatter::PATTERN_RULEBASED => ['PATTERN_RULEBASED', 'Rule-based format defined by pattern.'],
        NumberFormatter::DECIMAL => ['DECIMAL', 'Decimal format.'],
        NumberFormatter::CURRENCY => ['CURRENCY', 'Currency format.'],
        NumberFormatter::PERCENT => ['PERCENT', 'Percent format.'],
        NumberFormatter::SCIENTIFIC => ['SCIENTIFIC', 'Scientific format.'],
        NumberFormatter::SPELLOUT => ['SPELLOUT', 'Spellout rule-based format.'],
        NumberFormatter::ORDINAL => ['ORDINAL', 'Ordinal rule-based format.'],
        NumberFormatter::DURATION => ['DURATION', 'Duration rule-based format.'],
        NumberFormatter::DEFAULT_STYLE => ['DEFAULT_STYLE', 'Default format for the locale.'],
//        NumberFormatter::IGNORE => ['IGNORE', 'Alias for PATTERN_DECIMAL.'],
    ];

    public static $formats = [
        NumberFormatter::TYPE_DEFAULT => ['TYPE_DEFAULT', 'Derive the type from variable type.'],
        NumberFormatter::TYPE_INT32 => ['TYPE_INT32', 'Format/parse as 32-bit integer.'],
        NumberFormatter::TYPE_INT64 => ['TYPE_INT64', 'Format/parse as 64-bit integer.'],
        NumberFormatter::TYPE_DOUBLE => ['TYPE_INT64', 'Format/parse as floating point value.'],
        NumberFormatter::TYPE_CURRENCY => ['TYPE_CURRENCY', 'Format/parse as currency value.'],
    ];

    public static $attributes = [
        NumberFormatter::PARSE_INT_ONLY => ['PARSE_INT_ONLY', 'Parse integers only.'],
        NumberFormatter::GROUPING_USED => ['GROUPING_USED', 'Use grouping separator.'],
        NumberFormatter::DECIMAL_ALWAYS_SHOWN => ['DECIMAL_ALWAYS_SHOWN', 'Always show decimal point.'],
        NumberFormatter::MAX_INTEGER_DIGITS => ['MAX_INTEGER_DIGITS', 'Maximum integer digits.'],
        NumberFormatter::MIN_INTEGER_DIGITS => ['MIN_INTEGER_DIGITS', 'Minimum integer digits.'],
        NumberFormatter::INTEGER_DIGITS => ['INTEGER_DIGITS', 'Integer digits.'],
        NumberFormatter::MAX_FRACTION_DIGITS => ['MAX_FRACTION_DIGITS', 'Maximum fraction digits.'],
        NumberFormatter::MIN_FRACTION_DIGITS => ['MIN_FRACTION_DIGITS', 'Minimum fraction digits.'],
        NumberFormatter::FRACTION_DIGITS => ['FRACTION_DIGITS', 'Fraction digits.'],
        NumberFormatter::MULTIPLIER => ['MULTIPLIER', 'Multiplier.'],
        NumberFormatter::GROUPING_SIZE => ['GROUPING_SIZE', 'Grouping size.'],
        NumberFormatter::ROUNDING_MODE => ['ROUNDING_MODE', 'Rounding Mode.'],
        NumberFormatter::ROUNDING_INCREMENT => ['ROUNDING_INCREMENT', 'Rounding increment.'],
        NumberFormatter::FORMAT_WIDTH => ['FORMAT_WIDTH', 'The width to which the output of format() is padded.'],
        NumberFormatter::PADDING_POSITION => ['PADDING_POSITION', 'The position at which padding will take place.'],
        NumberFormatter::SECONDARY_GROUPING_SIZE => ['SECONDARY_GROUPING_SIZE', 'Secondary grouping size.'],
        NumberFormatter::SIGNIFICANT_DIGITS_USED => ['SIGNIFICANT_DIGITS_USED', 'Use significant digits.'],
        NumberFormatter::MIN_SIGNIFICANT_DIGITS => ['MIN_SIGNIFICANT_DIGITS', 'Minimum significant digits.'],
        NumberFormatter::MAX_SIGNIFICANT_DIGITS => ['MAX_SIGNIFICANT_DIGITS', 'Maximum significant digits.'],
        NumberFormatter::LENIENT_PARSE => ['LENIENT_PARSE', 'Lenient parse mode used by rule-based formats.'],
    ];

    public static $textAttributes = [
        NumberFormatter::POSITIVE_PREFIX => ['POSITIVE_PREFIX', 'Positive suffix.'],
        NumberFormatter::NEGATIVE_PREFIX => ['NEGATIVE_PREFIX', 'Negative prefix.'],
        NumberFormatter::NEGATIVE_SUFFIX => ['NEGATIVE_SUFFIX', 'Negative suffix.'],
        NumberFormatter::PADDING_CHARACTER => ['PADDING_CHARACTER', 'The character used to pad to the format width.'],
        NumberFormatter::CURRENCY_CODE => ['CURRENCY_CODE', 'The ISO currency code.'],
        NumberFormatter::DEFAULT_RULESET => [
            'DEFAULT_RULESET',
            'The default rule set. This is only available with rule-based formatters.'
        ],
        NumberFormatter::PUBLIC_RULESETS => [
            'PUBLIC_RULESETS',
            'The public rule sets.This is only available with rule-based formatters. This is a read-only attribute. The public rulesets are returned as a single string, with each ruleset name delimited by \';\' (semicolon).'
        ],
    ];

    public static $symbols = [
        NumberFormatter::DECIMAL_SEPARATOR_SYMBOL => ['DECIMAL_SEPARATOR_SYMBOL', 'The decimal separator.'],
        NumberFormatter::GROUPING_SEPARATOR_SYMBOL => ['GROUPING_SEPARATOR_SYMBOL', 'The grouping separator.'],
        NumberFormatter::PATTERN_SEPARATOR_SYMBOL => ['PATTERN_SEPARATOR_SYMBOL', 'The pattern separator.'],
        NumberFormatter::PERCENT_SYMBOL => ['PERCENT_SYMBOL', 'The percent sign.'],
        NumberFormatter::ZERO_DIGIT_SYMBOL => ['ZERO_DIGIT_SYMBOL', 'Zero.'],
        NumberFormatter::DIGIT_SYMBOL => ['DIGIT_SYMBOL', 'Character representing a digit in the pattern.'],
        NumberFormatter::MINUS_SIGN_SYMBOL => ['MINUS_SIGN_SYMBOL', 'The minus sign.'],
        NumberFormatter::PLUS_SIGN_SYMBOL => ['PLUS_SIGN_SYMBOL', 'The plus sign.'],
        NumberFormatter::CURRENCY_SYMBOL => ['CURRENCY_SYMBOL', 'The currency symbol.'],
        NumberFormatter::INTL_CURRENCY_SYMBOL => ['INTL_CURRENCY_SYMBOL', 'The international currency symbol.'],
        NumberFormatter::MONETARY_SEPARATOR_SYMBOL => ['MONETARY_SEPARATOR_SYMBOL', 'The monetary separator.'],
        NumberFormatter::EXPONENTIAL_SYMBOL => ['EXPONENTIAL_SYMBOL', 'The exponential symbol.'],
        NumberFormatter::PERMILL_SYMBOL => ['PERMILL_SYMBOL', 'Per mill symbol.'],
        NumberFormatter::PAD_ESCAPE_SYMBOL => ['PAD_ESCAPE_SYMBOL', 'Escape padding character.'],
        NumberFormatter::INFINITY_SYMBOL => ['INFINITY_SYMBOL', 'Infinity symbol.'],
        NumberFormatter::NAN_SYMBOL => ['NAN_SYMBOL', 'Not-a-number symbol.'],
        NumberFormatter::SIGNIFICANT_DIGIT_SYMBOL => ['SIGNIFICANT_DIGIT_SYMBOL', 'Significant digit symbol.'],
        NumberFormatter::MONETARY_GROUPING_SEPARATOR_SYMBOL => [
            'MONETARY_GROUPING_SEPARATOR_SYMBOL',
            'The monetary grouping separator. '
        ],
    ];

    public static function getSymbolTable($locale)
    {
        $result = [];
        foreach (static::$types as $type => $typeDetails) {
            $nf = new NumberFormatter($locale, $type);
            foreach (static::$symbols as $symbol => $symbolDetails) {
                $result[$symbol][$type] = $nf->getSymbol($symbol);
            }
        }
        return $result;
    }

    public static function getPatternTable($locale)
    {
        $result = [];
        foreach (static::$types as $type => $typeDetails) {
            $nf = new NumberFormatter($locale, $type);
            $result[$type] = $nf->getPattern();
        }
        return $result;
    }

    public static function getDefaultCurrency($locale)
    {
        $nf = new NumberFormatter($locale, NumberFormatter::CURRENCY);
        return $nf->getSymbol(NumberFormatter::INTL_CURRENCY_SYMBOL);
    }

    public static function getDefaultCurrencySymbol($locale)
    {
        $nf = new NumberFormatter($locale, NumberFormatter::CURRENCY);
        return $nf->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
    }
}
