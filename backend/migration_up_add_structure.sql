CREATE TABLE user
(
    id SERIAL,
    login VARCHAR(255),
    hash VARCHAR(255),
    salt VARCHAR(255),
    token VARCHAR(255)
);
CREATE INDEX IX_user_login ON user (login);
CREATE INDEX IX_user_token ON user (token);

CREATE TABLE `group`
(
    id SERIAL,
    name VARCHAR(255)
);
CREATE INDEX IX_group_name ON `group` (name);

CREATE TABLE student
(
    id SERIAL,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    group_id BIGINT UNSIGNED,
    checked TINYINT(1) DEFAULT 0,
    CONSTRAINT FK_student_group_id
    FOREIGN KEY (group_id)
        REFERENCES `group`(id)
);
CREATE INDEX IX_group_name ON student (first_name, last_name);
