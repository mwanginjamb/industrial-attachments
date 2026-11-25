<?php

use yii\db\Migration;

/**
 * Seeds the application_status rows that frontend\models\Application status constants point to.
 *
 * application.status has a foreign key to application_status.id, so these rows must exist
 * before any application can be saved. Only missing ids are inserted; existing rows (which HR
 * can rename via the Review Status screen) are left untouched.
 */
class m261125_120000_seed_application_status_rows extends Migration
{
    private const STATUSES = [
        1 => 'Submitted',
        2 => 'Under Review',
        3 => 'Accepted',
        4 => 'Rejected',
        5 => 'Placed',
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $now = time();
        foreach (self::STATUSES as $id => $description) {
            $exists = (new \yii\db\Query())
                ->from('{{%application_status}}')
                ->where(['id' => $id])
                ->exists($this->db);

            if ($exists) {
                echo "    > application_status #{$id} already exists, leaving it as is.\n";
                continue;
            }

            $this->insert('{{%application_status}}', [
                'id' => $id,
                'description' => $description,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // No-op: rows may pre-date this migration or be referenced by applications.
    }
}
