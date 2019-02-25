<?php

namespace Demo;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Hello {

	public function run ()
	{
		//var_dump(__METHOD__);

		$this->prepareDir();


		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Hello World !');

		$file_path = THE_VAR_DIR_PATH . '/hello/hello-world.xlsx';
		$writer = new Xlsx($spreadsheet);
		$writer->save($file_path);


		echo('Create file: ' . $file_path);
		echo(PHP_EOL);
		echo('Please run: ');
		echo(PHP_EOL);
		echo('$ localc ' . "'" . $file_path  . "'");
		echo(PHP_EOL);

	}

	protected function prepareDir ()
	{
		$dir_path = THE_VAR_DIR_PATH . '/hello';

		if (file_exists($dir_path)) {
			return;
		}

		mkdir($dir_path, 0755 ,true);
	}

} // End class Hello
