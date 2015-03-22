#How to install and configure MWG via cpanel


## Requirements ##

  1. Web hosting server: Please note: MWG supports suPHP/phpsuexec. If your host runs php in another manner, you may have permissions issues.
  1. “cPanel”, a third party software to manage your server files and MySQL database.
  1. “Djinnstaller”, an Intellispire product extension: http://network.intellispire.com/mwg/mwginstaller.php.zip


## Procedure ##

  1. Download Djinstaller for MWG from this link: http://marketingwebsitegenerator.com/club/login.php
  1. Enter your name and email on the sign up module provided, and you should be able to download the installer "mwg-1.1.0.zip"
  1. Before you upload the zipped file to your server, its best to create a directory on your server for the Marketing Website Generator you are going to create, and set-up MySQL database while you’re at it.
    * On your browser, type the link where your cPanel is located, and Log-on to it.
    * Go to “File Manager” > select “Web Root” radio button > Go
    * Click on the folder “home” > select “public\_html” ( This is where all the action takes place)

> Note: You may already have files and folders existing on the public\_html directory from other website you have, so it is important you create a MWG folder (or name whatever you prefer) as a place holder for your installation files.

  * Go back to cPanel, click on “MySQL”, then create a name of the database (eg. mwg). Take note that when you create a database name, cPanel always appends your unique identifier before the DB name you created, so it should become like “identifier\_mwg”, and that will be your actual database name.

  * Moving on, create a user name, and password for your database. Take note again that the username you created was appended automatically with your unique identifier, for this example the actual username will be “identifier\_username”.

  * Next is to “Add User to Database”. Select Username you created on “User” drop down menu, select also database name you created on “Database” drop down menu, then click “Add”.

  * Then check “All Privilages” radio button to grant all privileges to your admin account.

> At this point, your database and web directory should be ready.

  1. Go back to "home" of your cPanel, click on File manager > public\_html > then select directory, in this example its "mwg"
  1. Click "upload", browse from your hard drive and look for "mwg-1.1.0.zip"
  1. Once done, check the file and click "extract" on your cPanel.
  1. On your browser, type the link where your installer is located (eg: www.yourdomain/mwg/).
  1. Read the instruction indicated, and just click on “Next"
  1. On this page you have to input DB username, the one you have created previously. Take note of the actual appended user name, in this case should be “identifier\_username”.
  1. Enter the DB password you created.
  1. Enter DB host, and 99% of the time indicate “localhost”.
  1. Enter DB name: in our example its “identifier\_mwg”
  1. When all boxes filled, click next
  1. On this page an instruction to delete the "install" folder in your server. Go to your cPanel, click file manager > directory where your MWG files reside (eg. /public\_html/mwg ), then check "install" folder and delete that.
  1. You can now log-in at the administrator page (page on item# 13), and you should see the backend of your new MWG website.
  1. Do some post install/Crons set-up for your site. On cPanel/File manager, CHMOD tempates & verify folder set from 777 to 644 for security purpose. There is a key icon on top to do just that.
  1. Set Cron jobs. What cron jobs will do is to automate some of your email & autoresponder settings within the MWG.
  1. Log back in your cPanel/home, find cron job icon and select that.

  * Three items you need to set cron and you can find it in your admin sub directory: "cron\_expand.php", "cron\_expand\_followups.php", and "cron\_send.php"


# Setup the Cron #
Most hosting companies have good videos on setting up "cron", or timed processes.
This is what you need to know.

```
0    0 * * * php /PATH/TO/SITE/admin/cron.oto.bck.php
*/5  * * * * php /PATH/TO/SITE/admin/cron_send.php
0   12 * * * php /PATH/TO/SITE/admin/cron_expand_followups.php
*/10 * * * * php /PATH/TO/SITE/admin/cron_expand.php
```

Note that cron\_send.php sends up to 1,500 emails ever time it's run, so if you
leave it to run every 5 minutes (as suggested), you'll send about 30,000 per hour,
which is the limit of most small servers.

It is possible to choke the amount of email by tweaking these settings.

That is a setting we plan to enable you to change in a future release.