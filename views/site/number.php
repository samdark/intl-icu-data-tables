<?php
use app\models\NumberFormatterInfo;
use yii\bootstrap\Html;

/* @var $this yii\web\View */

/* @var $locale string */
/* @var $query string */
/* @var $title string */

echo $this->render('_locale', ['locale' => $locale, 'title' => '']);

if ($locale):
?>

<h2 id="numberformatter-symbols">NumberFormatter Symbols <small><a href="#numberformatter-symbols">#</a></small></h2>

<table class="table table-hover">
    <tr>
        <th>&nbsp;</th>
    <?php foreach(NumberFormatterInfo::$types as $type => $typeDetails): ?>
        <th><?= $typeDetails[0] ?><br /><small><?= $typeDetails[1] ?></small></th>
    <?php endforeach; ?>
    </tr>
    <?php foreach(NumberFormatterInfo::getSymbolTable($locale) as $symbolId => $symbols): ?>
        <tr>
        <th><?= NumberFormatterInfo::$symbols[$symbolId][0] ?><br /><small><?= NumberFormatterInfo::$symbols[$symbolId][1] ?></small></th>
        <?php foreach($symbols as $type => $symbol): ?>
            <td><code><?= $symbol ?></code></td>
        <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
</table>

<h2 id="numberformatter-patterns">NumberFormatter Patterns <small><a href="#numberformatter-patterns">#</a></small></h2>

<table class="table table-hover">
    <tr>
        <th>Formatter Type</th>
        <th>Pattern</th>
    </tr>
    <?php foreach(NumberFormatterInfo::getPatternTable($locale) as $type => $pattern): ?>
        <tr>
        <th><?= NumberFormatterInfo::$types[$type][0] ?><br /><small><?= NumberFormatterInfo::$types[$type][1] ?></small></th>
        <td><code><?= $pattern ?></code></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php endif; ?>