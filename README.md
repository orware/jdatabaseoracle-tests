# jdatabaseoracle-tests
A collection of tests that can be run against the HR schema built-in to the free Oracle Express Edition 11g

### Oracle Express Edition 11g Release 2 Download Page

The setup for this can be found here:
* http://www.oracle.com/technetwork/database/database-technologies/express-edition/downloads/index.html

After installing it (I grabbed the 64-bit version and I was able to connect to it just fine from XAMPP and the 32-bit version of the Oracle Instant Client I have intalled) you will need to make sure and enable the HR schema.

In my case I set the SYS/SYSTEM accounts to use a password of 1234 during the installation process, but I knew it also came with a default schema that could be used for testing, and this is the HR one.

To unlock the HR schema simply go here and follow these quick steps:

* https://docs.oracle.com/cd/E17781_01/admin.112/e18585/toc.htm#XEGSG121

You may also choose to install SQL Developer (if you'd like to also run queries directly against the database).

In SQL Developer, after unlocking the HR schema I added it in as a connection using this info (I set the password for the HR schema during the unlock steps above):

* Connection Name: HRTEST
* Username: HR
* Password: 1234
* Connection Type: Basic
* Hostname: localhost
* Port: 1521
* SID: xe

Once connected to the HR schema you can expand the Tables area on the left-hand side to see the tables that come included. You can right-click on this Tables section to refresh the list manually (which might be needed during these tests when tables get created).

### Joomla Testing

The index file here is meant to be used as a temporary replacement for the templates/protostar index.php file that way you can simply open up your Joomla site and see the results collected at the bottom of your screen.
