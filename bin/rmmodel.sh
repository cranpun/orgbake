#!/bin/sh

#echo -n "Big Plural : "
#read bigplural
#echo -n "Big Singular : "
#read bigsingular

sd=

if test $# -lt 2 
then
    echo "usage: rmmodel.sh [BigPlural] [SingularPlural]"
    exit 1
fi

if test $# -gt 3
then
    echo "usage: rmmodel.sh [BigPlural] [SingularPlural]"
    exit 1
fi

if test $# -eq 2
then
    echo "delete BigPlural:${1} BigSingular:${2}? y / n"
    read confirm
    if test ${confirm} != "y"
    then 
        echo "cancel delete"
        exit 1
    fi
fi
if test $# -eq 3
then
    if test ${3} != "y"
    then
        echo "usage: rmmodel.sh [BigPlural] [SingularPlural] [y *]"
        exit 1
    fi
fi

echo "start delete BigPlural:${1} BigSingular:${2}"
echo " -- delete model/entity"
$sd rm -vf "src/Model/Entity/${2}.php";
echo " -- delete model/table"
$sd rm -vf "src/Model/Table/${1}Table.php";
echo " -- delete controller"
$sd rm -vf "src/Controller/${1}Controller.php";
echo " -- delete templates"
$sd rm -vf "src/Template/${1}/index.ctp";
$sd rm -vf "src/Template/${1}/add.ctp";
$sd rm -vf "src/Template/${1}/view.ctp";
$sd rm -vf "src/Template/${1}/edit.ctp";
$sd rm -vf "src/Template/${1}/delete.ctp";
if test -z "$(ls -A src/Template/${1}/)"
then
    $sd rmdir "src/Template/${1}/";
fi
echo " -- delete fixture"
$sd rm -vf "tests/Fixture/${1}Fixture.php";
echo " -- delete testcase/controller"
$sd rm -vf "tests/TestCase/Controller/${1}ControllerTest.php";
echo " -- delete testcase/table"
$sd rm -vf "tests/TestCase/Model/Table/${1}TableTest.php";
echo " done delete "
