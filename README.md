# GenericCRUD
This is a super simple,highly insecure, CRUD writted in php with ChatGPT, I'ts working on any mysql-based db


I fixed the basis for make it work but it still super-insecure and probably bugged
Still! I find it really convenient for simpel thing. It's like a micro phpmyadmin!

## How to use it
Just edit the config.inc.php according to your db data

In the same you need to create a simple table called genericcrud_users with this schema:

```sql
CREATE TABLE `genericcrud_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

