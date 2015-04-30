<?php

namespace BinaryKitten\PluginName\Db;


class Migrate1
{
    public static function update()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'plugin_table';

        $SQL = <<<EO_SQL
CREATE TABLE $table_name (
    person_name  varchar(255) NOT NULL ,
added_date  datetime NULL ,
PRIMARY KEY (person_name)
)
;
EO_SQL;

        dbDelta($SQL);

    }
}