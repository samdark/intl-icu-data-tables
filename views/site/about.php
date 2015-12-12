<h1>About the project</h1>

<p>The project was created by <a href="http://github.com/samdark">Alexander Makarov</a> to simplify checking out
    various PHP intl / ICU / CLDR data which is mainly used in translation strings without the need to check different
    websites and search huge data tables for locale you need.</p>

<p>Instead you can enter locale code and get all the info for just that locale right away.</p>

<h2>What's currently displayed:</h2>

<ul>
    <li>Plural rules. Also <a href="http://www.unicode.org/cldr/charts/27/supplemental/language_plural_rules.html">available via CLDR website</a>.</li>
    <li>Numbering schemas. Not available anywhere but ICU resource sources which aren't too user friendly to read.</li>
</ul>

<h2>Are examples broken?</h2>

<p>There are <a href="https://bugs.php.net/bug.php?id=70484">known issues</a> with PHP intl extension regarding usage of named
parameters such as <code>{n}</code>. Severity of issues depends on PHP and intl versions used. The primary goal of the project
is to serve as info source for using with <a href="http://www.yiiframework.com/">Yii 2.0 framework</a> which provides
wrapper around intl allowing usage of named parameters in all possible cases.</p>

<p>If you're not using Yii, try positional placeholders such as <code>{0}</code> instead.</p>

<h2>Contact info</h2>

<p>You can contact me via email: <a href="mailto:sam@rmcreative.ru">sam@rmcreative.ru</a></p>