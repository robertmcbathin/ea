-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Янв 29 2016 г., 16:06
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `endoadmin`
--

-- --------------------------------------------------------

--
-- Структура таблицы `agreement_act_data`
--

CREATE TABLE IF NOT EXISTS `agreement_act_data` (
  `agreement_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pacient_id` int(10) unsigned NOT NULL,
  `app_id` int(10) unsigned NOT NULL,
  `number` int(10) unsigned NOT NULL COMMENT 'Номер договора',
  `period_from` date NOT NULL,
  `period_to` int(11) NOT NULL,
  `service1_id` tinyint(3) unsigned NOT NULL,
  `quantity1` tinyint(3) unsigned NOT NULL,
  `doctor1_id` tinyint(3) unsigned NOT NULL,
  `service2_id` tinyint(3) unsigned NOT NULL,
  `quantity2` tinyint(3) unsigned NOT NULL,
  `doctor2_id` tinyint(3) unsigned NOT NULL,
  `service3_id` tinyint(3) unsigned NOT NULL,
  `quantity3` tinyint(3) unsigned NOT NULL,
  `doctor3_id` tinyint(3) unsigned NOT NULL,
  `service4_id` tinyint(3) unsigned NOT NULL,
  `quantity4` tinyint(3) unsigned NOT NULL,
  `doctor4_id` tinyint(3) unsigned NOT NULL,
  `service5_id` tinyint(3) unsigned NOT NULL,
  `quantity5` tinyint(3) unsigned NOT NULL,
  `doctor5_id` tinyint(3) unsigned NOT NULL,
  `med_fio` tinyint(4) DEFAULT NULL,
  `sign_date` datetime DEFAULT NULL,
  `summary` float unsigned NOT NULL,
  PRIMARY KEY (`agreement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Договоры с пациентами' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `appointment`
--

CREATE TABLE IF NOT EXISTS `appointment` (
  `app_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pacient_id` int(10) unsigned NOT NULL,
  `request_id` int(10) unsigned NOT NULL,
  `service_id` tinyint(3) unsigned NOT NULL,
  `doctor_id` tinyint(3) unsigned NOT NULL,
  `app_title` varchar(80) NOT NULL,
  `app_desc` text NOT NULL,
  `status` enum('назначено','идет прием','прием завершен','отменено') NOT NULL,
  `conclusion` text NOT NULL,
  `app_start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `app_end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`app_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Дамп данных таблицы `appointment`
--

INSERT INTO `appointment` (`app_id`, `pacient_id`, `request_id`, `service_id`, `doctor_id`, `app_title`, `app_desc`, `status`, `conclusion`, `app_start`, `app_end`) VALUES
(1, 1, 45, 0, 0, 'Колоно', 'Мужчина, 47 лет', 'назначено', '', '2015-01-15 00:20:31', '2015-01-16 05:00:00'),
(2, 2, 33, 0, 0, 'Гастро', 'Женщина, 35 лет', 'назначено', '', '2015-01-15 00:20:31', '2015-01-17 11:00:00'),
(3, 2, 2, 0, 0, 'Выходной', 'Можно отдыхать', 'прием завершен', '', '2010-01-01 20:00:00', '2010-01-02 19:59:59'),
(4, 2, 333, 0, 0, 'Васильев Михаил', '222', 'прием завершен', '', '2010-01-13 20:00:00', '2010-01-14 20:00:00'),
(7, 0, 0, 1, 2, 'Мичурин', 'wecewc', 'назначено', '', '2010-01-18 13:00:00', '2010-01-18 14:00:00'),
(8, 0, 0, 0, 0, 'Семенова Мария', 'fh', 'идет прием', '', '2010-01-10 20:00:00', '2010-01-10 20:00:00'),
(9, 0, 0, 0, 0, 'Васильев Михаил Анатольевич', '          gdg', 'назначено', '', '2010-01-05 20:00:00', '2010-01-05 20:00:00'),
(10, 0, 0, 0, 0, 'Петрова Анастасия', 'Варикоз', 'отменено', '', '2010-01-11 20:00:00', '2010-01-11 20:00:00'),
(11, 0, 0, 0, 0, 'Васильев Михаил', 'пке', 'назначено', '', '2015-02-18 20:00:00', '2015-02-18 20:21:00'),
(12, 0, 0, 0, 0, 'Павлов Виктор', '  	    Колоно', 'отменено', '', '2010-01-14 18:00:00', '2010-01-14 20:00:00'),
(13, 0, 0, 0, 0, 'Васильев Михаил', 'eedc', 'назначено', '', '2010-01-13 20:00:00', '2010-01-14 20:00:00'),
(14, 0, 0, 0, 0, '', '  	    ', 'назначено', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 3, 0, 1, 2, '', '	    234', 'назначено', '', '2015-02-13 20:32:00', '2015-02-13 01:32:00'),
(16, 4, 0, 1, 1, '', '	    кеие', 'назначено', '', '2015-02-12 01:45:00', '2015-02-12 02:00:00'),
(17, 1, 0, 1, 2, '', '	    кие', 'назначено', '', '2015-02-13 12:44:00', '2015-02-13 13:00:00'),
(18, 1, 0, 2, 1, '', '	    патрн', 'назначено', '', '1970-01-01 00:33:35', '2015-02-19 02:54:00'),
(19, 1, 0, 2, 1, '', '	    руенр', 'назначено', '', '2015-02-20 01:35:00', '2015-02-20 02:32:00'),
(20, 4, 0, 1, 1, '', '	    иерп', 'назначено', '', '2015-02-21 00:45:00', '2015-02-21 03:59:00'),
(21, 9, 0, 0, 0, '', '	    ', 'назначено', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 9, 0, 2, 2, '', '	    псгуцигшо', 'назначено', '', '2015-02-20 00:35:00', '2015-02-20 02:52:00'),
(23, 6, 0, 1, 1, '', 'Может задержаться	    ', 'назначено', '', '2015-03-21 09:00:00', '2015-03-21 09:30:00'),
(24, 3, 0, 2, 1, 'brfbrte', 'rtbhnrthbtrh', 'назначено', 'ntrbhnrt', '2015-03-21 07:00:00', '2015-03-21 08:00:00'),
(25, 2, 0, 1, 1, 'vergvb', 'brtebrtweb', 'назначено', '3regvre', '2015-03-21 11:00:00', '2015-03-06 12:00:00'),
(26, 6, 0, 2, 2, '', '	    ', 'назначено', '', '2015-03-21 05:20:00', '2015-03-21 06:00:00'),
(27, 6, 0, 2, 2, '', 'ыыы	    ', 'назначено', '', '2015-04-17 07:15:00', '2015-04-17 07:45:00'),
(28, 6, 0, 1, 1, '', '	    ', 'назначено', '', '2015-04-17 07:50:00', '2015-04-17 08:20:00'),
(29, 18, 0, 0, 2, '', '	    ', 'назначено', '', '2016-01-23 05:05:00', '2016-01-23 05:25:00'),
(30, 1, 0, 1, 1, '', '	    ', 'назначено', '', '2016-01-24 05:30:00', '2016-01-24 06:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `conclusion`
--

CREATE TABLE IF NOT EXISTS `conclusion` (
  `conclusion_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pacient_id` int(10) unsigned NOT NULL DEFAULT '0',
  `doctor_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0',
  `dignosis` text NOT NULL,
  `preparation` text NOT NULL,
  `additional_manipulations` text NOT NULL,
  `conclusion_text` text NOT NULL,
  `recommendation` varchar(200) NOT NULL,
  PRIMARY KEY (`conclusion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Врачебные заключения' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `doctor`
--

CREATE TABLE IF NOT EXISTS `doctor` (
  `doctor_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `fio_full` varchar(255) NOT NULL,
  `fio_short` varchar(80) NOT NULL,
  `specialization` varchar(150) NOT NULL,
  PRIMARY KEY (`doctor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Доктора' AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `doctor`
--

INSERT INTO `doctor` (`doctor_id`, `fio_full`, `fio_short`, `specialization`) VALUES
(1, 'Лисицин Евгений Анатольевич', 'Лисицин В.Е.', 'Гастроэнтерология'),
(2, 'Сысуйкин Александр Владимирович', 'Сысуйкин А.В.', 'Проктология'),
(3, 'Кудряшова Марина Николаевна', 'Кудряшова М.Н.', 'УЗИ');

-- --------------------------------------------------------

--
-- Структура таблицы `pacient`
--

CREATE TABLE IF NOT EXISTS `pacient` (
  `pacient_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fio` varchar(150) NOT NULL,
  `date_of_birth` date NOT NULL,
  `phone` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `sex` enum('мужской','женский','','') NOT NULL,
  `passport_serie` tinyint(4) unsigned NOT NULL,
  `passport_number` mediumint(6) unsigned NOT NULL,
  `passport_date_of_issue` date NOT NULL,
  `passport_place_of_issue` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `place_of_residence` varchar(255) NOT NULL,
  `place_of_work` varchar(255) NOT NULL,
  `profession` varchar(255) NOT NULL,
  `dms` varchar(150) NOT NULL,
  `dms_number` varchar(50) NOT NULL,
  `valid` date DEFAULT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`pacient_id`),
  UNIQUE KEY `pacient_id` (`pacient_id`),
  UNIQUE KEY `pacient_id_2` (`pacient_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Дамп данных таблицы `pacient`
--

INSERT INTO `pacient` (`pacient_id`, `fio`, `date_of_birth`, `phone`, `email`, `sex`, `passport_serie`, `passport_number`, `passport_date_of_issue`, `passport_place_of_issue`, `place_of_residence`, `place_of_work`, `profession`, `dms`, `dms_number`, `valid`, `comment`) VALUES
(1, 'Борисов Михаил Иванович', '1955-09-10', '8999777665', 'borisov@mihail.ru', 'мужской', 255, 0, '0000-00-00', '', 'пос. Ишлеи', 'Агрегатный завод', 'Сборщик', '', '', NULL, 'Хронический гастрит.'),
(2, 'Ефимова Ольга Петровна', '1976-05-06', '8999555443', 'efimova@olga.ru', 'женский', 255, 0, '0000-00-00', '', 'гор. Новочебоксарск', 'магазин Ромашка', 'продавец', 'Чувашия-Мед', '066889786890', '2017-04-10', 'Язва желудка в возрасте 27 лет'),
(3, 'Семенов Олег Петрович', '0000-00-00', '', '', '', 0, 0, '0000-00-00', '', '', '', '', '', '', '0000-00-00', ''),
(4, 'Смирнов Виктор Петрович', '1991-10-23', '8099099990', '', 'мужской', 0, 0, '0000-00-00', '', '', '', '', '', '', '0000-00-00', ''),
(5, 'Смирнов Виктор Петрович', '1991-10-23', '8099099990', '', 'мужской', 0, 0, '0000-00-00', '', '', '', '', '', '', '0000-00-00', ''),
(6, 'Дементьев Владимир Сергеевич', '1986-01-15', '8777666554', 'dementev@v.ru', 'мужской', 255, 0, '0000-00-00', '', 'Батырево', 'Прокуратура Батыревского района', 'Помощник прокурора', 'Росгосстрах', '233242352', '2012-05-20', ''),
(7, 'Борисов Егор Саидрахманович', '1994-04-16', '+798845533', '', 'мужской', 0, 0, '0000-00-00', '', '', '', '', '', '', '0000-00-00', ''),
(8, 'Королев Евгений Сергеевич', '2014-08-09', '', '', 'мужской', 0, 0, '0000-00-00', '', '', '', '', '', '', '0000-00-00', ''),
(9, 'Яковлев Роман Борисович', '2015-02-14', '', '', 'мужской', 0, 0, '0000-00-00', '', '', '', '', '', '', '0000-00-00', ''),
(10, 'Симонова Людмила Борисовна', '2015-02-11', '8999777665', '', 'женский', 0, 0, '0000-00-00', '', '', '', '', '', '', '0000-00-00', ''),
(11, 'Яковлев Роман Борисович', '2014-08-06', '', '', 'мужской', 0, 0, '0000-00-00', '', '', '', '', '', '', '0000-00-00', ''),
(12, 'Панова Виктория Ильинична', '1766-12-30', '', '', 'женский', 0, 0, '0000-00-00', '', '', '', '', '', '', '0000-00-00', ''),
(13, 'Панова Виктория Ильинична', '0000-00-00', '', '', '', 0, 0, '0000-00-00', '', '', '', '', '', '', '0000-00-00', ''),
(14, 'Панова Виктория Ильинична', '0000-00-00', '', '', '', 0, 0, '0000-00-00', '', '', '', '', '', '', '0000-00-00', ''),
(15, 'Андреев Роман Сергеевич', '0000-00-00', '', '', '', 0, 0, '0000-00-00', '', '', '', '', '', '', '0000-00-00', ''),
(16, 'Ярмук Чингыз Арамович', '0000-00-00', '', '', '', 0, 0, '0000-00-00', '', '', '', '', '', '', '0000-00-00', ''),
(17, 'Тарантас Шоха Копейкович', '0000-00-00', '', '', '', 0, 0, '0000-00-00', '', '', '', '', '', '', '0000-00-00', ''),
(18, 'Швецов Лев Александрович', '1978-01-31', '2423432423', 'shvel@mail.ru', 'мужской', 255, 324324, '2012-02-27', 'уакак', 'Чебоксары ', 'ООО "ЕТК"', 'Лева', '', '', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Структура таблицы `pacient_story`
--

CREATE TABLE IF NOT EXISTS `pacient_story` (
  `story_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pacient_id` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `text` text NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `reception_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`story_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='История клиента' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `person`
--

CREATE TABLE IF NOT EXISTS `person` (
  `person_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `name_short` varchar(50) NOT NULL,
  `type` enum('doctor','administrator','headmaster','') NOT NULL,
  `specialization` varchar(255) NOT NULL,
  `email` varchar(80) NOT NULL,
  `login` varchar(80) NOT NULL,
  `psw` varchar(47) NOT NULL,
  PRIMARY KEY (`person_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `person`
--

INSERT INTO `person` (`person_id`, `name`, `name_short`, `type`, `specialization`, `email`, `login`, `psw`) VALUES
(1, 'Лисицин Виталий Евгеньевич', 'Лисицин В.Е.', 'headmaster', 'Директор', '', 'vilis', '9033899550');

-- --------------------------------------------------------

--
-- Структура таблицы `request`
--

CREATE TABLE IF NOT EXISTS `request` (
  `rid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tomail` varchar(100) NOT NULL,
  `frommail` varchar(100) NOT NULL,
  `fio` varchar(200) NOT NULL,
  `phone` varchar(13) NOT NULL,
  `date_of_receive` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `direction` enum('Фиброэзофагогастродуоденоскопия (ФГДС)','Колоноскопия (ФКС)','Проктология',' Консультация гастроэнтеролога') NOT NULL,
  `desireddate` date DEFAULT NULL,
  `begin_time` time NOT NULL,
  `end_time` time NOT NULL,
  `comment` text NOT NULL,
  `status` enum('new','received','cancelled') NOT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Заявки' AUTO_INCREMENT=24 ;

--
-- Дамп данных таблицы `request`
--

INSERT INTO `request` (`rid`, `tomail`, `frommail`, `fio`, `phone`, `date_of_receive`, `direction`, `desireddate`, `begin_time`, `end_time`, `comment`, `status`) VALUES
(1, 'registry@endoscopy21.ru', 'eewew', 'Иванов Петр Иванович', '87876', '2014-02-27 10:39:32', ' Консультация гастроэнтеролога', '0000-00-00', '00:00:00', '00:00:00', '', 'new'),
(2, 'registry@endoscopy21.ru', 'greger', 'Викторов Роман Иванович', '436546', '2014-02-27 10:39:32', 'Проктология', '0000-00-00', '00:00:00', '00:00:00', '', ''),
(16, 'registry@endoscopy21.ru', 'alexander21-12@mail.ru', 'Романов Петр Петрович', '89854356086', '2014-03-03 10:08:31', 'Проктология', '0000-00-00', '00:00:00', '00:00:00', 'dvrere', 'new'),
(19, 'registry@endoscopy21.ru', '', 'Семенова Ольга Степановна', '456677', '2014-03-11 11:23:46', ' Консультация гастроэнтеролога', '0000-00-00', '00:00:00', '00:00:00', 'btrsb', 'new'),
(20, 'registry@endoscopy21.ru', '', 'Антонов Виктор Геннадьевич', '8665334554', '2014-03-11 11:24:12', 'Фиброэзофагогастродуоденоскопия (ФГДС)', '0000-00-00', '00:00:00', '00:00:00', 'vareave', 'new'),
(21, 'registry@endoscopy21.ru', '', 'Малова Виктория Александровна', '89067775522', '2014-03-11 11:24:57', 'Проктология', '0000-00-00', '00:00:00', '00:00:00', 'vareave', 'new'),
(22, 'registry@endoscopy21.ru', 'alexander21-12@mail.ru', 'Федорова Ирина Витальевна', '9879870', '2014-03-17 07:50:46', 'Колоноскопия (ФКС)', '2014-03-20', '00:02:00', '11:00:00', 'ascas', 'new'),
(23, 'registry@endoscopy21.ru', 'brtbtrebrbrt', 'Митрофанов Сергей Вячеславович', '2332543', '2014-03-25 08:12:03', 'Фиброэзофагогастродуоденоскопия (ФГДС)', '2014-03-29', '00:01:00', '02:02:00', 'vrtbtrbrt', 'new');

-- --------------------------------------------------------

--
-- Структура таблицы `service`
--

CREATE TABLE IF NOT EXISTS `service` (
  `service_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `service_full_name` varchar(255) NOT NULL,
  `service_short_name` varchar(80) NOT NULL,
  `price` float NOT NULL,
  `referred_to` varchar(80) NOT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Услуги' AUTO_INCREMENT=59 ;

--
-- Дамп данных таблицы `service`
--

INSERT INTO `service` (`service_id`, `service_full_name`, `service_short_name`, `price`, `referred_to`) VALUES
(3, 'Видеогастроскопия', 'ФГДС', 1200, 'Фиброэзофагогастродуоденоскопия (ФГДС)'),
(4, 'Видеоколоноскопия', 'ФКС', 2000, 'Колоноскопия (ФКС)'),
(5, 'Консультация врача-проктолога и осмотр', 'Консультация врача-проктолога и осмотр', 500, 'Проктолог'),
(6, 'Консультация врача-невролога и осмотр', 'Консультация врача-невролога и осмотр', 600, 'Невролог'),
(7, 'Консультация врача-терапевта и осмотр', 'Консультация врача-терапевта и осмотр', 600, 'Терапевт'),
(8, 'Консультация врача-эндокринолога и осмотр', 'Консультация врача-эндокринолога и осмотр', 650, 'Эндокринолог'),
(9, 'Консультация врача-гастроэнтеролога и осмотр', 'Консультация врача-гастроэнтеролога и осмотр', 600, 'Гастроэнтеролог'),
(10, 'один фрагмент (биоптата)', 'один фрагмент (биоптата)', 700, 'Патогистологическая биопсия'),
(11, 'два фрагмента (биоптата)', 'два фрагмента (биоптата)', 1200, 'Патогистологическая биопсия'),
(12, 'три фрагмента (биоптата)', 'три фрагмента (биоптата)', 1800, 'Патогистологическая биопсия'),
(13, 'Цитологическая биопсия за один фрагмент биоптата', 'Цитологическая биопсия за один фрагмент биоптата', 500, 'Патогистологическая биопсия'),
(14, 'Тест Helicobacter', 'Тест Helicobacter', 400, 'Патогистологическая биопсия'),
(15, 'УЗИ органов брюшной полости (печени, желчного пузыря, поджелудочной железы, селезенки)', ' УЗИ органов брюшной полости', 500, 'УЗИ'),
(16, 'УЗИ печени и желчного пузыря', 'УЗИ печени и желчного пузыря', 300, 'УЗИ'),
(17, 'УЗИ желчного пузыря с определением функции', 'УЗИ желчного пузыря с определением функции', 600, 'УЗИ'),
(18, 'УЗИ поджелудочной железы', 'УЗИ поджелудочной железы', 300, 'УЗИ'),
(19, 'УЗИ селезенки', 'УЗИ селезенки', 300, 'УЗИ'),
(20, 'УЗИ органов брюшной полости и почек (комплексно)', 'УЗИ органов брюшной полости и почек (комплексно)', 650, 'УЗИ'),
(21, 'УЗИ почек', 'УЗИ почек', 300, 'УЗИ'),
(22, 'УЗИ почек и надпочечников', 'УЗИ почек и надпочечников', 350, 'УЗИ'),
(23, 'УЗИ надпочечников', 'УЗИ надпочечников', 200, 'УЗИ'),
(24, 'УЗИ почек, надпочечников и мочевого пузыря', 'УЗИ почек, надпочечников и мочевого пузыря', 450, 'УЗИ'),
(25, 'УЗИ мочевого пузыря', 'УЗИ мочевого пузыря', 200, 'УЗИ'),
(26, 'УЗИ мочевого пузыря с определением остаточной мочи', 'УЗИ мочевого пузыря с определением остаточной мочи', 250, 'УЗИ'),
(27, 'УЗИ желудка', 'УЗИ желудка', 500, 'УЗИ'),
(28, 'УЗИ молочных желез и лимфатических узлов', 'УЗИ молочных желез и лимфатических узлов', 500, 'УЗИ'),
(29, 'УЗИ грудных желез (мужчин) без лимфоузлов', 'УЗИ грудных желез (мужчин) без лимфоузлов', 300, 'УЗИ'),
(30, 'УЗИ органов малого таза (транс абдоминально)', 'УЗИ органов малого таза (транс абдоминально)', 400, 'УЗИ'),
(31, 'УЗИ органов малого таза с применением вагинального датчика', 'УЗИ органов малого таза с применением вагинального датчика', 450, 'УЗИ'),
(32, 'УЗИ мошонки', 'УЗИ мошонки', 400, 'УЗИ'),
(33, 'УЗИ полового члена', 'УЗИ полового члена', 300, 'УЗИ'),
(34, 'УЗИ предстательной железы с применением ректального датчика (ТРУЗИ)', 'УЗИ предстательной железы с применением ректального датчика (ТРУЗИ)', 400, 'УЗИ'),
(35, 'УЗИ предстательной железы трансабдоминально без исследования мочевого пузыря', 'УЗИ предстательной железы трансабдоминально без исследования мочевого пузыря', 250, 'УЗИ'),
(36, 'УЗИ предстательной железы трансабдоминально и исследование мочевого пузыря', 'УЗИ предстательной железы трансабдоминально и исследование мочевого пузыря', 350, 'УЗИ'),
(37, 'УЗИ предстательной железы абдоминально, мочевой пузырь с определением объема остаточной мочи	', 'УЗИ предстательной железы абдоминально, мочевой пузырь с определением объема ост', 450, 'УЗИ'),
(38, 'УЗИ лимфатических узлов - одна область', 'УЗИ лимфатических узлов - одна область', 250, 'УЗИ'),
(39, 'УЗИ предстательной железы абдоминально, мочевой пузырь с определением объема остаточной мочи	', 'УЗИ предстательной железы абдоминально', 450, 'УЗИ'),
(40, 'УЗИ лимфатических узлов - одна область', 'УЗИ лимфатических узлов - одна область', 250, 'УЗИ'),
(41, 'УЗИ лимфатических узлов - две области', 'УЗИ лимфатических узлов - две области', 400, 'УЗИ'),
(42, 'УЗИ лимфатических узлов - три области', 'УЗИ лимфатических узлов - три области', 600, 'УЗИ'),
(43, 'УЗИ щитовидной железы и лимфатических узлов', 'УЗИ щитовидной железы и лимфатических узлов', 450, 'УЗИ'),
(44, 'УЗИ щитовидной железы и лимфатических узлов с цветным доплеровским картированием', 'УЗИ щитовидной железы и лимфатических узлов с цветным доплеровским картированием', 500, 'УЗИ'),
(45, 'УЗИ почек, предстательной железы, мочевого пузыря, объёма остаточной мочи', 'УЗИ почек, предстательной железы, мочевого пузыря, объёма остаточной мочи', 600, 'УЗИ'),
(46, 'УЗИ слюнных желез', 'УЗИ слюнных желез', 300, 'УЗИ'),
(47, 'УЗИ слюнных желез и лимфатических узлов подчелюстной области', 'УЗИ слюнных желез и лимфатических узлов подчелюстной области', 450, 'УЗИ'),
(48, 'УЗИ плевральных полостей', 'УЗИ плевральных полостей', 300, 'УЗИ'),
(49, 'УЗИ допплерография аорты (брюшная часть)', 'УЗИ допплерография аорты (брюшная часть)', 450, 'УЗИ'),
(50, 'УЗИ одного крупного сустава', 'УЗИ одного крупного сустава', 400, 'УЗИ'),
(51, 'УЗИ мягких тканей (одна область)', 'УЗИ мягких тканей (одна область)', 300, 'УЗИ'),
(52, 'УЗДГ сосудов печени (портальной системы)', 'УЗДГ сосудов печени (портальной системы)', 450, 'УЗИ'),
(53, 'ЦДК одного органа', 'ЦДК одного органа', 200, 'УЗИ'),
(54, 'ЦДК двух суставов одной области', 'ЦДК двух суставов одной области', 600, 'УЗИ'),
(55, 'УЗИ ахиллового сухожилия', 'УЗИ ахиллового сухожилия', 200, 'УЗИ'),
(56, 'УЗДГ сосудов почек', 'УЗДГ сосудов почек', 700, 'УЗИ'),
(57, 'УЗДГ сосудов шеи', 'УЗДГ сосудов шеи', 700, 'УЗИ'),
(58, 'Видеозапись обследования на цифровой носитель (цифровой flash-накопитель входит в стоимость)', 'Видеозапись обследования на цифровой носитель', 500, 'ДОПОЛНИТЕЛЬНЫЕ УСЛУГИ');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
