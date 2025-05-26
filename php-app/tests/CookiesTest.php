<?php

  require_once 'classes/Cookies.php';

  use PHPUnit\Framework\TestCase;

  final class CookiesTest extends TestCase {

      public function testCheckCookie(): void {

        $userID = 45;

        $generateCookie = Cookie::new('user', $userID, 1, true);

        $expect = "%" . $userID . "%";

        $this->assertStringStartsWith($expect, $generateCookie);

      }

  }

?>
