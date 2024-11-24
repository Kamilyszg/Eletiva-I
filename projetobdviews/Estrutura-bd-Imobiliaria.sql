-- -----------------------------------------------------
-- Schema imobiliaria
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `imobiliaria` DEFAULT CHARACTER SET utf8 ;
USE `imobiliaria` ;

-- -----------------------------------------------------
-- Table `imobiliaria`.`endereco`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `imobiliaria`.`endereco` (
  `idendereco` INT(11) NOT NULL AUTO_INCREMENT,
  `logradouro` VARCHAR(45) NULL DEFAULT NULL,
  `numero` INT(11) NULL DEFAULT NULL,
  `bairro` VARCHAR(45) NULL DEFAULT NULL,
  `cidade` VARCHAR(45) NULL DEFAULT NULL,
  `estado` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`idendereco`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table `imobiliaria`.`proprietario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `imobiliaria`.`proprietario` (
  `idproprietario` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NULL DEFAULT NULL,
  `cpf` VARCHAR(12) NULL DEFAULT NULL,
  `cnpj` VARCHAR(14) NULL DEFAULT NULL,
  `idendereco` INT(11) NOT NULL,
  PRIMARY KEY (`idproprietario`),
  INDEX `fk_proprietario_endereco1_idx` (`idendereco` ASC),
  CONSTRAINT `fk_proprietario_endereco1`
    FOREIGN KEY (`idendereco`)
    REFERENCES `imobiliaria`.`endereco` (`idendereco`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table `imobiliaria`.`imovel`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `imobiliaria`.`imovel` (
  `idimovel` INT(11) NOT NULL AUTO_INCREMENT,
  `tipo` VARCHAR(45) NULL DEFAULT NULL,
  `valor` DECIMAL(10,2) NULL DEFAULT NULL,
  `status` VARCHAR(45) NULL DEFAULT NULL,
  `dataCadastro` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `idendereco` INT(11) NOT NULL,
  `idproprietario` INT(11) NOT NULL,
  PRIMARY KEY (`idimovel`),
  INDEX `fk_imovel_endereco1_idx` (`idendereco`),
  INDEX `fk_imovel_proprietario1_idx` (`idproprietario`),
  CONSTRAINT `fk_imovel_endereco1`
    FOREIGN KEY (`idendereco`)
    REFERENCES `imobiliaria`.`endereco` (`idendereco`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_imovel_proprietario1`
    FOREIGN KEY (`idproprietario`)
    REFERENCES `imobiliaria`.`proprietario` (`idproprietario`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION
) ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table `imobiliaria`.`locatario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `imobiliaria`.`locatario` (
  `idlocatario` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NULL DEFAULT NULL,
  `cpf` VARCHAR(12) NULL DEFAULT NULL,
  `cnpj` VARCHAR(14) NULL DEFAULT NULL,
  `idendereco` INT(11) NOT NULL,
  PRIMARY KEY (`idlocatario`),
  INDEX `fk_locatario_endereco1_idx` (`idendereco`),
  CONSTRAINT `fk_locatario_endereco1`
    FOREIGN KEY (`idendereco`)
    REFERENCES `imobiliaria`.`endereco` (`idendereco`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table `imobiliaria`.`contrato_locacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `imobiliaria`.`contrato_locacao` (
  `idcontrato` INT(11) NOT NULL AUTO_INCREMENT,
  `data_inicio` DATE NULL DEFAULT NULL,
  `data_fim` DATE NULL DEFAULT NULL,
  `valor_mensal` DECIMAL(10,2) NULL DEFAULT NULL,
  `status` VARCHAR(45) NULL DEFAULT NULL,
  `idlocatario` INT(11) NOT NULL,
  `idimovel` INT(11) NOT NULL,
  `idproprietario` INT(11) NOT NULL,
  PRIMARY KEY (`idcontrato`, `idproprietario`, `idimovel`, `idlocatario`),
  INDEX `fk_contrato_locacao_locatario1_idx` (`idlocatario`),
  INDEX `fk_contrato_locacao_imovel1_idx` (`idimovel`),
  INDEX `fk_contrato_locacao_proprietario1_idx` (`idproprietario`),
  CONSTRAINT `fk_contrato_locacao_imovel1`
    FOREIGN KEY (`idimovel`)
    REFERENCES `imobiliaria`.`imovel` (`idimovel`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contrato_locacao_locatario1`
    FOREIGN KEY (`idlocatario`)
    REFERENCES `imobiliaria`.`locatario` (`idlocatario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contrato_locacao_proprietario1`
    FOREIGN KEY (`idproprietario`)
    REFERENCES `imobiliaria`.`proprietario` (`idproprietario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table `imobiliaria`.`email`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `imobiliaria`.`email` (
  `idemail` INT(11) NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(45) NULL DEFAULT NULL,
  `idproprietario` INT(11) NULL DEFAULT NULL,
  `idlocatario` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`idemail`),
  INDEX `fk_email_proprietario1_idx` (`idproprietario`),
  INDEX `fk_email_locatario1_idx` (`idlocatario`),
  CONSTRAINT `fk_email_locatario1`
    FOREIGN KEY (`idlocatario`)
    REFERENCES `imobiliaria`.`locatario` (`idlocatario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_email_proprietario1`
    FOREIGN KEY (`idproprietario`)
    REFERENCES `imobiliaria`.`proprietario` (`idproprietario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table `imobiliaria`.`telefone`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `imobiliaria`.`telefone` (
  `idtelefone` INT(11) NOT NULL AUTO_INCREMENT,
  `numero` INT(11) NULL DEFAULT NULL,
  `idlocatario` INT(11) NULL DEFAULT NULL,
  `idproprietario` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`idtelefone`),
  INDEX `fk_telefone_locatario1_idx` (`idlocatario`),
  INDEX `fk_telefone_proprietario1_idx` (`idproprietario`),
  CONSTRAINT `fk_telefone_locatario1`
    FOREIGN KEY (`idlocatario`)
    REFERENCES `imobiliaria`.`locatario` (`idlocatario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_telefone_proprietario1`
    FOREIGN KEY (`idproprietario`)
    REFERENCES `imobiliaria`.`proprietario` (`idproprietario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Tabela Usuário
-- -----------------------------------------------------
CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    nivel ENUM('adm', 'colab') NOT NULL
);
