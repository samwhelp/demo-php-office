<?php

namespace Demo\Dump;

use PhpOffice\PhpSpreadsheet\IOFactory;

class Ex0011 {

	public function run ()
	{
		//var_dump(__METHOD__);


		$file_path = THE_VAR_DIR_PATH . '/merge-ex0010/final.ods';

		if (!file_exists($file_path)) {
			echo 'Please run first:';
			echo PHP_EOL;

			echo '$ make merge-ex0010';
			echo PHP_EOL;
			return;
		}

		$this->dump_file($file_path, true);
		$this->dump_file($file_path, false);


	}

	protected function dump_file ($file_path, $calculateFormulas)
	{
		// https://github.com/PHPOffice/PhpSpreadsheet/blob/master/samples/Reader/01_Simple_file_reader_using_IOFactory.php

		echo 'Dump file: ' . $file_path;
		echo PHP_EOL;
		echo PHP_EOL;


		// https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/IOFactory.html#method_load
		// https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/Spreadsheet.html
		$spreadsheet = IOFactory::load($file_path);


		// https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/Spreadsheet.html#method_getActiveSheet
		// https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/Worksheet/Worksheet.html#method_toArray
		$data = $spreadsheet->getActiveSheet()->toArray(null, $calculateFormulas, true, true);

		var_dump($data);

		echo PHP_EOL;
	}


} // End class Ex0011

/*
Dump file: /home/user/project/demo-php-office/demo-php-spreadsheet/case-discussion/var/merge-ex0010/final.ods

array(3) {
  [1]=>
  array(3) {
    ["A"]=>
    string(1) "x"
    ["B"]=>
    string(1) "y"
    ["C"]=>
    string(3) "sum"
  }
  [2]=>
  array(3) {
    ["A"]=>
    float(1)
    ["B"]=>
    float(2)
    ["C"]=>
    float(3)
  }
  [3]=>
  array(3) {
    ["A"]=>
    float(3)
    ["B"]=>
    float(4)
    ["C"]=>
    float(7)
  }
}

Dump file: /home/user/project/demo-php-office/demo-php-spreadsheet/case-discussion/var/merge-ex0010/final.ods

array(3) {
  [1]=>
  array(3) {
    ["A"]=>
    string(1) "x"
    ["B"]=>
    string(1) "y"
    ["C"]=>
    string(3) "sum"
  }
  [2]=>
  array(3) {
    ["A"]=>
    float(1)
    ["B"]=>
    float(2)
    ["C"]=>
    string(11) "=SUM(A2:B2)"
  }
  [3]=>
  array(3) {
    ["A"]=>
    float(3)
    ["B"]=>
    float(4)
    ["C"]=>
    string(11) "=SUM(A3:B3)"
  }
}
*/
