<?php

  require_once 'classes/DB.php';

  use PHPUnit\Framework\TestCase;

  final class DatabaseTest extends TestCase {

      public function testGetDataQuery(): void {

        $getData = DB::getInstance("test")->getData("*", "posts", array("id", ">", 0), true);

        $expectQuery = "SELECT * FROM posts WHERE id > 0";

        $this->assertEquals($expectQuery, $getData);

      }

      public function testAddDataQuery(): void {

        $getData = DB::getInstance("test")->addData("posts", array(
          "title" => "Animals food",
          "body" => "Cat like sausages, but Dogs too",
          "author" => "AnimalPlanet_345"
        ), true);

        $expectQuery = "INSERT INTO posts(title, body, author) VALUES (?, ?, ?)";

        $this->assertEquals($expectQuery, $getData);

      }

      public function testUpdateDataQuery(): void {

        $getData = DB::getInstance("test")->updateData("posts", array(
          "title" => "Planets",
          "body" => "New planet is Pluton.. again!",
          "author" => "AnimalPlanet_345"
        ), "10", true);

        $expectQuery = "UPDATE posts SET title = ?, body = ?, author = ? WHERE id = 10";

        $this->assertEquals($expectQuery, $getData);

      }

  }

?>
