<?php
/** @var yii\web\View $this */
/** @var app\models\LehrerSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

use app\models\Lehrer;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Lehrerverwaltung';
?>

    <div class="page-header">
        <ul class="breadcrumb">
            <li><?= Html::a('Admin', ['index']) ?></li>
            <li>Lehrer</li>
        </ul>
        <h1>Lehrer <em style="font-style:italic; font-weight:300; color:var(--text-muted);">verwalten</em></h1>
    </div>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?= Html::encode(Yii::$app->session->getFlash('success')) ?>
    </div>
<?php endif; ?>
<?php if (Yii::$app->session->hasFlash('danger')): ?>
    <div class="alert alert-danger">
        <?= Html::encode(Yii::$app->session->getFlash('danger')) ?>
    </div>
<?php endif; ?>

<?php Pjax::begin(); ?>

    <div class="table-wrapper">
        <table class="table">
            <thead>
            <tr>
                <th colspan="6" style="background:var(--surface); padding:.85rem 1rem;">
                    <?= Html::a('+ Neuen Lehrer anlegen', ['lehrer-create'], ['class' => 'btn btn-primary']) ?>
                </th>
            </tr>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Kuerzel</th>
                <th>Faecher</th>
                <th>Status</th>
                <th style="text-align:right;">Aktionen</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $models = $dataProvider->getModels();
            ?>
            <?php if (empty($models)): ?>
                <tr>
                    <td colspan="6" style="text-align:center; color:var(--text-muted); padding:2rem;">
                        Keine Lehrer gefunden.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($models as $model): ?>
                    <?php
                    /** @var Lehrer $model */
                    $isAktiv = ($model->Status === 'Aktiv');

                    $fNames = $model->getFNames()->all();
                    $faecherList = '';
                    foreach ($fNames as $f) {
                        $faecherList .= Html::encode($f->F_Name) . ' ';
                    }
                    $faecherList = trim($faecherList);
                    if ($faecherList === '') {
                        $faecherList = '&mdash;';
                    }
                    ?>
                    <tr>
                        <td style="color:var(--text-muted); font-size:.8rem;"><?= $model->L_ID ?></td>
                        <td><strong><?= Html::encode($model->Vorname) ?> <?= Html::encode($model->Nachname) ?></strong></td>
                        <td style="color:var(--text-muted);"><?= Html::encode($model->Kuerzel) ?></td>
                        <td style="font-size:.85rem;"><?= $faecherList ?></td>
                        <td>
                            <?php if ($isAktiv): ?>
                                <span class="badge badge-erledigt">Aktiv</span>
                            <?php else: ?>
                                <span class="badge badge-rot">Inaktiv</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="action-btns" style="justify-content:flex-end;">
                                <?= Html::a('Bearbeiten', ['lehrer-update', 'L_ID' => $model->L_ID], ['class' => 'btn btn-sm btn-outline']) ?>
                                <?= Html::a('Loeschen', ['lehrer-delete', 'L_ID' => $model->L_ID], [
                                    'class'        => 'btn btn-sm btn-outline',
                                    'style'        => 'color:var(--danger); border-color:var(--danger);',
                                    'data-confirm' => 'Diesen Lehrer wirklich loeschen?',
                                    'data-method'  => 'post',
                                ]) ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

<?php Pjax::end(); ?>