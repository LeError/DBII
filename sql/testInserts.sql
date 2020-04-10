-- Insert Users
INSERT INTO user (username, password) VALUES ("Leoni", "test");
INSERT INTO user (username, password) VALUES ("Moe", "test");
INSERT INTO user (username, password) VALUES ("Malik", "test");
INSERT INTO user (username, password) VALUES ("Robin", "test");

-- Insert Surveys
INSERT INTO survey (title_short, title, username) VALUES ("test0", "TEST 0", "Leoni");
INSERT INTO survey (title_short, title, username) VALUES ("test1", "TEST 1", "Moe");
INSERT INTO survey (title_short, title, username) VALUES ("test2", "TEST 2", "Malik");
INSERT INTO survey (title_short, title, username) VALUES ("test3", "TEST 3", "Robin");

-- Insert Questions
INSERT INTO  question (question, title_short) VALUES ("Is this a good question?", "test0");
INSERT INTO  question (question, title_short) VALUES ("Is this a good question?", "test1");
INSERT INTO  question (question, title_short) VALUES ("Is this a good question?", "test2");
INSERT INTO  question (question, title_short) VALUES ("Is this a good question?", "test3");
INSERT INTO  question (question, title_short) VALUES ("It isnt right?", "test0");
INSERT INTO  question (question, title_short) VALUES ("It isnt right?", "test1");
INSERT INTO  question (question, title_short) VALUES ("It isnt right?", "test2");
INSERT INTO  question (question, title_short) VALUES ("It isnt right?", "test3");

-- Insert Course
INSERT INTO survey_user_group (course_short, course) VALUE ("WWI118BE", "WWI118 Business Engineering");

-- Insert Survey User
INSERT INTO survey_user (matricule_number, username, course_short) VALUES ("0000000", "Rauch, Leonie", "WWI118BE");
INSERT INTO survey_user (matricule_number, username, course_short) VALUES ("1111111", "Buerkle, Moritz", "WWI118BE");
INSERT INTO survey_user (matricule_number, username, course_short) VALUES ("2222222", "Press, Malik Jannico", "WWI118BE");
INSERT INTO survey_user (matricule_number, username, course_short) VALUES ("3333333", "Herder, Robin", "WWI118BE");

-- Insert assign
INSERT INTO assigned (title_short, course_short) VALUES ("test0", "WWI118BE");
INSERT INTO assigned (title_short, course_short) VALUES ("test1", "WWI118BE");
INSERT INTO assigned (title_short, course_short) VALUES ("test2", "WWI118BE");
INSERT INTO assigned (title_short, course_short) VALUES ("test3", "WWI118BE");

-- Insert answer
INSERT INTO answer (id, matricule_number, value) VALUES (1, "2222222", 5);
INSERT INTO answer (id, matricule_number, value) VALUES (2, "2222222", 5);

-- Insert comment
INSERT INTO assigned_comment (title_short, matricule_number, comment) VALUES ("test0", "2222222", "Bester Fragebogen Wallah");

-- Insert status
INSERT INTO assigned_status (title_short, matricule_number) VALUES ("test0", "2222222");