<?php

/**
 * Create Trean base tables (as of Trean 1.x).
 *
 * Copyright 2010-2017 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (BSD). If you
 * did not receive this file, see http://www.horde.org/licenses/bsdl.php.
 *
 * @author   Chuck Hagenbuch <chuck@horde.org>
 * @category Horde
 * @license  http://www.horde.org/licenses/bsdl.php BSD
 * @package  Trean
 */
class TreanBaseTables extends Horde_Db_Migration_Base
{
    /**
     * Upgrade.
     */
    public function up()
    {
        $tableList = $this->tables();

        if (!in_array('trean_bookmarks', $tableList)) {
            $t = $this->createTable('trean_bookmarks', ['autoincrementKey' => false]);
            $t->column('bookmark_id', 'integer', ['null' => false]);
            $t->column('folder_id', 'integer', ['null' => false]);
            $t->column('bookmark_url', 'string', ['limit' => 255, 'null' => false]);
            $t->column('bookmark_title', 'string', ['limit' => 255]);
            $t->column('bookmark_description', 'string', ['limit' => 255]);
            $t->column('bookmark_clicks', 'integer', ['default' => 0]);
            $t->column('bookmark_rating', 'integer', ['default' => 0]);
            $t->column('bookmark_http_status', 'string', ['limit' => 5]);
            $t->primaryKey(['bookmark_id']);
            $t->end();
            $this->addIndex('trean_bookmarks', ['bookmark_clicks']);
        }
    }

    public function down()
    {
        $this->dropTable('trean_bookmarks');
    }
}
