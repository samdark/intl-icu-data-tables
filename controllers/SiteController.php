<?php

namespace app\controllers;

use app\models\NumberFormatterInfo;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex($locale = '')
    {
        if ($locale) {
            $locale = \Locale::canonicalize($locale);
        }

        return $this->render('index', [
            'locale' => $locale,
        ]);
    }

    public function actionMessageFormatting($locale = '')
    {
        if ($locale) {
            $locale = \Locale::canonicalize($locale);
        }

        return $this->render('message', [
            'locale' => $locale,
            'spelloutRules' => $this->getRules($locale, \NumberFormatter::SPELLOUT),
            'ordinalRules' => $this->getRules($locale, \NumberFormatter::ORDINAL),
            'durationRules' => $this->getRules($locale, \NumberFormatter::DURATION),
            'pluralCardinalRules' => $this->getPluralCardinalRules($locale),
            'pluralCardinalExample' => $this->getPluralCardinalExample($locale),
            'pluralOrdinalRules' => $this->getPluralOrdinalRules($locale),
            'pluralOrdinalExample' => $this->getPluralOrdinalExample($locale),
        ]);
    }

    public function actionNumberFormatting($locale = '')
    {
        if ($locale) {
            $locale = \Locale::canonicalize($locale);
        }

        return $this->render('number', [
            'locale' => $locale,
        ]);
    }

    public function actionCurrencyData($locale = '')
    {
        if ($locale) {
            $locale = \Locale::canonicalize($locale);
        }

        return $this->render('currency-data', [
            'locale' => $locale,
        ]);
    }

    public function actionLanguageData($locale = '')
    {
        if ($locale) {
            $locale = \Locale::canonicalize($locale);
        }

        return $this->render('language-data', [
            'locale' => $locale,
        ]);
    }

    public function actionRegionData($locale = '')
    {
        if ($locale) {
            $locale = \Locale::canonicalize($locale);
        }

        return $this->render('region-data', [
            'locale' => $locale,
        ]);
    }

    public function actionZoneData($locale = '')
    {
        if ($locale) {
            $locale = \Locale::canonicalize($locale);
        }

        return $this->render('zone-data', [
            'locale' => $locale,
        ]);
    }


    private function getRules($locale, $type)
    {
        $formatter = new \NumberFormatter($locale, $type);

        $rules = [];
        $rawRules = explode(';', trim($formatter->getTextAttribute(\NumberFormatter::PUBLIC_RULESETS), ';'));
        $default = $formatter->getTextAttribute(\NumberFormatter::DEFAULT_RULESET);

        foreach ($rawRules as $rule) {
            $rules[$rule] = ($rule === $default);
        }

        return $rules;
    }

    private function getLanguage($locale)
    {
        $parts = \Locale::parseLocale($locale);
        return $parts['language'];
    }

    private function getNumberThatSatisfiesCondition($condition)
    {
        $n = 0;
        while ($n < 10000) {
            if (eval('return ' . $condition . ';')) {
                return $n;
            }

            $n++;
        }
        return null;
    }

    private function getPluralCardinalRules($locale, $forPHP = false)
    {
        return $this->getPluralRules($locale, 'locales', $forPHP);
    }

    private function getPluralCardinalExample($locale)
    {
        $rules = $this->getPluralCardinalRules($locale, true);

        if ($rules === null) {
            return null;
        }

        $examples = [];

        $ruleStrings = [];
        foreach ($rules as $category => $rule) {
            $ruleStrings[] = "$category{# $category}";
            $examples[] = $this->getNumberThatSatisfiesCondition($rule);
        }

        return [
            '{n, plural, '. implode(' ', $ruleStrings) .' other{# other}}',
            $examples
        ];
    }

    private function getPluralOrdinalRules($locale, $forPHP = false)
    {
        return $this->getPluralRules($locale, 'locales_ordinals', $forPHP);
    }

    private function getPluralOrdinalExample($locale)
    {
        $rules = $this->getPluralOrdinalRules($locale, true);

        if ($rules === null) {
            return null;
        }

        $examples = [];

        $ruleStrings = [];
        foreach ($rules as $category => $rule) {
            $ruleStrings[] = $category . '{#-' . $category . '}';
            $examples[] = $this->getNumberThatSatisfiesCondition($rule);
        }

        return [
            '{n, selectordinal, '. implode(' ', $ruleStrings) .' other{#-other}}',
            $examples
        ];
    }

    private function normalizePluralRule($rules, $forPHP)
    {
        if ($forPHP) {
            $replace = [
                '~(?: |^)n(?: |$)~' => ' $n ',
                '~mod~' => '%',
                '~is not~' => '!=',
                '~is~' => '==',
                '~and~' => '&&',
                '~or~' => '||',
                '~(\|\| |&& |^)([^|&]+) not in (\d+)\.\.(\d+)~' => '\1!in_array(\2, range(\3, \4))',
                '~(\|\| |&& |^)([^|&]+) (?:with)?in (\d+)\.\.(\d+)~' => '\1in_array(\2, range(\3, \4))',
            ];

            $rules = preg_replace(array_keys($replace), array_values($replace), $rules);
        } else {
            $rules = strtr($rules, ['mod' => '%', 'not in' => '!=', 'is not' => '!=', 'is' => '=', 'within' => '=', 'in' => '=']);
        }
        return $rules;
    }

    private function getPluralRules($locale, $type, $forPHP = false)
    {
        $language = $this->getLanguage($locale);
        $bundle = new \ResourceBundle('plurals', null);
        $key = $bundle[$type][$language];
        $data = $this->resourceBundleToArray($bundle['rules'][$key]);

        if ($data) {
            foreach ($data as $category => $rules) {
                $data[$category] = $this->normalizePluralRule($rules, $forPHP);
            }
        }

        if ($data !== null) {
            $order = ['one', 'two', 'few', 'many'];
            foreach ($order as $k => $v) {
                if (!array_key_exists($v, $data)) {
                    unset($order[$k]);
                }
            }

            $data = array_replace(array_flip($order), $data);
        }

        return $data;
    }

    private function resourceBundleToArray($bundle, $depth = 0)
    {
        if ($bundle === null) {
            return null;
        } elseif (is_scalar($bundle)) {
            return $bundle;
        }

        $result = [];
        foreach ($bundle as $key => $value) {
            $result[$key] = $this->resourceBundleToArray($value);
        }
        return $result;
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSuggestLocale($term)
    {
        $result = [];
        $locales = \ResourceBundle::getLocales('');

        foreach ($locales as $locale) {
            if ($term !== '' && strncasecmp($term, $locale, min(strlen($term), strlen($locale))) === 0) {
                $result[] = $locale;
            }
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }
}
