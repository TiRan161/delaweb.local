1. Поднять localhost
2. БД Mysql
3. Заполнить DATABASE_URL в .env
4. Создать базу данных php bin/console doctrine:database:create
5. Накатить миграции php bin/console do:mi:mi
6. Роуты:
- /user/registration - Окно регистрации. Доступ только не авторизованным 
- /login    - Окно авторизации. Доступен только не авторизованным
- /user/profile - Окно профиля. Доступ только для авторизованных
- /logout - Логаут
