# SNARTO

### Instalacja:

##### 1. Uruchom dockera:

Z folderu źródłowego

```
docker-compose up -d
```

##### 2. Połącz się z terimalem kontenera.

Z folderu źródłowego

```
docker exec -it php bash
```

##### 3. Instalacja backendu:

Z folderu źródłowego kontenera

```
composer install
```

##### 4. Uruchom migracje bazy danych.

Z folderu źródłowego kontenera

```
bin/console doctrine:migrations:migrate
```

##### 5. Uruchomienie testów:

Z folderu źródłowego kontenera

```
php bin/phpunit
```

### API

#### Dodawanie firmy (POST do http://localhost:8080/api/regon)

```
Body: {"regon": "070569406"}
```

#### Wszytkie firmy (GET do http://localhost:8080/api/regon)
