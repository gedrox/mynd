#Installation of web gallery Mynd

# Database #

Database must be built. Run the SQL files in database directory.
The MySQL is recommended.

# Web #

The webroot directory should be set as directory root in Apache. Default .htaccess file assumes you are running gallery on http://localhost/mynd/ alias.

PHP should have extensions exif, pdo, pdo\_mysql, mbstring enabled.

Apache mod\_rewrite module is used.