-- CREATE DATABASE
-- Users Table
CREATE TABLE USERS (
    user_id INT PRIMARY KEY ON DELETE CASCADE,
    username VARCHAR(255) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    is_public BOOLEAN NOT NULL,
    is_admin BOOLEAN NOT NULL
);

-- Groups Table
CREATE TABLE GROUPS (
    group_id INT PRIMARY KEY ON DELETE CASCADE,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    icon LONGBLOB
);

-- Group Role Requests Table
CREATE TABLE GROUP_ROLE_REQUEST (
    requester_id INT,
    group_id INT,
    FOREIGN KEY (requester_id) REFERENCES USERS(user_id),
    FOREIGN KEY (group_id) REFERENCES GROUPS(group_id),
    PRIMARY KEY (requester_id, approver_id, group_id)
);

-- Group Join Requests Table
CREATE TABLE GROUP_JOIN_REQUESTS (
    requester_id INT,
    group_id INT,
    FOREIGN KEY (requester_id) REFERENCES USERS(user_id),
    FOREIGN KEY (group_id) REFERENCES GROUPS(group_id),
    PRIMARY KEY (requester_id, approver_id, group_id)
);

-- Group Members Table
CREATE TABLE GROUP_MEMBERS (
    group_id INT,
    user_id INT,
    role ENUM('admin', 'registered', 'anonymous'),
    FOREIGN KEY (group_id) REFERENCES GROUPS(group_id),
    FOREIGN KEY (user_id) REFERENCES USERS(user_id),
    PRIMARY KEY (group_id, user_id)
);

-- Threads Table
CREATE TABLE THREADS (
    thread_id INT PRIMARY KEY ON DELETE CASCADE,
    group_id INT,
    user_id INT,
    topic VARCHAR(255) NOT NULL,
    FOREIGN KEY (group_id) REFERENCES GROUPS(group_id),
    FOREIGN KEY (user_id) REFERENCES USERS(user_id)
);

-- Posts Table
CREATE TABLE POSTS (
    post_id INT PRIMARY KEY ON DELETE CASCADE,
    thread_id INT,
    user_id INT,
    content TEXT
);

-- Rating Table
CREATE TABLE RATING (
    FOREIGN KEY (user_id) REFERENCES USERS(user_id),
    FOREIGN KEY (post_id) REFERENCES POSTS(post_id),
    type ENUM('like', 'dislike')
);

-- FILL DATABASE
-- Insert Users
-- password_bcrypt in passqord_hash()
INSERT INTO USERS (user_id, username, password_hash, is_public, is_admin) VALUES (1, 'Alice', '$2y$10$8nuKig2hg6Kz3REOk8k8EuSZvPZW4obcwm34tXWicH7orxQEXFHSm', TRUE, FALSE), (2, 'Bob', '$2y$10$3uWRft8x/6bBaS1D0nxvwessTHyL7E1DEv5W5aad2ey1PEzfpeqou', TRUE, FALSE), (3, 'Charlie', '$2y$10$7xn03aupjBLrpxHcUDP7Fu/PiNQYysGNgS6WH6z5hnQ0z1duUXHRW', FALSE, FALSE), (4, 'DavidNonAdmin', '$2y$10$swRmEHKczw6xAXF0ML/qgeEecaOgZKtE266BF7lUapDmLWvCErJ0.', TRUE, FALSE), (5, 'Eve', '$2y$10$qgiZXzFL4.l10eu0QcccnuC4Xm.srjVB26qHVWdgj4eL7WWL4V2iC', FALSE, FALSE), (6, 'Faythe', '$2y$10$egdDR64sq1l0/bWHPu987.47..Mnrwu7PRvR.ORCXs3H2J2TlPBgS', TRUE, FALSE), (7, 'Grace', '$2y$10$dldc5BNnSnwki2OpRY1VXuqh4V.YSinbzvE0c/NVZfKZximcB6pcm', FALSE, FALSE), (8, 'Heidi', '$2y$10$RYx74kkEnhZWc5KbpibxqubdcJul/cLWkn9YgaHGEgESE63z0TNjq', TRUE, FALSE), (9, 'Ivan', '$2y$10$w2x/excwruQOCaJ3Y3X/ruz15CB3DRmwEVWhrBjblfxkGIL4UMJnW', FALSE, FALSE), (10, 'Judy', '$2y$10$i1wU9WoEBeIkrN7F9mrdZuCy/h/yF7MaWlj9OGuOb4f8KCHldJ79K', TRUE, FALSE);

-- Insert admin accounts
INSERT INTO USERS (user_id, username, password_hash, is_public, is_admin) VALUES (69, 'PetrAdmin', '$2y$10$/qkuwB.ctpw/mlTASsmbzellZQWUmvpK5RUSymGL7maEL/JIQh.qi', TRUE, TRUE);
INSERT INTO USERS (user_id, username, password_hash, is_public, is_admin) VALUES (420, 'DavidAdmin', '$2y$10$FQ6S7aW2niDCZoj6EoiF.O2Vs9zO8asGa6JFXQtQJ.PPg.F0.aa.O', TRUE, TRUE);

-- Insert Groups
INSERT INTO GROUPS (group_id, name, description, icon) VALUES (1, 'GroupA', 'This is Group A', '');
INSERT INTO GROUPS (group_id, name, description, icon) VALUES (2, 'GroupB', 'This is Group B', '');
INSERT INTO GROUPS (group_id, name, description, icon) VALUES (3, 'GroupC', 'This is Group C', '');
INSERT INTO GROUPS (group_id, name, description, icon) VALUES (4, 'GroupD', 'This is Group D', '');
INSERT INTO GROUPS (group_id, name, description, icon) VALUES (5, 'GroupE', 'This is Group E', '');

-- Set Admins for each group
-- Group A
INSERT INTO GROUP_MEMBERS (group_id, user_id, role) VALUES (1, 5, 'admin');

-- Group B
INSERT INTO GROUP_MEMBERS (group_id, user_id, role) VALUES (2, 6, 'admin');

-- Group C
INSERT INTO GROUP_MEMBERS (group_id, user_id, role) VALUES (3, 5, 'admin');
INSERT INTO GROUP_MEMBERS (group_id, user_id, role) VALUES (3, 6, 'admin');

-- Group D
INSERT INTO GROUP_MEMBERS (group_id, user_id, role) VALUES (4, 5, 'admin');

-- Group E
INSERT INTO GROUP_MEMBERS (group_id, user_id, role) VALUES (5, 6, 'admin');

-- Note: Additional group members (non-admins) are not inserted here. Add as required.

