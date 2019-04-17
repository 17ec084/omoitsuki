<?php

if(!isset($_GET['url']) || ($str=curl_get_contents($_GET['url']))===false)
{
    print "README.mdへのurlを指定してください。";
    return;
}

$newLine="\\n|\\r|(\\r\\n)";
$exceptNewLine="^(".$newLine.")";

$pattern=$newLine."######(".$exceptNewLine."*)".$newLine."/u";
$replace='<h6>$2</h6>';
$str=preg_replace($pattern, $replace, $str);
/*
正規表現「\\n#######(^\\r)*\\n」を、
「<h7>(^\\n)*</h7>」に置き換える
* /
$str=
/*
上記を、h6～h1について、この順で実行
* /

$str=
/*
正規表現「<!\\-\\- hole(^(\\-\\->))*\\-\\->」を、
「<input type="button" value="?" onClick="alert("(中身)");">」に置き換える
* /

$str=
/*
正規表現「\\n\\-\\-\\-\\-」を、
「<hr>」に置き換える
* /

$str=
/*
正規表現「!\\[(^])*]( |\\t|\\n)*\\((^(\\))*\\)」を、
「<img src="**">」に置き換える
* /

$str=
/*
正規表現「\\[(^])*]( |\\t|\\n)*\\((^(\\))*\\)」を、
「<a href="**">**</a>」に置き換える
* /

$str=
/*
正規表現「<!\\-\\- lc msg=(^\\-)*-->」を、
(msgの値)に置き換える
*/

$str='<html>
    <head>
        <title>
            README.md READER developed by 17ec084
        </title>
    </head>
    <body>
        お知らせ:<br>README.md READERのデベロパが
        <a href="http://rights-for.men/">任意団体 男性会議</a>
        を立ち上げました。<br>
        <a href="https://www.change.org/p/%E5%A5%B3%E6%80%A7%E5%B0%82%E7%94%A8%E8%BB%8A%E4%B8%A1%E3%82%92%E5%B0%8E%E5%85%A5%E3%81%97%E3%81%A6%E3%81%84%E3%82%8B%E9%89%84%E9%81%93%E4%BC%9A%E7%A4%BE-%E7%94%B7%E6%80%A7%E5%B0%82%E7%94%A8%E8%BB%8A%E4%B8%A1%E3%81%AE%E5%B0%8E%E5%85%A5%E3%82%92%E6%B1%82%E3%82%81%E3%81%BE%E3%81%99">男性専用車両導入を求める署名運動</a>もしておりますので、ご協力ください。<br>
        (一部サービスは、こちらの署名への協力を条件に提供しております。ご了承ください)
        <hr>
".$str."
    </body>
</html>";

print $str;

