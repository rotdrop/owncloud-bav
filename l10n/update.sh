#! /bin/bash

perl ./l10n.pl read
msgmerge -vU --previous --backup=numbered de/bav.po  templates/bav.pot
perl ./l10n.pl write

