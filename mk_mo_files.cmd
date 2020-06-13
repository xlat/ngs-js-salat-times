@perl -E"qx[d:\\apps\\Poedit\\GettextTools\\bin\\msgfmt.exe -cv -o $_.mo $_.po] for map{ s/\.po$//r } <languages/*.po>"
