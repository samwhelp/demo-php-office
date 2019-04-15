#!/usr/bin/env python3

# https://docs.python.org/3/library/csv.html
# https://docs.python.org/3/library/io.html
# https://blog.gtwang.org/programming/python-csv-file-reading-and-writing-tutorial/

import csv

def main ():
	input_csv = 'var/input.csv'
	output_csv = 'var/output.csv'

	data = []

	with open(input_csv) as input_file:
		reader = csv.reader(input_file)

		for row in reader: ## 一列一列巡迴
			# print(row)

			if row[3] == '0': ## 排除第四個欄位是「0」的那一列(row)。第四個欄位指的是「欄位D」。
				continue

			data.append(row) ## 此列沒被排除，所以放到「data」。

		# print(data)


	with open(output_csv, 'w') as output_file:
		writer = csv.writer(output_file)
		writer.writerows(data) ## 將「data」寫到「output.csv」。


if __name__ == '__main__':
	main()
