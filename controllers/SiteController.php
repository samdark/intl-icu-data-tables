<?php

namespace app\controllers;

use app\models\NormalizedPluralRule;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
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

        if (!$this->localeExists($locale)) {
            throw new NotFoundHttpException("Locale $locale was not found.");
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
            try {
                if (@eval('return ' . $condition . ';')) {
                    return $n;
                }
            } catch (\ParseError $error) {
                // ignore
            }

            $n++;
        }
        return [];
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
            '{n, plural, ' . implode(' ', $ruleStrings) . ' other{# other}}',
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
            '{n, selectordinal, ' . implode(' ', $ruleStrings) . ' other{#-other}}',
            $examples
        ];
    }

    private function getPluralRules($locale, $type, $forPHP = false)
    {
        $language = $this->getLanguage($locale);
        $bundle = new \ResourceBundle('plurals', null);
        $key = $bundle[$type][$language];
        $data = $this->resourceBundleToArray($bundle['rules'][$key]);

        if ($data) {
            unset($data['other']);
            foreach ($data as $category => $rules) {
                $normalizedRule = new NormalizedPluralRule($rules);
                if ($forPHP) {
                    $data[$category] = $normalizedRule->getPhp();
                } else {
                    $data[$category] = $normalizedRule->getDisplayString();
                }
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
        }

        if (is_scalar($bundle)) {
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

    private function localeExists($term)
    {
        $locales = \ResourceBundle::getLocales('');

        foreach ($locales as $locale) {
            if (strcasecmp($term, $locale) === 0) {
                return true;
            }
        }

        return false;
    }
}
