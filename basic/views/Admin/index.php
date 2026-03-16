<?php
/** @var yii\web\View $this */
/** @var app\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var int $totalUsers */
/** @var int $adminCount */
/** @var int $normalCount */

use app\models\User;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Benutzerverwaltung';
?>

    <div class="page-header">
        <ul class="breadcrumb">
            <li><?= Html::a('Admin', ['index']) ?></li>
            <li>Benutzer</li>
        </ul>
        <h1>Benutzer <em>verwalten</em></h1>
        <div class="page-actions">
            <?= Html::a('+ Neuer Benutzer', ['create'], ['class' => 'btn btn-primary']) ?>
        </div>
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

    <div class="stats-row">
        <div class="stat-pill"><strong><?= $totalUsers ?></strong>&nbsp;Benutzer gesamt</div>
        <div class="stat-pill"><strong><?= $adminCount ?></strong>&nbsp;Admin(s)</div>
        <div class="stat-pill"><strong><?= $normalCount ?></strong>&nbsp;normale User</div>
    </div>

<?php Pjax::begin(['id' => 'user-pjax']); ?>

    <div class="filter-bar">
        <?php $form = \yii\widgets\ActiveForm::begin([
                'action'  => ['index'],
                'method'  => 'get',
                'options' => ['data-pjax' => 1],
        ]); ?>
        <input type="text"
               name="UserSearch[Name]"
               value="<?= Html::encode($searchModel->Name) ?>"
               placeholder="Nach Name suchen"
               class="form-control">
        <select name="UserSearch[is_admin]" class="form-control select-narrow">
            <option value="">Alle Rollen</option>
            <option value="1" <?php if ($searchModel->is_admin === '1') { echo 'selected'; } ?>>Nur Admins</option>
            <option value="0" <?php if ($searchModel->is_admin === '0') { echo 'selected'; } ?>>Nur normale User</option>
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
                <th>Rolle</th>
                <th>ID</th>
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
                    <td colspan="5" class="table-empty">Keine Benutzer gefunden.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($models as $i => $model): ?>
                    <?php
                    /** @var User $model */
                    $isCurrentUser = ((int)$model->U_ID === (int)Yii::$app->user->id);
                    $isModelAdmin  = $model->isAdmin();
                    $confirmToggle = $isModelAdmin ? 'Admin-Rechte entziehen?' : 'Zum Admin ernennen?';
                    $confirmDelete = 'Diesen User wirklich loeschen?';
                    ?>
                    <tr>
                        <td class="col-id"><?= $offset + $i + 1 ?></td>
                        <td>
                            <strong><?= Html::encode($model->Name) ?></strong>
                            <?php if ($isCurrentUser): ?>
                                <span class="user-tag">(du)</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($isModelAdmin): ?>
                                <span class="badge badge-admin">Admin</span>
                            <?php else: ?>
                                <span class="badge badge-user">User</span>
                            <?php endif; ?>
                        </td>
                        <td class="col-id"><?= $model->U_ID ?></td>
                        <td>
                            <div class="action-btns action-btns-right">
                                <?= Html::a('Ansehen', ['view', 'U_ID' => $model->U_ID], ['class' => 'btn btn-sm btn-outline']) ?>
                                <?= Html::a('Bearbeiten', ['update', 'U_ID' => $model->U_ID], ['class' => 'btn btn-sm btn-outline']) ?>
                                <?php if (!$isCurrentUser): ?>
                                    <?= Html::a(
                                            $isModelAdmin ? 'Admin entziehen' : 'Zum Admin',
                                            ['toggle-admin', 'U_ID' => $model->U_ID],
                                            [
                                                    'class'        => 'btn btn-sm btn-outline ' . ($isModelAdmin ? 'btn-outline-warn' : 'btn-outline-accent'),
                                                    'data-confirm' => $confirmToggle,
                                                    'data-method'  => 'post',
                                            ]
                                    ) ?>
                                    <?= Html::a('Loeschen', ['delete', 'U_ID' => $model->U_ID], [
                                            'class'        => 'btn btn-sm btn-outline btn-outline-danger',
                                            'data-confirm' => $confirmDelete,
                                            'data-method'  => 'post',
                                    ]) ?>
                                <?php endif; ?>
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