<?php

/**
 * Tests for the Testee_addon class.
 *
 * @package		Testee
 * @author		Stephen Lewis <stephen@experienceinternet.co.uk>
 * @copyright	Experience Internet
 */

require_once PATH_THIRD .'testee/classes/Testee_addon' .EXT;

Mock::generatePartial(
	'Testee_db',
	'Mock_db',
	array('get')
);

class Test_testee_addon extends Testee_unit_test_case {

	/* --------------------------------------------------------------
	 * PRIVATE PROPERTIES
	 * ------------------------------------------------------------ */

	/**
	 * The `add-on` class.
	 *
	 * @access	private
	 * @var		Testee_addon
	 */
	private $_addon;
	

	
	/* --------------------------------------------------------------
	 * PUBLIC METHODS
	 * ------------------------------------------------------------ */

	/**
	 * Runs before each test.
	 *
	 * @access	public
	 * @return	void
	 */
	function setUp()
	{
		$this->_addon = new Testee_addon();

		/**
		 * This would make much more sense in the constructor.
		 * 
		 * Unfortunately, that won't work, because SimpleTest
		 * needs to know which test is running when the mock
		 * object is created.
		 */

		$this->_ee->db =& new Mock_db($this);
		$this->_ee->db->setReturnReference('get', new stdClass());
		$this->_ee->db->__construct(parent::$_db);
	}
	

	/**
	 * Runs after each test.
	 *
	 * @access	public
	 * @return	void
	 */
	function tearDown()
	{
		// Do nothing.
	}
	
	
	/* --------------------------------------------------------------
	 * TEST METHODS
	 * ------------------------------------------------------------ */

	function test_construct()
	{
		$addon = new Testee_addon(array(
			'name'	=> 'Test Addon',
			'tests'	=> array(new Testee_test())
		));
		
		$this->assertTrue($addon->name = 'Test Addon');
		$this->assertEqual(count($addon->tests), 1);
		$this->assertNotEqual(count($addon->tests), 0);
	}
	
	
	function test_add_test()
	{
		$test = new Testee_test();
		
		$this->_addon->add_test($test);
		
		$this->assertEqual(count($this->_addon->tests), 1);
		$this->assertNotEqual(count($this->_addon->tests), 0);
	}
	
	
	function test_set_name()
	{
		$this->_addon->name = 'Test Addon';
		$this->assertEqual($this->_addon->name, 'Test Addon');
		$this->assertNotEqual($this->_addon->name, 'Wibble');
	}
	
	
	function test_set_tests()
	{
		$test = new Testee_test();
		
		$this->_addon->tests = array($test, $test, $test);
		$this->assertEqual(count($this->_addon->tests), 3);
		$this->assertNotEqual(count($this->_addon->tests), 1);
	}
}

?>