#!/bin/bash

function getConfigVals(){
    php7.0 -f 'callMongo.php'
}


# func1 parameters: a b
result=$(getConfigVals)


INDEX=0
OIFS=$IFS
IFS=';'
mails2=$result

for y in $mails2

do
    #echo ${INDEX}
    let INDEX=${INDEX}+1
    #./BOT.py "$x"
done

INDEX1=0
for x in $mails2

do
    let INDEX1=${INDEX1}+1
    #let INDEX=${INDEX}+1
    if [ "$INDEX" -le "$INDEX1" ];then
    #echo $INDEX1
    #echo "Para";
        ./BOT.py "$x" "S"
    else :
        #echo $INDEX1
        #echo $INDEX
        #echo "Sigue";
        ./BOT.py "$x" "N"
    fi
done

IFS=$OIFS