https://user-images.githubusercontent.com/97070988/186443548-8f86d7bb-4ebe-4315-9209-6f933577c514.gif

# 勤怠管理を行うシステムです

　WEB上で、出退勤時間の打刻・管理を行うことができるシステムを個人開発しました。

　レスポンシブ対応となっていますので、スマホやタブレットからもご確認いただけます。

## 開発までの経緯

　毎月ハローワークに失業手当の受給申請を行うために、失業認定申請書と別紙に就労移行支援サービスの利用日時の記載が必要となっています。

　そのため、ハローワークに行く前日にはタイムカードを写真に撮り、自宅に帰ってから記載していましたが、写真を取り忘れることもありました。

　写真の撮り忘れをミスを防く方法はないか、かつWEB上で確認できる手段を考え、本システムを開発しました。
 
　システム開発にあたっては、私個人だけが使うためだけでなく、勤怠管理が必要な個人事業主などの小規模企業者を顧客モデルをペルソナとして定義の上、必要な機能をイメージして開発を行っております。
 
## URL

　**[こちらのリンクから、出退勤画面に移動できます。](https://attendance-managements.herokuapp.com/)**

　**[こちらのリンクから、管理用画面に移動できます。](https://attendance-managements.herokuapp.com/admin)**
 
　↓ ログイン情報は以下の通りです。
  
　・社員番号（管理者番号）：1001
 
　・パスワード：password123

## 機能一覧
- **出退勤画面側**
    - ログイン
    - 勤務時間の打刻（出勤、退勤）
    - 日報の登録
    - 勤怠情報の閲覧（当月から過去1年分）
    - 部下一覧
        - 勤怠情報の閲覧・編集
        - 部下のパスワードの変更
    - パスワードの変更


- **管理用画面側**
    - ログイン
    - 社員一覧
        - 社員の検索
        - 社員情報の編集
            - 退職・復職処理
        - 勤怠情報の閲覧・編集
        - 社員のパスワードの変更
        - 退職者の表示
        - 時短社員の表示
    - 社員の新規登録
    - 管理画面
        - 就業時間の変更（時短社員を除く）
    - パスワードの変更
 
## 設計書

　ポートフォリオの作成に辺り、要件設計・画面詳細・テーブル定義書・試験項目表などを作成しております。
 
 　**[こちらのリンクから、ご覧いただけます。](doc)**

## 実装環境

　バックエンド　： PHP(8.1.6) , Laravel8  , MySQL

　フロントエンド： HTML・CSS, JavaScript, Bootstrap5, Tailwind CSS v2.0
 
## SSL設定について
　ポートフォリオ公開のため、Herokuで無料公開としておりSSL設定がされていません。