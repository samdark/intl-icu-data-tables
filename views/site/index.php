<?php
/* @var $this yii\web\View */
/* @var $query string */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\AutoComplete;

$this->title = '';
if ($locale) {
	$this->title = \Locale::getDisplayName($locale, Yii::$app->language) . ', '. Html::encode($locale) . ' - ';
}
$this->title .= 'PHP intl extension, ICU data tables';
?>

<?= Html::beginForm(['site/index'], 'get', ['class' => 'form-horizontal']) ?>
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

<h1><?= Html::encode(\Locale::getDisplayName($locale, Yii::$app->language)) ?> <small><?= Html::encode($locale) ?></small></h1>
<small>Based on PHP intl data: ICU <?= INTL_ICU_VERSION ?>. Data <?= INTL_ICU_DATA_VERSION ?>.</small>

<h2 id="plural-rules">Plural Rules <small><a href="#plural-rules">#</a></small></h2>

<h3 id="plural-rules-cardinal">Cardinal <small>plural <a href="#plural-rules-cardinal">#</a></small></h3>

<?php if ($pluralCardinalRules): ?>
    <table class="table table-hover">
        <tr>
            <th>Category</th>
            <th>Rules</th>
        </tr>
    <?php foreach ($pluralCardinalRules as $category => $rules): ?>
        <tr>
            <td><?= Html::encode($category) ?></td>
            <td><?= Html::encode($rules) ?></td>
        </tr>
    <?php endforeach ?>
        <tr>
            <td>other</td>
            <td>Everything else</td>
        </tr>
    </table>

    <pre><code><?= Html::encode($pluralCardinalExample[0])?></code></pre>

    <ul>
        <?php foreach ($pluralCardinalExample[1] as $n): ?>
            <li><?= Yii::$app->i18n->format($pluralCardinalExample[0], ['n' => $n], $locale) ?></li>
        <?php endforeach ?>
        <li><?= Yii::$app->i18n->format($pluralCardinalExample[0], ['n' => 0.12], $locale) ?></li>
    </ul>
<?php else: ?>
    Not supported.
<?php endif ?>

<h3 id="plural-rules-ordinal">Ordinal <small>selectordinal <a href="#plural-rules-ordinal">#</a></small></h3>

<?php if ($pluralOrdinalRules): ?>
    <table class="table table-hover">
        <tr>
            <th>Category</th>
            <th>Rules</th>
        </tr>
    <?php foreach ($pluralOrdinalRules as $category => $rules): ?>
        <tr>
            <td><?= Html::encode($category) ?></td>
            <td><?= Html::encode($rules) ?></td>
        </tr>
    <?php endforeach ?>
        <tr>
            <td>other</td>
            <td>Everything else</td>
        </tr>
    </table>

    <pre><code><?= Html::encode($pluralOrdinalExample[0])?></code></pre>

    <ul>
        <?php foreach ($pluralOrdinalExample[1] as $n): ?>
            <li><?= Yii::$app->i18n->format($pluralOrdinalExample[0], ['n' => $n], $locale) ?></li>
        <?php endforeach ?>
        <li><?= Yii::$app->i18n->format($pluralOrdinalExample[0], ['n' => 0.12], $locale) ?></li>
    </ul>
<?php else: ?>
    Not supported.
<?php endif ?>

<h2 id="numbering-schemas">Numbering schemas <small><a href="#numbering-schemas">#</a></small></h2>

<h3 id="numbering-schemas-spellout">Spellout <small><a href="#numbering-schemas-spellout">#</a></small></h3>

<table class="table table-hover">
    <tr>
        <th>Schema</th>
        <th>Example</th>
        <th>Result</th>
    </tr>
<?php foreach ($spelloutRules as $rule => $isDefault): ?>
    <tr>
        <td>
    <?php if ($isDefault): ?>
        <strong><?= Html::encode($rule) ?> (default)</strong>
    <?php else: ?>
        <?= Html::encode($rule) ?>
    <?php endif ?>
        </td>
        <td>
            <pre><code>{n, spellout,<?= Html::encode($rule) ?>}</code></pre>
        </td>
        <td>
            <?= Yii::$app->i18n->format('{n, spellout,' . $rule . '}', ['n' => 471], $locale) ?>
        </td>
    </tr>
<?php endforeach ?>
</table>

<h3 id="numbering-schemas-ordinal">Ordinal <small><a href="#numbering-schemas-ordinal">#</a></small></h3>

<table class="table table-hover">
    <tr>
        <th>Schema</th>
        <th>Example</th>
        <th>Result</th>
    </tr>
<?php foreach ($ordinalRules as $rule => $isDefault): ?>
    <tr>
        <td>
    <?php if ($isDefault): ?>
        <strong><?= Html::encode($rule) ?> (default)</strong>
    <?php else: ?>
        <?= Html::encode($rule) ?>
    <?php endif ?>
        </td>
            <td>
                <pre><code>{n, ordinal,<?= Html::encode($rule) ?>}</code></pre>
            </td>
            <td>
                <?= Yii::$app->i18n->format('{n, ordinal,' . $rule . '}', ['n' => 471], $locale) ?>
            </td>
        </tr>
<?php endforeach ?>
</table>

<h3 id="numbering-schemas-duration">Duration <small><a href="#numbering-schemas-duration">#</a></small></h3>

<table class="table table-hover">
    <tr>
        <th>Schema</th>
        <th>Example</th>
        <th>Result</th>
    </tr>
<?php foreach ($durationRules as $rule => $isDefault): ?>
    <tr>
        <td>
    <?php if ($isDefault): ?>
        <strong><?= Html::encode($rule) ?> (default)</strong>
    <?php else: ?>
        <?= Html::encode($rule) ?>
    <?php endif ?>
        </td>
        <td>
            <pre><code>{n, duration,<?= Html::encode($rule) ?>}</code></pre>
        </td>
        <td>
            <?= Yii::$app->i18n->format('{n, duration,' . $rule . '}', ['n' => 471227], $locale) ?>
        </td>
    </tr>
<?php endforeach ?>
</table>

<?php endif ?>