#!/usr/bin/env python3

# https://docs.python.org/3/library/csv.html
# https://blog.gtwang.org/programming/python-csv-file-reading-and-writing-tutorial/

import csv

def main ():
	input_csv = 'var/input.csv'
	output_csv = 'var/output.csv'

	data_target = []

	with open(input_csv) as input_csv_file:
		cells = csv.reader(input_csv_file)

		for cell in cells:
			# print(cell)

			if cell[3] == '0':
				continue

			data_target.append(cell)

		# print(data_target)


	with open(output_csv, 'w') as output_csv_file:
		writer = csv.writer(output_csv_file)
		writer.writerows(data_target)


if __name__ == '__main__':
	main()
