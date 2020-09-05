# LAMP Stack - Docker Container

# Project work

http://localhost:9090/

# PhpMyAdmin

http://localhost:9091/


# MySql RECOVER (restore a database from a file)

**Backup your mysql Database once and a while.**
1. Navigate to http://localhost:9091/
2. On the left click New
3. For the *Database name type: TestDataBase*
4. Click Create
5. At the top, click Import.
6. Chose File
7. Navigate to the TestDataBase.sql file.
8. Click "Go"

This is how to successfully restore a database

# MySql DESTROY (start your database from scratch)

Data for my sql is stored in the .mysql-data folder. Do not delete this folder or the contents of this folder.
Also, you might not want to push this folder to github, and that is why there is a .gitignore file. You might want 
to share the database with team members, so use the Export functionality in PhpMyAdmin to export sql files which
represents your entire database.

If you want to start will a completely empty database **Make sure you backup your sql database in phpmyadmin**

Then, in VSCode:

1. click on "Remote Explorer"
2. click "Other Containers" 
3. right click "VSCodeLampStackDocker_devcontainer (/VSCodeLampStackDocker_devcontainer_mysql-server_1)"
4. click "Remove Container"s

Now you can Ctrl Shift P, and Rebuild Container.  You will have a completely fresh mysql server running.
Don't forget to *Create the Database name* again in phpmyadmin first, when you are ready to restore from a sql file
