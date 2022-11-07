https://user-images.githubusercontent.com/97070988/186443548-8f86d7bb-4ebe-4315-9209-6f933577c514.gif

# 勤怠管理を行うシステムです

　WEB上で、出退勤時間の打刻・管理を行うことができるシステムを個人開発しました。

　レスポンシブ対応となっていますので、スマホやタブレットからもご確認いただけます。

## 本システムの特徴
- **本システム開発の顧客モデル**
 
    - 本システムは、社員を雇い勤怠管理が必要となった個人事業主の方や、会社規模を拡大し勤務時間の管理・集計の簡略化を目指す小規模企業者を顧客モデルをペルソナとして定義しました。
 
 - **工夫した点**
    - 開発にあたり、社員・部下を抱える社員・統括部門や人事部門の社員の3者間を想定したシステムをしました。
        - **[設計書の要件設計に画像付きでイメージ図を記載しています。(クリックで移動できます。）](doc/01.要件設計.pdf)**

    - 勤務時間の管理を行うために、ログインした社員が自分自身の勤怠の修正はできないようにし、上司のみが勤怠の変更を行うようにしました。
        - 機能実装のため、社員の登録情報を管理するデータベースのテーブルとは別に、上司と部下の情報を管理する階層のテーブルを設けることで実現ができました。

    - 勤務時間の計算を行う上で、会社全体の就業時間を9時～18時と設定し、9時より早く出勤を打刻した場合は、9時から労働時間のカウントを行い、18時以降に退勤を打刻した場合は、超過した時間を残業時間としてカウントするようプログラミングを行いました。
        - 会社全体の就業時間の変更に備え、一人ひとりの登録情報の変更のではなく、管理画面で一括で変更できるようにしています。
        - 時短勤務の社員もいる場合に備えて、9時～18時に当てはまらない社員はデータベースのテーブルに時短フラグを付与し、一括変更の対象外としました。
     
## URL

　**[こちらのリンクから、出退勤画面に移動できます。](https://attendance-managements.work/)**

　**[こちらのリンクから、管理用画面に移動できます。](https://attendance-managements.work/admin)**
 
　↓ ログイン情報は以下の通りです。
  
　・社員番号（管理者番号）：1001
 
　・パスワード：password123

## 機能一覧
- **出退勤画面側**
    - ログイン
    - 勤務時間の打刻（出勤、退勤）
    - 日報の登録
    - 勤怠情報の閲覧（当月から過去1年分）
         - 選択期間の合計表示
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
            - 選択期間の合計表示
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
　AWS(Amazon Web Services)にてSSL設定をした上で、ポートフォリオを公開しております。
 
