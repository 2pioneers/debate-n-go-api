#!/bin/sh
rm *.json
mongoexport --db HOA --collection voting_topics --out HOA_voting_topics_backup.json
mongoexport --db HOA --collection users --out HOA_users_backup.json
mongoexport --db HOA --collection messages --out HOA_messages_backup.json
mongoexport --db HOA --collection options --out HOA_options_backup.json
