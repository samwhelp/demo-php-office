<?php

namespace Demo\Merge;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Calculation\Calculation;

class Ex0020 {

	public function run ()
	{
		//var_dump(__METHOD__);

		$this->prepareDir();




////////////////////////////////////////////////////////////////////////////////
//
		// 載入「asset/merge/merge/1.ods」
		// https://github.com/PHPOffice/PhpSpreadsheet/blob/master/samples/Reader/01_Simple_file_reader_using_IOFactory.php
		$file_path_1 = THE_ASSET_DIR_PATH . '/merge/1.ods';

		// https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/IOFactory.html#method_load
		// https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/Spreadsheet.html
		$spreadsheet_1 = IOFactory::load($file_path_1);


		// https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/Spreadsheet.html#method_getActiveSheet
		// https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/Worksheet/Worksheet.html#method_toArray
		$data_1 = $spreadsheet_1->getActiveSheet()->toArray(null, true, true, true);
		//var_dump($data_1);
//
////////////////////////////////////////////////////////////////////////////////




////////////////////////////////////////////////////////////////////////////////
//
		// 載入「asset/merge/merge/2.ods」
		// https://github.com/PHPOffice/PhpSpreadsheet/blob/master/samples/Reader/01_Simple_file_reader_using_IOFactory.php
		$file_path_2 =  THE_ASSET_DIR_PATH . '/merge/2.ods';

		$spreadsheet_2 = IOFactory::load($file_path_2);

		$data_2 = $spreadsheet_2->getActiveSheet()->toArray(null, true, true, true);
		//var_dump($data_2);
//
////////////////////////////////////////////////////////////////////////////////




////////////////////////////////////////////////////////////////////////////////
//
		// 載入「asset/merge/merge/3.ods」
		// https://github.com/PHPOffice/PhpSpreadsheet/blob/master/samples/Reader/01_Simple_file_reader_using_IOFactory.php
		$file_path_3 =  THE_ASSET_DIR_PATH . '/merge/3.ods';

		$spreadsheet_3 = IOFactory::load($file_path_3);

		//var_dump($spreadsheet_3->getActiveSheet()->getCell('C3')->getValue());

		$data_3 = $spreadsheet_3->getActiveSheet()->toArray(null, true, true, true);
		//var_dump($data_3);
//
////////////////////////////////////////////////////////////////////////////////




////////////////////////////////////////////////////////////////////////////////
//

		/*
			1.ods

			A, B

		1	x, y
		2	1, 2
		3	3, 4

		*/

		/*
			2.ods

			A, B

		1	x, y
		2	5, 6
		3	7, 8

		*/

		/*
			3.ods

			A, B, C

		1	x, y, sum
		2	 ,  , =SUM(A2:B2)
		3	 ,  , =SUM(A3:B3)

		*/

		/*
			final.ods

			A, B, C

		1	x, y, sum
		2	6, 8, =SUM(A2:B2)
		3	10, 12, =SUM(A3:B3)

		*/

		/*
			final.ods - Calculated

			A, B, C

		1	x, y, sum
		2	6, 8, 14
		3	10, 12, 22

		*/


		/*
			原本「3.ods」的「C2」是「=SUM(A2:B2)」
			原本「3.ods」的「C3」是「=SUM(A3:B3)」
			這個範例
			會將「1.ods」的「A2」「A3」「B2」「B3」的值,
			來和「2.ods」的「A2」「A3」「B2」「B3」的值相加,
			填到「3.ods」的「A2」「A3」「B2」「B3」，
			然後另存到「var/merge-ex0020/final.ods」這個檔案。
		*/

		foreach ($data_3 as $row_index_3 => $row_3) {

			if ($row_index_3 == 1) { // 不處理第一列
				continue;
			}

			foreach ($row_3 as $col_index_3 => $col_3) {

				if ($col_index_3 == 'C') { // 不處理第三欄
					continue;
				}

				$cell_name = $col_index_3 . $row_index_3;
				//var_dump($cell_name);

				//$new_val = '1';
				$new_val = $data_1[$row_index_3][$col_index_3];
				$new_val += $data_2[$row_index_3][$col_index_3];

				// https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/Worksheet/Worksheet.html#method_setCellValue
				$spreadsheet_3->getActiveSheet()->setCellValue($cell_name, $new_val);

			}
		}
//
////////////////////////////////////////////////////////////////////////////////




////////////////////////////////////////////////////////////////////////////////
//
		// 這裡要將「Cache」清除，這樣最後寫入的時候，「C2」和「C3」才會是正確的值。
		// https://phpspreadsheet.readthedocs.io/en/latest/topics/calculation-engine/#calculation-cache
		//Calculation::getInstance($spreadsheet_3)->disableCalculationCache();
		Calculation::getInstance($spreadsheet_3)->clearCalculationCache();

		// https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/Calculation/Calculation.html#method_getInstance

//
////////////////////////////////////////////////////////////////////////////////




////////////////////////////////////////////////////////////////////////////////
//
		// 另存新檔到「var/merge-ex0010/final.ods」。
		$file_path_final = THE_VAR_DIR_PATH . '/merge-ex0020/final.ods';

		// https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/IOFactory.html#method_createWriter
		$writer = IOFactory::createWriter($spreadsheet_3, 'Ods');

		// https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/Writer/IWriter.html#method_save
		$writer->save($file_path_final);
//
////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////
//
		// 完成後，顯示提示訊息
		echo 'Merge_file_1: ' . $file_path_1;
		echo PHP_EOL;

		echo 'Merge_file_2: ' . $file_path_2;
		echo PHP_EOL;

		echo 'Merge_file_3: ' . $file_path_3;
		echo PHP_EOL;

		echo 'Merge_final: ' . $file_path_final;
		echo PHP_EOL;

		echo 'Open_final, Please run: ';
		echo PHP_EOL;

		echo '$ localc '. $file_path_final;
		echo PHP_EOL;
//
////////////////////////////////////////////////////////////////////////////////

	}

	protected function prepareDir ()
	{
		$dir_path = THE_VAR_DIR_PATH . '/merge-ex0020';

		if (file_exists($dir_path)) {
			return;
		}

		mkdir($dir_path, 0755 ,true);
	}

} // End class Ex0020
