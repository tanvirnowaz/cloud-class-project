#!/usr/local/bin/perl

use English;
use Carp;
use Getopt::Long;

sub Usage{
    my $message = shift;

    print STDERR $message, "\n" if $message;
    print STDERR "\nUsage: $0 -d(ef) definition_file -i(n) source \n";

    print STDERR <<'EOM';
-d(ef) filename  : Specifies the definition file which is a set of pairs, each corresponding to a "replacement pattern", e.g.,
a A
b B
c C
...
z Z                  
 would replace all lower cases with upper cases

    -h(elp) : display this message
EOM

 exit(1);

}

my ($defFile, $inFile) = @ARGV;


open(D, $defFile) || die "can't open definition file:$opt_def\n";
while (<D>) {
    ($oldp, $newp) = split;
    $dic{$oldp}=$newp;
}

close(D);

$oldStr = "";
$newStr ="";
open(I, $inFile) || die "can't open input file:$opt_in\n";
while (<I>) {
    $oldStr = $_;
    foreach $k (keys %dic) {
        s/$k/$dic{$k}/g;
    }
    $newStr = $_;
    print;
}
