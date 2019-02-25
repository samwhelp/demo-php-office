<?php

namespace Demo\Dump;

use PhpOffice\PhpSpreadsheet\IOFactory;

class Ex0010 {

	public function run ()
	{
		//var_dump(__METHOD__);


		$this->dump_1();
		$this->dump_2();
		$this->dump_3();

	}

	protected function dump_file ($file_path)
	{
		echo 'Dump file: ' . $file_path;
		echo PHP_EOL;
		echo PHP_EOL;

		$spreadsheet = IOFactory::load($file_path);

		$data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

		var_dump($data);

		echo PHP_EOL;
	}

	/*
	protected function dump_1 ()
	{
		$file_path = THE_ASSET_DIR_PATH . '/merge/1.ods';

		echo 'Dump file: ' . $file_path;
		echo PHP_EOL;
		echo PHP_EOL;

		$spreadsheet = IOFactory::load($file_path);

		$data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

		var_dump($data);

		echo PHP_EOL;
	}
	*/

	protected function dump_1 ()
	{
		$this->dump_file(THE_ASSET_DIR_PATH . '/merge/1.ods');
	}

	protected function dump_2 ()
	{
		$this->dump_file(THE_ASSET_DIR_PATH . '/merge/2.ods');
	}

	protected function dump_3 ()
	{
		$this->dump_file(THE_ASSET_DIR_PATH . '/merge/3.ods');
	}


} // End class Hello
