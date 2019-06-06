#!/bin/bash

echo "Waiting for other services";

sleep 15;

composer init-project;
php bin/console messenger:consume-messages amqp;