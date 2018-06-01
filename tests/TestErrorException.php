<?php
 
use \ready2order\ready2orderAPI;
use ready2order\ready2orderErrorException;

class TestErrorException extends Ready2orderAPITest
{

	public function setUp()
	{
		$dotenv = new Dotenv\Dotenv(__DIR__.'/../');
		$dotenv->load();
	}

	public function testEmptyData()
	{
		$ready2order = new ready2orderAPI(getenv('R2O_USER_TOKEN'));
		$ready2order->setApiEndpoint(getenv('R2O_API'));

		try {
			$ready2order->put('productgroups');
		} catch(ready2orderErrorException $ready2orderErrorException){
		} finally{
			$this->assertNotNull($ready2orderErrorException, "No exception thrown!");

			$data = $ready2orderErrorException->getData();
			$this->assertNotNull($data, "No data in exception!");

			$this->assertTrue($data["error"]);
			$this->assertEquals("No data provided.", $data["msg"]);
		}
	}

}