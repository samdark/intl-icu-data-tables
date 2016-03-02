<?php
/* @var $this yii\web\View */
use yii\bootstrap\Html;

/* @var $locale string */
/* @var $query string */
/* @var $title string */

/* @var $spelloutRules array */
/* @var $ordinalRules array */
/* @var $durationRules array */
/* @var $pluralCardinalRules array */
/* @var $pluralCardinalExample array */
/* @var $pluralOrdinalRules array */
/* @var $pluralOrdinalExample array */

echo $this->render('_locale', ['locale' => $locale, 'title' => '']);

if ($locale):
?>

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