-- データベース作成（存在確認付き）
CREATE DATABASE IF NOT EXISTS agemochi CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ユーザー作成（存在チェックはできないのでエラーを許容）
CREATE USER IF NOT EXISTS 'agemochi_user'@'%' IDENTIFIED BY 'secret';

-- 権限付与（すでにあっても問題なし）
GRANT ALL PRIVILEGES ON agemochi.* TO 'agemochi_user'@'%';

FLUSH PRIVILEGES;
