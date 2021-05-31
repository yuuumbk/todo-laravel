
# Todo-Laravel
ご覧いただきありがとうございます。このリポジトリは、Laravelで開発されたTodoアプリです。

![todo-laravel-test-user-home](https://user-images.githubusercontent.com/73621966/120127303-fbc5e500-c1f9-11eb-903d-6e5f5ee067cb.png)


## クイックスタート

ローカル動作環境を簡単に構築する手順を紹介します。

クイックスタートを始める前に[前提環境](#前提環境)をご覧ください。必要なものが全てインストールされている場合にクイックスタートをご利用いただけます。また、ポートについては[ポート](#手順4-その他設定)を確認ください。すでにポートが使用されていた場合エラーが出ます。その際は適切なポートへ変更してください。データベース設定などを行う場合は、[手順](#手順)より始めてください。

クイックスタートに失敗した場合は、[手順](#手順)を参照ください。なお、環境構築官僚に数分を要しますのでご了承ください。

---

それではクイックスタートを始めましょう。たった2行をコマンドプロントに貼り付けるだけでTodoアプリが使えるようになります！

まず初めに以下をコマンドプロントに貼り付けてください。実行したディレクトリの位置に`todo-laravel`ディレクトリが作成されます。

```
git clone git@github.com:yuuumbk/todo-laravel.git && cd todo-laravel && docker-sync start && docker-compose up -d --build && docker-compose exec app bash
``` 

次に以下をコマンドプロントに貼り付けてください。上のコマンドを貼り付け後、動作の終了を待たずこちらを貼り付け、実行（エンターキーを押）しておくととスムーズに進みます。

```
composer install && cp .env.example .env && php artisan key:generate && php artisan migrate:refresh && chown www-data storage/ -R && exit
```

---

もしくは、以下のコマンドを一つずつ実行してください。

```
$ git clone git@github.com:yuuumbk/todo-laravel.git
$ cd todo-laravel
$ docker-sync start
$ docker-compose up -d --build
$ docker-compose exec app bash
$ composer install
$ cp .env.example .env
$ php artisan key:generate
$ php artisan migrate:refresh
$ chown www-data storage/ -R
$ exit
```

全てのコマンドが正常に実行されたら、`http:localhost:8080`にアクセスしてください。

ローカル動作環境を完全に削除する際は、[補足2](#補足2-ローカル動作環境を完全に削除する)をご覧ください。

###動作確認用アカウントについて
Todoアプリがどのように動作するかを確認するだけであれば、あらかじめ用意されたアカウントを用いると便利です。詳しくは[補足1](#補足1-テストアカウントでTodoアプリを試す)をご覧ください。


## 手順
以下、ローカル動作環境を構築する手順を紹介します。

### 前提環境

#### 1. docker
```
$ docker -v
Docker version 20.10.6, build 370c289
```
参考：https://docs.docker.com/docker-for-mac/install/


#### 2. docker-compose
```
$ docker-compose -v
docker-compose version 1.29.1, build c34c88b2
```

参考：https://docs.docker.com/docker-for-mac/install/

#### 3. docker-sync
```
$ docker-sync -v
0.6.0
```

参考:[手順5](#手順5-docker-sync-を起動する)

#### 4. git
```
$ git --version
git version 2.31.1
```

参考(Mac):https://qiita.com/micheleno13/items/133aee005ae37c28960e

参考:https://git-scm.com/book/ja/v2/%E4%BD%BF%E3%81%84%E5%A7%8B%E3%82%81%E3%82%8B-Git%E3%81%AE%E3%82%A4%E3%83%B3%E3%82%B9%E3%83%88%E3%83%BC%E3%83%AB

#### 5. Homebrew
MacOSかつdocker-syncがインストールされていない場合
```
$ brew --version
Homebrew 3.1.9
```

参考:https://brew.sh/index_ja

---

### 手順1.  フォルダを作成する
ローカル環境へクローンするフォルダを作成してください。

```
$ mkdir 任意のフォルダパス
$ cd 任意のフォルダパス
```

または、クローンするフォルダに移動してください。

```
$ cd 任意のフォルダパス
```

---

### 手順2. クローンする
このリポジトリを先ほど作成したフォルダにクローンします。以下のどちらかのコマンドを実行してください。

```
$ git clone git@github.com:yuuumbk/todo-laravel.git
```

```
$ git clone https://github.com/yuuumbk/todo-laravel.git
```

以下のように出力されたら成功です。
```
Cloning into 'todo-laravel'...
remote: Enumerating objects: 240, done.
remote: Counting objects: 100% (240/240), done.
remote: Compressing objects: 100% (180/180), done.
remote: Total 240 (delta 57), reused 220 (delta 42), pack-reused 0
Receiving objects: 100% (240/240), 890.54 KiB | 1.20 MiB/s, done.
Resolving deltas: 100% (57/57), done.
```

クローンしたディレクトリに移動しておきます。

```
$ cd todo-laravel
```

---

### 手順3. データベース設定

データベースのユーザ名とパスワードを変更しない場合は、[手順4](#手順4-その他設定)へ進んでください。

`$ code docker-compose.yml` などで、`docker-compose.yml`を開いてください。

>MYSQL_DATABASE: todo #データベース名
>
>MYSQL_USER: user #ユーザー名
>
>MYSQL_PASSWORD: password #パスワード
>
>MYSQL_ROOT_PASSWORD: password #ルートパスワード

となっています。phpmyadminも併せて修正してください。

>PMA_USER: user #MYSQL_USERと同値
>
>PMA_PASSWORD: password #MYSQL_PASSWORDと同値

---

### 手順4. その他設定
その他の設定は`docker-compose` や `Dockerfile` 等より行ってください。

なお、ポートはそれぞれ

>web(nginx): 8080
>
>phpmyadmin: 8888
>
>mail: 1025
>
>mail: 8025

を使用しています。既に該当ポートを使用している場合や

```
ERROR: for todo-laravel_****_1 Cannot start service ****: driver failed programming external connectivity on endpoint ********(~~): Bind for *.*.*.*:* failed: port is already allocated
```

というように`port is already allocated` だった場合、未使用ポートを割り当ててください。

---


### 手順5. docker-sync を起動する
Docker For Mac は、このままの状態だと動作が遅いため、`docker-sync`を用いて高速化します。


`docker-sync`がインストールされていない場合は以下のコマンドを入力してください。

```
$ sudo gem install docker-sync
$ brew install fswatch
$ brew install unison
```

そして、

```
$ docker-sync start
```

を入力し、`docker-sync`を起動させます。

---

### 手順6. ビルドし、コンテナを起動する
ビルドとコンテナの起動を行います。

```
$ docker-compose up -d --build
```

初めての場合、時間がかかることがあります。以下のように出力されたら成功です。

```
Creating network "todo-laravel_default" with the default driver
Creating todo-laravel_mail_1 ... done
Creating todo-laravel_web_1  ... done
Creating todo-laravel_app_1  ... done
Creating todo-laravel_db_1 ... done
Creating todo-laravel_phpmyadmin_1 ... done
```

---

### 手順7. Laravelパッケージをインストール
Laravelパッケージをインストールします。

```
root：/work# composer install
```

```
Package manifest generated successfully.
74 packages you are using are looking for funding.
Use the `composer fund` command to find out more!
```

しばらく経ち、このように表示されたら成功です。

---

### 手順8. .envファイルを作成する
`.env`ファイルはクローンされていないため、`/backend/.env.sample`をコピーして`/backend/.env`ファイルを作成します。


まず初めにコンテナ内に入ります。

```
$ docker-compose exec app bash
```

`root@******：/work# ` の入力画面になります。以下、`root：/work# `はコンテナ内でのコマンド実行を表します。

```
root：/work# cp .env.example .env
```

`/backend`ディレクトリに.envファイルが作成されました。

次に、`APP_KEY`を設定します。

```
root：/work# php artisan key:generate
```

`.env`ファイルの`APP_KEY`にキーが追加されました。

また、[手順3](#手順3-データベース設定)でユーザー名やパスワードを変更した場合は、`.env`ファイルで該当箇所を修正してください。

>DB_USERNAME=user #MYSQL_USERと同値
>
>DB_PASSWORD=password #MYSQL_PASSWORDと同値

---

### 手順9. データベースを作成する
データベースを以下のコマンドで作成します。

```
root：/work# php artisan migrate:refresh
```

---

以上でローカル環境の構築が完了しました。`http:localhost:8080`（[手順4](#手順4-その他設定)でポートを変更した場合は、8080をそのポートに変更してください。）
からアクセスして、Todoアプリを始めましょう！

#### パーミッションエラーが発生した場合
`http:localhost:8080`にアクセスした際に、

>UnexpectedValueException
>The stream or file "/work/storage/logs/laravel.log" could not be opened in append mode: Failed to open stream: Permission denied

と表示された場合は、"コンテナ内" で以下のコマンドを入力してください。

```
root:/work# chown www-data storage/ -R
```

---

### 補足1.  テストアカウントでTodoアプリを試す

動作確認をする場合、テストアカウントを用いることをお勧めします。テストアカウントには、あらかじめフォルダとタスクが登録されています。なお、全てのデータがリセットされますのでご注意ください。

![todo-laravel-test-user-home](https://user-images.githubusercontent.com/73621966/120127303-fbc5e500-c1f9-11eb-903d-6e5f5ee067cb.png)

テストアカウントを使うには、"コンテナ内"で以下のコマンドを入力します。

```
root：/work# php artisan migrate:refresh --seed
```

次に`http:localhost:8080`のログイン画面から

>メールアドレス：test@example.com
>
>パスワード：todo-laravel

を入力してください。

### 補足2. ローカル動作環境を完全に削除する

以下のコマンドを入力してください。エラーが出ることがありますが問題ありません。

```
$ docker-compose down --rmi all --volumes --remove-orphans
$ docker-sync clean
```
