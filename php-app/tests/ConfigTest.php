<?php

  require_once 'classes/Config.php';
  require_once 'core/init.php';

  use PHPUnit\Framework\TestCase;

  final class ConfigTest extends TestCase {

      public function testGetData(): void {

        $getUsername = Config::get('mysql/username');
        $getDBname = Config::get('mysql/db');

        $this->assertEquals('jochemos', $getUsername);
        $this->assertEquals('php_db', $getDBname);

      }

  }

?>
