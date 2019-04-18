<?php

if(!isset($_GET['url']) || ($str=curl_get_contents($_GET['url']))===false)
{
    print "README.mdへのurlを指定してください。";
    return;
}

$beginLine="(^|\\r|\\n|\\r\\n)";
$endLine="(\\r|\\n|\\r\\n|$)";
$exceptNewLine="^(".$endLine.")";
$space="( |\\t|\\r|\\n|\\r\\n)";
$d="~";//デリミタ

$conf=array($beginLine, $endLine, $exceptNewLine, $space, $d);
//h6to1等々の関数に渡すとき、冗長化を防ぐ
//本来はグローバル変数にすればいい話だが、lcrp関数にしたくなった時のことを考えると、そうしたくない。


$str=h6to1($str,$conf);
//「#」をh6～1に変換
//先にh1を置き換えようとするとh2～h6が誤検出される。パターンの冗長化を防ぐため、あえてこの問題を解決していない。

$str=hole($str,$conf);
//「<!-- hole 」と「-->」に囲まれた部分を、
//「<input type="button" value="?" onClick="alert('(中身)');">」に置き換える

$str=lc($str,$conf);
//「<!-- lc -->」の部分を、
//「<input type="button" value="非公開情報" onClick="alert('非公開情報です。交換条件を満たし、ライセンスを取得してください');">」に置き換える

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
'.$str.'
    </body>
</html>';

print $str;



    function curl_get_contents( $url, $timeout = 60 )
    {
    //外部サイトから引用
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_HEADER, false );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
        $result = curl_exec( $ch );
        curl_close( $ch );
        return $result;
    }

    function h6to1($str,$conf)
    {

        $beginLine=$conf[0];
        $endLine=$conf[1];
        $exceptNewLine=$conf[2];
        $space=$conf[3];
        $d=$conf[4];//デリミタ

        for($i=6; $i>1-1; $i--)
        {
            $sharp="";
            for($j=0; $j<$i; $j++)
            {
                $sharp.="#";
            }
            $pattern=$d.$beginLine.$sharp." (.*)".$endLine.$d."u";
            $replace='<h'.$i.'>$2</h'.$i.'>'."\n";
            $str=preg_replace($pattern, $replace, $str);
        }

        return $str;
    }

    function hole($str, $conf)
    {
        $beginLine=$conf[0];
        $endLine=$conf[1];
        $exceptNewLine=$conf[2];
        $space=$conf[3];
        $d=$conf[4];//デリミタ

        $pattern=$d.
        "<!".			//<!
        "\\-\\-".		//<!--
        "(".$space.")*".	//<!--(空白)
        "hole".			//<!--(空白)hole
        "(".$space.")+".	//<!--(空白)hole(空白)
        "([^".			//終了=
          "(".				
            "(".$space.")*".	//(空白)
            "\\-\\->".		//(空白)-->
          ")".
        "]*)".			//<!--(空白)hole(空白)(「終了」以外)
        "(".$space.")*".	//<!--(空白)hole(空白)(「終了」以外)(空白)
        "\\-\\->".		//<!--(空白)hole(空白)(「終了」以外)(空白)-->
        $d."u";
        $replace='<input type="button" value="?" onclick="alert(\'$5\');">';
        $str=preg_replace($pattern, $replace, $str);

        return $str;
    }

    function lc($str, $conf)
    {
        $beginLine=$conf[0];
        $endLine=$conf[1];
        $exceptNewLine=$conf[2];
        $space=$conf[3];
        $d=$conf[4];//デリミタ

        $pattern=$d.
        "<!".			//<!
        "\\-\\-".		//<!--
        "(".$space.")*".	//<!--(空白)
        "lc".			//<!--(空白)hole
        "(".$space.")+".	//<!--(空白)hole(空白)
        "([^".			//終了=
          "(".				
            "(".$space.")*".	//(空白)
            "\\-\\->".		//(空白)-->
          ")".
        "]*)".			//<!--(空白)hole(空白)(「終了」以外)
        "(".$space.")*".	//<!--(空白)hole(空白)(「終了」以外)(空白)
        "\\-\\->".		//<!--(空白)hole(空白)(「終了」以外)(空白)-->
        $d."u";
        $replace='<input type="button" value="非公開情報" onclick="alert(\'非公開情報です。交換条件を満たし、ライセンスを取得してください\');">';
        $str=preg_replace($pattern, $replace, $str);

        return $str;
    }
