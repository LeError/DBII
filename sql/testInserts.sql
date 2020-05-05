USE survey_site;

-- Insert Users
INSERT INTO user (username, password) VALUES ("Leoni", "$2y$10$bFmkrG6gAem093R2tqNhZuL4xWAxYdThrEhHKp7t4ed8jE6eiWhbm");
INSERT INTO user (username, password) VALUES ("Moe", "$2y$10$bFmkrG6gAem093R2tqNhZuL4xWAxYdThrEhHKp7t4ed8jE6eiWhbm");
INSERT INTO user (username, password) VALUES ("Malik", "$2y$10$bFmkrG6gAem093R2tqNhZuL4xWAxYdThrEhHKp7t4ed8jE6eiWhbm");
INSERT INTO user (username, password) VALUES ("Robin", "$2y$10$bFmkrG6gAem093R2tqNhZuL4xWAxYdThrEhHKp7t4ed8jE6eiWhbm");

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
INSERT INTO survey_user_group (course_short, course) VALUE ("WWI117DS", "WWI117 Data Science");

-- Insert Survey User
INSERT INTO survey_user (matricule_number, username, course_short) VALUES ("0000000", "Rauch, Leonie", "WWI118BE");
INSERT INTO survey_user (matricule_number, username, course_short) VALUES ("1111111", "Buerkle, Moritz", "WWI118BE");
INSERT INTO survey_user (matricule_number, username, course_short) VALUES ("2222222", "Press, Malik Jannico", "WWI118BE");
INSERT INTO survey_user (matricule_number, username, course_short) VALUES ("3333333", "Herder, Robin", "WWI118BE");
INSERT INTO survey_user (matricule_number, username, course_short) VALUES ("4444444", "Bernd, Das Brot", "WWI117DS");
INSERT INTO survey_user (matricule_number, username, course_short) VALUES ("5555555", "Trump, Donald", "WWI117DS");
INSERT INTO survey_user (matricule_number, username, course_short) VALUES ("6666666", "Merkel, Angela", "WWI117DS");

-- Insert assign
INSERT INTO assigned (title_short, course_short) VALUES ("test0", "WWI118BE");
INSERT INTO assigned (title_short, course_short) VALUES ("test1", "WWI118BE");
INSERT INTO assigned (title_short, course_short) VALUES ("test2", "WWI118BE");
INSERT INTO assigned (title_short, course_short) VALUES ("test3", "WWI118BE");
INSERT INTO assigned (title_short, course_short) VALUES ("test0", "WWI117DS");
INSERT INTO assigned (title_short, course_short) VALUES ("test1", "WWI117DS");

-- Insert answer
INSERT INTO answer (id, matricule_number, value) VALUES (1, "2222222", 5);
INSERT INTO answer (id, matricule_number, value) VALUES (2, "2222222", 5);
INSERT INTO answer (id, matricule_number, value) VALUES (1, "4444444", 5);
INSERT INTO answer (id, matricule_number, value) VALUES (5, "4444444", 5);
INSERT INTO answer (id, matricule_number, value) VALUES (1, "5555555", 5);
INSERT INTO answer (id, matricule_number, value) VALUES (5, "5555555", 5);
INSERT INTO answer (id, matricule_number, value) VALUES (1, "6666666", 1);
INSERT INTO answer (id, matricule_number, value) VALUES (5, "6666666", 1);

-- Insert comment
INSERT INTO assigned_comment (title_short, matricule_number, comment) VALUES ("test0", "2222222", "Bester Fragebogen Wallah");
INSERT INTO assigned_comment (title_short, matricule_number, comment) VALUES ("test0", "4444444", "Mist!");
INSERT INTO assigned_comment (title_short, matricule_number, comment) VALUES ("test0", "5555555", "America first.");
INSERT INTO assigned_comment (title_short, matricule_number, comment) VALUES ("test0", "6666666", "Wir schaffen das!");

-- Insert status
INSERT INTO assigned_status (title_short, matricule_number) VALUES ("test0", "2222222");
INSERT INTO assigned_status (title_short, matricule_number) VALUES ("test0", "4444444");
INSERT INTO assigned_status (title_short, matricule_number) VALUES ("test0", "5555555");
INSERT INTO assigned_status (title_short, matricule_number) VALUES ("test0", "6666666");