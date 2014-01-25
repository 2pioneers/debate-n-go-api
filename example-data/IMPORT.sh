#!/bin/sh
mongoimport --db HOA --collection voting_topics --file HOA_voting_topics_backup.json
mongoimport --db HOA --collection users --file HOA_users_backup.json
mongoimport --db HOA --collection messages --file HOA_messages_backup.json
mongoimport --db HOA --collection options --file HOA_options_backup.json
