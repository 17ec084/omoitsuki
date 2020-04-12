#要約
$n$次元ベクトルを、数式を用いて回転させるのは

- 原点を通る$\left(\begin{array}{a}1 && 0 && 0 && \dots \end{array}\right)$方向の軸(要は$x$軸)を回転軸として何度回転するか($\theta_0$)
- 原点を通る$\left(\begin{array}{a}0 && 1 && 0 && \dots \end{array}\right)$方向の軸(要は$y$軸)を回転軸として何度回転するか($\theta_1$) 
- 原点を通る$\left(\begin{array}{a}0 && 0 && 1 && \dots \end{array}\right)$方向の軸(要は$z$軸)を回転軸として何度回転するか($\theta_2$)

...(以下略)
を求め、$\theta_0, \theta_1, \theta_2, ...$それぞれの変換を実現する「回転行列」を順番にかけることで表現できます。
 
#1.導入
mebiusbox2さんの[３次元座標変換のメモ書き](https://qiita.com/mebiusbox2/items/044c7a43b94e4ae250b7)を読んで、これを一般化できないかと考えたのが執筆の始まりです。

$n$次元列(縦)ベクトルの左に$n$次正方行列をかける<sub><sub>(行列積の詳しい説明は[他](https://www.youtube.com/watch?v=X2Xy2wnQbXc)に譲ります)</sub></sub>と、新しい$n$次元列ベクトルに変換することができます。

```math
\left(
\begin{array}{aaa}
変 \\換 \\ \textbf{後}\\ の\\ ベ\\ ク\\ ト\\ ル
\end{array}
\right)=
\left(
\begin{array}{aaa}
1 && 0 && 0     && 0 && 0 && 0 && 0 && 0 \\
0 && 1 && 0     && 0 && 0 && 0 && 0 && 0 \\
0 && 0 && 後/前 && 0 && 0 && 0 && 0 && 0 \\
0 && 0 && 0     && 1 && 0 && 0 && 0 && 0 \\
0 && 0 && 0     && 0 && 1 && 0 && 0 && 0 \\
0 && 0 && 0     && 0 && 0 && 1 && 0 && 0 \\
0 && 0 && 0     && 0 && 0 && 0 && 1 && 0 \\
0 && 0 && 0     && 0 && 0 && 0 && 0 && 1 \\
\end{array}
\right)
\left(
\begin{array}{aaa}
変 \\換 \\ \textbf{前}\\ の\\ ベ\\ ク\\ ト\\ ル
\end{array}
\right)
```
この変換を線形変換といいます。
線形変換に出てくる行列を変換行列といいます。
変換行列に三角関数を(ルールに沿って)含めることで、大きさを保ったまま、向きだけを変えることができます。
このときの変換行列を回転行列といいます。

#2.回転行列
##2-1. 2次元ベクトルの回転行列
まずは簡単に考えるため低い次元で考えます。2次元ベクトルを角度$☆$だけ回転させることを考えましょう。
回転前の2次元ベクトルを$\left(\begin{array}{aaa}□ \\\\ △\end{array}\right)$とします。
長さは$\sqrt{□^2+△^2}$, $x$軸からの角度は$\arctan(\frac{△}{□})$の解のうちどれか一つです。
ここで$\frac{△}{□}:=\tan ☆$と定義したらどうでしょう。ベクトルの角度は$\arctan(\tan ☆)=☆$と、簡単になります。
また、$\tan☆=\frac{\sin☆}{\cos☆}$ですから$\frac{△}{□}=\frac{\sin☆}{\cos☆}$が成り立ちます。
これを整理すれば、

- $△=◎ \sin☆$
- $□=◎ \cos☆$  
($◎$は実数)  

が得られます。ベクトルの長さは$\sqrt{□^2+△^2}=\sqrt{◎^2(\cos^2☆+\sin^2☆)}　=◎$と計算できます。

まとめると、

```math
\left(\begin{array}{aaa}□ \\ △\end{array}\right)=\left(\begin{array}{aaa}◎ \cos ☆ \\ ◎ \sin ☆\end{array}\right)
```

ってことです。(要は極座標の変換公式です)

これを$\theta$だけ回転させると、

```math
\begin{array}{bbb}

\left(\begin{array}{aaa}◎ \cos (☆+\theta) \\ ◎ \sin (☆+\theta)\end{array}\right) \\
= 
\left(\begin{array}{aaa}◎(\cos{☆}\cos{\theta}-\sin{☆}\sin{\theta})　\\ ◎(\sin{☆}\cos{\theta}+\cos{☆}\sin{\theta})\end{array}\right)　\\
=
\left(\begin{array}{aaa}◎\cos{☆}\cos{\theta}-◎\sin{☆}\sin{\theta}　\\ ◎\sin{☆}\cos{\theta}+◎\cos{☆}\sin{\theta}\end{array}\right)　\\
=
\left(\begin{array}{aaa} \cos \theta && -\sin \theta \\ \sin \theta && \cos\theta \end{array}\right)

\left(\begin{array}{aaa}◎ \cos ☆ \\ ◎ \sin ☆\end{array}\right)
\end{array} 
```

となります。最初の変形には加法定理を用いています。
以上のように極座標で表すことで三角関数に変換してから加法定理を適用し、行列積で表すことで、
2次元ベクトルを$\theta$だけ回転させる回転行列

```math
\left(\begin{array}{aaa} \cos \theta && -\sin \theta \\ \sin \theta && \cos\theta \end{array}\right)
```

を得るというわけです。



##2-2. 3次元ベクトルの回転行列
2次元空間には回転の方向という概念は存在しません。(時計回り/反時計回りは存在しますが、これは「合わせて1つ」としてください)
2次元空間の各方向を「東西南北」で表すなら 東→南→西→北→(東に戻る) を繰り返すことでしか回転することができません。

これに対して、3次元以上の空間では、「回転の方向」という概念が生まれます。
3次元空間の各方向を「東西南北上下」で表すなら 東→南→西→北 以外にも 東→上→西→下 や、その他にも斜めを取り入れれば無限に「回転の方向」を考えることができます。

たとえ話でいえば、2次元空間では時計の向きは正面で固定されていて、その中で時計の針が回転しますが、3次元以降の空間では時計の針の回転とは別に、時計そのものがどこを向いているかという概念が生まれるわけです。(図2-2-1)

![image.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/319477/ff5ab0f9-dae3-b08b-a8aa-e8eee3adc465.png)
図2-2-1. 2次元および3次元における回転

### 2-2-1. 回転軸がz軸の場合

試しに$z$軸を回転軸として(つまり$xy$平面内で回転させて)三次元ベクトルを回転させましょう。
$z$軸が回転軸であるため、$z$成分は変化してはいけません。
この時点で回転行列は

```math
\left(
\begin{array}{aaa}
? && ? && ?\\
? && ? && ?\\
0 && 0 && 1
\end{array}
\right)
```

であることが確定します。(ア)

また$xy$平面内の回転なので、$z$成分は無関係です。$z$成分が変換結果の$x$成分と$y$成分に影響を与えることがないことから

```math
\left(
\begin{array}{aaa}
? && ? && 0\\
? && ? && 0\\
? && ? && ?
\end{array}
\right)
```
が約束されます。(イ)


最後に、$x$成分と$y$成分は、2次元ベクトルの回転と同じように変化すべきです。このことから

```math
\left(
\begin{array}{aaa}
\cos\theta && -\sin\theta && ?\\
\sin\theta && \cos\theta && ?\\
? && ? && ?
\end{array}
\right)
```
がわかります。(ウ)

これらをまとめると、
$z$軸を回転軸($xy$平面内の回転)として3次元ベクトルを$\theta$だけ回転させる回転行列は

```math
\left(
\begin{array}{aaa}
\cos\theta && -\sin\theta && 0\\
\sin\theta && \cos\theta && 0\\
0 && 0 && 1
\end{array}
\right)
```
であると求められます。

また$yx$平面内の回転を考えたい場合、$xy$平面を裏側から見ることに等しいので「逆回転」となります。
これは回転行列の各成分における$\theta$を-1倍することで求められます。
$\cos x = \cos -x$、$\sin x = -\sin -x$に気を付けると

```math
\left(
\begin{array}{aaa}
\cos\theta && \sin\theta && 0\\
-\sin\theta && \cos\theta && 0\\
0 && 0 && 1
\end{array}
\right)
```
となります。

 実装例
---
matlabで、ベクトル`[a;b;c]`を$xy$平面内で`theta`だけ回転させたベクトルを求めるプログラムは次のように書けます。

```matlab:rot_xy.m
function v_ = rot_xy(a,b,c,theta)
%ROT_XY xy平面内で3次元ベクトルを回転させる
    matrix = ...
    [...
        cos(theta), -sin(theta), 0;...
        sin(theta),  cos(theta), 0;...
        0         ,  0         , 1 ...
    ];
    v = ...
    [...
        a;...
        b;...
        c ...
    ];
    v_ = matrix*v;
end
```

$\left(\begin{array}{aaa}1\\\\2\\\\3\end{array}\right)$を$xy$平面内で回転させた軌跡を表示するプログラムは、次のように書けます。

```matlab:コマンドライン
hold off
hold on
for theta = [0:0.1:(2*pi)]
    v_ = rot_xy(1,2,3,theta);
    x = v_(1); y = v_(2); z = v_(3);
    q = quiver3(0,0,0,x,y,z);
    q.AutoScale = 'off';
end
q = quiver3(0,0,0,x,y,z);
q.LineWidth = 10;
q.AutoScale = 'off';
grid on
```

![image.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/319477/042b1dad-d9ec-4eea-b73d-8b23d2d0e3a4.png)
図2-2-1-1. プログラム実行結果(ラベル、視点などは手動で編集しました)

### 2-2-2. 回転軸がx軸やy軸の場合
$x$軸または$y$軸を回転軸とする場合も同様に考えることができます。

具体的に$x$軸を回転軸とする場合(yz平面内の回転)を解説します。
回転行列の<sub><sub>(1オリジン)</sub></sub>3行目が、変換**後**のベクトルの$z$成分に,
1行目が$x$成分に,
それぞれ影響します。
また、回転行列の2列目が、変換**前**のベクトルの$z$成分と,
1列目が$x$成分と,
それぞれ関わります。
ということは、(ア)～(ウ)において3行目と1行目、3列目と1列目を置き換えればよいです。

```math
\left(
\begin{array}{aaa}
1 && 0 && 0\\
? && ? && ?\\
? && ? && ?
\end{array}
\right)
\dots(ア)' \\
\left(
\begin{array}{aaa}
? && ? && ?\\
0 && ? && ?\\
0 && ? && ?
\end{array}
\right)
\dots(イ)' \\
\left(
\begin{array}{aaa}
? && ? && ? \\
? && \cos\theta && \sin\theta\\
? && -\sin\theta && \cos\theta
\end{array}
\right)
\dots(ウ)'
```
合わせて

```math
\left(
\begin{array}{aaa}
1 && 0 && 0\\
0 && \cos\theta && \sin\theta\\
0 && -\sin\theta && \cos\theta
\end{array}
\right)

```
となります。
これは$zy$平面内の回転行列です。(オリジナルが$xy$平面内の回転行列だったところ、$x$と$z$を置き換えた)
$yz$平面内の回転行列を求めたい場合、さらに2行(列)目と3行(列)目を入れ替える必要があります。

```math
\left(
\begin{array}{aaa}
1 && 0 && 0\\
0 && \cos\theta && -\sin\theta\\
0 && \sin\theta && \cos\theta
\end{array}
\right)

```

$y$軸を回転軸とする場合も同様です。

```math
\left(
\begin{array}{aaa}
\cos\theta && 0 && -\sin\theta\\
0 && 1 && 0\\
\sin\theta && 0 && \cos\theta
\end{array}
\right)
```
$xz$平面内の回転行列を求めたもの

```math
\left(
\begin{array}{aaa}
\cos\theta && 0 && \sin\theta\\
0 && 1 && 0\\
-\sin\theta && 0 && \cos\theta
\end{array}
\right)
```
$zx$平面内の回転行列を求めたもの


### 2-2-3. 回転の組み合わせ

その他の回転軸を考える場合は、以上で紹介した回転行列の積を計算したものを、回転行列として使います。
例えば$xy$平面内で$\theta$回転してから$yz$平面内で$\phi$回転する場合は

```math
\left(
\begin{array}{aaa}
1 && 0 && 0\\
0 && \cos\phi && -\sin\phi\\
0 && \sin\phi && \cos\phi
\end{array}
\right)
\left(
\begin{array}{aaa}
\cos\theta && -\sin\theta && 0\\
\sin\theta && \cos\theta && 0\\
0 && 0 && 1
\end{array}
\right)
=
\left(
\begin{array}{aaa}
\cos\theta && -\sin\theta && 0\\
\sin\theta \cos\phi  && \cos\theta \cos\phi && -\sin\phi\\
\sin\theta \sin\phi && \cos\theta \sin\phi && \cos\phi
\end{array}
\right)
```

が回転行列となるわけです。
ちなみに、回行列積が非可換であるという事実は、2つの非平行な平面に沿った回転の順番を逆にすると結果は必ずしも一致しないことを示しています。
$xy$平面内で$\theta$回転してから$yz$平面内で$\phi$回転するのと、・・・(rot_xy_yz.m)
$yz$平面内で$\phi$回転してから$xy$平面内で$\theta$回転するのは、別の結果を導きえます。・・・(rot_yz_xy.m)
それぞれをmatlabのプログラムで図示してみましょう。
ただし$\theta=60^\circ, \phi=30^\circ,$とします。また回転させるベクトルは$\left(\begin{array}{aaa}1 \\\\1 \\\\1 \end{array}\right)$とします。

```matlab:rot_yz.m
function v_ = rot_yz(a,b,c,phi)
%ROT_YZ yz平面内で3次元ベクトルを回転させる
    matrix = ...
    [...
        1         ,  0         ,  0       ;...
        0         ,  cos(phi)  , -sin(phi);...
        0         ,  sin(phi)  ,  cos(phi) ...
    ];
    v = ...
    [...
        a;...
        b;...
        c ...
    ];
    v_ = matrix*v;
end
```


```matlab:コマンドライン
hold off
hold on
    % 元のベクトル(黒)
    q = quiver3(0,0,0,1,1,1);
    q.AutoScale = 'off';
    q.Color = 'black';

    % xy方向に60度回転(水色)
    v_ = rot_xy(1,1,1,deg2rad(60));
    x = v_(1); y = v_(2); z = v_(3);
    q = quiver3(0,0,0,x,y,z);
    q.AutoScale = 'off';
    q.Color = 'cyan';

    %xy60度→yz30度(青色)
    v_ = rot_xy(1,1,1,deg2rad(60)); 
    x = v_(1); y = v_(2); z = v_(3);
    v_ = rot_yz(x,y,z,deg2rad(30));
    x = v_(1); y = v_(2); z = v_(3);
    q = quiver3(0,0,0,x,y,z);
    q.AutoScale = 'off';
    q.Color = 'blue';

    %yz30度(ピンク色)
    v_ = rot_yz(1,1,1,deg2rad(30)); 
    x = v_(1); y = v_(2); z = v_(3);
    q = quiver3(0,0,0,x,y,z);
    q.AutoScale = 'off';
    q.Color = 'magenta';

    %yz30度→xy60度(赤色)
    v_ = rot_yz(1,1,1,deg2rad(30)); 
    x = v_(1); y = v_(2); z = v_(3);
    v_ = rot_xy(x,y,z,deg2rad(60));
    x = v_(1); y = v_(2); z = v_(3);
    q = quiver3(0,0,0,x,y,z);
    q.AutoScale = 'off';
    q.Color = 'red';
xticks([-0.5:0.5:1.5])
yticks([0:0.5:2])
zticks([0:0.5:2])
xlim([-0.5 1.5])
ylim([0 2])
zlim([0 2])
grid on
axis square
grid3d([-0.5 -0.366 1 0.183 1.5],[0 1.366 0.683 0.366 1.049 2],[0 1 1.549 1.366 2])
```
ただし`grid3d([-0.5:0.5:1.5],[0:0.5:2],[0:0.5:2])`は立体グリッドを実現するための関数で、
[ネット署名にご協力いただく条件で利用を許可しています](https://github.com/17ec084/license-contracteds/tree/master/matlab)。
結果は図2-2-3-1のようになります。

![image.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/319477/baf350b2-cc84-8487-ea39-60bcc299ad8a.png)
図2-2-3-1. 3次元ベクトルの回転

図2-2-3-1に加筆を加えた図2-2-3-2を見ると、青のベクトルと赤のベクトルがそれぞれどのように回転して得られているかを視覚的に確認できます。
![image.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/319477/af0cf6ac-6a65-f86a-fcb4-f40145d0f1cf.png)

図2-2-3-2. 3次元ベクトルの回転(加筆済み)

### 2-2-4. 任意の軸に基づいた回転
これまで議論してきたのは$x～z$軸のいずれかを回転軸とした回転です。
例えば「$\left(\begin{array}{aaa}1\\\\2\\\\1\end{array}\right)$を回転軸とした回転」といったものは考えてきませんでした。
<sub><sub>(よく任意軸による回転行列の公式として「ロドリゲスの回転公式」なんてのが紹介されたりしますが、その説明をネットで読むと、必ずと言っていいほど3次元空間の図を用いて考え、複雑な演算を繰り返すものばかり見つかります。では4次元以降はいったいどうするというのでしょうか。我々は4次元空間を想像することなどできません。)</sub></sub>
しかし、$x～z$軸を回転軸とした回転を組み合わせることで、こういった回転が可能になります。
具体的には
1. 回転軸を$x$軸まで回転させるための回転行列$R$を考える
2. $R$をもとに変形した系にて、$x$軸を回転軸として回転させる
3. $R^{-1}$をかけて元の系に戻す

とします。
以下、回転軸を$\left(\begin{array}{aaa}〇\\\\△\\\\□\end{array}\right)$、回転させたいベクトルを$\left(\begin{array}{aaa}a\\\\b\\\\c\end{array}\right)$、回転角を$\theta$とします。
手順1 回転軸をx軸まで回転させる
----

極座標変換をもとに、任意の回転軸を$x$軸方向まで回転させる行列$R$を考えます。

$\left(\begin{array}{aaa}〇\\\\△\\\\□\end{array}\right)=\left(\begin{array}{aaa}◎\cos☆\cos★\\\\◎\cos☆\sin★\\\\◎\sin☆\end{array}\right)$
と変換したとき、回転行列$R$は

```math
R=R_{zx}(☆)R_{xy}(-★)=\left(
\begin{array}{aaa}
\cos☆ && 0 && \sin☆\\
0 && 1 && 0\\
-\sin☆ && 0 && \cos☆
\end{array}
\right)
\left(
\begin{array}{aaa}
\cos★ && \sin★ && 0\\
-\sin★ && \cos★ && 0\\
0 && 0 && 1
\end{array}
\right)
```
となります。
ただし$R_{hoge}(fuga)$は$hoge$平面内を$fuga$だけ回転する回転行列です。

> 解説
> ----
<font color='#000'>以下、極座標変換式を得るところから丁寧に解説していきます。必要に応じてお読みください。
$\left(\begin{array}{aaa}〇\\\\△\\\\□\end{array}\right)$を$x$軸と平行になるよう回転させると、$\left(\begin{array}{aaa}\sqrt{〇^2+△^2+□^2}\\\\0\\\\0\end{array}\right)$になります。
さて、$\sqrt{〇^2+△^2+□^2}$を何とかして$\sqrt{(◎\cos☆)^2+(◎\sin☆)^2　　　}$として表せないでしょうか。
(それができれば、$\left(\begin{array}{aaa}〇\\\\△\\\\□\end{array}\right)$を大きさ◎角度☆といってよくなります。)
仮に$□:=◎\sin☆$としてみますと、
$\sqrt{〇^2+△^2}=\sqrt{(◎\cos☆)^2　}=\sqrt{(◎\cos☆\cos★)^2+(◎\cos☆\sin★)^2　}$
とできます。つまり
$\left(\begin{array}{aaa}〇\\\\△\\\\□\end{array}\right)=\left(\begin{array}{aaa}◎\cos☆\cos★\\\\◎\cos☆\sin★\\\\◎\sin☆\end{array}\right)$
ってことです。
これの意味を考えてみましょう。
$z$成分を無視して考えてみると、$\left(\begin{array}{aaa}〇\\\\△\end{array}\right)=\left(\begin{array}{aaa}◎\cos☆\cos★\\\\◎\cos☆\sin★\end{array}\right)$は大きさ$◎\cos☆$で$x$から$y$への角度が$★$であるようなベクトルを示しています。(図2-2-4-1)
![image.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/319477/4ca3b0a4-2685-0bec-fe4c-2af56f84667a.png)
図2-2-4-1. 3次元ベクトルをxy平面を正面にして眺めた図
　
図2-2-4-1に、無視していた$z$成分が$◎\sin☆$であることを書き足すと、図2-2-4-2のようになります。ふとめに示したのが$\left(\begin{array}{aaa}〇\\\\△\\\\□\end{array}\right)$です。
![image.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/319477/26d2a3ad-4e71-bb85-7fca-36b335c4a496.png)
図2-2-4-2. 3次元空間におけるベクトルの向きの考え方
　
まとめると、$\left(\begin{array}{aaa}〇\\\\△\\\\□\end{array}\right)=\left(\begin{array}{aaa}◎\cos☆\cos★\\\\◎\cos☆\sin★\\\\◎\sin☆\end{array}\right)$は、
大きさが◎で向きが「$xy$平面へ角度★で交わる面」(ピンクの面)内で角度☆の向きとなるわけです。
　
逆にいえば、$xy$平面内で角度-★だけ回転することで、ピンクの面は$xz$平面にぴったり重なります。
その上で$xz$平面内で角度-☆だけ回転(つまり$zx$平面内で☆だけ回転)することで、$\left(\begin{array}{aaa}〇\\\\△\\\\□\end{array}\right)$は$x$軸に重なるはずです。
　
よって、回転軸を$x$軸まで回転させる回転行列$R$は
$
R=R_{zx}(☆)R_{xy}(-★)=\left(
\begin{array}{aaa}
\cos☆ && 0 && \sin☆\\\\
0 && 1 && 0\\\\
-\sin☆ && 0 && \cos☆
\end{array}
\right)
\left(
\begin{array}{aaa}
\cos★ && \sin★ && 0\\\\
-\sin★ && \cos★ && 0\\\\
0 && 0 && 1
\end{array}
\right)
$
となります。
ただし$R_{hoge}(fuga)$は$hoge$平面内を$fuga$だけ回転する回転行列です。
　
プログラムを用いて確かめてみましょう。成分がすべて非負数であるどんな3次元ベクトルに対してもy成分やz成分が0であるような3次元ベクトルが返ってくれば成功です。(負数を含めると逆三角関数の解が1つに絞れなくなって厄介なので、今回は考えないものとします)</font>
>
```matlab:get_degs.m
function rtn = get_degs(vec)
    try
        vec = reshape(vec, 3,1);
    catch 
        disp('get_degsでエラー: 3次元ベクトル以外が入力されました');
        rtn = NaN;
        return
    end
    abs = sqrt(vec(1)^2+vec(2)^2+vec(3)^2);%◎
    deg1 = asin(vec(3)/abs);%☆
    deg2 = acos(vec(1)/(abs*cos(deg1)));%★
    rtn = [deg1, deg2, abs];
end
```

>
```matlab:rot_to_x.m
function vec_ = rot_to_x(arr)
    deg1 = arr(1); deg2 = arr(2); abs = arr(3);
    vec = zeros(3,1);
    vec(1,1) = abs*cos(deg1)*cos(deg2);
    vec(2,1) = abs*cos(deg1)*sin(deg2);
    vec(3,1) = abs*sin(deg1);
    mat1 =...
    [...
         cos(deg1), 0        , sin(deg1);...
         0        , 1        , 0        ;...
        -sin(deg1), 0        , cos(deg1) ...
    ];
    mat2 =...
    [...
         cos(deg2), sin(deg2),         0;...
        -sin(deg2), cos(deg2),         0;...
         0        , 0        ,         1 ...
    ];
    vec_ = mat1*mat2*vec;
end
```

>
```matlab:コマンドライン
for i=1:10
    before_vec = rand(1,3)
    after_vec = rot_to_x(get_degs(before_vec))
end
```
> <font color="#000">
実行すると、`after_vec`として必ず$x$成分正, $y$成分0, $z$成分0のベクトルが得られます。
</font>


手順2 x軸を回転軸として回転させる
----

手順1にて、$\left(\begin{array}{aaa}〇\\\\△\\\\□\end{array}\right)=\left(\begin{array}{aaa}◎\cos☆\cos★\\\\◎\cos☆\sin★\\\\◎\sin☆\end{array}\right)$は回転行列$R_{zx}(☆)R_{xy}(-★)$にて$x$軸に重ねることができることがわかりました。

この回転行列で$\left(\begin{array}{aaa}a\\\\b\\\\c\end{array}\right)$は$R_{zx}(☆)R_{xy}(-★)\left(\begin{array}{aaa}a\\\\b\\\\c\end{array}\right)$へ移ります。
これは、「$\left(\begin{array}{aaa}〇\\\\△\\\\□\end{array}\right)$を$x$軸に移したときの$\left(\begin{array}{aaa}a\\\\b\\\\c\end{array}\right)$がどこへ移るか」を表していると解釈できます。
したがって、これを$x$軸まわりに回転させることは、$\left(\begin{array}{aaa}a\\\\b\\\\c\end{array}\right)$を$\left(\begin{array}{aaa}〇\\\\△\\\\□\end{array}\right)$まわりに回転させることに等価であるはずです。
$x$軸を回転軸に$\theta$だけ回転させますと、$R_{yz}(\theta)R_{zx}(☆)R_{xy}(-★)\left(\begin{array}{aaa}a\\\\b\\\\c\end{array}\right)$を得ます。


手順3 Rの逆行列をかけてもとの系に戻す
----

要は、$R=R_{zx}(☆)R_{xy}(-★)$による回転を逆の角度、逆の順番にやることで、手順2のために手順1で回転させたのをもとに戻そうということです。

操作の意味が分かれば、わざわざ逆行列の計算をする必要もありません。
$R^{-1}=R_{xy}(★)R_{zx}(-☆)$でOKです。
これを$R_{yz}(\theta)R_{zx}(☆)R_{xy}(-★)\left(\begin{array}{aaa}a\\\\b\\\\c\end{array}\right)$に対して左からかければ、
$\left(\begin{array}{aaa}〇\\\\△\\\\□\end{array}\right)$を回転軸として$\left(\begin{array}{aaa}a\\\\b\\\\c\end{array}\right)$を回転させたベクトルになるはずです。


手順1～3により、我々は次の結論を得ます。
><font color='#000'>
$\left(\begin{array}{aaa}〇\\\\△\\\\□\end{array}\right)=\left(\begin{array}{aaa}◎\cos☆\cos★\\\\◎\cos☆\sin★\\\\◎\sin☆\end{array}\right)$を回転軸として$\left(\begin{array}{aaa}a\\\\b\\\\c\end{array}\right)$を$\theta$だけ回転させたベクトルは
$R^{-1}R_{yz}(\theta)R\left(\begin{array}{aaa}a\\\\b\\\\c\end{array}\right) \\\\
=R_{xy}(★)R_{zx}(-☆)R_{yz}(\theta)R_{zx}(☆)R_{xy}(-★)\left(\begin{array}{aaa}a\\\\b\\\\c\end{array}\right) \\\\
=\left(\begin{array}{aaa}\cos\theta + \cos^2☆\cos^2★ - \cos^2☆\cos^2★\cos\theta 
&& \cos^2☆\cos★\sin★ - \sin☆\sin\theta - \cos^2☆\cos★\sin★\cos\theta 
&& \cos☆(\sin★\sin\theta - \cos★\sin☆\cos\theta) + \cos☆\cos★\sin☆
\\\\
\sin☆\sin\theta + \cos^2☆\cos★\sin★ - \cos^2☆\cos★\sin★\cos\theta
&& \cos^2★\cos\theta + \cos^2☆\sin^2★ + \sin^2☆\sin^2★\cos\theta
&& \cos☆\sin☆\sin★ - \cos☆(\cos★\sin\theta + \sin☆\sin★\cos\theta)
\\\\
\cos★\cos☆\sin☆ - \cos☆\sin☆\cos\theta) - \cos☆\sin★\sin\theta 
&& sin★)(\cos☆\sin☆ - \cos☆\sin☆\cos\theta) + \cos☆\cos★\sin\theta
&& \cos^2☆\cos\theta - \cos^2☆ + 1
\end{array}\right)$
である。</font>

プログラムで見ていきましょう。$\left(\begin{array}{aaa}1\\\\2\\\\3\end{array}\right)$を回転軸に
$\left(\begin{array}{aaa}4\\\\5\\\\6\end{array}\right)$を回転させた軌跡を描きます。

```matlab:rot_3d.m
function roted_target = rot_3d(target, axis, theta)
%ROT_3D axisの3次元ベクトルをもとにtargetの3次元ベクトルをthetaだけ回転させる
    arr = get_degs(axis);
    deg1 = arr(1); deg2 = arr(2);
    target_where_axis_move_to_x = Rzx(Rxy(target, -deg2), deg1);%回転軸がx軸に重なった時のtarget
    roted_target_where_axis_move_to_x = Ryz(target_where_axis_move_to_x, theta);
    roted_target = Rxy(Rzx(roted_target_where_axis_move_to_x, -deg1), deg2);    
end
    function vec_=Rxy(vec, theta)
        vec_ = rot_xy(vec(1), vec(2), vec(3), theta);
    end
    function vec_=Rzx(vec, theta)
        vec_ = rot_zx(vec(1), vec(2), vec(3), theta);
    end
    function vec_=Ryz(vec, theta)
        vec_ = rot_yz(vec(1), vec(2), vec(3), theta);
    end
```

```matlab:コマンドライン
hold off
hold on

q = quiver3(0,0,0, 1,2,3);
q.AutoScale = 'off';
q.LineStyle = '--';

q = quiver3(0,0,0, 4,5,6);
q.LineStyle = '-';
q.LineWidth = 10';

for i=0:0.1:2*pi
    roted_target = rot_3d([4, 5, 6], [1, 2, 3], i);
    x = roted_target(1); y = roted_target(2); z = roted_target(3);
    q = quiver3(0,0,0, x,y,z);
    q.LineWidth = 0.5;
end
grid on
axis equal
```
プログラムを実行すると、図2-2-4-1を得ます。このことから、確かに3次元のベクトルで任意の回転軸を基準にベクトルを回転させることができたことがわかります。
![image.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/319477/89ee7db3-0516-66f7-2061-76a8eeabc4d1.png)

図2-2-4-1. (1,2,3)を回転軸として(4,5,6)を一回転させて得られる立体図形

## 2-3. n次元ベクトルの回転行列

> <font color="red">警告: この節は独自研究を含んでいます。
3次元を超えるベクトル空間における回転の先行研究を調査したところ、「4次元では面が回転軸となる」という事実以外を確認することができませんでした。
本節と同じ課題に取り組む論文には[Aguilera and Pérez-Aguila (2004). General n-Dimensional Rotations.](http://citeseerx.ist.psu.edu/viewdoc/download?doi=10.1.1.4.8662&rep=rep1&type=pdf)や
[Teoh (2005). Formula for Vector Rotation in Arbitrary Planes in R^n.](http://eusebeia.dyndns.org/4d/genrot.pdf)
があるようですが、これらの論文内に示されている結論との整合性は**未確認**です。</font>


2-2-4節の議論を一般化することで、$n$次元ベクトルにおける任意の回転軸での回転を考えることができます。
ただし、3次元より高い次元の空間を我々は想像することができないので、途中で議論が曖昧にならないよう、「回転とは何か」、「どのように回転させるか」について慎重に考えていく必要があります。

### 2-3-1. n次元ベクトルの回転および回転軸とは
何次元においても、回転とは結局「ある$n$次元空間から取り出せる**任意の2次元空間に沿って、円を描くように動くこと**」に他なりません。図2-2-1で用いた時計の例でいえば、**何次元空間においても時計の次元「2」は決して上がることなく、変化しうるのは時計全体がどこを向くかの自由度のみである**ということです。
だから0次元空間や1次元空間では回転を定義できず、2次元空間では「時計の向き」が一意に定まり<sub><sub>(2次元空間から自分自身を取り出す方法は明らかに一意ですよね)</sub></sub>、3次元空間で初めて「時計の向き」という概念が生まれたのです。
3次元空間から時計の2次元空間を取り出すことを線形代数学で考えますと、3つのベクトル(仮に$\boldsymbol{a},\boldsymbol{b},\boldsymbol{c}$とします。)で基底が構成されるベクトル空間(3次元空間)から、線形独立なベクトルを2つ$\boldsymbol{a},\boldsymbol{b}$を取り出してこれを基底とする時計のベクトル空間を考えるわけです。
すると、$\boldsymbol{c}$に対して次の2つのことが言えます。

- 時計のベクトル空間<sub><sub>の基底</sub></sub>から独立している。
- 時計のベクトル空間と合わせることで、もとの空間を張ることができる。

この2つのことをいえるようなベクトル(の組)を「回転軸」というとき、$\boldsymbol{c}$は回転軸といえます。
回転軸のベクトルの組がベクトル1つで構成されているので、3次元空間における回転軸は1次元なのです。
同じように考えると、**$n$次元空間における回転軸は$n-2$次元であるということが言えます。**

### 2-3-2. n次元の極座標とは
3次元では、回転軸のベクトルは極座標変換することでその大きさと向きを特定することができ、またその結果に基づいて回転を加えることで$x$軸に重ねることができます。
3次元を超える空間では回転軸の次元も1次元を超えますが、基底となるベクトルの組を考えることで対応できます。
以降、議論を一般化するため、$x$成分や$x$軸を$x_1$、$y$を$x_2$、$z$を$x_3$のように表現することとします。
2-2-4節で取り上げた3次元ベクトルを任意の回転軸で回転させるアイデアは「回転軸をone-hotベクトルに重ねることで議論を単純化する」というものです。これを$n$次元に拡張して適用するため、「回転軸を$x_1～x_{n-2}$超空間に重ねる」こととしましょう。
例を挙げますと$n=4$次元ベクトルを考えるなら回転軸を$xy$平面に重ねるし、5次元ベクトルを考えるなら回転軸を$xyz$空間に重ねるってわけです。

次に、$n$次元ベクトル$\left(\begin{array}{aaa}a_1\\\\ \vdots\\\\ a_n\end{array}\right)$を極座標変換することを考えましょう。

```math
\begin{array}{aaa}
r && \\\\=
\sqrt{a_1^2 + a_2^2 + a_3^2 + ... + a_{n-2}^2 + a_{n-1}^2 + a_n^2} \\\\=
\sqrt{(a_1^2 + a_2^2 + a_3^2 + ... + a_{n-2}^2 + a_{n-1}^2) + (a_n^2)} \\\\=
\sqrt{(a_1^2 + a_2^2 + a_3^2 + ... + a_{n-2}^2 + a_{n-1}^2) + (r\sin\theta)^2} \\\\=
\sqrt{((a_1^2 + a_2^2 + a_3^2 + ... + a_{n-2}^2) + (r\cos\theta_n\sin\theta_{n-1})^2) + (r\sin\theta_n)^2} \\\\=
\sqrt{(((a_1^2 + a_2^2 + a_3^2) + ... + (r\cos\theta_n\cos\theta_{n-1}\sin\theta_{n-2})^2) + (r\cos\theta_n\sin\theta_{n-1})^2) + (r\sin\theta_n)^2} \\\\=
\sqrt{((((a_1^2 + a_2^2) + (r\cos\theta_n\cos\theta_{n-1}\cos\theta_{n-2}...\sin\theta_{3})^2) + ... + (r\cos\theta_n\cos\theta_{n-1}\sin\theta_{n-2})^2) + (r\cos\theta_n\sin\theta_{n-1})^2) + (r\sin\theta_n)^2} \\\\=
\sqrt{(((((a_1^2) + (r\cos\theta_n\cos\theta_{n-1}\cos\theta_{n-2}...\cos\theta_{3}\sin\theta_{2})^2) + (r\cos\theta_n\cos\theta_{n-1}\cos\theta_{n-2}...\sin\theta_{3})^2) + ... + (r\cos\theta_n\cos\theta_{n-1}\sin\theta_{n-2})^2) + (r\cos\theta_n\sin\theta_{n-1})^2) + (r\sin\theta_n)^2} \\\\=
\sqrt{((((((r\cos\theta_n\cos\theta_{n-1}\cos\theta_{n-2}...\cos\theta_{3}\cos\theta_{2})^2) + (r\cos\theta_n\cos\theta_{n-1}\cos\theta_{n-2}...\cos\theta_{3}\sin\theta_{2})^2) + (r\cos\theta_n\cos\theta_{n-1}\cos\theta_{n-2}...\sin\theta_{3})^2) + ... + (r\cos\theta_n\cos\theta_{n-1}\sin\theta_{n-2})^2) + (r\cos\theta_n\sin\theta_{n-1})^2) + (r\sin\theta_n)^2}
\end{array}
```
ですから、
$\left(\begin{array}{aaa}a_1\\\\ a_2\\\\ a_3\\\\ \vdots\\\\ a_{n-2}\\\\ a_{n-1}\\\\ a_n\end{array}\right)=
\left(\begin{array}{aaa}
r\cos\theta_n\cos\theta_{n-1}\cos\theta_{n-2}...\cos\theta_{3}\cos\theta_{2}\\\\ 
r\cos\theta_n\cos\theta_{n-1}\cos\theta_{n-2}...\cos\theta_{3}\sin\theta_{2}\\\\ 
r\cos\theta_n\cos\theta_{n-1}\cos\theta_{n-2}...\sin\theta_{3}\\\\ 
\vdots\\\\ 
r\cos\theta_n\cos\theta_{n-1}\sin\theta_{n-2}\\\\ 
r\cos\theta_n\sin\theta_{n-1}\\\\ 
r\sin\theta_n\end{array}\right)$
と表せます。
図2-2-4-2を高次元に拡張することで、この変換の意味を考えていきましょう。
$x_3$の次元までを考え、$x_4$以降を無視したものが図2-3-2-1です。

![image.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/319477/713153fa-8864-ee28-8219-cc8fd59db7dc.png)
図2-3-2-1. 回転軸の3次元グラフ

図2-3-2-1に加筆し、$x_4$を考慮したものが図2-3-2-2です。
![image.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/319477/5f9f6147-798f-1108-4c09-b5400141fddd.png)
図2-3-2-2. 2次元回転軸の基底ベクトル(2つ中1つ)の4次元グラフ


回転軸の**直交**基底ベクトル2つ中の1つ目(以下「回転軸1of2」)は$R_{x_1x_4}(-\theta_4)R_{x_1x_3}(-\theta_3)R_{x_1x_2}(-\theta_2)$を左からかけることで$x_1$軸に重ねることができます。
これは図2-3-2-2中でピンクの面を$x_1x_3$平面に重ね、水色の面を$x_1x_4$平面に重ね、その平面内で回転軸1of2を$x_1$まで重ねる操作を行列積で表したものです。

さて、2-3-1節の議論より、4次元では回転軸の次元は2でした。2つ目の基底ベクトル2of2も考える必要がありますね。回転軸2of2は$x_2$軸に重ねることにしましょう。(これをすんなり許すために、回転軸の「直交」基底ベクトルを考える必要があるわけです。)
回転軸ベクトル1of2が$x_1$軸に固定された今、2of2ベクトルの$x_1$成分は明らかに0です。(非0であれば、それは$x_1$に直交していないことになりますからね。)そのため、$x_2x_3x_4$空間上の2of2ベクトルを$x_2$軸に重ねることを考えればよいわけです。

この回転行列は

$$R_{x_2x_4}(-\phi_3)R_{x_2x_3}(-\phi_2)$$

となります。これを先ほどの回転行列に左からかけると、

$$R:=R_{x_2x_4}(-\phi_3)R_{x_2x_2}(-\phi_3)R_{x_1x_4}(-\theta_4)R_{x_1x_3}(-\theta_3)R_{x_1x_2}(-\theta_2)$$

を得ます。

さて、以上で2次元回転軸を$x_1x_2$平面へ移動することに成功しました。$x_1x_2$平面を軸とすることは、ベクトルの回転前後で$x_1$成分と$x_2$成分を固定することに等価です。したがってこれらの成分は回転によって変わることがないため、消去法的に回転が$x_3x_4$平面内で起こるということが見出せます。



以上の議論より、$x_1x_2x_3x_4$超空間や$x_1～x_n$超空間におけるベクトルの回転は、次のような式で求めることができます。

> <font color="black">
$n$次元ベクトルにおいて、回転軸たる平面が直行基底$\boldsymbol{a_{xis1ofn-2}}, \boldsymbol{a_{xis2ofn-2}},...$により張られるベクトル部分空間とみれるときを考える。
$R_i$は$\prod_{j=1}^{i-1} R_j, R_0=I$の直後に$x_i(i>0)$へ$\boldsymbol{a_{xisiof2}}$を重ねるための回転行列(の因数行列)であるとする。
$\prod_{j=1}^{i-1} R_j$による回転を加えた系において、
$\boldsymbol{a_{xisiofn-2}}$を極座標変換した結果を
$$\boldsymbol{a_{xisiofn-2}}:=\left(\begin{array}{aaa}
r_i\cos\theta_{i,n}\cos\theta_{i,n-1}\cos\theta_{i,n-2}...\cos\theta_{i,3}\cos\theta_{i,2}\\\\ 
r_i\cos\theta_{i,n}\cos\theta_{i,n-1}\cos\theta_{i,n-2}...\cos\theta_{i,3}\sin\theta_{i,2}\\\\ 
r_i\cos\theta_{i,n}\cos\theta_{i,n-1}\cos\theta_{i,n-2}...\sin\theta_{i,3}\\\\ 
\vdots\\\\ 
r_i\cos\theta_{i,n}\cos\theta_{i,n-1}\sin\theta_{i,n-2}\\\\ 
r_i\cos\theta_{i,n}\sin\theta_{i,n-1}\\\\ 
r_i\sin\theta_{i,n}\end{array}\right)$$
(ただし$\theta_{k,l} (l>i+1, kは任意)$は常に0である)
と書くとき、
回転軸を$x_1x_2...x_{n-2}$超空間に重ねるための回転行列$R$は
$$
\begin{array}{aaa}
R &&:=\prod_{i=n-2}^{1} R_i\\\\ &&:=\prod_{i=n-2}^{1} \prod_{j=i+1}^{n}R_{x_ix_j}(-\theta_{i,j-i+1})
\end{array}$$
とかける。
任意のベクトルを$\phi$だけ、回転軸に沿って回転させる回転行列は
$$R^{-1}R_{x_{n-1}x_n}(\phi)R$$
として得られる。
</font>
また回転行列$R_{x_ix_j}(\theta)$については2-3-3節で解説します。


### 2-3-3. xixj平面内の回転
$n$次元ベクトル空間における、$x_ix_j$平面内で$\theta$だけ回転させるための回転行列$R_{x_ix_j}(\theta)$を求めましょう。
$x_i$および$x_j$以外のすべての成分は回転軸の基底、すなわち回転軸の一部なので、回転の前後で変化することはありません。
したがって単位行列と同じようにone-hotベクトルを並べた形式となります。
また、$i$,$j$行目の$i$,$j$列目については2次元の場合の回転行列$\left(\begin{array}{aaa}\cos\theta&&-\sin\theta\\\\ \sin\theta&&\cos\theta\end{array}\right)$を当てはめます。
つまり、次の結論を得ます。

> <font color="black">$n$次元ベクトル空間における、$x_ix_j$平面内で$\theta$だけ回転させるための回転行列$R_{x_ix_j}(\theta)$は、
単位行列$I_n$に次の変更を加えることで得られる。
1. $i$行$i$列目および$j$行$j$列目を$\cos\theta$に置き換える
2. $i$行$j$列目を$-\sin\theta$に、$j$行$i$列目を$\sin\theta$に置き換える

</font>

