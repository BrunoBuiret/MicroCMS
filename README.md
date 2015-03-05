MicroCMS
========
In order to work properly, you have to define a virtual host. Here's an example of
what can be used with an Apache server.

```apache
# MicroCMS
Listen 15000
    
<VirtualHost *:15000>
    ServerName localhost:15000
    DocumentRoot "D:/Web/MicroCMS/web"
        
    <Directory "D:/Web/MicroCMS/web">
        Options Indexes FollowSymLinks
        AllowOverride all
    </Directory>
</VirtualHost>
```

The database structure can be found in `db/` repertory.

1. db/database.sql
2. db/schema.sql
3. db/content.sql
