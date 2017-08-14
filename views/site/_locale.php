<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\AutoComplete;

/* @var $this yii\web\View */
/* @var $locale string */
/* @var $title string */

$this->title = '';
if ($locale) {
	$this->title = \Locale::getDisplayName($locale, Yii::$app->language) . ', '. Html::encode($locale) . ' - ';
}
if ($title) {
	$this->title .= Html::encode($title) . ' - ';
}
$this->title .= 'PHP intl extension, ICU data tables';
?>

<?= Html::beginForm([''], 'get', ['class' => 'form-horizontal']) ?>
<div class="input-group">
    <?= AutoComplete::widget([
        'name' => 'locale',
        'value' => $locale,
        'options' => ['class' => 'form-control', 'placeholder' => 'Enter locale code such as "en" or "en_US"', 'autofocus' => true],
        'clientOptions' => [
            'source' => Url::toRoute(['site/suggest-locale']),
        ],
    ]) ?>
    <span class="input-group-btn">
        <?= Html::submitButton('Find', ['class' => 'btn btn-primary']) ?>
    </span>
</div>
<?= Html::endForm() ?>

<?php if ($locale): ?>

<h1><?= Html::encode(Locale::getDisplayName($locale, Yii::$app->language)) ?> <small><?= Html::encode($locale) ?></small></h1>
<small>Based on PHP intl data: ICU <?= INTL_ICU_VERSION ?>. Data <?= INTL_ICU_DATA_VERSION ?>.</small>

<?= \yii\bootstrap\Tabs::widget([
    'items' => [
        ['label' => 'General', 'url' => ['site/index', 'locale' => $locale], 'active' => $this->context->action->id === 'index'],
        ['label' => 'Message Formatting', 'url' => ['site/message-formatting', 'locale' => $locale], 'active' => $this->context->action->id === 'message-formatting'],
        ['label' => 'Number Formatting', 'url' => ['site/number-formatting', 'locale' => $locale], 'active' => $this->context->action->id === 'number-formatting'],
        ['label' => 'ICU Currency Data', 'url' => ['site/currency-data', 'locale' => $locale], 'active' => $this->context->action->id === 'currency-data'],
        ['label' => 'ICU Language Data', 'url' => ['site/language-data', 'locale' => $locale], 'active' => $this->context->action->id === 'language-data'],
        ['label' => 'ICU Region Data', 'url' => ['site/region-data', 'locale' => $locale], 'active' => $this->context->action->id === 'region-data'],
        ['label' => 'ICU Zone Data', 'url' => ['site/zone-data', 'locale' => $locale], 'active' => $this->context->action->id === 'zone-data'],
        ['label' => 'ICU Unit Data', 'url' => ['site/unit-data', 'locale' => $locale], 'active' => $this->context->action->id === 'unit-data'],
    ]
]) ?>


<?php endif; ?>
