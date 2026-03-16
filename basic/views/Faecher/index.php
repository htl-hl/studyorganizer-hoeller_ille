<?php
/** @var yii\web\View $this */
/** @var app\models\FaecherSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

use app\models\Faecher;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Fächerverwaltung';

$total = Faecher::find()->count();
?>

    <div class="page-header">
        <ul class="breadcrumb">
            <li><?= Html::a('Admin', ['/admin/index']) ?></li>
            <li>Fächer</li>
        </ul>
        <h1>Fächer <em>verwalten</em></h1>
        <div class="page-actions">
            <?= Html::a('+ Neues Fach anlegen', ['create'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?= Html::encode(Yii::$app->session->getFlash('success')) ?>
    </div>
<?php endif; ?>

    <div class="stats-row">
        <div class="stat-pill"><strong><?= $total ?></strong>&nbsp;Fächer gesamt</div>
    </div>

<?php Pjax::begin(['id' => 'faecher-pjax']); ?>

    <div class="filter-bar">
        <?php $form = \yii\widgets\ActiveForm::begin([
                'action'  => ['index'],
                'method'  => 'get',
                'options' => ['data-pjax' => 1],
        ]); ?>
        <input type="text"
               name="FaecherSearch[F_Name]"
               value="<?= Html::encode($searchModel->F_Name) ?>"
               placeholder="Nach Fachname suchen"
               class="form-control">
        <?= Html::submitButton('Suchen', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Zuruecksetzen', ['index'], ['class' => 'btn btn-outline']) ?>
        <?php \yii\widgets\ActiveForm::end(); ?>
    </div>

    <div class="table-wrapper">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Fachname</th>
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
                    <td colspan="3" class="table-empty">Keine Fächer gefunden.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($models as $i => $model): ?>
                    <?php /** @var Faecher $model */ ?>
                    <tr>
                        <td class="col-id"><?= $offset + $i + 1 ?></td>
                        <td><strong><?= Html::encode($model->F_Name) ?></strong></td>
                        <td>
                            <div class="action-btns action-btns-right">
                                <?= Html::a('Bearbeiten', ['update', 'F_Name' => $model->F_Name], ['class' => 'btn btn-sm btn-outline']) ?>
                                <?= Html::a('Loeschen', ['delete', 'F_Name' => $model->F_Name], [
                                        'class'        => 'btn btn-sm btn-outline btn-outline-danger',
                                        'data-confirm' => 'Dieses Fach wirklich löschen?',
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