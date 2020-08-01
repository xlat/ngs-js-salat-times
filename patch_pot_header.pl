use Modern::Perl;
use POSIX 'strftime';
#patch_pot_header.pl
my $P_VERSION = '1.3';
open my $F, '<', 'languages\ngs-js-salat-times.pot' or die $!;
my $header = 1;
my @content;
my $now = strftime('%Y-%m-%d %H:%M', localtime) . '+0100';
while(<$F>) {
  chomp;
  if($header) {
    s/SOME DESCRIPTIVE TITLE/NGS JS Salat Times WrodPress Plugin/;
    s/YEAR THE PACKAGE'S COPYRIGHT HOLDER/2020 Nicolas Georges/;
    s/under the same license as the PACKAGE package/under the MIT license/;
    s/FIRST AUTHOR <EMAIL\@ADDRESS>, YEAR/Nicolas Georges <nicolas\@ngs.ma>, 2020/;
    s/PACKAGE VERSION/ngs-js-salat-times $P_VERSION/;
    s/"POT-Creation-Date:.*/"POT-Creation-Date: 2020-06-13 14:50+0100\\n"/;
    s/YEAR-MO-DA HO:MI\+ZONE/$now/;
    s/FULL NAME <EMAIL\@ADDRESS>/Nicolas Georges <nicolas\@ngs.ma>/;
    s/LANGUAGE <LL\@li.org>/Nicolas <nicolas\@ngs.ma>/;
  }
  push @content, $_;
  if(/#: ngs-js-salat-times/) {
    $header = 0;
  }
  # say $_;
}
close $F;

open $F, '>', 'languages\ngs-js-salat-times.pot' or die $!;
say $F $_ for @content;
close $F;
