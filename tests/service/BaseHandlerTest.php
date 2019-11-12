<?php

use Tatter\Schemas\BaseHandler;

class BaseHandlerTest extends CIModuleTests\Support\UnitTestCase
{
	public function setUp(): void
	{
		parent::setUp();

		$this->handler = new BaseHandler($this->config);
	}
	
	public function testGetErrors()
	{
		$this->assertEquals([], $this->handler->getErrors());
	}
}
