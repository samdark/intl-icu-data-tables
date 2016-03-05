<?php
use app\models\ResourceInfo;
use yii\bootstrap\Html;

/* @var $this yii\web\View */

/* @var $locale string */
/* @var $query string */
/* @var $title string */

echo $this->render('_locale', ['locale' => $locale, 'title' => '']);

if ($locale):
?>

<h2 id="general-information">General Information <small><a href="#general-information">#</a></small></h2>

<table class="table table-hover">
    <tr>
        <th></th>
        <th>Code</th>
        <th>Name (<?= Html::encode(Yii::$app->language) ?>)</th>
        <th>Name (<?= Html::encode($locale) ?>)</th>
    </tr>
    <tr>
        <th>Language</th>
        <td><?= Locale::getPrimaryLanguage($locale) ?: '<em>none</em>' ?></td>
        <td><?= Locale::getDisplayLanguage($locale, Yii::$app->language) ?: '<em>none</em>' ?></td>
        <td><?= Locale::getDisplayLanguage($locale, $locale) ?: '<em>none</em>' ?></td>
    </tr>
    <tr>
        <th>Region</th>
        <td><?= Locale::getRegion($locale) ?: '<em>none</em>' ?></td>
        <td><?= Locale::getDisplayRegion($locale, Yii::$app->language) ?: '<em>none</em>' ?></td>
        <td><?= Locale::getDisplayRegion($locale, $locale) ?: '<em>none</em>' ?></td>
    </tr>
    <tr>
        <th>Script</th>
        <td><?= Locale::getScript($locale) ?: '<em>none</em>' ?></td>
        <td><?= Locale::getDisplayScript($locale, Yii::$app->language) ?: '<em>none</em>' ?></td>
        <td><?= Locale::getDisplayScript($locale, $locale) ?: '<em>none</em>' ?></td>
    </tr>
    <tr>
        <th>Default Currency</th>
        <?php $defaultCurrency = \app\models\NumberFormatterInfo::getDefaultCurrency($locale); ?>
        <td><?= $defaultCurrency ? $defaultCurrency . ' (' . \app\models\NumberFormatterInfo::getDefaultCurrencySymbol($locale) . ')' : '<em>none</em>' ?></td>
        <td><?= $defaultCurrency ? ResourceInfo::getCurrencyName($defaultCurrency, Yii::$app->language) : '<em>none</em>' ?></td>
        <td><?= $defaultCurrency ? ResourceInfo::getCurrencyName($defaultCurrency, $locale) : '<em>none</em>' ?></td>
    </tr>
</table>


<h2 id="icu-data-default">ICU Data <small><a href="#icu-data-default">#</a></small></h2>

<?= $this->render('_icuData', ['icuData' => ResourceInfo::defaultData($locale)]) ?>

<?php endif; ?>