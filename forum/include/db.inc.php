<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

Beehive Forum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'errorhandler.inc.php';
require_once BH_INCLUDE_PATH. 'server.inc.php';

class db extends mysqli
{
    protected static $config;

    protected static $connection;

    protected function __construct($host = null, $username = null, $password = null, $database = null, $port = null, $socket = null)
    {
        parent::__construct($host, $username, $password, $database, $port, $socket);
    }

    public static function get($new_connection = false)
    {
        if (!isset(self::$config)) {
            self::$config = server_get_config();
        }

        if (!db::$connection || $new_connection) {

            $db = new self(self::$config['db_server'], self::$config['db_username'], self::$config['db_password'], self::$config['db_database'], self::$config['db_port']);

            if (mysqli_connect_error()) {
                throw new Exception(sprintf('Could not connect to database server. Error received: %s', mysqli_connect_error()), MYSQL_CONNECT_ERROR);
            }

            if (!$db->set_charset('utf8')) {
                throw new Exception('Could not change MySQL character-set. Check your MySQL user credentials');
            }

            if (!$db->set_time_zone()) {
                throw new Exception('Could not change MySQL time-zone. Check your MySQL user credentials');
            }

            if (isset($config['mysql_big_selects']) && ($config['mysql_big_selects'] === true)) {

                if (!$db->enable_compat_mode()) {
                    throw new Exception('Could not change MYSQL compatbility options. Check your MySQL user permissions.');
                }
            }

            if ($new_connection) return $db;

            db::$connection = $db;
        }

        return db::$connection;
    }

    public static function set_config(array $config)
    {
        if (!isset($config['db_server'], $config['db_username'], $config['db_password'], $config['db_database'], $config['db_port'])) {
            throw new Exception('Missing required database configuration. Config array should contain db_server, db_username, db_password, db_database and db_port keys');
        }

        self::$config = $config;
    }

    public static function get_version()
    {
        $db = db::get();

        $sql = "SELECT VERSION() AS version";

        if (!($result = $db->query($sql))) {
            return false;
        }

        if (!($version_data = $result->fetch_assoc())) {

            $sql = "SHOW VARIABLES LIKE 'version'";

            if (!($result = $db->query($sql))) {
                return false;
            }

            $version_data = $result->fetch_assoc();
        }

        $version_array = explode('.', $version_data['version']);

        if (!isset($version_array[0])) {
            $version_array[0] = 3;
        }

        if (!isset($version_array[1])) {
            $version_array[1] = 21;
        }

        if (!isset($version_array[2])) {
            $version_array[2] = 0;
        }

        return sprintf(
            '%d.%d.%d',
            $version_array[0],
            $version_array[1],
            intval($version_array[2])
        );
    }

    protected function set_time_zone()
    {
        return $this->query("SET SESSION time_zone = '+0:00'");
    }

    protected function enable_compat_mode()
    {
        if (!$this->query('SET SESSION SQL_BIG_SELECTS = 1')) return false;
        if (!$this->query('SET SESSION SQL_MAX_JOIN_SIZE = DEFAULT')) return false;

        return true;
    }

    public function escape($var)
    {
        return $this->real_escape_string($var);
    }

    public function query($sql, $resultmode = MYSQLI_STORE_RESULT)
    {
        if (($result = parent::query($sql, $resultmode)) === false) {
            throw new Exception($this->error, $this->errno);
        }

        return $result;
    }
}

?>