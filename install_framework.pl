#!/usr/bin/perl -w
use strict;

#This script installs testframework on the remote hos 


my ($username,$testhost,$testframeworkRootPath)=@ARGV;

my $cmd="(/bin/sh -c 'cd $testframeworkRootPath && tar -cf - *') | (ssh -i $testframeworkRootPath/credential/tanvir-west.pem $username\@$testhost 'mkdir testframework && cd testframework && tar xf -')";
my $out= system($cmd);
