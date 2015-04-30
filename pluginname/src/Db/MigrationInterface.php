<?php
/**
 * Created by PhpStorm.
 * User: Kat
 * Date: 30/04/2015
 * Time: 18:31
 */

namespace BinaryKitten\PluginName\Db;

use \WPDB;

interface MigrationInterface
{
    public static function update(WPDB $wpdb);
    public static function rollback(WPDB $wpdb);
}