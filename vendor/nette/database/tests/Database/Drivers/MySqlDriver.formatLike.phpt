<?php

/**
 * @dataProvider? ../databases.ini  mysql
 */

declare(strict_types=1);

use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

$connection = connectToDB()->getConnection();
$driver = $connection->getDriver();

Assert::same(0, $connection->query("SELECT 'AAxBB' LIKE", $connection::literal($driver->formatLike('A_B', 0)))->fetchField());
Assert::same(1, $connection->query("SELECT 'AA_BB' LIKE", $connection::literal($driver->formatLike('A_B', 0)))->fetchField());

Assert::same(0, $connection->query("SELECT 'AAxBB' LIKE", $connection::literal($driver->formatLike('A%B', 0)))->fetchField());
Assert::same(1, $connection->query("SELECT 'AA%BB' LIKE", $connection::literal($driver->formatLike('A%B', 0)))->fetchField());

Assert::same(0, $connection->query("SELECT 'AAxBB' LIKE", $connection::literal($driver->formatLike("A'B", 0)))->fetchField());
Assert::same(1, $connection->query("SELECT 'AA''BB' LIKE", $connection::literal($driver->formatLike("A'B", 0)))->fetchField());

Assert::same(0, $connection->query("SELECT 'AAxBB' LIKE", $connection::literal($driver->formatLike('A"B', 0)))->fetchField());
Assert::same(1, $connection->query("SELECT 'AA\"BB' LIKE", $connection::literal($driver->formatLike('A"B', 0)))->fetchField());

Assert::same(0, $connection->query("SELECT 'AAxBB' LIKE", $connection::literal($driver->formatLike('A\B', 0)))->fetchField());
Assert::same(1, $connection->query("SELECT 'AA\\\\BB' LIKE", $connection::literal($driver->formatLike('A\B', 0)))->fetchField());

Assert::same(0, $connection->query("SELECT 'AAxBB' LIKE", $connection::literal($driver->formatLike('A\%B', 0)))->fetchField());
Assert::same(1, $connection->query("SELECT 'AA\\\\%BB' LIKE", $connection::literal($driver->formatLike('A\%B', 0)))->fetchField());
