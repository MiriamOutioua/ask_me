CREATE DATABASE IF NOT EXISTS ask_me_db;

USE ask_me_db;

SET SQL_MODE='ALLOW_INVALID_DATES';

CREATE TABLE answers (
	a_id int(25) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	a_author varchar(255) NOT NULL,
	a_content text NOT NULL,
	post_id int(25) NOT NULL,
	a_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	like_count int(25) NOT NULL DEFAULT '0',
	a_uid int(25) NOT NULL,
	a_edit_date timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE follow (
  f_id int(25) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  f_user_id int(25) NOT NULL,
  f_suivre int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8; 

CREATE TABLE likes (
  l_id int(25) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  answer_id int(25) NOT NULL,
  l_uid int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE posts (
  p_id int(25) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  p_title varchar(256) NOT NULL,
  p_tags varchar(256) NOT NULL,
  p_content text NOT NULL,
  p_author varchar(256) NOT NULL,
  p_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  p_uid int(25) DEFAULT NULL,
  p_edit_date timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE users (
  id int(25) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  username varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  isAdmin tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO users (id, username, email, password, isAdmin) VALUES (1, 'Admin', 'admin@gmail.com', '1a1dc91c907325c69271ddf0c944bc72', 1);

INSERT INTO users (id, username, email, password, isAdmin) VALUES (2, 'User', 'user@gmail.com', 'ee11cbb19052e40b07aac0ca060c23ee', 0);

INSERT INTO users (id, username, email, password, isAdmin) VALUES (3, 'User2', 'user2@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 0);

INSERT INTO posts (p_id, p_title, p_tags, p_content, p_author, p_date, p_uid, p_edit_date) VALUES (1, 'Comment faire un lien en html ?', '#html #lorem', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus dolor quod dignissimos dicta est animi tenetur ipsum expedita voluptates consequatur ab molestiae, ipsam mollitia assumenda aliquid fuga deleniti autem veniam! Optio necessitatibus quia pariatur, a eveniet impedit ducimus rem nulla earum dolores vitae repellat hic quas rerum nemo odio veniam nam, cumque vel eligendi reiciendis excepturi! Esse quis minima rerum.', 'User2' , '2021-05-10 15:32:48', 3, '0000-00-00 00:00:00');
INSERT INTO posts (p_id, p_title, p_tags, p_content, p_author, p_date, p_uid, p_edit_date) VALUES (2, 'Quelle est la tour la plus haute du monde ?', '#tour' ,'Bonjour, quelques jours plus tôt Optio necessitatibus quia pariatur, a eveniet impedit ducimus rem nulla earum dolores vitae repellat hic quas rerum nemo odio veniam nam, cumque vel eligendi reiciendis excepturi! Esse quis minima rerum.', 'User', '2021-05-10 16:15:48', 2, '0000-00-00 00:00:00');
INSERT INTO posts (p_id, p_title, p_tags, p_content, p_author, p_date, p_uid, p_edit_date) VALUES (3, 'Quelle est la langue la plus parlée ?', '#langue', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum quod harum.', 'User', '2021-05-10 16:30:48', 2, '0000-00-00 00:00:00');

INSERT INTO answers (a_id, a_author, a_content, post_id, a_date, like_count, a_uid, a_edit_date) VALUES (1, 'Admin', "Voici un exemple de lien html : &lt;a href=&quot;lien.html&quot;&gt;Lien&lt;/a&gt;", 1, '2021-05-10 16:32:30', 2, 1, '0000-00-00 00:00:00');
INSERT INTO answers (a_id, a_author, a_content, post_id, a_date, like_count, a_uid, a_edit_date) VALUES (2, 'User2', 'La tour Khalifa à Dubaï est la plus grande avec ses 828 mètres !', 2, '2021-05-10 16:50:30', 2, 3, '0000-00-00 00:00:00');

INSERT INTO likes (l_id, answer_id, l_uid) VALUES (1, 2, 1);
INSERT INTO likes (l_id, answer_id, l_uid) VALUES (2, 2, 2);
INSERT INTO likes (l_id, answer_id, l_uid) VALUES (3, 1, 2);
INSERT INTO likes (l_id, answer_id, l_uid) VALUES (4, 1, 3);

INSERT INTO follow (f_id, f_user_id, f_suivre) VALUES (1, 3, 2);
INSERT INTO follow (f_id, f_user_id, f_suivre) VALUES (2, 3, 1);
INSERT INTO follow (f_id, f_user_id, f_suivre) VALUES (3, 2, 1);
INSERT INTO follow (f_id, f_user_id, f_suivre) VALUES (4, 1, 2);