#!/bin/bash

function getConfigVals(){
    php7.0 -f 'callMongo.php'
}


# func1 parameters: a b
result=$(getConfigVals)

#echo $result

OIFS=$IFS
IFS=';'
mails2=$result
for x in $mails2
do
    ./BOT.py "$x"
done

IFS=$OIFS