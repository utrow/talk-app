talk-app「LINEを作る」

# SETUP
## application/config/database.php
    データベースの設定。(hosts,user,password,database)

# 主要なファイル
## application/controllers/
### 基本的にJSONで返す。
    * Auth.php : 認証部分
    * Friends.php : 友だちの取り扱い
    * Talks.php : メッセージの取り扱い

### フロント部分の出力
    * Home.php :

## application/models/
    * Authmodel.php : 認証部分のモデル
    * Db_mdl.php : 認証以外でデータベースを扱うモデル

## application/view/
    * line_home.php : メインのHTML

## dist/js/app/
    * home.js : 主にjQueryでコーディングしたフロント部分
