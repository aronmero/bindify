Este proyecto utiliza PHP con Laravel.

Primero utilizar composer para instalar los paquetes necesarios

```bash
composer install
```

**Cambiar el .env seleccionando las credenciales de la base de datos que utilice.**  

Para introducir datos en la base de datos utilizar el comando:

```bash
php artisan migrate:fresh --seed
```

Por ultimo para poner en marcha el servicio utilizar el comando:

```bash
php artisan serve
```

