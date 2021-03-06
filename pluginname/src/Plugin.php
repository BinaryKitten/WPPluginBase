<?php
namespace BinaryKitten\PluginName;

use BinaryKitten\PluginName\Db\MigrationInterface;

class Plugin
{
    const PLUGIN_VERSION = 1; // update to trigger next migrations
    static $classes = array(
        'Admin\ChangeFooter'
    );
    protected $pluginDir = '';

    /**
     * @param string $pluginDir Location of plugin - used to handle file loading etc
     * @param string $pluginFile Filename of the plugin - used for activation hooks
     */
    public function __construct($pluginDir ,$pluginFile)
    {
        $this->pluginDir = $pluginDir;
        register_activation_hook($pluginFile, array($this, 'activation'));
        add_action('plugins_loaded', array($this, 'activation'));

        foreach (self::$classes as $class) {
            $class = __NAMESPACE__ . "\\" . $class;
            $create = true;
            if (method_exists($class, 'createCheck')) {
                $create = call_user_func(array($class, 'createCheck'));
            }

            if ($create) {
                new $class($pluginDir);
            }
        }

        $frontendFunctionsFile = $pluginDir . 'src/Front/Functions.php';
        if (file_exists($frontendFunctionsFile)) {
            require_once $frontendFunctionsFile;
        }
    }


    public function activation()
    {
        /** @var \WPDB $wpdb **/
        global $wpdb;

        $version = get_option(__NAMESPACE__ . '_VERSION');
        if ($version === false && 'plugins_loaded' == current_filter()) {
            return;
        } elseif ($version === false) {
            $version = 0;
        }
        $action = null;
        if ($version == self::PLUGIN_VERSION) {
            return;
        }

        if (!function_exists('dbDelta')) {
            require ABSPATH . 'wp-admin/includes/upgrade.php';
        }

        $results = array();
        $classPrefix = implode("\\", array(__NAMESPACE__, "Db", "Migrate"));
        $migrationInterface = implode("\\", array(__NAMESPACE__, "Db", "MigrationInterface"));
        if ($version < self::PLUGIN_VERSION) {
            for ($i = ($version+1); $i <= self::PLUGIN_VERSION; $i++) {
                $className = $classPrefix . $i;
                if (class_exists($className)) {
                    $implements = class_implements($className);
                    if(in_array($migrationInterface, $implements)) {
                        $results[] = call_user_func(array($className, 'update'), $wpdb);
                    }
                }
            }
        } elseif ($version > self::PLUGIN_VERSION) {
            for ($i = self::PLUGIN_VERSION; $i > $version; $i--) {
                $className = $classPrefix . $i;
                if (class_exists($className)) {
                    $implements = class_implements($className);
                    if(in_array($migrationInterface, $implements)) {
                        $results[] = call_user_func(array($className, 'rollback'), $wpdb);
                    }
                }
            }
        }
        update_option(__NAMESPACE__ . '_VERSION', self::PLUGIN_VERSION);
        return $results;

        update_option(__NAMESPACE__ . '_VERSION', self::PLUGIN_VERSION);
    }
}
