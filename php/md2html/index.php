<?php
include "include/getTextFromTo.php";
include "include/str_replace_once.php";
?>

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

$str=inlineCode($str,$conf);
//「`」に囲まれた文字列(改行無し)を、「<table bgcolor="#FEE"><tbody><tr><td><code><xmp>」と「</xmp></code></td></tr></tbody></table>」で囲む

//$str=multiCode($str,$conf);
//「```」に囲まれた文字列(改行あり)を、「<br><table bgcolor="#FEE"><tbody><tr><td><code><xmp>」と「</xmp></code></td></tr></tbody></table><br>」で囲む

//$str=escape($str);
//コードを示す範囲内では、通常の処理(h6～1への変換や、改行など)を行うべきではない。
//そのために、コードを示す範囲内にある、処理されうる文字を何らかの処理されえない文字に、一時的に書き換えておく。




$str=absPasser($str,$conf);
//[]内に相対パス(httpが先頭に無いもの)があったら、絶対パスに書き換える

$str=h6to1($str,$conf);
//「#」をh6～1に変換
//先にh1を置き換えようとするとh2～h6が誤検出される。パターンの冗長化を防ぐため、あえてこの問題を解決していない。

$str=hole($str,$conf);
//「<!-- hole 」と「-->」に囲まれた部分を、
//「<input type="button" value="?" onClick="alert('(中身)');">」に置き換える

$str=lc($str,$conf);
//「<!-- lc -->」の部分を、
//「<input type="button" value="非公開情報" onClick="alert('非公開情報です。交換条件を満たし、ライセンスを取得してください');">」に置き換える

$str=hr($str,$conf);
//「 ---- 」を<hr>に書き換える(左右に空白が必要)

$str=img($str,$conf);
//「![*](*)」をimgタグに書き換える(左右に空白が必要)

$str=a($str,$conf);
//「[*](*)」をaタグに書き換える(左右に空白が必要)

$str=quote($str,$conf);
//「(beginLine)(space)>...(改行)」を「<span style="padding-left: *em; background-color: #******; color: #000000;/*quote*/">...</span>」に置き換える。
//「/*quote*/">(空白)>...</span>」を「/*quote*/"><span...</span></span>」置き換える。

$str=br($str,$conf);
//スペース2連続と改行の連続を、<br>に書き換える

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

    function absPasser($str,$conf)
    {
        //仕様: ../など、上の階層に戻る内容の相対パスはさすがに対応しきれない
        $beginLine=$conf[0];
        $endLine=$conf[1];
        $exceptNewLine=$conf[2];
        $space=$conf[3];
        $d=$conf[4];//デリミタ

        $pattern=$d."\\[([^\\]]*)\\]".$space."*"."\\(".$space."*"."(((?!\http|\\]).)*)".$space."*\\)".$d."u";
        //[(]以外)](空白)((空白)(非http)(非]))        

        $parentPass=preg_replace($d."((?!http(.)*\\/).)"."((?!\\/|\\.md).)+\\.md".$d."u", '${1}', $_GET['url']);
        //代替案(上のディレクトリ名に「.md」が含まれると誤作動しうる)$dir=preg_replace($d."(^(http(.)*\\/))"."(.)+\\.md".$d."u", 'aaaa${1}bbbb', $_GET['url']);
        //mdファイルを格納しているディレクトリ
        $str=preg_replace($pattern, '[$1]('.$parentPass.'${4})', $str);

        //正規表現がどうしてもうまく動かないので、一部str_replaceを使ってごまかす。
        $str=str_replace($parentPass."http", "http", $str);

        return $str;
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

    function hr($str, $conf)
    {
        $beginLine=$conf[0];
        $endLine=$conf[1];
        $exceptNewLine=$conf[2];
        $space=$conf[3];
        $d=$conf[4];//デリミタ

        $pattern=$d.$space."\\-\\-\\-\\-".$space.$d."u";
        $replace="\n<hr>\n";
        $str=preg_replace($pattern, $replace, $str);

        return $str;
    }

    function img($str, $conf)
    {
        $beginLine=$conf[0];
        $endLine=$conf[1];
        $exceptNewLine=$conf[2];
        $space=$conf[3];
        $d=$conf[4];//デリミタ

$pattern=$d.
$space."!\\[".		//![
$space."*".		//![(空白)
"([^\\]]*)".		//![(空白)(]以外)
$space."*".		//![(空白)(]以外)(空白)
"\\]".			//![(空白)(]以外)(空白)]
$space."*".		//![(空白)(]以外)(空白)](空白)
"\\(".			//![(空白)(]以外)(空白)](空白)（
$space."*".		//![(空白)(]以外)(空白)](空白)（(空白)
"([^\\)]*)".		//![(空白)(]以外)(空白)](空白)（(空白)(「）」以外)
"\\)".			//![(空白)(]以外)(空白)](空白)（(空白)(「）」以外)）
$space.			//![(空白)(]以外)(空白)](空白)（(空白)(「）」以外)）(空白)
$d."u";
//.  $space."*".  "\\("."([^\\)]*)"."\\)".$space.$d."u";
//        $pattern=$d.$space."!\\["."([^\\]*])"."\\("."([^\\)*])".")".$space.$d."u";
        $replace=' <img src="$7" alt="$3" title="$3"> ';
        $str=preg_replace($pattern, $replace, $str);


        return $str;
    }

    function a($str, $conf)
    {
        $beginLine=$conf[0];
        $endLine=$conf[1];
        $exceptNewLine=$conf[2];
        $space=$conf[3];
        $d=$conf[4];//デリミタ

$pattern=$d.
$space."\\[".		//[
$space."*".		//[(空白)
"([^\\]]*)".		//[(空白)(]以外)
$space."*".		//[(空白)(]以外)(空白)
"\\]".			//[(空白)(]以外)(空白)]
$space."*".		//[(空白)(]以外)(空白)](空白)
"\\(".			//[(空白)(]以外)(空白)](空白)（
$space."*".		//[(空白)(]以外)(空白)](空白)（(空白)
"([^\\)]*)".		//[(空白)(]以外)(空白)](空白)（(空白)(「）」以外)
"\\)".			//[(空白)(]以外)(空白)](空白)（(空白)(「）」以外)）
$space.			//[(空白)(]以外)(空白)](空白)（(空白)(「）」以外)）(空白)
$d."u";
//.  $space."*".  "\\("."([^\\)]*)"."\\)".$space.$d."u";
//        $pattern=$d.$space."!\\["."([^\\]*])"."\\("."([^\\)*])".")".$space.$d."u";
        $replace=' <a href="$7" alt="$3" title="$3">$3</a> ';
        $str=preg_replace($pattern, $replace, $str);


        return $str;
    }

    function quote($str, $conf)
    {

        //仕様:ネストには対応しない。面倒だから。
        //引用を分割するとき、本来は1行だけ開ければよいが、readerの場合は2行開けること
        //そのほうが処理が簡単だから。
        $beginLine=$conf[0];
        $endLine=$conf[1];
        $exceptNewLine=$conf[2];
        $space="( |\\t)";//変更。
        $d=$conf[4];//デリミタ
/*
例:

hoge\n
   \n
> 1  \n
> 2  \n
> 3\n
 \n
 \n
> 4\n
 \n

*/
        $pattern=$d.$beginLine.$space."*".$endLine.">".$d."u";
        $replace="\n<!-- quote -->\n>";
        $str=preg_replace($pattern, $replace, $str);

        $pattern=$d."(".$beginLine.">.*".$endLine.")".$space."*".$endLine.$d."u";
        $replace='$1<!-- quote -->'."\n";
        $str=preg_replace($pattern, $replace, $str);
/*
例:

hoge\n
<!-- quote -->\n
> 1  \n
> 2  \n
> 3\n
<!-- quote -->
<!-- quote -->
> 4\n
<!-- quote -->

*/

        while(strpos($str, "<!-- quote -->")!==false)
        {
            $len=strlen("<!-- quote -->");
            //$str=
            //a<!-- quote -->b<!-- quote -->c<!-- quote -->d...
            $l=strpos($str, "<!-- quote -->");
            $quote=substr($str, $l);
            //<!-- quote -->b<!-- quote -->c<!-- quote -->d...
            $tmp=substr($quote, $len);
            //b<!-- quote -->c<!-- quote -->d...
            $r=strpos($tmp, "<!-- quote -->")+$len*2;
            $originalQuote=$quote=substr($quote, 0, $r);
            //<!-- quote -->b<!-- quote -->

            while(preg_match($d.$space.$space.$endLine.">".$d."u", $quote)!=0)
            //preg_matchはmatchしなかった場合は0を返す。
            //strposとは違うので要要要注意
            {
                $pattern=$d.$space.$space.$endLine.">".$d."u";
                $replace="<br>";
                $quote=preg_replace($pattern, $replace, $quote);
            }

            $tmp=substr($quote, $len, strlen($quote)-$len*2);
//print "\nstr=".$str."\nquote=".$quote;


            $quoteAfter='<span style="padding-left: 4em; background-color: #DDDDDD; color: #000000; display: block;/*quote*/">'.$tmp.'</span>';
            $str=str_replace_once($originalQuote, $quoteAfter, $str, 0);
        }

        $str=str_replace('<span style="padding-left: 4em; background-color: #DDDDDD; color: #000000; display: block;/*quote*/">'."\n>", '<span style="padding-left: 4em; background-color: #DDDDDD; color: #000000; display: block;/*quote*/">'."\n",$str);

        return $str;
    }

    function inlineCode($str, $conf)
    {
        $beginLine=$conf[0];
        $endLine=$conf[1];
        $exceptNewLine=$conf[2];
        $space=$conf[3];
        $spaceOrEndLine='('.$space.'|'.$endLine.')';
        $d=$conf[4];//デリミタ

        while(preg_match($d.$space."`"."([^`.]+)"."`".$spaceOrEndLine.$d."u", $str)!=0)
        {
            $pattern=$d.$space."`"."([^`.]+)"."`".$spaceOrEndLine.$d."u";
            //$replace="\n".'<!-- 次行以降変換除外 -->'."\n".'<table bgcolor="#FEE"><tbody><tr><td><code><xmp>$2</xmp></code></td></tr></tbody></table>'."\n".'<!-- 前行以前変換除外 -->'."\n";
            $replace="\n".'<!-- 次行以降変換除外 -->'."\n".'<code style="background-color: rgba(27,31,35,.05); border-radius: 3px; font-size: 85%; margin: 0; padding: .2em .4em;">$2</code>'."\n".'<!-- 前行以前変換除外 -->'."\n";
            $str=preg_replace($pattern, $replace, $str);
        }

        //以上で、コード用のタグへ変換完了
        //以下、改行を取り除くために、(必要に応じて)さらにタグを書き換える。
/*
        $pattern=$d."<\\/tr><\\/tbody><\\/table>\\n<!\\-\\- 前行以前変換除外 \\-\\->

</tr></tbody></table>
<!-- 前行以前変換除外 -->
(この部分に、改行が無ければよい)
<!-- 次行以降変換除外 -->
<table bgcolor="#FEE"><tbody><tr>
*/

        return $str;
    }

    function br($str, $conf)
    {
        $beginLine=$conf[0];
        $endLine=$conf[1];
        $exceptNewLine=$conf[2];
        $space=$conf[3];
        $d=$conf[4];//デリミタ

        $pattern=$d.$space.$space.$endLine.$d."u";
        $replace="<br>\n";
        $str=preg_replace($pattern, $replace, $str);

        return $str;
    }