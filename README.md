https://user-images.githubusercontent.com/97070988/186443548-8f86d7bb-4ebe-4315-9209-6f933577c514.gif

# 勤怠管理を行うシステムです

　WEB上で、出退勤時間の打刻・管理を行うことができるシステムを個人開発しました。

　レスポンシブ対応となっていますので、スマホやタブレットからもご確認いただけます。

## 本システムの特徴
- **本システム開発の顧客モデル**
 
    - 本システムは、社員を雇い勤怠管理が必要となった個人事業主の方や、会社規模を拡大し勤務時間の管理・集計の簡略化を目指す小規模企業者を顧客モデルをペルソナとして定義しました。
 
 - **工夫した点**
    <details><summary>１. 社員・上司・人事課の3者間を想定したシステムで設計しました。</summary>
    　開発にあたり、社員とその上司、統括部門や人事課の社員といった3者間を想定したシステムを設計しました。</br>
    　<a href="https://drive.google.com/file/d/143bPEoMrf6qgVqQ6PF_Fgwe8OdsNH4W7">要件設計書には、画像付きのイメージ図を記載しています。クリックして移動できます。</a>
    </details>
    
    <details><summary>２.上司のみが部下の勤怠の変更を行うことが出来るよう設計しました。</summary>
    　勤務時間の管理を行うために、ログインした社員が自分自身の勤怠の修正はできないようにし、上司のみが勤怠の変更を行うようにしました。</br>
    　・機能実装のため、社員の登録情報を管理するデータベースのテーブルとは別に、上司と部下の情報を管理する階層のテーブルを設けることで実現ができました。
    </details>
    
    <details><summary>３.勤怠情報を.xlsx形式でダウンロード出来るようにしました。</summary>
    　出勤簿として提出・管理ができるように、勤怠情報の画面で選択した期間の始業時間・終業時間・所定労働時間・時間外を.xlsx形式でダウンロード出来るようにプログラムを行いました。</br>
    　・一度に出力できる期間は、最大30日としています。</br>
    　・選択期間内で勤怠情報がない場合は日付と曜日のみを出力して、連続した日付で勤怠情報を確認ができるようにしています。</br>
    　<a href="https://drive.google.com/file/d/1TweFr9RwKIJXtoqDT5OTpJxTj7C31eWs/view?usp=sharing">・出勤簿のサンプルはこちらからご覧いただけます。(クリックで移動できます。）</a>
    </details>
    
    <details><summary>４.出勤時間と退勤時間を元に、残業時間が自動計算されるようにしました。</summary>
    　勤務時間の計算を行う上で、会社全体の所定労働時間を9時～18時と設定し、9時より早く出勤を打刻した場合は、9時から労働時間のカウントを行い、18時以降に退勤を打刻した場合は、超過した時間を残業時間としてカウントするようプログラミングを行いました。</br>
    　・会社全体の所定労働時間の変更に備え、一人ひとりの登録情報の変更のではなく、管理画面で一括で変更できるようにしています。</br>
    　・時短勤務の社員もいる場合に備えて、9時～18時に当てはまらない社員はデータベースのテーブルに時短フラグを付与し、一括変更の対象外としました。</br>
    </details>
    
    <details><summary>５..xlsx形式のファイルを取り込み、社員の一括登録が出来るようにしました。</summary>
    　.xlsx形式のファイルを読み込み、一括で社員登録が出来るようにプログラムを行いました。</br>
    　・読み込む行・列を指定し、バリエーションチェックを行った上で、社員情報が登録されるようにしています。</br>
    　・重複登録を避けるため、シートに入力の人名をデータベースから検索し、すでに社員情報が登録されている場合は読込を中断、シートに同一人名が複数入力されている場合は1人分のみ登録されるようにしています。</br>
    </details>
    
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
         - 出勤簿の出力（.xlsxファイル形式）
    - 部下一覧
        - 勤怠情報の閲覧・編集
        - 出勤簿の出力（.xlsxファイル形式）
        - 部下のパスワードの変更
    - パスワードの変更


- **管理用画面側**
    - ログイン
    - 社員一覧
        - 社員の検索
        - 社員情報の編集
            - 退職・復職処理
        - 勤怠情報の閲覧・編集
            - 出勤簿の出力（選択期間内の始業時間、終業時間、労働時間）
        - 社員のパスワードの変更
        - 退職者の表示
        - 時短社員の表示
    - 社員の新規登録
    - 管理画面
        - 所定労働時間の変更（時短社員を除く）
        - 社員名簿のダウンロード（.xlsxファイル形式）
        - 社員の一括登録(.xlsxファイル読込)
    - パスワードの変更
 
## 設計書

　ポートフォリオの作成に辺り、要件設計・画面詳細・テーブル定義書・試験項目表などを作成しております。
 
 　**[こちらのリンクから、ご覧いただけます。](doc)**

## 実装環境

　バックエンド　： PHP(8.1.6) , Laravel8  , MySQL

　フロントエンド： HTML・CSS, JavaScript, Bootstrap5, Tailwind CSS v2.0
 
## SSL設定について
　AWS(Amazon Web Services)にてSSL設定をした上で、ポートフォリオを公開しております。
 
