<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\helpers\Html;

AppAsset::register($this);

$this->registerCssFile('@web/css/Hausaufgaben.css');
$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <title><?= Html::encode($this->title) ?> — HausaufgabenManager</title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>

    <nav class="navbar">
        <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>">
            Hausaufgaben<em>Manager</em>
        </a>

        <ul class="navbar-nav">
            <li><?= Html::a('Dashboard', ['/site/index'], ['class' => $this->context->route === 'site/index' ? 'active' : '']) ?></li>
            <li><?= Html::a('Hausaufgaben', ['/hausaufgaben/index'], ['class' => str_starts_with($this->context->route, 'Hausaufgaben') ? 'active' : '']) ?></li>
            <?php if (Yii::$app->user->isGuest || !Yii::$app->user->identity->isAdmin()): ?>
                <li><?= Html::a('Faecher', ['/faecher/index'], ['class' => str_starts_with($this->context->route, 'Faecher') ? 'active' : '']) ?></li>
                <li><?= Html::a('Lehrer', ['/lehrer/index'], ['class' => str_starts_with($this->context->route, 'Lehrer') ? 'active' : '']) ?></li>
                <li><?= Html::a('Users', ['/user/index'], ['class' => str_starts_with($this->context->route, 'User') ? 'active' : '']) ?></li>
            <?php endif; ?>
            <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()): ?>
                <li><?= Html::a('Admin', ['/admin/index'], ['class' => str_starts_with($this->context->route, 'Admin') ? 'active' : '']) ?></li>
            <?php endif; ?>
        </ul>

        <div class="navbar-greeting">
            <?php if (Yii::$app->user->isGuest): ?>
                <?= Html::a('Login', ['/site/login']) ?>
            <?php else: ?>
                Hallo, <strong><?= Html::encode(Yii::$app->user->identity->username) ?></strong>
                &nbsp;·&nbsp;
                <?php
                echo Html::beginForm(['/site/logout'], 'post', ['style' => 'display:inline']);
                echo Html::submitButton('Abmelden', ['style' => 'background:none;border:none;cursor:pointer;color:var(--text-muted);font-family:inherit;font-size:.82rem;padding:0']);
                echo Html::endForm();
                ?>
            <?php endif ?>
        </div>
    </nav>

    <div style="padding: 2rem 2.5rem; max-width: 1060px;">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <ul class="breadcrumb">
                <?php foreach ($this->params['breadcrumbs'] as $i => $crumb): ?>
                    <?php if (is_array($crumb)): ?>
                        <li><?= Html::a(Html::encode($crumb['label']), $crumb['url']) ?></li>
                    <?php else: ?>
                        <li><?= Html::encode($crumb) ?></li>
                    <?php endif ?>
                <?php endforeach ?>
            </ul>
        <?php endif ?>

        <?= Alert::widget() ?>
        <?= $content ?>
    </div>

    <footer style="border-top:1px solid var(--border);padding:1.25rem 2.5rem;margin-top:3rem;font-size:.78rem;color:var(--text-muted);display:flex;justify-content:space-between;">
        <span>&copy; <?= date('Y') ?> HausaufgabenManager</span>
        <span><?= Yii::powered() ?></span>
    </footer>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>