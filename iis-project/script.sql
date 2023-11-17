-- CREATE DATABASE
USE iis;

DROP TABLE IF EXISTS RATING_T CASCADE;
DROP TABLE IF EXISTS POSTS_T CASCADE;
DROP TABLE IF EXISTS THREADS_T CASCADE;
DROP TABLE IF EXISTS GROUP_MEMBERS_T CASCADE;
DROP TABLE IF EXISTS GROUP_JOIN_REQUESTS_T CASCADE;
DROP TABLE IF EXISTS GROUP_ROLE_REQUEST_T CASCADE;
DROP TABLE IF EXISTS GROUPS_T CASCADE;
DROP TABLE IF EXISTS USERS_T CASCADE;

-- Users Table
CREATE TABLE USERS_T (
    user_id INT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    is_public BOOLEAN NOT NULL,
    is_admin BOOLEAN NOT NULL
);

-- Groups Table
CREATE TABLE GROUPS_T (
    group_id INT PRIMARY KEY,
    group_name VARCHAR(255) NOT NULL,
    group_description TEXT
);

-- Group Role Requests Table
CREATE TABLE GROUP_ROLE_REQUEST_T (
    requester_id INT,
    group_id INT,
    FOREIGN KEY (requester_id) REFERENCES USERS_T(user_id) ON DELETE CASCADE,
    FOREIGN KEY (group_id) REFERENCES GROUPS_T(group_id) ON DELETE CASCADE,
    PRIMARY KEY (requester_id, group_id)
);

-- Group Join Requests Table
CREATE TABLE GROUP_JOIN_REQUESTS_T (
    requester_id INT,
    group_id INT,
    FOREIGN KEY (requester_id) REFERENCES USERS_T(user_id) ON DELETE CASCADE,
    FOREIGN KEY (group_id) REFERENCES GROUPS_T(group_id) ON DELETE CASCADE,
    PRIMARY KEY (requester_id, group_id)
);

-- Group Members Table
CREATE TABLE GROUP_MEMBERS_T (
    group_id INT,
    user_id INT,
    member_role ENUM('owner', 'moderator', 'regular'),
    FOREIGN KEY (group_id) REFERENCES GROUPS_T(group_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES USERS_T(user_id) ON DELETE CASCADE,
    PRIMARY KEY (group_id, user_id)
);

-- Threads Table
CREATE TABLE THREADS_T (
    thread_id INT PRIMARY KEY,
    group_id INT,
    user_id INT,
    topic VARCHAR(255) NOT NULL,
    FOREIGN KEY (group_id) REFERENCES GROUPS_T(group_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES USERS_T(user_id) ON DELETE CASCADE
);

-- Posts Table
CREATE TABLE POSTS_T (
    post_id INT PRIMARY KEY,
    thread_id INT,
    user_id INT,
    post_content TEXT,
    FOREIGN KEY (thread_id) REFERENCES THREADS_T(thread_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES USERS_T(user_id) ON DELETE CASCADE
);

-- Rating Table
CREATE TABLE RATING_T (
    user_id INT,
    post_id INT,
    type ENUM('like', 'dislike'),
    FOREIGN KEY (user_id) REFERENCES USERS_T(user_id) ON DELETE CASCADE,
    FOREIGN KEY (post_id) REFERENCES POSTS_T(post_id) ON DELETE CASCADE
);

-- FILL DATABASE
-- Insert Users
-- password_bcrypt in passqord_hash()
INSERT INTO USERS_T (user_id, username, password_hash, is_public, is_admin) VALUES (1, 'Alice', '$2y$10$8nuKig2hg6Kz3REOk8k8EuSZvPZW4obcwm34tXWicH7orxQEXFHSm', TRUE, FALSE), (2, 'Bob', '$2y$10$3uWRft8x/6bBaS1D0nxvwessTHyL7E1DEv5W5aad2ey1PEzfpeqou', TRUE, FALSE), (3, 'Charlie', '$2y$10$7xn03aupjBLrpxHcUDP7Fu/PiNQYysGNgS6WH6z5hnQ0z1duUXHRW', FALSE, FALSE), (4, 'DavidNonAdmin', '$2y$10$swRmEHKczw6xAXF0ML/qgeEecaOgZKtE266BF7lUapDmLWvCErJ0.', TRUE, FALSE), (5, 'Eve', '$2y$10$qgiZXzFL4.l10eu0QcccnuC4Xm.srjVB26qHVWdgj4eL7WWL4V2iC', FALSE, FALSE), (6, 'Faythe', '$2y$10$egdDR64sq1l0/bWHPu987.47..Mnrwu7PRvR.ORCXs3H2J2TlPBgS', TRUE, FALSE), (7, 'Grace', '$2y$10$dldc5BNnSnwki2OpRY1VXuqh4V.YSinbzvE0c/NVZfKZximcB6pcm', FALSE, FALSE), (8, 'Heidi', '$2y$10$RYx74kkEnhZWc5KbpibxqubdcJul/cLWkn9YgaHGEgESE63z0TNjq', TRUE, FALSE), (9, 'Ivan', '$2y$10$w2x/excwruQOCaJ3Y3X/ruz15CB3DRmwEVWhrBjblfxkGIL4UMJnW', FALSE, FALSE), (10, 'Judy', '$2y$10$i1wU9WoEBeIkrN7F9mrdZuCy/h/yF7MaWlj9OGuOb4f8KCHldJ79K', TRUE, FALSE);

-- Insert admin accounts
INSERT INTO USERS_T (user_id, username, password_hash, is_public, is_admin) VALUES (69, 'PetrAdmin', '$2y$10$/qkuwB.ctpw/mlTASsmbzellZQWUmvpK5RUSymGL7maEL/JIQh.qi', TRUE, TRUE);
INSERT INTO USERS_T (user_id, username, password_hash, is_public, is_admin) VALUES (420, 'DavidAdmin', '$2y$10$FQ6S7aW2niDCZoj6EoiF.O2Vs9zO8asGa6JFXQtQJ.PPg.F0.aa.O', TRUE, TRUE);

-- Insert Groups
INSERT INTO GROUPS_T (group_id, group_name, group_description) VALUES (1, 'GroupA', 'This is Group A');
INSERT INTO GROUPS_T (group_id, group_name, group_description) VALUES (2, 'GroupB', 'This is Group B');
INSERT INTO GROUPS_T (group_id, group_name, group_description) VALUES (3, 'GroupC', 'This is Group C');
INSERT INTO GROUPS_T (group_id, group_name, group_description) VALUES (4, 'GroupD', 'This is Group D');
INSERT INTO GROUPS_T (group_id, group_name, group_description) VALUES (5, 'GroupE', 'This is Group E');

-- Set Admins for each group
-- Group A
INSERT INTO GROUP_MEMBERS_T (group_id, user_id, member_role) VALUES (1, 5, 'owner');

-- Group B
INSERT INTO GROUP_MEMBERS_T (group_id, user_id, member_role) VALUES (2, 6, 'owner');

-- Group C
INSERT INTO GROUP_MEMBERS_T (group_id, user_id, member_role) VALUES (3, 5, 'owner');
INSERT INTO GROUP_MEMBERS_T (group_id, user_id, member_role) VALUES (3, 6, 'owner');

-- Group D
INSERT INTO GROUP_MEMBERS_T (group_id, user_id, member_role) VALUES (4, 5, 'owner');

-- Group E
INSERT INTO GROUP_MEMBERS_T (group_id, user_id, member_role) VALUES (5, 6, 'owner');

-- Add non owner users to groups
INSERT INTO GROUP_MEMBERS_T (group_id, user_id, member_role) VALUES 
(1, 1, 'regular'), (1, 2, 'regular'), (1, 3, 'regular'), (1, 4, 'regular'), (1, 6, 'regular'), (1, 7, 'regular'), (1, 8, 'regular'), (1, 9, 'regular'), (1, 10, 'regular'), (2, 1, 'regular'), (2, 2, 'regular'), (2, 3, 'regular'), (2, 4, 'regular'), (2, 5, 'regular'), (2, 7, 'regular'), (2, 8, 'regular'), (2, 9, 'regular'), (2, 10, 'regular'), (3, 1, 'regular'), (3, 2, 'regular'), (3, 3, 'regular'), (3, 4, 'regular'), (3, 7, 'regular'), (3, 8, 'regular'), (3, 9, 'regular'), (3, 10, 'regular'), (4, 1, 'regular'), (4, 3, 'regular'), (4, 4, 'regular'), (4, 7, 'regular'), (4, 9, 'regular'), (5, 1, 'regular'), (5, 2, 'regular'), (5, 3, 'regular'), (5, 4, 'regular');

