CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) COLLATE utf8mb4_persian_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_persian_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

COMMIT;
