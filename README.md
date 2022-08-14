# Dockerを使ったPHP8開発

## 環境構築

```bash
# Docker イメージのビルド
docker-compose build

# Docker コンテナの起動
docker-compose up -d

# Docker コンテナ内でコマンドを実行する
docker-compose exec web php -v

# Docker コンテナの停止・削除
docker-compose down
```

## Docker でよく使うコマンド

```bash
# コンテナの一覧と起動状態を確認する
docker-compose ps

# コンテナ内で bash を操作する（コンテナ起動中のみ）
docker-compose exec web /bin/bash

# Docker イメージのビルドとコンテナの起動を同時に実行
docker-compose up -d　--build

# ターミナルからphpファイルを実行する(例:batchディレクトリにあるimport_users.phpファイルを実行)
docker-compose exec -i web php batch/import_users.php
```


## コンテナのデータを初期化する
環境構築した最初のデータに戻したい時は以下コマンドを実行

```bash
# mysqlの入っているストレージ(ボリューム)を初期化
docker-compose down -v

# 対応したらコンテナを起動します。
docker-compose up -d　--build
```
環境構築した最初のデータに戻っているか確認してください。


## ハードディスクの容量が逼迫したら
不要なイメージ、コンテナなどを削除します。

```bash
# Docker の不要なイメージ、コンテナなどを削除する
docker system prune -a
```