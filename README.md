# TimeTreeから予定を独自のサイトに反映させるプログラム

## 1. 注意事項
- 1. ウェブサーバー・データベースは各自用意してください。
- 2. Pythonの環境は3.10.6で動作確認しました。
- 3. Pythonファイルはcronやタスクスケジューラ,Lambdaなどでスケジューリングして実行してください。
- 4. Timetreeのアカウント、及びトークンに関しても各自で用意してください。今回のトークンは**Personal access token**を使用しています

## 2. 環境構築
- 1. Pythonをインストール
バージョンは3.9以上推奨です。
[ダウンロードサイト](https://www.python.org/downloads/release/python-3106/)
```
python --version
```
**インストールの際、ADD PATHにチェックを入れるのを忘れないでください**
上のコマンドでバージョンが出てくるとOKです。

- 2. pip(パッケージマネージャー)をダウンロードしてください。
もともと入っているかもしれないですが、一応ダウンロードリンク貼っておきます。
[get-pip.py](https://bootstrap.pypa.io/get-pip.py)
このファイルをダウンロードして実行するとダウンロードされます。

- 3. パッケージをダウンロード
```
pip install mysql-connector-python requests isodate
```

- 4. データベースを用意
今回は、ID,タイトル,開始時間,終了時間だけしか格納していません。

```
CREATE TABLE `timetree` (
  `id` varchar(255) NOT NULL,
  `title` varchar(64) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

- 5. 残りはpythonを実行して、ウェブサイトを参照してください。
APIの都合により、6日後までの予定しかデータベースに入らないので、それに合わせたPythonの実行スケジューリングを立ててください。