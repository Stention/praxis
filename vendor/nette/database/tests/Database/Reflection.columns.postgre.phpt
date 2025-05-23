<?php

/**
 * Test: Nette\Database\Connection: reflection
 * @dataProvider? databases.ini  postgresql
 */

declare(strict_types=1);

use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$connection = connectToDB()->getConnection();
Nette\Database\Helpers::loadFromFile($connection, __DIR__ . '/files/pgsql-nette_test3.sql');


$reflection = $connection->getReflection();
$columns = $reflection->getTable('types')->columns;

$expectedColumns = [
	'smallint' => [
		'name' => 'smallint',
		'table' => 'types',
		'nativeType' => 'INT2',
		'size' => 2,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
	'integer' => [
		'name' => 'integer',
		'table' => 'types',
		'nativeType' => 'INT4',
		'size' => 4,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
	'bigint' => [
		'name' => 'bigint',
		'table' => 'types',
		'nativeType' => 'INT8',
		'size' => 8,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
	'numeric' => [
		'name' => 'numeric',
		'table' => 'types',
		'nativeType' => 'NUMERIC',
		'size' => 3,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
	'real' => [
		'name' => 'real',
		'table' => 'types',
		'nativeType' => 'FLOAT4',
		'size' => 4,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
	'double' => [
		'name' => 'double',
		'table' => 'types',
		'nativeType' => 'FLOAT8',
		'size' => 8,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
	'money' => [
		'name' => 'money',
		'table' => 'types',
		'nativeType' => 'MONEY',
		'size' => 8,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
	'bool' => [
		'name' => 'bool',
		'table' => 'types',
		'nativeType' => 'BOOL',
		'size' => 1,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
	'date' => [
		'name' => 'date',
		'table' => 'types',
		'nativeType' => 'DATE',
		'size' => 4,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
	'time' => [
		'name' => 'time',
		'table' => 'types',
		'nativeType' => 'TIME',
		'size' => 8,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
	'timestamp' => [
		'name' => 'timestamp',
		'table' => 'types',
		'nativeType' => 'TIMESTAMP',
		'size' => 8,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
	'timestampZone' => [
		'name' => 'timestampZone',
		'table' => 'types',
		'nativeType' => 'TIMESTAMPTZ',
		'size' => 8,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
	'interval' => [
		'name' => 'interval',
		'table' => 'types',
		'nativeType' => 'INTERVAL',
		'size' => 16,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
	'character' => [
		'name' => 'character',
		'table' => 'types',
		'nativeType' => 'BPCHAR',
		'size' => 30,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
	'character_varying' => [
		'name' => 'character_varying',
		'table' => 'types',
		'nativeType' => 'VARCHAR',
		'size' => 30,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
	'text' => [
		'name' => 'text',
		'table' => 'types',
		'nativeType' => 'TEXT',
		'size' => null,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
	'tsquery' => [
		'name' => 'tsquery',
		'table' => 'types',
		'nativeType' => 'TSQUERY',
		'size' => null,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
	'tsvector' => [
		'name' => 'tsvector',
		'table' => 'types',
		'nativeType' => 'TSVECTOR',
		'size' => null,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
	'uuid' => [
		'name' => 'uuid',
		'table' => 'types',
		'nativeType' => 'UUID',
		'size' => 16,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
	'xml' => [
		'name' => 'xml',
		'table' => 'types',
		'nativeType' => 'XML',
		'size' => null,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
	'cidr' => [
		'name' => 'cidr',
		'table' => 'types',
		'nativeType' => 'CIDR',
		'size' => null,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
	'inet' => [
		'name' => 'inet',
		'table' => 'types',
		'nativeType' => 'INET',
		'size' => null,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
	'macaddr' => [
		'name' => 'macaddr',
		'table' => 'types',
		'nativeType' => 'MACADDR',
		'size' => 6,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
	'bit' => [
		'name' => 'bit',
		'table' => 'types',
		'nativeType' => 'BIT',
		'size' => -3,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
	'bit_varying' => [
		'name' => 'bit_varying',
		'table' => 'types',
		'nativeType' => 'VARBIT',
		'size' => null,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
	'bytea' => [
		'name' => 'bytea',
		'table' => 'types',
		'nativeType' => 'BYTEA',
		'size' => null,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
	'box' => [
		'name' => 'box',
		'table' => 'types',
		'nativeType' => 'BOX',
		'size' => 32,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
	'circle' => [
		'name' => 'circle',
		'table' => 'types',
		'nativeType' => 'CIRCLE',
		'size' => 24,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
	'lseg' => [
		'name' => 'lseg',
		'table' => 'types',
		'nativeType' => 'LSEG',
		'size' => 32,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
	'path' => [
		'name' => 'path',
		'table' => 'types',
		'nativeType' => 'PATH',
		'size' => null,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
	'point' => [
		'name' => 'point',
		'table' => 'types',
		'nativeType' => 'POINT',
		'size' => 16,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
	'polygon' => [
		'name' => 'polygon',
		'table' => 'types',
		'nativeType' => 'POLYGON',
		'size' => null,
		'nullable' => true,
		'default' => null,
		'autoIncrement' => false,
		'primary' => false,
	],
];

Assert::same(
	$expectedColumns,
	array_map(fn($c) => [
		'name' => $c->name,
		'table' => $c->table->name,
		'nativeType' => $c->nativeType,
		'size' => $c->size,
		'nullable' => $c->nullable,
		'default' => $c->default,
		'autoIncrement' => $c->autoIncrement,
		'primary' => $c->primary,
	], $columns),
);
