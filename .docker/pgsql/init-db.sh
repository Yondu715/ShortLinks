#!/bin/bash
set -e

# Cоздания базы и пользователя
psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<-EOSQL
    CREATE USER "$CUSTOM_USER" WITH PASSWORD '$CUSTOM_PASS' LOGIN;
    CREATE DATABASE "$CUSTOM_DB" OWNER "$CUSTOM_USER"; 
EOSQL