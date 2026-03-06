<?php

/** @var yii\web\View $this */
/** @var app\models\Hausaufgaben[] $offeneAufgaben */
/** @var app\models\Hausaufgaben[] $erledigteAufgaben */

use yii\helpers\Html;

$this->title = 'Dashboard';

// Hilfsfunktion: Status → Badge CSS-Klasse + Label
function statusInfo($status) {
    switch (strtolower(trim($status ?? ''))) {
        case 'erledigt': return ['class' => 'badge-erledigt', 'label' => '✓ Erledigt'];
        case 'rot':      return ['class' => 'badge-rot',      'label' => 'Überfällig'];
        case 'blau':     return ['class' => 'badge badge-blau', 'label' => 'Neu'];
        case 'gelb':     return ['class' => 'badge-offen',    'label' => 'Offen'];
        default:         return ['class' => 'badge-offen',    'label' => 'Offen'];
    }
}

// Hilfsfunktion: Status → data-status (linke Border-Farbe)
function statusAttr($status) {
    switch (strtolower(trim($status ?? ''))) {
        case 'erledigt': return 'erledigt';
        case 'rot':      return 'rot';
        default:         return 'offen';
    }
}

// Alle Fächer für den Filter sammeln
$alleFaecher = array_unique(array_filter(array_map(
        fn($a) => $a->F_Name,
        array_merge($offeneAufgaben, $erledigteAufgaben)
)));
?>

<!-- Dashboard Hero -->
<div class="dash-hero">
    <h1 class="dash-greeting">
        Hallo, <em><?= Html::encode(Yii::$app->user->identity->Name ?? 'Gast') ?>.</em>
    </h1>
    <div class="stat-pills">
        <div class="pill"><strong><?= count($offeneAufgaben) ?></strong> offen</div>
        <div class="pill"><strong><?= count($erledigteAufgaben) ?></strong> erledigt</div>
        <?php
        // Nächste Abgabe anzeigen
        if (!empty($offeneAufgaben) && $offeneAufgaben[0]->Faelligkeitsdatum) {
            $datum = date('d. M', strtotime($offeneAufgaben[0]->Faelligkeitsdatum));
            echo '<div class="pill"><strong>' . $datum . '</strong> nächste Abgabe</div>';
        }
        ?>
    </div>
</div>

<!-- Such- und Filterleiste -->
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
        <?php foreach ($alleFaecher as $fach): ?>
            <option value="<?= Html::encode($fach) ?>"><?= Html::encode($fach) ?></option>
        <?php endforeach ?>
    </select>
    <?= Html::a('+ Neue Aufgabe', ['/hausaufgaben/create'], ['class' => 'btn btn-primary btn-sm']) ?>
</div>

<!-- ── Offene Aufgaben ─────────────────────── -->
<div class="section-header">
    <h2 class="section-title">Offene Aufgaben <small><?= count($offeneAufgaben) ?></small></h2>
</div>

<div id="offene-liste">
    <?php if (empty($offeneAufgaben)): ?>
        <div style="color:var(--text-muted);font-size:.9rem;padding:.75rem 0">
            Keine offenen Aufgaben — gut gemacht! 🎉
        </div>
    <?php else: ?>
        <?php foreach ($offeneAufgaben as $aufgabe): ?>
            <?php $info = statusInfo($aufgabe->Status); ?>
            <div class="task-card"
                 data-status="<?= statusAttr($aufgabe->Status) ?>"
                 data-title="<?= Html::encode(strtolower($aufgabe->Titel)) ?>"
                 data-fach="<?= Html::encode($aufgabe->F_Name) ?>">

                <span class="task-fach"><?= Html::encode($aufgabe->F_Name ?? '—') ?></span>

                <div class="task-body">
                    <div class="task-title"><?= Html::encode($aufgabe->Titel) ?></div>
                    <?php if ($aufgabe->Beschreibung): ?>
                        <div class="task-desc"><?= Html::encode($aufgabe->Beschreibung) ?></div>
                    <?php endif ?>
                    <div class="task-meta">
                        <?php if ($aufgabe->lehrer): ?>
                            <span>von <?= Html::encode($aufgabe->lehrer->Nachname) ?></span>
                            <span>·</span>
                        <?php endif ?>
                        <?php if ($aufgabe->Faelligkeitsdatum): ?>
                            <span>Fällig: <?= date('d.m.Y', strtotime($aufgabe->Faelligkeitsdatum)) ?></span>
                        <?php endif ?>
                    </div>
                </div>

                <div class="task-right">
                    <?php if ($aufgabe->Faelligkeitsdatum): ?>
                        <span class="task-date"><?= date('d. M', strtotime($aufgabe->Faelligkeitsdatum)) ?></span>
                    <?php endif ?>
                    <span class="badge <?= $info['class'] ?>"><?= $info['label'] ?></span>
                    <?= Html::a('Bearbeiten', ['/hausaufgaben/update', 'HU_ID' => $aufgabe->HU_ID], ['class' => 'btn btn-secondary btn-sm']) ?>
                </div>
            </div>
        <?php endforeach ?>
    <?php endif ?>
</div>

<hr class="divider">

<!-- ── Erledigte Aufgaben ──────────────────── -->
<div class="section-header">
    <h2 class="section-title">Erledigt <small><?= count($erledigteAufgaben) ?></small></h2>
</div>

<div id="erledigte-liste">
    <?php if (empty($erledigteAufgaben)): ?>
        <div style="color:var(--text-muted);font-size:.9rem;padding:.75rem 0">
            Noch keine erledigten Aufgaben.
        </div>
    <?php else: ?>
        <?php foreach ($erledigteAufgaben as $aufgabe): ?>
            <div class="task-card"
                 data-status="erledigt"
                 data-title="<?= Html::encode(strtolower($aufgabe->Titel)) ?>"
                 data-fach="<?= Html::encode($aufgabe->F_Name) ?>"
                 style="opacity:.6">

                <span class="task-fach"><?= Html::encode($aufgabe->F_Name ?? '—') ?></span>

                <div class="task-body">
                    <div class="task-title"><?= Html::encode($aufgabe->Titel) ?></div>
                    <?php if ($aufgabe->Beschreibung): ?>
                        <div class="task-desc"><?= Html::encode($aufgabe->Beschreibung) ?></div>
                    <?php endif ?>
                    <div class="task-meta">
                        <?php if ($aufgabe->Faelligkeitsdatum): ?>
                            <span>Fällig: <?= date('d.m.Y', strtotime($aufgabe->Faelligkeitsdatum)) ?></span>
                        <?php endif ?>
                    </div>
                </div>

                <div class="task-right">
                    <span class="badge badge-erledigt">✓ Erledigt</span>
                    <?= Html::a('Ansehen', ['/hausaufgaben/view', 'HU_ID' => $aufgabe->HU_ID], ['class' => 'btn btn-secondary btn-sm']) ?>
                </div>
            </div>
        <?php endforeach ?>
    <?php endif ?>
</div>

<!-- ── Live-Filter JS ─────────────────────── -->
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