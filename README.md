# NExT Query Loop Link Target

クエリーループブロック（`core/query`）のインスペクターパネルに **「新しいタブでリンクを開く」** トグルを追加する WordPress プラグインです。

## 機能

- クエリーループブロックの設定サイドバーに「リンクターゲット」パネルを追加
- トグルをオンにすると、そのクエリーループ内のすべての `<a>` タグに `target="_blank" rel="noopener noreferrer"` が付与される
- すでに `target` 属性が指定されているリンクは変更されない

## セットアップ

### 依存パッケージのインストールとビルド

```bash
cd /path/to/NExT-Query-Loop-Link-Target
npm install
npm run build
```

### 開発時（ファイル変更を監視）

```bash
npm start
```

## プレフィックス

| 種別 | 値 |
|------|-----|
| PHP 関数・フック | `nqllt_` |
| JS フィルター namespace | `nqllt/` |
| ブロック属性キー | `nqlltOpenInNewTab` |
| スクリプトハンドル | `nqllt-editor` |
| テキストドメイン | `nqllt` |

## ファイル構成

```
NExT-Query-Loop-Link-Target/
├── nqllt.php          # メインプラグインファイル
├── src/
│   └── index.js       # エディター拡張 JS（JSX）
├── build/             # ビルド後に生成される（git 管理外推奨）
│   ├── index.js
│   └── index.asset.php
└── package.json
```

## 仕組み

1. **JS（エディター側）**: `blocks.registerBlockType` フィルターで `core/query` ブロックに `nqlltOpenInNewTab`（boolean）属性を追加し、`editor.BlockEdit` フィルターでインスペクターにトグルコントロールを表示する。
2. **PHP（フロントエンド側）**: `render_block_core/query` フィルターで、属性が `true` のときレンダリング済み HTML 内の `<a>` タグに `target="_blank"` を付与する。
