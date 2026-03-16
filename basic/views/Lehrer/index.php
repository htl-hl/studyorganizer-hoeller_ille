<?php
/** @var yii\web\View $this */
/** @var app\models\LehrerSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

use app\models\Lehrer;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Lehrerverwaltung';

$allLehrer = Lehrer::find()->all();
$total     = count($allLehrer);
$aktiv     = count(array_filter($allLehrer, fn($l) => $l->Status === 'Aktiv'));
$inaktiv   = $total - $aktiv;
?>

    <div class="page-header">
        <ul class="breadcrumb">
            <li><?= Html::a('Admin', ['/admin/index']) ?></li>
            <li>Lehrer</li>
        </ul>
        <h1>Lehrer <em>verwalten</em></h1>
        <div class="page-actions">
            <?= Html::a('+ Neuen Lehrer anlegen', ['create'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?= Html::encode(Yii::$app->session->getFlash('success')) ?>
    </div>
<?php endif; ?>

    <div class="stats-row">
        <div class="stat-pill"><strong><?= $total ?></strong>&nbsp;Lehrer gesamt</div>
        <div class="stat-pill"><strong><?= $aktiv ?></strong>&nbsp;Aktiv</div>
        <div class="stat-pill"><strong><?= $inaktiv ?></strong>&nbsp;Inaktiv</div>
    </div>

<?php Pjax::begin(['id' => 'lehrer-pjax']); ?>

    <div class="filter-bar">
        <?php $form = \yii\widgets\ActiveForm::begin([
                'action'  => ['index'],
                'method'  => 'get',
                'options' => ['data-pjax' => 1],
        ]); ?>
        <input type="text"
               name="LehrerSearch[Nachname]"
               value="<?= Html::encode($searchModel->Nachname) ?>"
               placeholder="Nach Name suchen"
               class="form-control">
        <select name="LehrerSearch[Status]" class="form-control select-narrow">
            <option value="">Alle Status</option>
            <option value="Aktiv"   <?php if ($searchModel->Status === 'Aktiv')   { echo 'selected'; } ?>>Aktiv</option>
            <option value="Inaktiv" <?php if ($searchModel->Status === 'Inaktiv') { echo 'selected'; } ?>>Inaktiv</option>
        </select>
        <?= Html::submitButton('Suchen', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Zuruecksetzen', ['index'], ['class' => 'btn btn-outline']) ?>
        <?php \yii\widgets\ActiveForm::end(); ?>
    </div>

    <div class="table-wrapper">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Kuerzel</th>
                <th>Status</th>
                <th class="col-actions">Aktionen</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $models     = $dataProvider->getModels();
            $pagination = $dataProvider->getPagination();
            $offset     = $pagination ? $pagination->getOffset() : 0;
            ?>
            <?php if (empty($models)): ?>
                <tr>
                    <td colspan="5" class="table-empty">Keine Lehrer gefunden.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($models as $i => $model): ?>
                    <?php /** @var Lehrer $model */ ?>
                    <tr>
                        <td class="col-id"><?= $offset + $i + 1 ?></td>
                        <td><strong><?= Html::encode($model->Vorname) ?> <?= Html::encode($model->Nachname) ?></strong></td>
                        <td class="col-muted"><?= Html::encode($model->Kuerzel) ?></td>
                        <td>
                            <?php if ($model->Status === 'Aktiv'): ?>
                                <span class="badge badge-erledigt">Aktiv</span>
                            <?php else: ?>
                                <span class="badge badge-rot">Inaktiv</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="action-btns action-btns-right">
                                <?= Html::a('Bearbeiten', ['update', 'L_ID' => $model->L_ID], ['class' => 'btn btn-sm btn-outline']) ?>
                                <?= Html::a('Loeschen', ['delete', 'L_ID' => $model->L_ID], [
                                        'class'        => 'btn btn-sm btn-outline btn-outline-danger',
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

<?php if ($pagination !== false && $pagination !== null && $pagination->getPageCount() > 1): ?>
    <?php
    $currentPage = $pagination->getPage();
    $pageCount   = $pagination->getPageCount();
    ?>
    <ul class="pagination">
        <?php for ($p = 0; $p < $pageCount; $p++): ?>
            <?php $isActive = ($p === $currentPage); ?>
            <li class="<?= $isActive ? 'active' : '' ?>">
                <?php if ($isActive): ?>
                    <span><?= $p + 1 ?></span>
                <?php else: ?>
                    <?= Html::a($p + 1, ['index', 'page' => $p + 1]) ?>
                <?php endif; ?>
            </li>
        <?php endfor; ?>
    </ul>
<?php endif; ?>

<?php Pjax::end(); ?>