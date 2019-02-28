<?php

namespace Demo\Iterator;

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
		// https://github.com/PHPOffice/PhpSpreadsheet/blob/master/samples/Reader/01_Simple_file_reader_using_IOFactory.php

		echo 'Dump file: ' . $file_path;
		echo PHP_EOL;
		echo PHP_EOL;


		// https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/IOFactory.html#method_load
		// https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/Spreadsheet.html
		$spreadsheet = IOFactory::load($file_path);


		// https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/Spreadsheet.html#method_getWorksheetIterator
		// https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/Worksheet/Worksheet.html
		foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
			//var_dump($worksheet);
			var_dump($worksheet->getTitle());



			// https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/Worksheet/Worksheet.html#method_getRowIterator
			// https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/Worksheet/RowIterator.html
			// https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/Worksheet/Row.html
			foreach ($worksheet->getRowIterator() as $row) {
				//var_dump($row);

	
				echo PHP_EOL;

				var_dump($row->getRowIndex() . '================================================================================');



				// https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/Worksheet/Row.html#method_getCellIterator
				// https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/Worksheet/RowCellIterator.html
				$cell_iterator = $row->getCellIterator();
				$cell_iterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set


				// https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/Worksheet/RowCellIterator.html
				// https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/Cell/Cell.html
				foreach ($cell_iterator as $cell) {
					//var_dump($cell);
					if ($cell === null) {
						continue;
					}



					var_dump($cell->getColumn());
					var_dump($cell->getRow());
					var_dump($cell->getCoordinate());
					var_dump($cell->getValue());
					var_dump($cell->getCalculatedValue());

					var_dump('----------------------------------------');
				}

			}
		}

		echo PHP_EOL;
	}



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


} // End class Ex0010

/*
Dump file: /home/user/project/demo-php-office/demo-php-spreadsheet/case-discussion/asset/merge/1.ods

array(3) {
  [1]=>
  array(2) {
    ["A"]=>
    string(1) "x"
    ["B"]=>
    string(1) "y"
  }
  [2]=>
  array(2) {
    ["A"]=>
    float(1)
    ["B"]=>
    float(2)
  }
  [3]=>
  array(2) {
    ["A"]=>
    float(3)
    ["B"]=>
    float(4)
  }
}

Dump file: /home/user/project/demo-php-office/demo-php-spreadsheet/case-discussion/asset/merge/2.ods

array(3) {
  [1]=>
  array(2) {
    ["A"]=>
    string(1) "x"
    ["B"]=>
    string(1) "y"
  }
  [2]=>
  array(2) {
    ["A"]=>
    float(5)
    ["B"]=>
    float(6)
  }
  [3]=>
  array(2) {
    ["A"]=>
    float(7)
    ["B"]=>
    float(8)
  }
}

Dump file: /home/user/project/demo-php-office/demo-php-spreadsheet/case-discussion/asset/merge/3.ods

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
    NULL
    ["B"]=>
    NULL
    ["C"]=>
    int(0)
  }
  [3]=>
  array(3) {
    ["A"]=>
    NULL
    ["B"]=>
    NULL
    ["C"]=>
    int(0)
  }
}
*/
