<?php

use yii\db\Migration;

/**
 * Fügt die Spalte is_admin zur Tabelle User hinzu.
 */
class m260306_165943_add_is_admin_column_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Fügt die Spalte 'is_admin' zur Tabelle 'User' hinzu.
        // Typ: smallInteger (0 oder 1), darf nicht NULL sein, Standardwert ist 0.
        $this->addColumn('User', 'is_admin', $this->smallInteger()->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Macht die Änderung rückgängig und löscht die Spalte wieder.
        $this->dropColumn('User', 'is_admin');
    }
}