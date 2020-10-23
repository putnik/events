<?php

class ExampleTest extends TestCase {
	/**
	 * A basic test example.
	 *
	 * @covers nothing
	 * @return void
	 */
	public function testExample() {
		$this->get( '/' );

		$this->assertEquals(
			$this->app->version(), $this->response->getContent()
		);
	}
}
