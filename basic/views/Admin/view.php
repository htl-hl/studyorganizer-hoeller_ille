<?php
/** @var yii\web\View $this */
/** @var app\models\User $model */

use yii\helpers\Html;

$this->title = Html::encode($model->Name);
$isCurrentUser = ((int)$model->U_ID === (int)Yii::$app->user->id);
$isModelAdmin  = $model->isAdmin();
?>

    <div class="page-header">
        <ul class="breadcrumb">
            <li><?= Html::a('Admin', ['/admin/index']) ?></li>
            <li><?= Html::a('Benutzer', ['index']) ?></li>
            <li><?= Html::encode($model->Name) ?></li>
        </ul>
        <h1><?= Html::encode($model->Name) ?></h1>
        <div class="page-actions">
            <?= Html::a('Bearbeiten', ['update', 'U_ID' => $model->U_ID], ['class' => 'btn btn-primary']) ?>
            <?php if (!$isCurrentUser): ?>
                <?= Html::a('Loeschen', ['delete', 'U_ID' => $model->U_ID], [
                        'class'        => 'btn btn-outline',
                        'style'        => 'color:var(--danger); border-color:var(--danger);',
                        'data-confirm' => 'Diesen User wirklich loeschen?',
                        'data-method'  => 'post',
                ]) ?>
            <?php endif; ?>
            <?= Html::a('&larr; Zurueck zur Liste', ['index'], ['class' => 'btn btn-outline']) ?>
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

    <div class="detail-view" style="max-width:600px;">
        <table>
            <tr>
                <th>ID</th>
                <td style="color:var(--text-muted);"><?= $model->U_ID ?></td>
            </tr>
            <tr>
                <th>Name</th>
                <td>
                    <strong><?= Html::encode($model->Name) ?></strong>
                    <?php if ($isCurrentUser): ?>
                        <span style="font-size:.75rem; color:var(--text-muted); margin-left:.5rem;">(du)</span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th>Passwort</th>
                <td style="color:var(--text-muted); font-style:italic; font-size:.85rem;">
                    gehasht gespeichert
                </td>
            </tr>
            <tr>
                <th>Rolle</th>
                <td>
                    <?php if ($isModelAdmin): ?>
                        <span class="badge" style="background:var(--accent-light); color:var(--accent);">Admin</span>
                    <?php else: ?>
                        <span class="badge" style="background:var(--surface-2); color:var(--text-muted);">Normaler User</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php
            $aufgabenCount = $model->getHausaufgabens()->count();
            ?>
            <?php if ($aufgabenCount > 0): ?>
                <tr>
                    <th>Aufgaben</th>
                    <td>
                <span class="stat-pill" style="display:inline-flex;">
                    <strong><?= $aufgabenCount ?></strong>&nbsp;Hausaufgabe(n) zugewiesen
                </span>
                    </td>
                </tr>
            <?php endif; ?>
        </table>
    </div>

<?php if (!$isCurrentUser): ?>
    <div style="margin-top:1.5rem;">
        <hr class="divider">
        <p style="font-size:.85rem; color:var(--text-muted); margin-bottom:.75rem;">Admin-Status aendern</p>
        <?php
        $toggleLabel   = $isModelAdmin ? 'Admin-Rechte entziehen' : 'Zum Admin ernennen';
        $toggleStyle   = $isModelAdmin ? 'color:var(--warn); border-color:var(--warn);' : 'color:var(--accent); border-color:var(--accent);';
        $toggleConfirm = $isModelAdmin ? 'Admin-Rechte wirklich entziehen?' : 'Diesen User zum Admin machen?';
        ?>
        <?= Html::a($toggleLabel, ['toggle-Admin', 'U_ID' => $model->U_ID], [
                'class'        => 'btn btn-outline',
                'style'        => $toggleStyle,
                'data-confirm' => $toggleConfirm,
                'data-method'  => 'post',
        ]) ?>
    </div>
<?php endif; ?>