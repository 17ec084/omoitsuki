# md2html
gitHub上で公開されるREADME.mdファイルをhtmlに変換し、整形の上表示するプログラム  

## 仕様

- ＃のついた行をh1～7タグに書き換える

- 「＜!-- hole」 から 「--＞」に囲まれた部分は隠す。ボタンを用意し、クリックされると答えをアラートで表示。

- －－－－は水平線＜hr＞に書き換える。

- リンク及び画像を機能させる

- 「＜!-- lc--＞」は非公開を意味する。間違っても、間に非公開情報を書き込むな。mdファイルのソースから丸見えだ。
