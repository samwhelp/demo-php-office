#!/usr/bin/env bash

if [ -f "$HOME/bin/composer" ]; then
	echo "File exists:" "$HOME/bin/composer"
	echo "Please remove it first! Just run:"
	echo '$ rm ~/bin/composer'
	exit 1;
fi


mkdir -p "$HOME/bin"

wget -c 'https://getcomposer.org/composer.phar' -O "$HOME/bin/composer"

chmod u+x "$HOME/bin/composer"

"$HOME/bin/composer" self-update
