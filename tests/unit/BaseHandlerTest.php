<?php

use Tatter\Schemas\Handlers\BaseHandler;
use Tatter\Schemas\Structures\Mergeable;
use Tatter\Schemas\Structures\Field;
use Tatter\Schemas\Structures\Table;

class BaseHandlerTest extends \CodeIgniter\Test\CIUnitTestCase
{
	public function setUp(): void
	{
		parent::setUp();
		
		$config                        = new \Tatter\Schemas\Config\Schemas();
		$config->silent                = false;
		$config->ignoreMigrationsTable = true;
		$config->constrainByPrefix     = true;
		
		$this->config  = $config;
		$this->handler = new BaseHandler($config);
	}

	public function testFindKeyToForeignTable()
	{
		$table = new Table('machines');
		$method = $this->getPrivateMethodInvoker($this->handler, 'findKeyToForeignTable');
		
		$fields = new Mergeable();
		$fields->factory = new Field();
		$fields->type    = new Field();
		$fields->serial  = new Field();
		$table->fields   = $fields;
		
		$this->assertEquals('factory', $method($table, 'factories'));

		$fields = new Mergeable();
		$fields->factory_id = new Field();
		$fields->type       = new Field();
		$fields->serial     = new Field();
		$table->fields      = $fields;
		
		$this->assertEquals('factory_id', $method($table, 'factories'));

		$fields = new Mergeable();
		$fields->factories  = new Field();
		$fields->type       = new Field();
		$fields->serial     = new Field();
		$table->fields      = $fields;
		
		$this->assertEquals('factories', $method($table, 'factories'));

		$fields = new Mergeable();
		$fields->factories_id = new Field();
		$fields->type         = new Field();
		$fields->serial       = new Field();
		$table->fields        = $fields;
		
		$this->assertEquals('factories_id', $method($table, 'factories'));
	}

	public function testNotFindKeyToForeignTable()
	{
		$table = new Table('machines');
		$method = $this->getPrivateMethodInvoker($this->handler, 'findKeyToForeignTable');
		
		$fields = new Mergeable();
		$fields->factories  = new Field();
		$fields->type       = new Field();
		$fields->serial     = new Field();
		$table->fields      = $fields;
		
		$this->assertNull($method($table, 'lawyers'));
	}

	public function testFindPrimaryKeyActual()
	{
		$table = new Table('machines');
		$method = $this->getPrivateMethodInvoker($this->handler, 'findPrimaryKey');
		
		$field = new Field('machine_id');
		$field->primary_key = true;

		$fields = new Mergeable();
		$fields->machine_id  = $field;
		$fields->type       = new Field();
		$fields->serial     = new Field();
		$table->fields      = $fields;

		$this->assertEquals('machine_id', $method($table));
	}

	public function testFindPrimaryKeyImplied()
	{
		$table = new Table('machines');
		$method = $this->getPrivateMethodInvoker($this->handler, 'findPrimaryKey');
				
		$fields = new Mergeable();
		$fields->id     = new Field('id');
		$fields->type   = new Field();
		$fields->serial = new Field();
		$table->fields  = $fields;
		
		$this->assertEquals('id', $method($table));
	}

	public function testNotFindPrimaryKey()
	{
		$table = new Table('machines');
		$method = $this->getPrivateMethodInvoker($this->handler, 'findPrimaryKey');
		
		$fields = new Mergeable();
		$fields->primary    = new Field('primary');
		$fields->type       = new Field();
		$fields->serial     = new Field();
		$table->fields      = $fields;
		
		$this->assertNull($method($table));
	}
}
