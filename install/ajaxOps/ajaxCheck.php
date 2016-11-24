<?php

    $host = $_POST['host'];
    $name = $_POST['name'];
    $user = $_POST['user'];
    $password = $_POST['password'];
    
    $connessione = new mysqli( $host, $user, $password, $name );
    if (mysqli_connect_error ()) echo mysqli_connect_errno (); 
    else 
    {
        $createfile = fopen("../../db.txt", "w");
        fclose($createfile);
        $serializedPOST = serialize($_POST);
        file_put_contents("../../db.txt", $serializedPOST);
        
    $therewasanerror = false;    
    
    $connessione->query("DROP DATABASE IF EXISTS `$name`;");
    $connessione->query("CREATE DATABASE IF NOT EXISTS `$name`;");
    $connessione->query("USE `$name`;");
    if (!$connessione->query("DROP TABLE IF EXISTS `azienda`")){ echo "<br>".$connessione->error; $therewasanerror = true;}
    if(!$connessione->query("CREATE TABLE `azienda` (
  `id_azienda` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nome_aziendale` varchar(45) NOT NULL,
  `citta_aziendale` varchar(30) NOT NULL,
  `CAP` varchar(8) NOT NULL,
  `indirizzo` varchar(45) NOT NULL,
  `telefono_aziendale` varchar(15) DEFAULT NULL,
  `email_aziendale` varchar(35) DEFAULT NULL,
  `sito_web` varchar(45) DEFAULT NULL,
  `nome_responsabile` varchar(30) DEFAULT NULL,
  `cognome_responsabile` varchar(30) DEFAULT NULL,
  `telefono_responsabile` varchar(15) DEFAULT NULL,
  `email_responsabile` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`id_azienda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8")) { echo "<br>".$connessione->error; $therewasanerror = true;}

if (!$connessione->query("DROP TABLE IF EXISTS `docente`")) { echo "<br>".$connessione->error; $therewasanerror = true;}
if (!$connessione->query("CREATE TABLE `docente` (
  `id_docente` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `email` varchar(35) NOT NULL,
  `docente_referente` tinyint(1) NOT NULL DEFAULT '0',
  `docente_tutor` tinyint(1) NOT NULL DEFAULT '0',
  `super_user` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_docente`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8")) { echo "<br>".$connessione->error; $therewasanerror = true;}

   //if (!$connessione->query("INSERT INTO `docente` (`username`, `password`, `nome`, `cognome`, `telefono`, `email`, `docente_referente`, `docente_tutor`, `super_user`) VALUES ('SuperUser', 'd9ab4782321ccb984679e470cd8fa685', 'SuperUser', 'SuperUser', 'Sconosciuto', 'Sconosciuta', '0', '0', '1');")) echo $connessione->error;

if (!$connessione->query("DROP TABLE IF EXISTS `preferenza`")) { echo "<br>".$connessione->error; $therewasanerror = true;}
if(!$connessione->query("CREATE TABLE `preferenza` (
  `id_preferenza` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(25) NOT NULL,
  PRIMARY KEY (`id_preferenza`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8")){ echo "<br>".$connessione->error; $therewasanerror = true;}

if(!$connessione->query("DROP TABLE IF EXISTS `specializzazione`")){ echo "<br>".$connessione->error; $therewasanerror = true;}
if(!$connessione->query("CREATE TABLE `specializzazione` (
  `id_specializzazione` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) NOT NULL,
  PRIMARY KEY (`id_specializzazione`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8")){ echo "<br>".$connessione->error; $therewasanerror = true;}

if(!$connessione->query("DROP TABLE IF EXISTS `valutazione_studente`")){ echo "<br>".$connessione->error; $therewasanerror = true;}
if(!$connessione->query("CREATE TABLE `valutazione_studente` (
 `id_valutazione_studente` int(11) NOT NULL AUTO_INCREMENT,
 `gestione_ambiente_spazio_lavoro` int(11) NOT NULL,
 `collaborazione_comunicazione` int(11) NOT NULL,
 `uso_strumenti` int(11) NOT NULL,
 `rispetta_norme_vigenti` int(11) NOT NULL,
 `rispetto_ambiente` int(11) NOT NULL,
 `puntualita` int(11) NOT NULL,
 `collaborazione_tutor` int(11) NOT NULL,
 `lavoro_requisiti` int(11) NOT NULL,
 `conoscenze_tecniche` int(11) NOT NULL,
 `acquisire_nuove_conoscenze` int(11) NOT NULL,
 `commento` varchar(1000) DEFAULT NULL,
 PRIMARY KEY (`id_valutazione_studente`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8")){ echo "<br>".$connessione->error; $therewasanerror = true;}

if(!$connessione->query("DROP TABLE IF EXISTS `azienda_has_specializzazione`")){ echo "<br>".$connessione->error; $therewasanerror = true;}
if(!$connessione->query("CREATE TABLE `azienda_has_specializzazione` (
  `id_azienda_has_specializzazione` int(11) NOT NULL AUTO_INCREMENT,
  `azienda_id_azienda` int(11) NOT NULL,
  `specializzazione_id_specializzazione` int(11) NOT NULL,
  PRIMARY KEY (`id_azienda_has_specializzazione`),
  KEY `fk_azienda_has_specializzazione_specializzazione1_idx` (`specializzazione_id_specializzazione`),
  KEY `fk_azienda_has_specializzazione_azienda1_idx` (`azienda_id_azienda`),
  CONSTRAINT `fk_azienda_has_specializzazione_azienda1` FOREIGN KEY (`azienda_id_azienda`) REFERENCES `azienda` (`id_azienda`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_azienda_has_specializzazione_specializzazione1` FOREIGN KEY (`specializzazione_id_specializzazione`) REFERENCES `specializzazione` (`id_specializzazione`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8")){ echo "<br>".$connessione->error; $therewasanerror = true;}

if(!$connessione->query("DROP TABLE IF EXISTS `valutazione_stage`")){ echo "<br>".$connessione->error; $therewasanerror = true;}
if(!$connessione->query("CREATE TABLE `valutazione_stage` (
  `id_valutazione_stage` int(11) NOT NULL AUTO_INCREMENT,
  `descrizione` varchar(150) NOT NULL,
  `voto` int(11) NOT NULL,
  PRIMARY KEY (`id_valutazione_stage`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8")){ echo "<br>".$connessione->error; $therewasanerror = true;}

if(!$connessione->query("DROP TABLE IF EXISTS `classe`")){ echo "<br>".$connessione->error; $therewasanerror = true;}
if(!$connessione->query("CREATE TABLE `classe` (
  `id_classe` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(10) NOT NULL,
  `specializzazione_id_specializzazione` int(11) NOT NULL,
  PRIMARY KEY (`id_classe`),
  KEY `fk_classe_specializzazione1_idx` (`specializzazione_id_specializzazione`),
  CONSTRAINT `fk_classe_specializzazione1` FOREIGN KEY (`specializzazione_id_specializzazione`) REFERENCES `specializzazione` (`id_specializzazione`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8")){ echo "<br>".$connessione->error; $therewasanerror = true;}

if(!$connessione->query("DROP TABLE IF EXISTS `tutor`")){ echo "<br>".$connessione->error; $therewasanerror = true;}
if(!$connessione->query("CREATE TABLE `tutor` (
  `id_tutor` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `email` varchar(35) NOT NULL,
  `azienda_id_azienda` int(11) NOT NULL,
  PRIMARY KEY (`id_tutor`),
  KEY `fk_tutor_azienda1_idx` (`azienda_id_azienda`),
  CONSTRAINT `fk_tutor_azienda1` FOREIGN KEY (`azienda_id_azienda`) REFERENCES `azienda` (`id_azienda`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8")){ echo "<br>".$connessione->error; $therewasanerror = true;}

if(!$connessione->query("DROP TABLE IF EXISTS `studente`;")) { echo "<br>".$connessione->error; $therewasanerror = true;}
if (!$connessione->query("CREATE TABLE `studente` (
  `id_studente` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `citta` varchar(30) NOT NULL,
  `email` varchar(35) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `AutorizzazioneRegistro` tinyint(1) NOT NULL DEFAULT '1',
  `inizio_stage` date DEFAULT NULL,
  `durata_stage` int(11) DEFAULT NULL,
  `visita_azienda` tinyint(1) NOT NULL DEFAULT '0',
  `classe_id_classe` int(11) NOT NULL,
  `azienda_id_azienda` int(11) DEFAULT NULL,
  `docente_id_docente` int(11) DEFAULT NULL,
  `tutor_id_tutor` int(11) DEFAULT NULL,
  `valutazione_studente_id_valutazione_studente` int(11) DEFAULT NULL,
  `valutazione_stage_id_valutazione_stage` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_studente`),
  KEY `fk_studente_azienda_idx` (`azienda_id_azienda`),
  KEY `fk_studente_docente1_idx` (`docente_id_docente`),
  KEY `fk_studente_tutor1_idx` (`tutor_id_tutor`),
  KEY `fk_studente_valutazione_studente1_idx` (`valutazione_studente_id_valutazione_studente`),
  KEY `fk_studente_valutazione_stage1_idx` (`valutazione_stage_id_valutazione_stage`),
  KEY `fk_studente_classe1_idx` (`classe_id_classe`),
  CONSTRAINT `fk_studente_azienda` FOREIGN KEY (`azienda_id_azienda`) REFERENCES `azienda` (`id_azienda`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_studente_classe1` FOREIGN KEY (`classe_id_classe`) REFERENCES `classe` (`id_classe`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_studente_docente1` FOREIGN KEY (`docente_id_docente`) REFERENCES `docente` (`id_docente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_studente_tutor1` FOREIGN KEY (`tutor_id_tutor`) REFERENCES `tutor` (`id_tutor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_studente_valutazione_stage1` FOREIGN KEY (`valutazione_stage_id_valutazione_stage`) REFERENCES `valutazione_stage` (`id_valutazione_stage`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_studente_valutazione_studente1` FOREIGN KEY (`valutazione_studente_id_valutazione_studente`) REFERENCES `valutazione_studente` (`id_valutazione_studente`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;")){ echo "<br>".$connessione->error; $therewasanerror = true;}

if(!$connessione->query("DROP TABLE IF EXISTS `studente_has_preferenza`")){ echo "<br>".$connessione->error; $therewasanerror = true;}
if(!$connessione->query("CREATE TABLE `studente_has_preferenza` (
  `id_studente_has_preferenza` int(11) NOT NULL AUTO_INCREMENT,
  `studente_id_studente` int(11) NOT NULL,
  `preferenza_id_preferenza` int(11) NOT NULL,
  PRIMARY KEY (`id_studente_has_preferenza`),
  KEY `fk_studente_has_preferenza_preferenza1_idx` (`preferenza_id_preferenza`),
  KEY `fk_studente_has_preferenza_studente1_idx` (`studente_id_studente`),
  CONSTRAINT `fk_studente_has_preferenza_preferenza1` FOREIGN KEY (`preferenza_id_preferenza`) REFERENCES `preferenza` (`id_preferenza`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_studente_has_preferenza_studente1` FOREIGN KEY (`studente_id_studente`) REFERENCES `studente` (`id_studente`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8")){ echo "<br>".$connessione->error; $therewasanerror = true;}

if(!$connessione->query("DROP TABLE IF EXISTS `lavoro_giornaliero`")){ echo "<br>".$connessione->error; $therewasanerror = true;}
if(!$connessione->query("CREATE TABLE `lavoro_giornaliero` (
  `id_lavoro_giornaliero` int(11) NOT NULL AUTO_INCREMENT,
  `data` date NOT NULL,
  `descrizione` varchar(60) NOT NULL,
  `studente_id_studente` int(11) NOT NULL,
  PRIMARY KEY (`id_lavoro_giornaliero`),
  KEY `fk_lavoro_giornaliero_studente1_idx` (`studente_id_studente`),
  CONSTRAINT `fk_lavoro_giornaliero_studente1` FOREIGN KEY (`studente_id_studente`) REFERENCES `studente` (`id_studente`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8")){ echo "<br>".$connessione->error; $therewasanerror = true;}
}

if(!$connessione->query("CREATE TABLE `valutazione_applicazione` (
  `id_valutazione` int(11) NOT NULL AUTO_INCREMENT,
  `voto` int(11) NOT NULL,
  `descrizione` varchar(1000) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `tipo_utente` varchar(50) NOT NULL,
  PRIMARY KEY (`id_valutazione`)
) ENGINE=InnoDB AUTO_INCREMENT=17")){ echo "<br>".$connessione->error; $therewasanerror = true;}

if($therewasanerror === false){ echo "ok"; }