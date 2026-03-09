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
        <h1>Benutzer <em style="font-style:italic; font-weight:300; color:var(--text-muted); font-size:1.4rem;">verwalten</em></h1>
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

    <div style="display:flex; gap:.75rem; margin-bottom:1.5rem; flex-wrap:wrap;">
        <div class="stat-pill">
            <strong><?= $totalUsers ?></strong>&nbsp;Benutzer gesamt
        </div>
        <div class="stat-pill">
            <strong><?= $adminCount ?></strong>&nbsp;Admin(s)
        </div>
        <div class="stat-pill">
            <strong><?= $normalCount ?></strong>&nbsp;normale User
        </div>
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
               class="form-control"
               style="flex:1; min-width:180px;">
        <select name="UserSearch[is_admin]" class="form-control" style="flex:0 0 auto; min-width:140px;">
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
                <th style="text-align:right;">Aktionen</th>
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
                    <td colspan="5" style="text-align:center; color:var(--text-muted); padding:2rem;">
                        Keine Benutzer gefunden.
                    </td>
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
                        <td style="color:var(--text-muted); font-size:.8rem;"><?= $offset + $i + 1 ?></td>
                        <td>
                            <strong><?= Html::encode($model->Name) ?></strong>
                            <?php if ($isCurrentUser): ?>
                                <span style="font-size:.72rem; color:var(--text-muted); margin-left:.4rem;">(du)</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($isModelAdmin): ?>
                                <span class="badge" style="background:var(--accent-light); color:var(--accent);">Admin</span>
                            <?php else: ?>
                                <span class="badge" style="background:var(--surface-2); color:var(--text-muted);">User</span>
                            <?php endif; ?>
                        </td>
                        <td style="color:var(--text-muted); font-size:.8rem;"><?= $model->U_ID ?></td>
                        <td>
                            <div class="action-btns" style="justify-content:flex-end;">
                                <?= Html::a('Ansehen', ['view', 'U_ID' => $model->U_ID], ['class' => 'btn btn-sm btn-outline']) ?>
                                <?= Html::a('Bearbeiten', ['update', 'U_ID' => $model->U_ID], ['class' => 'btn btn-sm btn-outline']) ?>
                                <?php if (!$isCurrentUser): ?>
                                    <?php
                                    $toggleLabel = $isModelAdmin ? 'Admin entziehen' : 'Zum Admin';
                                    $toggleStyle = $isModelAdmin ? 'color:var(--warn); border-color:var(--warn);' : 'color:var(--accent); border-color:var(--accent);';
                                    ?>
                                    <?= Html::a($toggleLabel, ['toggle-admin', 'U_ID' => $model->U_ID], [
                                            'class'        => 'btn btn-sm btn-outline',
                                            'style'        => $toggleStyle,
                                            'data-confirm' => $confirmToggle,
                                            'data-method'  => 'post',
                                    ]) ?>
                                    <?= Html::a('Loeschen', ['delete', 'U_ID' => $model->U_ID], [
                                            'class'        => 'btn btn-sm btn-outline',
                                            'style'        => 'color:var(--danger); border-color:var(--danger);',
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