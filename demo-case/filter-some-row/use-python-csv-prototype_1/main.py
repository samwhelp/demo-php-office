#!/usr/bin/env python3


# https://docs.python.org/3/library/csv.html
# https://docs.python.org/3/library/io.html
# https://blog.gtwang.org/programming/python-csv-file-reading-and-writing-tutorial/

import csv

def main ():
	input_csv = 'var/input.csv'
	output_csv = 'var/output.csv'


	input_file = open(input_csv)
	reader = csv.reader(input_file)

	output_file = open(output_csv, 'w')
	writer = csv.writer(output_file)


	for row in reader: ## 一列一列地巡迴
		# print(row)

		if row[3] == '0': ## 排除第四個欄位是「0」的那一列(row)。第四個欄位指的是「欄位D」。
			continue

		writer.writerow(row) ## 此列沒被排除，所以寫入「output.csv」。

	input_file.close()
	output_file.close()

if __name__ == '__main__':
	main()
