# Crietto Learning Portal

Crietto は Laravel 10 と React 18 (Vite) を用いた学習ポータル & CMS の最小実装です。左側にカリキュラム、右側に Python / PHP / Scratch の開発環境を配置し、生徒・講師・保護者が協働できる学習体験を提供します。

## 機能概要

- Laravel API (モノレポ構成) + React SPA
- ロールベース認証: `admin`, `coach`, `student`, `guardian`
- 学習構造: コース / ユニット / レッスン / 課題 (Seed でダミーデータを生成)
- 提出と擬似サンドボックス実行 (Laravel Queue + `RunCodeService`)
- Scratch プロジェクトの保存・共有ポリシー
- 成長ダッシュボード、提出物一覧、進捗 API
- 国際化 (日本語既定、英語フォールバック)

## セットアップ

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install
npm run dev
```

キューを処理するには別ターミナルで `php artisan queue:work` を実行してください。

## 主なディレクトリ

- `app/` … Laravel アプリケーション、モデル、ポリシー、サービス、キュージョブ
- `database/migrations` … データモデルを構成するマイグレーション
- `database/seeders` … ロール別ユーザーと学習コンテンツの初期データ
- `resources/js` … React 18 + Vite + Tailwind UI (SplitPane + DevTabs + Dashboard など)
- `docker/` … MySQL / Redis / PHP ワークスペースの compose 定義

## テスト

```bash
php artisan test
npm run lint
npm run build
```

## ライセンス

MIT License
