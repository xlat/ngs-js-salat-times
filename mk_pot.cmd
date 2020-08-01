%~d0
cd "%~dp0"

d:\apps\Poedit\GettextTools\bin\xgettext.exe ^
  -k__ -k_e ^
  -o languages\ngs-js-salat-times.pot ^
  --from-code=utf-8 ^
  --add-comments="translators:" ^
  -j ^
  ngs-js-salat-times.php

::patch POT header file
@perl patch_pot_header.pl

::then upgrade .po files
@perl -E"qx[d:\\apps\\Poedit\\GettextTools\\bin\\msgmerge.exe -o \"$_\" \"$_\" \"languages/ngs-js-salat-times.pot\"] for <languages/*.po>"