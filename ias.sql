

CREATE TABLE `instancias` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nomeArquivo` TEXT NOT NULL,
  `arquivo` TEXT NOT NULL,
  `dataCriado` DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `avaliado` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nomeArquivo` TEXT NOT NULL,
  `arquivo` TEXT NOT NULL,
  `dataCriado` DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
