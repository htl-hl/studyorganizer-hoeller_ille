<?php

/** @var yii\web\View $this */
/** @var app\models\Hausaufgaben[] $openTasks */
/** @var app\models\Hausaufgaben[] $doneTasks */

use yii\helpers\Html;

$this->title = 'Dashboard';

// hilft mit den farben und badges von den verschiedenen tasks
function statusInfo($status) {
    switch (strtolower(trim($status ?? ''))) {
        case 'erledigt': return ['class' => 'badge-erledigt', 'label' => '✓ Erledigt'];
        case 'rot':      return ['class' => 'badge-rot',      'label' => 'Überfällig'];
        case 'blau':     return ['class' => 'badge badge-blau', 'label' => 'Neu'];
        case 'gelb':     return ['class' => 'badge-offen',    'label' => 'Offen'];
        default:         return ['class' => 'badge-offen',    'label' => 'Offen'];
    }
}

// stellt die farbe um je nach offene oder fertige task
function statusAttr($status) {
    switch (strtolower(trim($status ?? ''))) {
        case 'erledigt': return 'erledigt';
        case 'rot':      return 'rot';
        default:         return 'offen';
    }
}

// das ist für den filter
$allSubjects = array_unique(array_filter(array_map(
        fn($a) => $a->F_Name,
        array_merge($openTasks, $doneTasks)
)));
?>

<div class="dash-hero">
    <h1 class="dash-greeting">
        Hallo, <em><?= Html::encode(Yii::$app->user->identity->Name ?? 'Gast') ?>.</em>
    </h1>
    <div class="stat-pills">
        <div class="pill"><strong><?= count($openTasks) ?></strong> offen</div>
        <div class="pill"><strong><?= count($doneTasks) ?></strong> erledigt</div>
        <?php
        // Nächste Abgabe anzeigen
        if (!empty($openTasks) && $openTasks[0]->Faelligkeitsdatum) {
            $datum = date('d. M', strtotime($openTasks[0]->Faelligkeitsdatum));
            echo '<div class="pill"><strong>' . $datum . '</strong> nächste Abgabe</div>';
        }
        ?>
    </div>
</div>

<!-- Searchbar und Navbar oder so -->
<div class="filter-bar">
    <input
            type="text"
            id="dash-search"
            placeholder="Nach Titel suchen…"
            oninput="dashFilter()"
            style="flex:1;min-width:180px"
    >
    <select id="dash-fach" onchange="dashFilter()">
        <option value="">Fach: Alle</option>
        <?php foreach ($allSubjects as $subject): ?>
            <option value="<?= Html::encode($subject) ?>"><?= Html::encode($subject) ?></option>
        <?php endforeach ?>
    </select>
    <?= Html::a('+ Neue Aufgabe', ['/hausaufgaben/create'], ['class' => 'btn btn-primary btn-sm']) ?>
</div>

<!-- noch offene aufgaben -->
<div class="section-header">
    <h2 class="section-title">Offene Aufgaben <small><?= count($openTasks) ?></small></h2>
</div>

<div id="offene-liste">
    <?php if (empty($openTasks)): ?>
        <div style="color:var(--text-muted);font-size:.9rem;padding:.75rem 0">
            Keine offenen Aufgaben — gut gemacht! 🎉
        </div>
    <?php else: ?>
        <?php foreach ($openTasks as $task): ?>
            <?php $info = statusInfo($task->Status); ?>
            <div class="task-card"
                 data-status="<?= statusAttr($task->Status) ?>"
                 data-title="<?= Html::encode(strtolower($task->Titel)) ?>"
                 data-fach="<?= Html::encode($task->F_Name) ?>">

                <span class="task-fach"><?= Html::encode($task->F_Name ?? '—') ?></span>

                <div class="task-body">
                    <div class="task-title"><?= Html::encode($task->Titel) ?></div>
                    <?php if ($task->Beschreibung): ?>
                        <div class="task-desc"><?= Html::encode($task->Beschreibung) ?></div>
                    <?php endif ?>
                    <div class="task-meta">
                        <?php if ($task->lehrer): ?>
                            <span>von <?= Html::encode($task->lehrer->Nachname) ?></span>
                            <span>·</span>
                        <?php endif ?>
                        <?php if ($task->Faelligkeitsdatum): ?>
                            <span>Fällig: <?= date('d.m.Y', strtotime($task->Faelligkeitsdatum)) ?></span>
                        <?php endif ?>
                    </div>
                </div>

                <div class="task-right">
                    <?php if ($task->Faelligkeitsdatum): ?>
                        <span class="task-date"><?= date('d. M', strtotime($task->Faelligkeitsdatum)) ?></span>
                    <?php endif ?>
                    <span class="badge <?= $info['class'] ?>"><?= $info['label'] ?></span>
                    <?= Html::a('Bearbeiten', ['/hausaufgaben/update', 'HU_ID' => $task->HU_ID], ['class' => 'btn btn-secondary btn-sm']) ?>
                </div>
            </div>
        <?php endforeach ?>
    <?php endif ?>
</div>

<hr class="divider">

<!-- done tasks -->
<div class="section-header">
    <h2 class="section-title">Erledigt <small><?= count($doneTasks) ?></small></h2>
</div>

<div id="erledigte-liste">
    <?php if (empty($doneTasks)): ?>
        <div style="color:var(--text-muted);font-size:.9rem;padding:.75rem 0">
            Noch keine erledigten Aufgaben.
        </div>
    <?php else: ?>
        <?php foreach ($doneTasks as $task): ?>
            <div class="task-card"
                 data-status="erledigt"
                 data-title="<?= Html::encode(strtolower($task->Titel)) ?>"
                 data-fach="<?= Html::encode($task->F_Name) ?>"
                 style="opacity:.6">

                <span class="task-fach"><?= Html::encode($task->F_Name ?? '—') ?></span>

                <div class="task-body">
                    <div class="task-title"><?= Html::encode($task->Titel) ?></div>
                    <?php if ($task->Beschreibung): ?>
                        <div class="task-desc"><?= Html::encode($task->Beschreibung) ?></div>
                    <?php endif ?>
                    <div class="task-meta">
                        <?php if ($task->Faelligkeitsdatum): ?>
                            <span>Fällig: <?= date('d.m.Y', strtotime($task->Faelligkeitsdatum)) ?></span>
                        <?php endif ?>
                    </div>
                </div>

                <div class="task-right">
                    <span class="badge badge-erledigt">✓ Erledigt</span>
                    <?= Html::a('Ansehen', ['/hausaufgaben/view', 'HU_ID' => $task->HU_ID], ['class' => 'btn btn-secondary btn-sm']) ?>
                </div>
            </div>
        <?php endforeach ?>
    <?php endif ?>
</div>

<!-- bissl js für an live filter -->
<script>
    function dashFilter() {
        const search = document.getElementById('dash-search').value.toLowerCase();
        const fach   = document.getElementById('dash-fach').value;

        document.querySelectorAll('.task-card').forEach(card => {
            const titleMatch = card.dataset.title.includes(search);
            const fachMatch  = !fach || card.dataset.fach === fach;
            card.style.display = (titleMatch && fachMatch) ? '' : 'none';
        });
    }
</script>