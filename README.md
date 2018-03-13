# Vapaa-ajan sivu
www-ohjelmoinnin työ

Oskar Stucki

This project is for a multifunctional website where a user can 
play games, add notes or take a look at the weather. The content is personalized
for the user as information is stored to the database. Sites header changes to reassemble users 
name. The site can be used with smaller devices ames it scales.
For memcached to start in cloud9 run bash command: "sudo service memcached restart"

The project has multiple files that are stored in folders:
assets, css, oldFiles, phpserver, scripts and the main folder.

Assets:
   - Here we have the pictures and graphics for the game and the site.
   - There are couple extra files for future extensions.

css:
   - In the folder the files are differentiated in different files as it 
   is much easier to locate mistakes and develop the css.
   - Shoud be compiled together when the site launces for speed
   
oldFiles:
   - some legacy files if needed. Not important.
   
phpserver:
   - Most of the files are used to communicate with the server. Some
   are used as functions.
   
scripts:
   - Different javascript functions. Mainly jquery functions, fb login and phaser file. 
   -Unfortunately fb-login doesn't work on cloud9 because the url cannot be appended to fb database. But it is
   implemented.
   
main folder:
   - The site files that are showed to the user. User must not access the other files. 
   
       
