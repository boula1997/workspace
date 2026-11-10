#!/bin/sh
# Runs once, when the db volume is created. Restores a pg_dump -Fc file if one is present.
# Make it with:  pg_dump -Fc -h localhost -U postgres workspace > docker/initdb/workspace.dump
set -e
DUMP=/docker-entrypoint-initdb.d/workspace.dump
if [ -f "$DUMP" ]; then
  echo "Restoring $DUMP into $POSTGRES_DB"
  pg_restore --no-owner --no-acl -U "$POSTGRES_USER" -d "$POSTGRES_DB" "$DUMP"
else
  echo "No $DUMP found: starting with an empty database"
fi
