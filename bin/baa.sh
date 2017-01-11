#!/bin/sh

function mybake() {
    echo "  bake start ${1}";
    bin/cake bake all -f ${1} -t Orgbake;
    echo "       done";
}

#mybake 'sts'
mybake 'temps'
