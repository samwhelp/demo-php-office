

default: merge
.PHONY: default


help:
	@echo Usage:

	@echo make
	@echo make help

	@echo make to-csv
	@echo make merge

	@echo make final-dump-csv
	@echo make final-view-ods
	@echo make final-view-csv

	@echo make clean


.PHONY: help


merge: to-csv
	@./merge.sh
.PHONY: merge


to-csv:
	@./to-csv.sh
.PHONY: to-csv


clean:
	rm -f *.csv
	rm -f final.ods
.PHONY: clean


final-view-csv:
	localc ./final.csv
.PHONY: final-view-csv


final-view-ods:
	localc ./final.ods
.PHONY: final-view-ods


final-dump-csv:
	cat ./final.csv
.PHONY: final-dump-csv
