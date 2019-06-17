###Set up steps:
1. ```docker-compose run --rm backend composer install```
2. ```docker-compose run --rm backend /app/init --env=Development --overwrite=All```
3. ```docker-compose run --rm backend yii migrate```

###Run project with:
```docker-compose up -d```

###Access project
[Frontend](http://127.0.0.1:20080) and [API](http://127.0.0.1:21080)
