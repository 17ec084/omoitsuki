//目的: FBPMLで書かれた文字列を多次元配列に変換する
//条件: 先にコンパイラ,jsが読み込まれること

function print穴あき問題(evt)
{
    const reader = new FileReader();
    reader.readAsText(evt.target.files[0]);
    reader.onload = function(ev)
    {
        try{処理する(reader.result);}
        catch (error){window.alert(error);}
    };
}

function 処理する(str_)
{
    const 文たち = 二次元配列の各要素から1番目だけとってくる(FBPML(str_));
    let 種類, htmlコード, 既知の穴, 新規の穴;
    let str = "";
    let 文番号, 穴番号;
    文番号 = 0;
    let 正解マップ = new Map();
    
    for (文_ of 文たち) // 「文」とすると、パース用の関数を上書きしてしまい、再帰が上手くいかなくなる
    {
        for (穴orhtmlコード of 文_)
        {
            種類 = 穴orhtmlコード[0];
            if     (種類 === "htmlコード")
            {
                htmlコード = 穴orhtmlコード[1];
                str += htmlコード;
            }
            else if(種類 === "新規の穴")
            {
                新規の穴 = 穴orhtmlコード[1];
                穴番号 = (新規の穴[1] * 1);
                if (新規の穴[1] !== 新規の穴[5])
                    throw new Error((文番号+1) + "番目の文において、穴の開始タグ("+新規の穴[1]+")と終了タグ("+新規の穴[5]+")で番号が異なるものがありました。");
                if(正解マップ.has(文番号 + "," + 穴番号))
                    throw new Error((文番号+1) + "番目の文において、穴番号" + 穴番号 + "が衝突しました。");
                正解マップ.set(文番号 + "," + 穴番号, 新規の穴[3]+"");
                str += "<input type='button' onClick='(function(文番号, 穴番号){document.body.innerHTML = \""+正解マップ.get(文番号+","+穴番号)+"<input type=#button# value=#問題へ戻る# onClick=#処理する(`"+ str_.replace(/\r/g, "\\r").replace(/\n/g, "\\n") +"`);#>\".replace(/#/g, String.fromCharCode(0x27));})("+文番号+","+穴番号+");' value='" + 穴番号 +"'>";
                
            }
            else if(種類 === "既知の穴")
            {
                既知の穴 = 穴orhtmlコード[1];
                穴番号 = 既知の穴[1] * 1;
                if(!正解マップ.has(文番号 + "," + 穴番号))
                    throw new Error((文番号+1) + "番目の文の穴" + 穴番号 + "について、新規定義よりも先に既知参照が発生しました。");
                str += "<input type='button' onClick='(function(文番号, 穴番号){document.body.innerHTML = \""+正解マップ.get(文番号+","+穴番号)+"<input type=#button# value=#問題へ戻る# onClick=#処理する(`"+ str_.replace(/\r/g, "\\r").replace(/\n/g, "\\n") +"`);#>\".replace(/#/g, String.fromCharCode(0x27));})("+文番号+","+穴番号+");' value='" + 穴番号 +"'>";
//                str += "<input type='button' onClick='function(文番号, 穴番号){window.alert(\"hello\");}' value='" + 穴番号 +"'>";
//                str += "<input type='button' onClick='Q(" + 文番号 + "," + 穴番号 + ")' value='" + 穴番号 +"'>";
            }
        }
        文番号 += 1;
    }
    document.body.innerHTML = str;

}

function 二次元配列の各要素から1番目だけとってくる(arr2d)
{
    const newarr = [];
    for (arr1d of arr2d)
        newarr.push(arr1d[1]);
    return newarr;
}