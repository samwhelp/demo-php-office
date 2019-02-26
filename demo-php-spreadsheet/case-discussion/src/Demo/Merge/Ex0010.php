<?php

namespace Demo\Merge;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Calculation\Calculation;

class Ex0010 {

	public function run ()
	{
		//var_dump(__METHOD__);

		$this->prepareDir();


		// https://github.com/PHPOffice/PhpSpreadsheet/blob/master/samples/Reader/01_Simple_file_reader_using_IOFactory.php
		$file_path_1 = THE_ASSET_DIR_PATH . '/merge/1.ods';

		$spreadsheet_1 = IOFactory::load($file_path_1);

		$data_1 = $spreadsheet_1->getActiveSheet()->toArray(null, true, true, true);
		//var_dump($data_1);


		$file_path_3 =  THE_ASSET_DIR_PATH . '/merge/3.ods';

		$spreadsheet_3 = IOFactory::load($file_path_3);

		//var_dump($spreadsheet_3->getActiveSheet()->getCell('C3')->getValue());

		$data_3 = $spreadsheet_3->getActiveSheet()->toArray(null, true, true, true);
		//var_dump($data_3);

		foreach ( $data_3 as $row_index_3 => $row_3) {
			if ($row_index_3 == 1) {
				continue;
			}

			foreach ($row_3 as $col_index_3 => $col_3) {

				if ($col_index_3 == 'C') {
					continue;
				}
				$cell_name = $col_index_3 . $row_index_3;

				//var_dump($col_index_3 . $row_index_3  );
				//$new_val = '1';
				$new_val = $data_1[$row_index_3][$col_index_3];
				$spreadsheet_3->getActiveSheet()->setCellValue($cell_name, $new_val);

			}
		}

		//https://phpspreadsheet.readthedocs.io/en/latest/topics/calculation-engine/#calculation-cache
		//Calculation::getInstance($spreadsheet_3)->disableCalculationCache();
		Calculation::getInstance($spreadsheet_3)->clearCalculationCache();


		$file_path_final = THE_VAR_DIR_PATH . '/merge-ex0010/final.ods';
		$writer = IOFactory::createWriter($spreadsheet_3, "Ods");
		$writer->save($file_path_final);


		echo 'Merge_file_1: ' . $file_path_1;
		echo PHP_EOL;
		echo 'Merge_file_3: ' . $file_path_3;
		echo PHP_EOL;
		echo 'Merge_final: ' . $file_path_final;
		echo PHP_EOL;
		echo 'Open_final, Please run: ';
		echo PHP_EOL;
		echo '$ localc '. $file_path_final;
		echo PHP_EOL;

	}

	protected function prepareDir ()
	{
		$dir_path = THE_VAR_DIR_PATH . '/merge-ex0010';

		if (file_exists($dir_path)) {
			return;
		}

		mkdir($dir_path, 0755 ,true);
	}

} // End class Hello
