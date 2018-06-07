SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


CREATE TABLE `friends` (
  `userid` int(11) NOT NULL,
  `friend_userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `messages` (
  `to_userid` int(11) NOT NULL,
  `from_userid` int(11) NOT NULL,
  `text` varchar(500) NOT NULL,
  `ts` int(11) NOT NULL,
  `already_read` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `screenname` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `comment` varchar(50) NOT NULL,
  `image_url` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `friends`
  ADD UNIQUE KEY `userid` (`userid`,`friend_userid`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`username`),
  ADD KEY `id` (`id`);


ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
