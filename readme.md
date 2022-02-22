# dev reqs
1. symfony.phar
2. mysql, php>7.2
3. supervisorctl for symfony messenger install-supervisor.sh, Makefile-suprevisor


# start without docker
1. run local database
2. create users and schemas as in the `my-init.sql`
3. `cd ./api && symfony local:server:start --port=8081 -d`
4. `cd ./fakesms && symfony local:server:start --port=8082 -d`
5. create schemas `cd ./api && symfony console doctrine:schema:create` 
6. make migrations `cd ./fakesms && symfony console doctrine:migrations:migrate`
7. run local rabbitmq
8. `cd ./api && symfony console messenger:setup-transports`
9. `cd ./fakesms && symfony console messenger:setup-transports && symfony console messenger:consume async -vv`


# start with docker
3. install containers
4. up containers
5. login to the mysql container and create databases (see run above)
7. adapt the settings in `.env.local` with ports
6. login to the every php container and run 
   1. create schemas `cd ./app && php ./bin/console doctrine:schema:create`
   2. make migrations `cd ./app && php ./bin/console doctrine:migrations:migrate`
   3. `cd ./app && php ./bin/console messenger:setup-transports`
   4. `cd ./app && php ./bin/console messenger:setup-transports && symfony console messenger:consume async -vv`

# comments
1. test are partially ready for the code confirmation and only in the for front API app.
