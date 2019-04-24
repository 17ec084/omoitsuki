<?php

print "<h2>外内 ＞ 左右と考える場合</h2>"; 

$str="12423531";

$pattern="/(1(2(4)2)(3(5)3)1)/";
 
myfunc($str, $pattern);


print "<hr>";

print "<h2>左右 ＞ 外内と考える場合</h2>"; 


$str="12324541";

$pattern="/(1(2(3)2)(4(5)4)1)/";

myfunc($str, $pattern);

    function myfunc($str, $pattern)
    {
        print "Against str \"".$str."\" <br>and pattern \"".$pattern."\",<br>";

        $replace=
        array
        (
        "0 is $0",
        "1 is $1",
        "2 is $2",
        "3 is $3",
        "4 is $4",
        "5 is $5",
        );

            foreach($replace as $rep)
            {
                print "$".preg_replace($pattern, $rep, $str)."<br>";
            }
    }

