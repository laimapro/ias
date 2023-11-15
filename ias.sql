

CREATE TABLE `avaliado` (
  `id` int(11) NOT NULL,
  `nomeArquivo` text NOT NULL,
  `arquivo` text NOT NULL,
  `dataCriado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `deficiencia` (
  `id` int(11) NOT NULL,
  `deficiencia` varchar(110) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `deficiencia` (`id`, `deficiencia`) VALUES
(1, 'Prefiro não informar'),
(2, 'Eu me identifico como uma pessoa com deficiência visual'),
(3, 'Eu me identifico como uma pessoa com baixa visão'),
(4, 'Eu me identifico como cego'),
(5, 'Eu me identifico como uma pessoa com deficiência auditiva'),
(6, 'Eu me identifico como surdo'),
(7, 'Eu me identifico como uma pessoa com deficiência intelectual'),
(8, 'Eu me identifico como uma pessoa com deficiência mental'),
(9, 'Eu me identifico como uma pessoa com deficiência física'),
(10, 'Eu me identifico como uma pessoa sem deficiência');


CREATE TABLE `escolaridade` (
  `idEscolaridade` int(11) NOT NULL,
  `nome` varchar(110) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `escolaridade` (`idEscolaridade`, `nome`) VALUES
(1, 'Ensino Fundamental 1'),
(2, 'Ensino Fundamental 2'),
(3, 'Ensino Médio'),
(4, 'Graduação'),
(5, 'Especialização'),
(6, 'Mestrado'),
(7, 'Doutorado');


CREATE TABLE `genero` (
  `idGenero` int(11) NOT NULL,
  `nome` varchar(110) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `genero` (`idGenero`, `nome`) VALUES
(1, 'Prefiro não informar'),
(2, 'Homem Cis'),
(3, 'Mulher Cis'),
(4, 'Não-binário'),
(5, 'Queer');



CREATE TABLE `instancias` (
  `id` int(11) NOT NULL,
  `nomeArquivo` text NOT NULL,
  `arquivo` text NOT NULL,
  `dataCriado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `pronomeReferencia` (
  `idPronomeReferencia` int(11) NOT NULL,
  `pronome` varchar(110) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `pronomeReferencia` (`idPronomeReferencia`, `pronome`) VALUES
(1, 'Ela'),
(2, 'Ele'),
(3, 'Elu');

ALTER TABLE `pronomeReferencia`
  ADD PRIMARY KEY (`idPronomeReferencia`);

ALTER TABLE `pronomeReferencia`
  MODIFY `idPronomeReferencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


CREATE TABLE `pronomeTratamento` (
  `idPronomeTratamento` int(11) NOT NULL,
  `pronome` varchar(110) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `pronomeTratamento` (`idPronomeTratamento`, `pronome`) VALUES
(1, 'Senhor'),
(2, 'Senhora'),
(3, 'Senhorita'),
(4, 'Mestre'),
(5, 'Doutor'),
(6, 'Doutora'),
(7, 'Chefe'),
(8, 'Gerente'),
(10, 'Encarregado'),
(11, 'Diretor'),
(12, 'Diretora'),
(13, 'Presidente');



ALTER TABLE `pronomeTratamento`
  ADD PRIMARY KEY (`idPronomeTratamento`);

ALTER TABLE `pronomeTratamento`
  MODIFY `idPronomeTratamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;











CREATE TABLE `sexo` (
  `idSexo` int(11) NOT NULL,
  `nome` varchar(110) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `sexo` (`idSexo`, `nome`) VALUES
(1, 'Prefiro não informar'),
(2, 'Assexual'),
(3, 'Bissexual'),
(4, 'Gay'),
(5, 'Heterosexual'),
(6, 'Lesbian'),
(7, 'Pansexual');



CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `nomeCompleto` varchar(110) NOT NULL,
  `nomeExibicao` varchar(110) NOT NULL,
  `fkPronomeTratamento` int(11) NOT NULL,
  `fkPronomeReferencia` int(11) NOT NULL,
  `dataNascimento` date NOT NULL,
  `fkSexo` int(11) NOT NULL,
  `fkGenero` int(11) NOT NULL,
  `fkEscolaridade` int(11) NOT NULL,
  `cargoFuncao` varchar(110) NOT NULL,
  `anoAdmissao` varchar(110) NOT NULL,
  `fkDeficiencia` int(11) NOT NULL,
  `email` varchar(110) NOT NULL,
  `senha` varchar(110) NOT NULL,
  `datacadastrado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE `avaliado`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `deficiencia`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `escolaridade`
  ADD PRIMARY KEY (`idEscolaridade`);


ALTER TABLE `genero`
  ADD PRIMARY KEY (`idGenero`);


ALTER TABLE `instancias`
  ADD PRIMARY KEY (`id`);




ALTER TABLE `sexo`
  ADD PRIMARY KEY (`idSexo`);


ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`);


ALTER TABLE `avaliado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `deficiencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;


ALTER TABLE `escolaridade`
  MODIFY `idEscolaridade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;


ALTER TABLE `genero`
  MODIFY `idGenero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;


ALTER TABLE `instancias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=290;



ALTER TABLE `sexo`
  MODIFY `idSexo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;


ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT;