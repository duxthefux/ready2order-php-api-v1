<?php

use \ready2order\ready2orderAPI;
 
class Ready2orderAPITest extends PHPUnit_Framework_TestCase
{

	public function setUp()
	{
		$dotenv = new Dotenv\Dotenv(__DIR__.'/../');
		$dotenv->load();
	}

	public function testTestEnvironment()
	{
		$this->assertNotEmpty(getenv('R2O_MASTER_TOKEN'), 'No environment variables! Copy .env.example -> .env and fill out your ready2order API credentials.');
	}

	public function testInstantiation()
	{
		$ready2order = new ready2orderAPI(getenv('R2O_USER_TOKEN'));
		$ready2order->setApiEndpoint(getenv('R2O_API'));
		$this->assertInstanceOf('\ready2order\ready2orderAPI', $ready2order);
	}

}