#!bin/bash

# GLOBALS
ABSOLUTE_PATH="./breadth/"
ACCESS_MAX_LIMIT="10000"
HTTPD_USER="nobody"
HTTPD_GRP="nobody"

# FUNCTIONS
cd $ABSOLUTE_PATH
echo $ACCESS_MAX_LIMIT | tee *
chown $HTTPD_USER:$HTTPD_GRP *
chmod -f 660 *

