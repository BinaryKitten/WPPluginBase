<?php

namespace BinaryKitten\PluginName\Db;


use WPDB;

class Migrate1 implements MigrationInterface
{
    public static function update(WPDB $wpdb)
    {
        // $table_name = $wpdb->prefix . 'plugin_table';

        /* $SQL = <<<EO_SQL
CREATE TABLE $table_name (
    person_name  varchar(255) NOT NULL ,
added_date  datetime NULL ,
PRIMARY KEY (person_name)
)
;
EO_SQL;

        dbDelta($SQL);

        */

    }

    public static function rollback(WPDB $wpdb)
    {
        // TODO: Implement rollback() method.
    }
}