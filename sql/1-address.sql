CREATE TABLE `address_book` (
`id` int(11) NOT NULL,
`address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `address_book`
ADD PRIMARY KEY (`id`);

ALTER TABLE `address_book`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `address_book` (`id`, `address`) VALUES
(1, '560 Spadafore Drive'),
(2, '4096 Locust View Drive'),
(3, '3204 Sweetwood Drive'),
(4, '379 Garfield Road'),
(5, '4620 Clair Street');