

default: filter
.PHONY: default


help:
	@echo Usage:

	@echo make
	@echo make help

	@echo make to-csv
	@echo make filter
	@echo make to-ods

	@echo make final-dump-csv
	@echo make final-view-ods
	@echo make final-view-csv

	@echo make clean


.PHONY: help


filter: to-csv
	@./run.sh
.PHONY: filter


to-csv:
	@./to-csv.sh
.PHONY: to-csv


to-ods:
	@./to-ods.sh
.PHONY: to-ods


clean:
	rm -f ./var/*.csv
	rm -f ./var/*.ods
.PHONY: clean


final-view-csv:
	localc ./var/output.csv
.PHONY: final-view-csv


final-view-ods:
	localc ./var/output.ods
.PHONY: final-view-ods


final-dump-csv:
	@cat ./var/output.csv
.PHONY: final-dump-csv
