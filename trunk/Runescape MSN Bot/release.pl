#   Copyright [2009] [Ben M. Fowler]
#
#   Licensed under the Apache License, Version 2.0 (the "License");
#   you may not use this file except in compliance with the License.
#   You may obtain a copy of the License at
#
#     http://www.apache.org/licenses/LICENSE-2.0
#
#   Unless required by applicable law or agreed to in writing, software
#   distributed under the License is distributed on an "AS IS" BASIS,
#   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
#   See the License for the specific language governing permissions and
#   limitations under the License.

use strict;
use warnings;

use Net::MSN;
use IO::Select;
use POSIX;
use LWP::Simple; 
use Switch;
use Data::Dumper;

my $msnpass = 'password'; #Your bot's MSN Password
my $msnemail = 'msnbot@email.com'; #Your bot's email login
my $LogFile = 'MSNLOG.log'; #Where to log
my $screenname = 'MSNBOT'; #Whatever screename you want to have your bot to have

#A hash containing the emails of your bot admins
my %admin = (
  'benmfowler@gmail.com' => 1,
  'anotheradmin@email.com' => 1
);

my $client = new Net::MSN(
  Debug           =>  1,
  Debug_Lvl       =>  3,
  Debug_STDERR    =>  1,
  #Debug_LogCaller =>  1,
  #Debug_LogTime   =>  1,
  #Debug_LogLvl    =>  1,
  #Debug_Log       =>  $LogFile,
  ScreenName      => 'MSN Bot'
);

$client->set_event(
  on_connect => \&on_connect,
  on_status  => \&on_status,
  on_answer  => \&on_answer,
  on_message => \&on_message,
  on_join    => \&on_join,
  on_bye     => \&on_bye,
  auth_add   => \&auth_add
);

$client->connect($msnemail, $msnpass, $screenname);


while (1) {
  $client->check_event();
}

sub on_connect {
  $client->{_Log}("Connected to MSN @ ". $client->{_Host}. ':'. 
    $client->{Port}. ' as: '. $client->{ScreenName}. 
    ' ('. $client->{Handle}. ")", 3);
}

sub auth_add {
  my ($chandle, $friendly) = @_;

  $client->{_Log}('recieved authorisation request to add '. $chandle. ' ('.
    $friendly. ')', 3);

  return 1;
}

sub on_answer {
  my $sb = shift;
  #print "Answer() called with parameters:\n";
  #print "   " . join(", ", @_), "\n";
}

sub on_message {
  my ($sb, $chandle, $friendly, $message) = @_;

########  Get stats
  if ($message =~ /^stats/i) {
    my $user = trim((split(/^stats/i, $message))[1]);
    $user =~ tr/ /_/;
    if (length(trim($user)) <= 12 && !(trim($user) =~ /\W/)) {
      $sb->sendmsg('Please Wait...');
      $sb->sendmsg(get_stats(trim($user)));
    } else {
      $sb->sendmsg('Error, RuneScape Usernames are smaller than 12 characters and are not to contain special characters.');
    }
#######  Add User Command
  } elsif ($message =~ /^addu/i) {
    if ($admin{$chandle} == 1) {
      my $cnt = (split(/^addu/i, $message))[1];
      $client->buddyadd($sb, trim($cnt), 'test');
    } else {
      $sb->sendmsg('You need to be an admin to use that command');
    }
####### Client Restart
  } elsif ($message =~ /^restart/i) {
    if ($admin{$chandle} == 1) {
      exec('perl test.pl');
      die 'Restarting Client';
    } else {
        $sb->sendmsg('You need to be an admin to use that command');
    }
  }
}


sub get_stats {
  my $user = "@_";
  #print "@_\n";
  my $hsserver = "http://hiscore.runescape.com/index_lite.ws?player=$user";
  my (@skills, @skill, @reply, $line); 
  my $response = get $hsserver;
  @reply = split(/\n/, $response); 
  my $c = 0; 
  foreach $line (@reply) { 
    @skill = split(/,/, $line); 
    push(@skills, $skill[0]); 
    push(@skills, $skill[1]); 
    push(@skills, $skill[2]); 
  } 
  foreach $line (@skills) { 
    if($line=="-1") { 
      $line="Not Ranked"; 
    } 
  }
  return "Stats for $user - Overall Rank $skills[0] \r\n LEVELS ~ Overall: $skills[1] - Atk: $skills[4] - Def: $skills[7] - Str: $skills[10] - HP: $skills[13] - Range: $skills[16] - Pray: $skills[19] - Mage: $skills[22] - Cook: $skills[25] - WC: $skills[28] - Fletch: $skills[31] - Fish: $skills[34] - FM: $skills[37] - Craft: $skills[40] - Smith: $skills[43] - Mine: $skills[46] - Herb: $skills[49] - Agil: $skills[52] - Thief: $skills[55] - Slay: $skills[58] - Farm: $skills[61] - RC: $skills[64] - Hunt: $skills[67] - Cons: $skills[70] - Summon: $skills[73]";
}

sub on_bye {
  my ($chandle) = @_;

  $client->{_Log}($chandle. " has left the conversation (switch board)", 3);  
}

sub add_user {
  my $user = "@_";
}

sub trim($) { 
  my $string = shift; 
  $string =~ s/^\s+//; 
  $string =~ s/\s+$//; 
  return $string; 
}
