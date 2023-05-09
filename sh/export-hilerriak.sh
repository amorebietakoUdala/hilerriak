#!/bin/bash

MOUNTPATH=/media/hilerriak
SCPATH=/var/www/SF5/hilerriak/sh
# mount -l "$MOUNTPATH"

cd "$SCPATH"
cp "$MOUNTPATH/Cementerio_Etxano.mdb" "$SCPATH/hilerriak.mdb"
cp "$MOUNTPATH/Cementerio_Leginetxe.mdb" "$SCPATH/hilerriak2.mdb"

# umount "$MOUNTPATH"
# Hay que quitar las constraints de los Ids, porque los ids de las adjudicaciones se repiten
#mdb-schema "$SCPATH/hilerriak.mdb" mysql > "$SCPATH/hilerriak-schema.sql"

#rm "$SCPATH/export-hilerriak.mdb.sql.gz"
# rm "$SCPATH/export-hilerriak.mdb.sql"
# rm "$SCPATH/truncate-hilerriak.mdb.sql"

#rm "$SCPATH/export-hilerriak2.mdb.sql.gz"
# rm "$SCPATH/export-hilerriak2.mdb.sql"
# rm "$SCPATH/truncate-hilerriak2.mdb.sql"

printf "Exporting tables:\n"
#for database in *.mdb
# for database in *.mdb
# do
# 	printf "$database\n"
# 	tables=`mdb-tables $SCPATH/$database`
# 	for i in $tables
# 	do
# 		printf " - $i\n"
# 		echo 'TRUNCATE TABLE '$i';' >> $SCPATH/truncate-$database.sql
# 		mdb-export -I mysql -D "%Y-%m-%d" -T "%Y-%m-%d %H:%M:%S" $SCPATH/$database $i >> $SCPATH/export-$database.sql
# 	done
# done

printf "Truncate tables and create schema\n"
mysql --defaults-extra-file=$SCPATH/export-hilerriak.cnf hilerriak < $SCPATH/hilerriak-schema.sql
mysql --defaults-extra-file=$SCPATH/export-hilerriak.cnf hilerriak < $SCPATH/truncate-hilerriak-mysql.sql


# printf "Truncate tables:\n"
#mysql --defaults-extra-file=$SCPATH/export-hilerriak.cnf hilerriak < $SCPATH/hilerriak-schema.sql
mysql --defaults-extra-file=$SCPATH/export-hilerriak.cnf hilerriak < $SCPATH/truncate-hilerriak.mdb.sql
mysql --defaults-extra-file=$SCPATH/export-hilerriak.cnf hilerriak < $SCPATH/truncate-hilerriak2.mdb.sql
printf "Importing tables:\n"
mysql --defaults-extra-file=$SCPATH/export-hilerriak.cnf hilerriak < $SCPATH/export-hilerriak.mdb.sql
mysql --defaults-extra-file=$SCPATH/export-hilerriak.cnf hilerriak < $SCPATH/export-hilerriak2.mdb.sql

#mysql --defaults-extra-file=$SCPATH/export-hilerriak.cnf hilerriak < $SCPATH/export-hilerriak2.mdb.sql
# for database in *.mdb
# do
# 	printf "$database\n"
# 	mysql --defaults-extra-file=$SCPATH/export-hilerriak.cnf hilerriak < $SCPATH/export-$database.sql
# done

printf "Initialize mysql tables:\n"
mysql --defaults-extra-file=$SCPATH/export-hilerriak.cnf hilerriak < $SCPATH/initialization.sql

printf "Adapting:\n"
mysql --defaults-extra-file=$SCPATH/export-hilerriak.cnf hilerriak < $SCPATH/adaptation.sql

# FILESIZE=$(( $( stat -c '%s' "$SCPATH/export-hilerriak.sql" ) / 1024 / 1024 ))
# printf "export-hilerriak.sql (Normalean 270 MB): $FILESIZE MB\n"

# gzip $SCPATH/export-hilerriak.sql
# FILESIZE=$(( $( stat -c '%s' "$SCPATH/export-hilerriak.sql.gz" ) / 1024 / 1024 ))
# printf "export-hilerriak.sql.gz (Normalean 12 MB): $FILESIZE MB\n"

printf "\nTHE END\n"
# umount "$MOUNTPATH"