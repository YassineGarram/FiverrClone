<?php

  require_once 'classes/Validation.php';

  use PHPUnit\Framework\TestCase;


  class getInstanceReflect {

    private static $_instance = null;

    private function __construct() {
      self::$_instance = new getReflect();
      return self::$_instance;
    }

    public static function setMethod($method) {
      $getMethod = new ReflectionMethod('Validation', $method);
      return $getMethod;
    }

    public static function getResultBy($method, $args) {
      $invokeArgs = self::setMethod($method)->invokeArgs(new Validation(), array($args));
      return $invokeArgs;
    }

  }


  final class ValidationTest extends TestCase {


    public function testRequireValues(): void {

      $data = array(
        "username" => '',
        "password" => '',
        "password_again" => '',
        "name" => ''
      );

      $result = getInstanceReflect::getResultBy('checkRequire', $data);

      $expect = array(
        0 => 'username required! <br>',
        1 => 'password required! <br>',
        2 => 'password_again required! <br>',
        3 => 'name required! <br>'
      );

      $this->assertEquals($expect, $result);

    }

    public function testLengthOfValues(): void {

      $notEnoughData = array(
        "username" => '',
        "password" => '',
        "password_again" => '',
        "name" => ''
      );

      $longerData = array(
        "username" => 'thisIsValueWithLongDataOfUsername',
        "password" => 'thisIsValueWithLongerDataOfPassword',
        "password_again" => 'thisIsValueWithLongerDataOfPassword',
        "name" => 'thisIsValueWithLongerDataOfName'
      );

      $resultWithLessData = getInstanceReflect::getResultBy('checkLength', $notEnoughData);
      $resultWithGreaterData = getInstanceReflect::getResultBy('checkLength', $longerData);

      $expect_first = array(
        0 => 'length of username must be greater than 4 <br>',
        1 => 'length of password must be greater than 5 <br>',
        2 => 'length of password_again must be greater than 5 <br>',
        3 => 'length of name must be greater than 2 <br>'
      );

      $expect_second = array(
        0 => 'length of username must be less than 15 <br>',
        1 => 'length of password must be less than 30 <br>',
        2 => 'length of password_again must be less than 30 <br>',
        3 => 'length of name must be less than 30 <br>'

      );

      $this->assertEquals($expect_first, $resultWithLessData);
      $this->assertEquals($expect_second, $resultWithGreaterData);

    }

    public function testCheckPassword(): void {

      $data = array(
        "username" => '',
        "password" => 'firstSetPassword',
        "password_again" => 'secondSetPassword',
        "name" => ''
      );

      $result = getInstanceReflect::getResultBy('checkPassword', $data);

      $expect = array(
        0 => 'Password must be equal <br>'
      );

      $this->assertEquals($expect, $result);

    }

    public function testCheckPost(): void {

      $notEnoughData = array(
        "title" => "",
        "body" => ""
      );

      $longerData = array(
        "title" => "thisIsLongerDataThenExpectOfTitle",
      );

      $resultWithLessData = getInstanceReflect::getResultBy('checkPostData', $notEnoughData);
      $resultWithGreaterData = getInstanceReflect::getResultBy('checkPostData', $longerData);

      $expect_first = array(
        0 => 'title is required ! <br>',
        1 => 'body is required ! <br>'
      );

      $expect_second = array(
        0 => 'title must be less than 30 ! <br>'
      );

      $this->assertEquals($expect_first, $resultWithLessData);
      $this->assertEquals($expect_second, $resultWithGreaterData);

    }


  }


?>
