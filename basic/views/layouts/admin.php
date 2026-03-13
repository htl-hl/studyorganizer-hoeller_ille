<?php
/** @var yii\web\View $this */
/** @var string $content */

use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);
$this->registerCssFile('@web/css/Hausaufgaben.css');
$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <title><?= Html::encode($this->title) ?> &mdash; Admin</title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>

    <nav class="navbar">
        <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>">
            Admin
        </a>
        <div class="navbar-greeting" style="margin-left:auto;">
            <?php if (!Yii::$app->user->isGuest): ?>
                Hallo, <strong><?= Html::encode(Yii::$app->user->identity->username) ?></strong>
                &nbsp;&middot;&nbsp;
                <?php
                echo Html::beginForm(['/site/logout'], 'post', ['style' => 'display:inline']);
                echo Html::submitButton('Abmelden', ['style' => 'background:none;border:none;cursor:pointer;color:var(--text-muted);font-family:inherit;font-size:.82rem;padding:0']);
                echo Html::endForm();
                ?>
            <?php endif ?>
        </div>
    </nav>

    <div class="page-wrapper">

        <aside class="sidebar">
            <div class="sidebar-section">
                <div class="sidebar-label">Verwaltung</div>
                <ul class="sidebar-nav">
                    <li>
                        <?php
                        $route = $this->context->route;
                        $faecherActive  = str_starts_with($route, 'Faecher') ? 'active' : '';
                        $lehrerActive   = str_starts_with($route, 'Lehrer')  ? 'active' : '';
                        $schuelerActive = str_starts_with($route, 'Admin')   ? 'active' : '';
                        ?>
                        <?= Html::a('Faecher verwalten', ['/faecher/index'], ['class' => $faecherActive]) ?>
                    </li>
                    <li>
                        <?= Html::a('Lehrer verwalten', ['/lehrer/index'], ['class' => $lehrerActive]) ?>
                    </li>
                    <li>
                        <?= Html::a('Schueler verwalten', ['/admin/index'], ['class' => $schuelerActive]) ?>
                    </li>
                </ul>
            </div>

        </aside>

        <main class="main-content">
            <?= $content ?>
        </main>

    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>