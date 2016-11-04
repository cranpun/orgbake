#!/bin/sh

if type sudo > /dev/null 2>&1; then
    SD=sudo
fi

function mybake() {
    echo "  bake start ${1}";
    $sd bin/cake bake all -f ${1} -t Orgbake;
    echo "       done";
}

mybake 'sts'
mybake 'comments'
