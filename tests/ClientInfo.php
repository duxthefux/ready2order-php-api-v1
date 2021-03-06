<?php
 
use \ready2order\ready2orderAPI;
 
class ClientInfoTest extends PHPUnit_Framework_TestCase
{

	public function setUp()
	{
		$dotenv = new Dotenv\Dotenv(__DIR__.'/../');
		$dotenv->load();
	}

	public function testGetCompanyInfo()
	{
		$ready2order = new ready2orderAPI(getenv('R2O_USER_TOKEN'));
		$ready2order->setApiEndpoint(getenv('R2O_API'));
		$info = $ready2order->get('company');

		$this->assertArrayHasKey('company_name', $info);
	}

}