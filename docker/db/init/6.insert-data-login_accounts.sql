USE docker_php_batch_db;

SET NAMES utf8mb4;

START TRANSACTION;

INSERT INTO login_accounts VALUES (1, 'admin', '$2y$10$nYG/BymkZz/W8hybdu1SZ.PiSx/GkW38H6pdDLIztX3mDnKR3GeS2', 'テストユーザー1', NOW(), NOW());
INSERT INTO login_accounts VALUES (2, 'root', '$2y$10$qgzrf3fMbs.Ym2Wr5M8vHOjwtC5hlv482Rf/tpnguEfhZZ71nw7fK', 'テストユーザー2', NOW(), NOW());
INSERT INTO login_accounts VALUES (3, 'test123', '$2y$10$Mo2niGe5CJHOrwC1bFOD6.W3pOK7HCuUvVSRpH2xIqGEV1APLEIL6', 'テストユーザー3', NOW(), NOW());

COMMIT;
