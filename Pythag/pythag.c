/* pythag.exe 
   Created by: JoshR 
   Edited By Zanith 

   Copyright [2009] [Ben M. Fowler]

   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at

     http://www.apache.org/licenses/LICENSE-2.0

   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.

*/


/* #include <string> 
   This header is made redundant */
#include <stdio.h> 
#include <math.h> 

/* A neat trick if you program for different systems
   Its a preprocessor macro, since you're new to c++ I'll not go into much detail.
   Basically it checks for a system constant, and if it exists in the form of linux or win32
   It will define the appropriate constant, you can use this later on in your program. */

#ifdef _WIN32
  #define SYS "Windows"
#endif
#ifdef linux
  #define SYS "Linux"
#endif

char side, back; 
float s[2], hyp;

/*  Since both are only a single char, I see no reason to use the string type.
    Double is only four decimal places more than a float, yet it uses twice the amount of memory as float would use.
    Also, I would personally use an array for this. */
int main() 
{ 
back='n';
do  // Using a do while, so it evaluates once and then will check if you've changed the value of of 'back'
 {
    if (SYS=="Windows") // Check, if its windows?
    {
      system("cls"); // Use the Windows clear function
    }
    else  // Presume its Linux
    {
      system("clear");  //Use the Linux clear function
    }
    
    printf("%s", "\n\tPythagoras\'s Theorum!\n\nWhich side are you solving for\?\n"); // Keep the heading text onto one line (Added tab spaces just to make it look better
    printf("%s", "H/B/C (H= Hypotenuse, B and C are either cathetus)\n");   // Since only a single character is entered, ask for a single character, and explain what they are
    scanf( "%s", &side ); // scanf is similer to cin, but as printf, it is more powerful
    if ( toupper(side) == 'H' )   //Make sure the value entered is Upper case
    { 
      printf("%s", "What is side B\?\n"); 
      scanf( "%f", &s[1]);
      printf("%s", "What is side C\?\n"); 
      scanf( "%f", &s[2]);
      if (isdigit(s[1]) || isdigit(s[2]) == 0) { // Make sure either value is a number
        printf("%s", "An error has occured and breaking\n"); 
        break;  // Breaks out of the application
      }
      hyp = sqrt ((s[1]*s[1])+(s[2]*s[2])); //Fixed your math issue, remember the operator order.  And don't worry about excessive brackets.
      printf("The hypotenuse is %6f in length.", hyp);  // %6f means a float correct to six decimal places.
    }
    else
    {
      printf("%s", "What is the hypotenuse\?\n");
      scanf( "%f", &hyp);
      printf("%s", "What is your other side\?\n");
      scanf( "%f", &s[2]);
      if (isdigit(hyp) || isdigit(s[2]) == 0) {
        printf("%s", "An error has occured and breaking\n"); 
        break;
      }
      s[1] = sqrt ((hyp*hyp)-(s[2]*s[2])); 
      printf("The missing side is %6f in length.", s[1]); 
    }
    printf("%s", "\nRestart\? Y/N\n");
    scanf("%s", &back);
    }
while ( 'Y' == toupper(back) );
/* The & before many of the variable names means 'addressof'
   It directs the input to be stored in that variable name which procedes it
   To find out more, just do some digging about pointers and C */
return 0;
} 
