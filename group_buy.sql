-- MySQL dump 10.13  Distrib 5.6.21, for osx10.8 (x86_64)
--
-- Host: localhost    Database: group_by
-- ------------------------------------------------------
-- Server version	5.6.21-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `gb_admin`
--

DROP TABLE IF EXISTS `gb_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gb_admin` (
  `account` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`account`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gb_admin`
--

LOCK TABLES `gb_admin` WRITE;
/*!40000 ALTER TABLE `gb_admin` DISABLE KEYS */;
INSERT INTO `gb_admin` VALUES ('jkdzsw','af589fc3bc2dbb44f104495eb59a9eef','碱康e家',1);
/*!40000 ALTER TABLE `gb_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gb_article`
--

DROP TABLE IF EXISTS `gb_article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gb_article` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `station_id` bigint(20) NOT NULL COMMENT '站点ID',
  `title` varchar(255) NOT NULL COMMENT '资讯标题',
  `section_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `author` varchar(255) DEFAULT NULL COMMENT '作者',
  `keywords` varchar(255) DEFAULT NULL COMMENT '资讯关键词',
  `desc` varchar(255) DEFAULT NULL COMMENT '资讯简介',
  `content` text COMMENT '资讯内容',
  `wap_content` text COMMENT '手机资讯内容',
  `cover` varchar(255) DEFAULT NULL COMMENT '封面图片',
  `thumb` varchar(255) DEFAULT NULL COMMENT '缩略图',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `add_time` int(11) NOT NULL COMMENT '创建时间',
  `last_modify` timestamp NOT NULL COMMENT '修改时间',
  `view_count` int(11) NOT NULL DEFAULT '0' COMMENT '浏览次数',
  `thumbs_up` int(11) NOT NULL DEFAULT '0' COMMENT '赞',
  `thumbs_down` int(11) NOT NULL DEFAULT '0' COMMENT '踩',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gb_article`
--

LOCK TABLES `gb_article` WRITE;
/*!40000 ALTER TABLE `gb_article` DISABLE KEYS */;
INSERT INTO `gb_article` VALUES (2,1,'健康之路',1,'碱康2家','你说呢','求生之路','这下就好了吧，很多内容噢','这下就好了吧，很多内容噢','/group_buy/upload/image/20170410/20170410155131_57573.png','/group_buy/upload/image/20161127/20161127142056_51025.jpg',50,1,1480842440,'2016-12-04 09:07:20',0,0,0),(3,1,'资讯标题',1,'碱康e家','关键词','简介简介简介','<p>\n	你猜这是啥\n</p>\n<p>\n	你猜我猜不猜\n</p>','<p>\n	你猜这是啥\n</p>\n<p>\n	你猜我猜不猜\n</p>','/group_buy/upload/image/20161204/20161204101206_27343.png','/group_buy/upload/image/20161204/20161204101215_44248.jpg',50,1,1480842760,'2016-12-04 09:12:40',0,0,0),(4,1,'第一章. 综述',4,'碱康e家','健康就是这么简单','自古逢秋悲寂寥，我言秋日胜春朝','<img src=\"/group_buy/upload/image/20161127/20161127100904_30333.jpg\" alt=\"\" />','<img src=\"/group_buy/upload/image/20161127/20161127100904_30333.jpg\" alt=\"\" />','/group_buy/upload/image/20161127/20161127115807_41378.jpg','/group_buy/upload/image/20161204/20161204100850_81233.jpg',50,1,1482069890,'2016-12-18 14:04:50',0,0,0),(5,1,'第二章. 上古天真论篇第一',4,'碱康e家','健康就是这么简单','晴空一鹤排云上，便引诗情到碧霄','<img src=\"/group_buy/upload/image/20161127/20161127100904_30333.jpg\" alt=\"\" />','<img src=\"/group_buy/upload/image/20161127/20161127100904_30333.jpg\" alt=\"\" />','/group_buy/upload/image/20161127/20161127100904_30333.jpg','/group_buy/upload/image/20161204/20161204100850_81233.jpg',50,1,1482069959,'2016-12-18 14:05:59',0,0,0),(6,1,'第三章. 四气调神大论篇第二',4,'碱康e家','健康就是这么简单','春三月，此谓发陈，天地俱生，万物以荣，夜卧早起，广步于庭，被发缓形，以使志生，生而勿杀，予而勿夺，赏而勿罚，此春气之应，养生之道也。逆之则伤肝，夏为寒变，奉长者少。','<p>\n	<span style=\"font-size:14px;\">&nbsp; &nbsp; 春三月，此谓发陈，天地俱生，万物以荣，夜卧早起，广步于庭，被发缓形，以使志生，生而勿杀，予而勿夺，赏而勿罚，此春气之应，养生之道也。逆之则伤肝，夏为寒变，奉长者少。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　夏三月，此谓蕃秀，天地气交，万物华实，夜卧早起，无厌于日，使志无怒，使华英成秀，使气得泄，若所爱在外，此夏气之应，养长之道也。逆之则伤心，秋为痎疟，奉收者少，冬至重病。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　秋三月，此谓容平，天气以急，地气以明，早卧早起，与鸡俱兴，使志安宁，以缓秋刑，收敛神气，使秋气平，无外其志，使肺气清，此秋气之应，养收之道也。逆之则伤肺，冬为飧泄，奉藏者少。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　冬三月，此谓闭藏，水冰地坼，无扰乎阳，早卧晚起，必待日光，使志若伏若匿，若有私意，若已有得，去寒就温，无泄皮肤，使气亟夺，此冬气之应，养藏之道也。逆之则伤肾，春为痿厥，奉生者少。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　天气，清净光明者也，藏德不止，故不下也。天明则日月不明，邪害空窍，阳气者闭塞，地气者冒明，云雾不精，则上应白露不下。交通不表，万物命故不施，不施则名木多死。恶气不发，风雨不节，白露不下，则菀槁不荣。贼风数至，暴雨数起，天地四时不相保，与道相失，则未央绝灭。唯圣人从之，故身无奇病，万物不失，生气不竭。逆春气，则少阳不生，肝气内变。逆夏气，则太阳不长，心气内洞。逆秋气，则太阴不收，肺气焦满。逆冬气，则少阴不藏，肾气独沉。夫四时阴阳者，万物之根本也。所以圣人春夏养阳，秋冬养阴，以从其根，故与万物沉浮于生长之门。逆其根，则伐其本，坏其真矣。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故阴阳四时者，万物之终始也，死生之本也，逆之则灾害生，从之则苛疾不起，是谓得道。道者，圣人行之，愚者佩之。从阴阳则生。逆之则死，从之则治，逆之则乱。反顺为逆，是谓内格。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　是故圣人不治已病，治未病，不治已乱，治未乱，此之谓也。夫病已成而后药之，乱已成而后治之，譬犹渴而穿井，斗而铸锥，不亦晚乎。</span>\n</p>','<p>\n	<span style=\"font-size:14px;\">&nbsp; &nbsp; 春三月，此谓发陈，天地俱生，万物以荣，夜卧早起，广步于庭，被发缓形，以使志生，生而勿杀，予而勿夺，赏而勿罚，此春气之应，养生之道也。逆之则伤肝，夏为寒变，奉长者少。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　夏三月，此谓蕃秀，天地气交，万物华实，夜卧早起，无厌于日，使志无怒，使华英成秀，使气得泄，若所爱在外，此夏气之应，养长之道也。逆之则伤心，秋为痎疟，奉收者少，冬至重病。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　秋三月，此谓容平，天气以急，地气以明，早卧早起，与鸡俱兴，使志安宁，以缓秋刑，收敛神气，使秋气平，无外其志，使肺气清，此秋气之应，养收之道也。逆之则伤肺，冬为飧泄，奉藏者少。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　冬三月，此谓闭藏，水冰地坼，无扰乎阳，早卧晚起，必待日光，使志若伏若匿，若有私意，若已有得，去寒就温，无泄皮肤，使气亟夺，此冬气之应，养藏之道也。逆之则伤肾，春为痿厥，奉生者少。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　天气，清净光明者也，藏德不止，故不下也。天明则日月不明，邪害空窍，阳气者闭塞，地气者冒明，云雾不精，则上应白露不下。交通不表，万物命故不施，不施则名木多死。恶气不发，风雨不节，白露不下，则菀槁不荣。贼风数至，暴雨数起，天地四时不相保，与道相失，则未央绝灭。唯圣人从之，故身无奇病，万物不失，生气不竭。逆春气，则少阳不生，肝气内变。逆夏气，则太阳不长，心气内洞。逆秋气，则太阴不收，肺气焦满。逆冬气，则少阴不藏，肾气独沉。夫四时阴阳者，万物之根本也。所以圣人春夏养阳，秋冬养阴，以从其根，故与万物沉浮于生长之门。逆其根，则伐其本，坏其真矣。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故阴阳四时者，万物之终始也，死生之本也，逆之则灾害生，从之则苛疾不起，是谓得道。道者，圣人行之，愚者佩之。从阴阳则生。逆之则死，从之则治，逆之则乱。反顺为逆，是谓内格。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　是故圣人不治已病，治未病，不治已乱，治未乱，此之谓也。夫病已成而后药之，乱已成而后治之，譬犹渴而穿井，斗而铸锥，不亦晚乎。</span>\n</p>','/group_buy/upload/image/20161127/20161127100904_30333.jpg','/group_buy/upload/image/20161204/20161204100850_81233.jpg',50,1,1482070160,'2016-12-18 14:09:20',0,0,0),(7,1,'第四章. 生气通天论篇第三',4,'碱康e家','健康就是这么简单','黄帝曰：夫自古通天者，生之本，本于阴阳。天地之间，六合之内，其气九州、九窍、五藏、十二节，皆通乎天气。其生五，其气三。数犯此者，则邪气伤人，此寿命之本也。','<p>\n	<span style=\"font-size:14px;\">黄帝曰：夫自古通天者，生之本，本于阴阳。天地之间，六合之内，其气九州、九窍、五藏、十二节，皆通乎天气。其生五，其气三。数犯此者，则邪气伤人，此寿命之本也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　苍天之气，清净则志意治，顺之则阳气固，虽有贼邪，弗能害也。此因时之序。故圣人传精神，服天气，而通神明，失之则内闭九窍，外壅肌肉，卫气散解，此谓自伤，气之削也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　阳气者若天与日，失其所，则折寿而不彰故天运当以日光明，是故阳因而上，卫外者也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　因于寒，欲如运枢，起居如惊，神气乃浮。因于暑，汗烦则喘喝，静则多言，体若燔炭，汗出而散。因于湿，首如裹，湿热不攘，大筋緛短，小筋驰长，软短为拘，驰长为痿。因于气，为肿，四维相代，阳气乃竭。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　阳气者，烦劳则张，精绝。辟积于夏，使人煎厥。目盲不可以视，耳闭不可能听，溃溃乎若坏都，汩汩乎不可止。阳气者，大怒则形气绝；而血菀于上，使人薄厥，有伤于筋，纵，其若不容，汗出偏沮，使人偏枯。汗出见湿，乃坐痤痱。高梁之变，足生大丁，受如持虚。劳汗当风，寒薄为皶，郁乃痤。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　阳气者，精则养神，柔则养筋。开阖不得，寒气从之，乃生大偻；陷脉为瘘，留连肉腠，俞气化薄，传为善畏，及为惊骇；营气不从，逆于肉理，乃生臃肿；魄汗未尽，形弱而气烁，穴俞以闭，发为风疟。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故风者，百病之始也。清静则肉腠闭拒，虽有大风苛毒，弗之能害，此因时之序也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故病久则传化，上下不并，良医弗为。故阳畜积病死，而阳气当隔，隔者当泻，不亟正治，粗乃败之。故阳气者，一日而主外，平旦人气生，日中而阳气隆，日西而阳气已虚，气门乃闭。是故暮而收拒，无扰筋骨，无见雾露，反此三时，形乃困薄。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　岐伯曰：阴者，藏精而起亟也；阳者，卫外而为固也。阴不胜其阳，则脉流薄疾，并乃狂；阳不胜其阴，则五藏气争，九窍不通。是以圣人陈阴阳，筋脉和同，骨髓坚固，血气皆从；如是则内外调和，邪不能害，耳目聪明，气立如故。风客淫气，精乃亡，邪伤肝也。因而饱食，筋脉横解，肠癖为痔；因而大饮，则气逆；因而强力，肾气乃伤，高骨乃坏。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　凡阴阳之要，阳密乃固，两者不和，若春无秋，若冬无夏，因而和之，是谓圣度。故阳强不能密，阴气乃绝；阴平阳秘，精神乃治；阴阳离决，精气乃绝。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　因于露风，乃生寒热。是以春伤于风，邪气留连，乃为洞泄；夏伤于暑，秋为痎疟；秋伤于湿，上逆而咳，发为痿厥；冬伤于寒，春必温病。四时之气，更伤五藏。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　阴之所生，本在五味，阴之五宫，伤在五味。是故味过于酸，肝气以津，脾气乃绝；味过于咸，大骨气劳，短肌，心气抑；味过于甘，心气喘满，色黑，肾气不衡；味过于苦，脾气不濡，胃气乃厚；味过于辛，筋脉沮驰，精神乃央。是故谨和五味，骨正筋柔，气血以流，腠理以密，如是则骨气以精。谨道如法，长有天命。</span>\n</p>','<p>\n	<span style=\"font-size:14px;\">黄帝曰：夫自古通天者，生之本，本于阴阳。天地之间，六合之内，其气九州、九窍、五藏、十二节，皆通乎天气。其生五，其气三。数犯此者，则邪气伤人，此寿命之本也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　苍天之气，清净则志意治，顺之则阳气固，虽有贼邪，弗能害也。此因时之序。故圣人传精神，服天气，而通神明，失之则内闭九窍，外壅肌肉，卫气散解，此谓自伤，气之削也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　阳气者若天与日，失其所，则折寿而不彰故天运当以日光明，是故阳因而上，卫外者也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　因于寒，欲如运枢，起居如惊，神气乃浮。因于暑，汗烦则喘喝，静则多言，体若燔炭，汗出而散。因于湿，首如裹，湿热不攘，大筋緛短，小筋驰长，软短为拘，驰长为痿。因于气，为肿，四维相代，阳气乃竭。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　阳气者，烦劳则张，精绝。辟积于夏，使人煎厥。目盲不可以视，耳闭不可能听，溃溃乎若坏都，汩汩乎不可止。阳气者，大怒则形气绝；而血菀于上，使人薄厥，有伤于筋，纵，其若不容，汗出偏沮，使人偏枯。汗出见湿，乃坐痤痱。高梁之变，足生大丁，受如持虚。劳汗当风，寒薄为皶，郁乃痤。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　阳气者，精则养神，柔则养筋。开阖不得，寒气从之，乃生大偻；陷脉为瘘，留连肉腠，俞气化薄，传为善畏，及为惊骇；营气不从，逆于肉理，乃生臃肿；魄汗未尽，形弱而气烁，穴俞以闭，发为风疟。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故风者，百病之始也。清静则肉腠闭拒，虽有大风苛毒，弗之能害，此因时之序也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故病久则传化，上下不并，良医弗为。故阳畜积病死，而阳气当隔，隔者当泻，不亟正治，粗乃败之。故阳气者，一日而主外，平旦人气生，日中而阳气隆，日西而阳气已虚，气门乃闭。是故暮而收拒，无扰筋骨，无见雾露，反此三时，形乃困薄。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　岐伯曰：阴者，藏精而起亟也；阳者，卫外而为固也。阴不胜其阳，则脉流薄疾，并乃狂；阳不胜其阴，则五藏气争，九窍不通。是以圣人陈阴阳，筋脉和同，骨髓坚固，血气皆从；如是则内外调和，邪不能害，耳目聪明，气立如故。风客淫气，精乃亡，邪伤肝也。因而饱食，筋脉横解，肠癖为痔；因而大饮，则气逆；因而强力，肾气乃伤，高骨乃坏。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　凡阴阳之要，阳密乃固，两者不和，若春无秋，若冬无夏，因而和之，是谓圣度。故阳强不能密，阴气乃绝；阴平阳秘，精神乃治；阴阳离决，精气乃绝。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　因于露风，乃生寒热。是以春伤于风，邪气留连，乃为洞泄；夏伤于暑，秋为痎疟；秋伤于湿，上逆而咳，发为痿厥；冬伤于寒，春必温病。四时之气，更伤五藏。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　阴之所生，本在五味，阴之五宫，伤在五味。是故味过于酸，肝气以津，脾气乃绝；味过于咸，大骨气劳，短肌，心气抑；味过于甘，心气喘满，色黑，肾气不衡；味过于苦，脾气不濡，胃气乃厚；味过于辛，筋脉沮驰，精神乃央。是故谨和五味，骨正筋柔，气血以流，腠理以密，如是则骨气以精。谨道如法，长有天命。</span>\n</p>','/group_buy/upload/image/20161127/20161127115807_41378.jpg','/group_buy/upload/image/20161204/20161204100850_81233.jpg',50,1,1482070279,'2016-12-18 14:11:19',0,0,0),(8,1,'第五章. 金匮真言论篇第四',4,'碱康e家','健康就是这么简单','黄帝曰：天有八风，经有五风，何谓？\n　　岐伯对曰：八风发邪，以为经风，触五藏，邪气发病。所谓得四时之胜者：春胜长夏，长夏胜冬，冬胜夏，夏胜秋，秋胜春，所谓四时之胜也。','<p>\n	<span style=\"font-size:14px;\">黄帝曰：天有八风，经有五风，何谓？</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　岐伯对曰：八风发邪，以为经风，触五藏，邪气发病。所谓得四时之胜者：春胜长夏，长夏胜冬，冬胜夏，夏胜秋，秋胜春，所谓四时之胜也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　东风生于春，病在肝，俞在颈项；南风生于夏，病在心，俞在胸胁；西风生于秋，病在肺，俞在肩背；北风生于冬，病在肾，俞在腰股；中央为土，病在脾，俞在脊。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故春气者，病在头；夏气者，病在藏；秋气者，病在肩背；冬气者，病在四支。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故春善病鼽衄，仲夏善病胸胁，长夏善病洞泄寒中，秋善病风疟，冬善病痹厥。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故冬不按跷，春不鼽衄，春不病颈项，仲夏不病胸胁，长夏不病洞泄寒中，秋不病风疟，冬不病痹厥，飧泄而汗出也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　夫精者，身之本也。故藏于精者，春不病温。夏暑汗不出者，秋成风疟。此平人脉法也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故曰：阴中有阴，阳中有阳。平旦至日中，天之阳，阳中之阳也；日中至黄昏，天之阳，阳中之阴也；合夜至鸡鸣，天之阴，阴中之阴也；鸡鸣至平旦，天之阴，阴中之阳也。故人亦应之。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　夫言人之阴阳，则外为阳，内为阴；言人身之阴阳，则背为阳，腹为阴；言人身之藏腑中阴阳，则藏者为阴，腑者为阳，肝、心、脾、肺、肾五藏皆为阴，胆、胃、大肠、小肠、膀胱、三焦六腑皆为阳。所以欲知阴中之阴、阳中之阳者何也？为冬病在阴，夏病在阳，春病在阴，秋病在阳，皆视其所在，为施针石也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故背为阳，阳中之阳，心也；背为阳，阳中之阴，肺也；腹为阴，阴中之阴，肾也；腹为阴，阴中之阳，肝也；腹为阴，阴中之至阴，脾也。此皆阴阳表里、内外、雌雄相输应也，故以应天之阴阳也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　帝曰：五藏应四时，各有收受乎？</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　岐伯曰：有。东方青色，入通于肝，开窍于目，藏精于肝，其病发惊骇；其味酸，其类草木，其畜鸡，其谷麦，其应四时，上为岁星，是以春气在头也，其音角，其数八，是以知病之在筋也，其臭臊。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　南方赤色，入通于心，开窍于耳，藏精于心，故病在五藏；其味苦，其类火，其畜羊，其谷黍，其应四时，上为荧惑星，是以知病之在脉也，其音徵，其数七，其臭焦。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　中央黄色，入通于脾，开窍于口，藏精于脾，故病在舌本；其味甘，其类土，其畜牛，其谷稷，其应四时上为镇星，是以知病在肉也，其音宫，其数五，其臭香。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　西方白色，入通于肺，开窍于鼻，藏精于肺，故病在背；其味辛，其类金，其畜马，其谷稻，其应四时，上为太白星，是以知病之在皮毛也，其音商，其数九，其臭腥。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　北方黑色，入通于肾，开窍于二阴，藏精于肾，故病在溪；其味咸，其类水，其畜彘，其谷豆，其应四时，上为辰星，是以知病之在骨也，其音羽，其数六，其臭腐。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故善为脉者，谨察五藏六府，一逆一从，阴阳、表里、雌雄之纪，藏之心意，合心于精。非其人勿教，非其真勿授，是谓得道。</span>\n</p>','<p>\n	<span style=\"font-size:14px;\">黄帝曰：天有八风，经有五风，何谓？</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　岐伯对曰：八风发邪，以为经风，触五藏，邪气发病。所谓得四时之胜者：春胜长夏，长夏胜冬，冬胜夏，夏胜秋，秋胜春，所谓四时之胜也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　东风生于春，病在肝，俞在颈项；南风生于夏，病在心，俞在胸胁；西风生于秋，病在肺，俞在肩背；北风生于冬，病在肾，俞在腰股；中央为土，病在脾，俞在脊。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故春气者，病在头；夏气者，病在藏；秋气者，病在肩背；冬气者，病在四支。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故春善病鼽衄，仲夏善病胸胁，长夏善病洞泄寒中，秋善病风疟，冬善病痹厥。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故冬不按跷，春不鼽衄，春不病颈项，仲夏不病胸胁，长夏不病洞泄寒中，秋不病风疟，冬不病痹厥，飧泄而汗出也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　夫精者，身之本也。故藏于精者，春不病温。夏暑汗不出者，秋成风疟。此平人脉法也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故曰：阴中有阴，阳中有阳。平旦至日中，天之阳，阳中之阳也；日中至黄昏，天之阳，阳中之阴也；合夜至鸡鸣，天之阴，阴中之阴也；鸡鸣至平旦，天之阴，阴中之阳也。故人亦应之。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　夫言人之阴阳，则外为阳，内为阴；言人身之阴阳，则背为阳，腹为阴；言人身之藏腑中阴阳，则藏者为阴，腑者为阳，肝、心、脾、肺、肾五藏皆为阴，胆、胃、大肠、小肠、膀胱、三焦六腑皆为阳。所以欲知阴中之阴、阳中之阳者何也？为冬病在阴，夏病在阳，春病在阴，秋病在阳，皆视其所在，为施针石也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故背为阳，阳中之阳，心也；背为阳，阳中之阴，肺也；腹为阴，阴中之阴，肾也；腹为阴，阴中之阳，肝也；腹为阴，阴中之至阴，脾也。此皆阴阳表里、内外、雌雄相输应也，故以应天之阴阳也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　帝曰：五藏应四时，各有收受乎？</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　岐伯曰：有。东方青色，入通于肝，开窍于目，藏精于肝，其病发惊骇；其味酸，其类草木，其畜鸡，其谷麦，其应四时，上为岁星，是以春气在头也，其音角，其数八，是以知病之在筋也，其臭臊。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　南方赤色，入通于心，开窍于耳，藏精于心，故病在五藏；其味苦，其类火，其畜羊，其谷黍，其应四时，上为荧惑星，是以知病之在脉也，其音徵，其数七，其臭焦。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　中央黄色，入通于脾，开窍于口，藏精于脾，故病在舌本；其味甘，其类土，其畜牛，其谷稷，其应四时上为镇星，是以知病在肉也，其音宫，其数五，其臭香。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　西方白色，入通于肺，开窍于鼻，藏精于肺，故病在背；其味辛，其类金，其畜马，其谷稻，其应四时，上为太白星，是以知病之在皮毛也，其音商，其数九，其臭腥。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　北方黑色，入通于肾，开窍于二阴，藏精于肾，故病在溪；其味咸，其类水，其畜彘，其谷豆，其应四时，上为辰星，是以知病之在骨也，其音羽，其数六，其臭腐。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故善为脉者，谨察五藏六府，一逆一从，阴阳、表里、雌雄之纪，藏之心意，合心于精。非其人勿教，非其真勿授，是谓得道。</span>\n</p>','/group_buy/upload/image/20161127/20161127100904_30333.jpg','/group_buy/upload/image/20161204/20161204100850_81233.jpg',50,1,1482071183,'2016-12-18 14:26:23',0,0,0),(9,1,'第六章. 阴阳应象大论篇第五',4,'碱康e家','健康就是这么简单','黄帝曰：阴阳者，天地之道也，万物之纲纪，变化之父母，生杀之本始，神明之府也。治病必求于本。故积阳为天，积阴为地。阴静阳躁，阳生阴长，阳杀阴藏。阳化气，阴成形。寒极生热，热极生寒；寒气生浊，热气生清；清气在下，则生飧泄，浊气在上，则生(月真chēn)胀。此阴阳反作，病之逆从也。','<p>\n	<span style=\"font-size:14px;\">黄帝曰：阴阳者，天地之道也，万物之纲纪，变化之父母，生杀之本始，神明之府也。治病必求于本。故积阳为天，积阴为地。阴静阳躁，阳生阴长，阳杀阴藏。阳化气，阴成形。寒极生热，热极生寒；寒气生浊，热气生清；清气在下，则生飧泄，浊气在上，则生(月真chēn)胀。此阴阳反作，病之逆从也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故清阳为天，浊阴为地。地气上为云，天气下为雨；雨出地气，云出天气。故清阳出上窍，浊阴出下窍；清阳发腠理，浊阴走五藏；清阳实四支，浊阴归六府。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　水为阴，火为阳。阳为气，阴为味。味归形，形归气，气归精，精归化；精食气，形食味，化生精，气生形。味伤形，气伤精，精化为气，气伤于味。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　阴味出下窍，阳气出上窍。味厚者为阴，薄为阴之阳；气厚者为阳，薄为阳之阴。味厚则泄，薄则通；气薄则发泄，厚则发热。壮火之气衰，少火之气壮，壮火食气，气食少火，壮火散气，少火生气。气味辛甘发散为阳，酸苦涌泄为阴。阴胜则阳病，阳胜则阴病。阳胜则热，阴胜则寒。重寒则热，重热则寒。寒伤形，热伤气；气伤痛，形伤肿。故先痛而后肿者，气伤形也；先肿而后痛者，形伤气也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　风胜则动，热胜则肿，燥胜则干，寒胜则浮，湿胜则濡泻。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　天有四时五行，以生长收藏，以生寒暑燥湿风。人有五藏化五气，以生喜怒悲忧恐。故喜怒伤气，寒暑伤形。暴怒伤阴，暴喜伤阳。厥气上行，满脉去形。喜怒不节，寒暑过度，生乃不固。故重阴必阳，重阳必阴。故曰：冬伤于寒，春必温病；春伤于风，夏生飧泄；夏伤于暑，秋必痎疟；秋伤于湿，冬生咳嗽。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　帝曰：余闻上古圣人，论理人形，列别藏府，端络经脉，会通六合，各从其经；气穴所发，各有处名；溪谷属骨，皆有所起；分部逆从，各有条理；四时阴阳，尽有经纪；外内之应，皆有表里，其信然乎？</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　岐伯对曰：东方生风，风生木，木生酸，酸生肝，肝生筋，筋生心，肝主目。其在天为玄，在人为道，在地为化。化生五味，道生智，玄生神。神在天为风，在地为木，在体为筋，在藏为肝，在色为苍，在音为角，在声为呼，在变动为握，在窍为目，在味为酸，在志为怒。怒伤肝，悲胜怒；风伤筋，燥胜风；酸伤筋，辛胜酸。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　南方生热，热生火，火生苦，苦生心，心生血，血生脾，心主舌。其在天为热，在地为火，在体为脉，在藏为心，在色为赤，在音为徵，在声为笑，在变动为忧，在窍为舌，在味为苦，在志为喜，喜伤心，恐胜喜；热伤气，寒胜热，苦伤气，咸胜苦。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　中央生湿，湿生土，土生甘，甘生脾，脾生肉，肉生肺，脾主口。其在天为湿，在地为土，在体为肉，在藏为脾，在色为黄，在音为宫，在声为歌，在变动为哕，在窍为口，在味为甘，在志为思。思伤脾，怒胜思；湿伤肉，风胜湿；甘伤肉，酸胜甘。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　西方生燥，燥生金，金生辛，辛生肺，肺生皮毛，皮毛生肾，肺主鼻。其在天为燥，在地为金，在体为皮毛，在藏为肺，在色为白，在音为商，在声为哭，在变动为咳，在窍为鼻，在味为辛，在志为忧。忧伤肺，喜胜忧；热伤皮毛，寒胜热；辛伤皮毛，苦胜辛。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　北方生寒，寒生水，水生咸，咸生肾，肾生骨髓，髓生肝，肾主耳。其在天为寒，在地为水，在体为骨，在藏为肾，在色为黑，在音为羽，在声为呻，在变动为栗，在窍为耳，在味为咸，在志为恐。恐伤肾，思胜恐；寒伤血，燥胜寒；咸伤血，甘胜咸。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故曰：天地者，万物之上下也；阴阳者，血气之男女也；左右者，阴阳之道路也；水火者，阴阳之征兆也；阴阳者，万物之能始也。故曰：阴在内，阳之守也；阳在外，阴之使也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　帝曰：法阴阳奈何？</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　岐伯曰：阳胜则身热，腠理闭，喘粗为之俯仰，汗不出而热，齿干以烦冤，腹满死，能冬不能夏。阴胜则身寒，汗出，身常清，数栗而寒，寒则厥，厥则腹满死，能夏不能冬。此阴阳更胜之变，病之形能也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　帝曰：调此二者奈何？</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　岐伯曰：能知七损八益，则二者可调，不知用此，则早衰之节也。年四十而阴气自半也，起居衰矣；年五十，体重，耳目不聪明矣；年六十，阴萎，气不衰，九窍不利，下虚上实，涕泣俱出矣。故曰：知之则强，不知则老，故同出而名异耳。智者察同，愚者察异。愚者不足，智者有余；有余则而目聪明，身体轻强，老者复壮，壮者益治。是以圣人为无为之事，乐恬淡之能，从欲快志于虚无之守，故寿命无穷，与天地终，此圣人之治身也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　天不足西北，故西北方阴也，而人右耳目不如左明也；地不满东南，故东南方阳也，而人左手足不如右强也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　帝曰：何以然？</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　岐伯曰：东方阳也，阳者其精并于上，并于上，则上明而下虚，故使耳目聪明，而手足不便也；西方阴也，阴者其精并于下，并于下，则下盛而上虚，故其耳目不聪明，而手足便也。故俱感于邪，其在上则右甚，在下则左甚，此天地阴阳所不能全也，故邪居之。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故天有精，地有形；天有八纪，地有五里，故能为万物之父母。清阳上天，浊阴归地，是故天地之动静，神明为之纲纪，故能以生长收藏，终而复始。惟贤人上配天以养头，下象地以养足，中傍人事以养五藏。天气通于肺，地气通于嗌，风气通于肝，雷气通于心，谷气通于脾，雨气通于肾。六经为川，肠胃为海，九窍为水注之气。以天地为之阴阳，阳之汗，以天地之雨名之；阳之气，以天地之疾风名之。暴气象雷，逆气象阳。故治不法天之纪，不用地之理，则灾害至矣。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故邪风之至，疾如风雨。故善治者治皮毛，其次治肌肤，其次治筋脉，其次治六府，其次治五藏。治五藏者，半死半生也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故天之邪气，感则害人五藏；水谷之寒热，感则害于六府；地之湿气，感则害皮肉筋脉。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故善用针者，从阴引阳，从阳引阴；以右治左，以左治右；以我知彼，以表知里；以观过与不及之理，见微得过，用之不殆。善诊者，察色按脉，先别阴阳；审清浊，而知部分；视喘息、听音声，而知所苦；观权衡规矩，而知病所主；按尺寸，观浮沉滑涩，而知病所生。以治无过，以诊则不失矣。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故曰：病之始起也，可刺而已；其盛，可待衰而已。故因其轻而扬之；因其重而减之；因其衰而彰之。形不足者，温之以气；精不足者，补之以味。其高者，因而越之；其下者，引而竭之；中满者，泻之于内；其有邪者，渍形以为汗；其在皮者，汗而发之，其彪悍者，按而收之；其实者，散而泻之。审其阴阳，以别柔刚，阳病治阴，阴病治阳；定其血气，各守其乡，血实宜决之，气虚宜掣引之。</span>\n</p>','<p>\n	<span style=\"font-size:14px;\">黄帝曰：阴阳者，天地之道也，万物之纲纪，变化之父母，生杀之本始，神明之府也。治病必求于本。故积阳为天，积阴为地。阴静阳躁，阳生阴长，阳杀阴藏。阳化气，阴成形。寒极生热，热极生寒；寒气生浊，热气生清；清气在下，则生飧泄，浊气在上，则生(月真chēn)胀。此阴阳反作，病之逆从也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故清阳为天，浊阴为地。地气上为云，天气下为雨；雨出地气，云出天气。故清阳出上窍，浊阴出下窍；清阳发腠理，浊阴走五藏；清阳实四支，浊阴归六府。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　水为阴，火为阳。阳为气，阴为味。味归形，形归气，气归精，精归化；精食气，形食味，化生精，气生形。味伤形，气伤精，精化为气，气伤于味。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　阴味出下窍，阳气出上窍。味厚者为阴，薄为阴之阳；气厚者为阳，薄为阳之阴。味厚则泄，薄则通；气薄则发泄，厚则发热。壮火之气衰，少火之气壮，壮火食气，气食少火，壮火散气，少火生气。气味辛甘发散为阳，酸苦涌泄为阴。阴胜则阳病，阳胜则阴病。阳胜则热，阴胜则寒。重寒则热，重热则寒。寒伤形，热伤气；气伤痛，形伤肿。故先痛而后肿者，气伤形也；先肿而后痛者，形伤气也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　风胜则动，热胜则肿，燥胜则干，寒胜则浮，湿胜则濡泻。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　天有四时五行，以生长收藏，以生寒暑燥湿风。人有五藏化五气，以生喜怒悲忧恐。故喜怒伤气，寒暑伤形。暴怒伤阴，暴喜伤阳。厥气上行，满脉去形。喜怒不节，寒暑过度，生乃不固。故重阴必阳，重阳必阴。故曰：冬伤于寒，春必温病；春伤于风，夏生飧泄；夏伤于暑，秋必痎疟；秋伤于湿，冬生咳嗽。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　帝曰：余闻上古圣人，论理人形，列别藏府，端络经脉，会通六合，各从其经；气穴所发，各有处名；溪谷属骨，皆有所起；分部逆从，各有条理；四时阴阳，尽有经纪；外内之应，皆有表里，其信然乎？</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　岐伯对曰：东方生风，风生木，木生酸，酸生肝，肝生筋，筋生心，肝主目。其在天为玄，在人为道，在地为化。化生五味，道生智，玄生神。神在天为风，在地为木，在体为筋，在藏为肝，在色为苍，在音为角，在声为呼，在变动为握，在窍为目，在味为酸，在志为怒。怒伤肝，悲胜怒；风伤筋，燥胜风；酸伤筋，辛胜酸。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　南方生热，热生火，火生苦，苦生心，心生血，血生脾，心主舌。其在天为热，在地为火，在体为脉，在藏为心，在色为赤，在音为徵，在声为笑，在变动为忧，在窍为舌，在味为苦，在志为喜，喜伤心，恐胜喜；热伤气，寒胜热，苦伤气，咸胜苦。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　中央生湿，湿生土，土生甘，甘生脾，脾生肉，肉生肺，脾主口。其在天为湿，在地为土，在体为肉，在藏为脾，在色为黄，在音为宫，在声为歌，在变动为哕，在窍为口，在味为甘，在志为思。思伤脾，怒胜思；湿伤肉，风胜湿；甘伤肉，酸胜甘。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　西方生燥，燥生金，金生辛，辛生肺，肺生皮毛，皮毛生肾，肺主鼻。其在天为燥，在地为金，在体为皮毛，在藏为肺，在色为白，在音为商，在声为哭，在变动为咳，在窍为鼻，在味为辛，在志为忧。忧伤肺，喜胜忧；热伤皮毛，寒胜热；辛伤皮毛，苦胜辛。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　北方生寒，寒生水，水生咸，咸生肾，肾生骨髓，髓生肝，肾主耳。其在天为寒，在地为水，在体为骨，在藏为肾，在色为黑，在音为羽，在声为呻，在变动为栗，在窍为耳，在味为咸，在志为恐。恐伤肾，思胜恐；寒伤血，燥胜寒；咸伤血，甘胜咸。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故曰：天地者，万物之上下也；阴阳者，血气之男女也；左右者，阴阳之道路也；水火者，阴阳之征兆也；阴阳者，万物之能始也。故曰：阴在内，阳之守也；阳在外，阴之使也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　帝曰：法阴阳奈何？</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　岐伯曰：阳胜则身热，腠理闭，喘粗为之俯仰，汗不出而热，齿干以烦冤，腹满死，能冬不能夏。阴胜则身寒，汗出，身常清，数栗而寒，寒则厥，厥则腹满死，能夏不能冬。此阴阳更胜之变，病之形能也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　帝曰：调此二者奈何？</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　岐伯曰：能知七损八益，则二者可调，不知用此，则早衰之节也。年四十而阴气自半也，起居衰矣；年五十，体重，耳目不聪明矣；年六十，阴萎，气不衰，九窍不利，下虚上实，涕泣俱出矣。故曰：知之则强，不知则老，故同出而名异耳。智者察同，愚者察异。愚者不足，智者有余；有余则而目聪明，身体轻强，老者复壮，壮者益治。是以圣人为无为之事，乐恬淡之能，从欲快志于虚无之守，故寿命无穷，与天地终，此圣人之治身也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　天不足西北，故西北方阴也，而人右耳目不如左明也；地不满东南，故东南方阳也，而人左手足不如右强也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　帝曰：何以然？</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　岐伯曰：东方阳也，阳者其精并于上，并于上，则上明而下虚，故使耳目聪明，而手足不便也；西方阴也，阴者其精并于下，并于下，则下盛而上虚，故其耳目不聪明，而手足便也。故俱感于邪，其在上则右甚，在下则左甚，此天地阴阳所不能全也，故邪居之。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故天有精，地有形；天有八纪，地有五里，故能为万物之父母。清阳上天，浊阴归地，是故天地之动静，神明为之纲纪，故能以生长收藏，终而复始。惟贤人上配天以养头，下象地以养足，中傍人事以养五藏。天气通于肺，地气通于嗌，风气通于肝，雷气通于心，谷气通于脾，雨气通于肾。六经为川，肠胃为海，九窍为水注之气。以天地为之阴阳，阳之汗，以天地之雨名之；阳之气，以天地之疾风名之。暴气象雷，逆气象阳。故治不法天之纪，不用地之理，则灾害至矣。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故邪风之至，疾如风雨。故善治者治皮毛，其次治肌肤，其次治筋脉，其次治六府，其次治五藏。治五藏者，半死半生也。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故天之邪气，感则害人五藏；水谷之寒热，感则害于六府；地之湿气，感则害皮肉筋脉。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故善用针者，从阴引阳，从阳引阴；以右治左，以左治右；以我知彼，以表知里；以观过与不及之理，见微得过，用之不殆。善诊者，察色按脉，先别阴阳；审清浊，而知部分；视喘息、听音声，而知所苦；观权衡规矩，而知病所主；按尺寸，观浮沉滑涩，而知病所生。以治无过，以诊则不失矣。</span>\n</p>\n<p>\n	<br />\n</p>\n<p>\n	<span style=\"font-size:14px;\">　　故曰：病之始起也，可刺而已；其盛，可待衰而已。故因其轻而扬之；因其重而减之；因其衰而彰之。形不足者，温之以气；精不足者，补之以味。其高者，因而越之；其下者，引而竭之；中满者，泻之于内；其有邪者，渍形以为汗；其在皮者，汗而发之，其彪悍者，按而收之；其实者，散而泻之。审其阴阳，以别柔刚，阳病治阴，阴病治阳；定其血气，各守其乡，血实宜决之，气虚宜掣引之。</span>\n</p>','/group_buy/upload/image/20161127/20161127135610_12145.jpg','/group_buy/upload/image/20161204/20161204100850_81233.jpg',50,1,1482071258,'2016-12-18 14:27:38',0,0,0);
/*!40000 ALTER TABLE `gb_article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gb_category`
--

DROP TABLE IF EXISTS `gb_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gb_category` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `station_id` bigint(20) NOT NULL COMMENT '站点ID',
  `name` varchar(255) NOT NULL COMMENT '商品分类名',
  `parent_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `path` varchar(255) DEFAULT NULL COMMENT '分类路径',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gb_category`
--

LOCK TABLES `gb_category` WRITE;
/*!40000 ALTER TABLE `gb_category` DISABLE KEYS */;
INSERT INTO `gb_category` VALUES (1,1,'保健品',0,'1,',50),(4,1,'消费品',1,'1,4,',50),(5,1,'王语嫣',6,'6,5,',50),(6,1,'天龙八部',0,'6,',50),(7,1,'碧水飘沙掌',5,'6,5,7,',50);
/*!40000 ALTER TABLE `gb_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gb_gallery`
--

DROP TABLE IF EXISTS `gb_gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gb_gallery` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `product_sn` varchar(255) NOT NULL COMMENT '商品编号',
  `image` varchar(255) NOT NULL COMMENT '图片URL',
  `sort` int(11) NOT NULL DEFAULT '10' COMMENT '图片排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gb_gallery`
--

LOCK TABLES `gb_gallery` WRITE;
/*!40000 ALTER TABLE `gb_gallery` DISABLE KEYS */;
/*!40000 ALTER TABLE `gb_gallery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gb_group`
--

DROP TABLE IF EXISTS `gb_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gb_group` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `group_sn` varchar(255) NOT NULL COMMENT '团编号',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '团状态',
  `add_time` datetime NOT NULL COMMENT '创建时间',
  `expired` datetime NOT NULL COMMENT '过期时间',
  `member_limit` int(11) NOT NULL COMMENT '组团人数',
  `current_number` int(11) NOT NULL COMMENT '当前团人数',
  PRIMARY KEY (`group_sn`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gb_group`
--

LOCK TABLES `gb_group` WRITE;
/*!40000 ALTER TABLE `gb_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `gb_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gb_nav`
--

DROP TABLE IF EXISTS `gb_nav`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gb_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `position` varchar(255) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '50',
  `path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gb_nav`
--

LOCK TABLES `gb_nav` WRITE;
/*!40000 ALTER TABLE `gb_nav` DISABLE KEYS */;
INSERT INTO `gb_nav` VALUES (1,'登录','http://localhost/group_buy/login.php',0,'top',50,'1,'),(2,'注册','http://localhost/group_buy/register.php',0,'top',50,'2,'),(3,'首页','http://localhost/group_buy/index.php',0,'middle',50,'3,'),(4,'品牌与产品','http://localhost/group_buy/section.php?id=1',0,'middle',50,'4,'),(5,'招商加盟','http://localhost/group_buy/article.php?id=1',0,'middle',50,'5,'),(6,'销售渠道','http://localhost/group_buy/sales.php',0,'middle',50,'6,'),(7,'健康学院','http://localhost/group_buy/section.php?id=2',0,'middle',50,'7,'),(8,'关于我们','http://localhost/group_buy/article.php?id=1',0,'middle',50,'8,'),(9,'防伪查询','http://localhost/group_buy/verify.php',0,'top',50,'9,'),(10,'销售渠道','http://localhost/group_buy/',0,'bottom',50,'10,'),(11,'品牌与产品','http://localhost/group_buy/',0,'bottom',50,'11,'),(12,'健康学院','http://localhost/group_buy/',0,'bottom',50,'12,'),(13,'网站地图','http://localhost/group_buy/site_map.php',0,'bottom',50,'13,');
/*!40000 ALTER TABLE `gb_nav` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gb_order`
--

DROP TABLE IF EXISTS `gb_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gb_order` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(255) NOT NULL COMMENT '订单编号',
  `add_time` datetime NOT NULL COMMENT '下单时间',
  `pay_time` datetime DEFAULT NULL COMMENT '支付时间',
  `pay_type` varchar(255) NOT NULL COMMENT '支付方式',
  `delivery_time` datetime DEFAULT NULL COMMENT '发货时间',
  `delivery_name` varchar(255) DEFAULT NULL COMMENT '快递公司',
  `delivery_sn` varchar(255) DEFAULT NULL COMMENT '快递单号',
  `delivery_code` varchar(255) DEFAULT NULL COMMENT '快递公司代码',
  `delivery_fee` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '订单运费',
  `order_amount` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '订单总额',
  `product_amount` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '产品总额',
  `coupon_amount` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '优惠券总额',
  `group_sn` varchar(255) DEFAULT NULL COMMENT '拼团编号',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '订单编号',
  `account` varchar(255) NOT NULL COMMENT '会员账号',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `delivery_type` varchar(255) NOT NULL COMMENT '物流方式',
  PRIMARY KEY (`order_sn`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gb_order`
--

LOCK TABLES `gb_order` WRITE;
/*!40000 ALTER TABLE `gb_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `gb_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gb_order_detail`
--

DROP TABLE IF EXISTS `gb_order_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gb_order_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(255) NOT NULL COMMENT '订单编号',
  `product_sn` varchar(255) NOT NULL COMMENT '产品编号',
  `image` varchar(255) NOT NULL COMMENT '产品图片',
  `price` decimal(18,2) NOT NULL COMMENT '购买单价',
  `unit` varchar(255) NOT NULL COMMENT '单位',
  `product_name` varchar(255) NOT NULL COMMENT '产品名称',
  `number` int(11) NOT NULL COMMENT '购买数量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gb_order_detail`
--

LOCK TABLES `gb_order_detail` WRITE;
/*!40000 ALTER TABLE `gb_order_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `gb_order_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gb_price_list`
--

DROP TABLE IF EXISTS `gb_price_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gb_price_list` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `product_sn` varchar(255) NOT NULL COMMENT '商品编号',
  `min_number` int(11) NOT NULL COMMENT '最低购买量',
  `price` decimal(18,2) NOT NULL COMMENT '价格',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gb_price_list`
--

LOCK TABLES `gb_price_list` WRITE;
/*!40000 ALTER TABLE `gb_price_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `gb_price_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gb_product`
--

DROP TABLE IF EXISTS `gb_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gb_product` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `station_id` bigint(20) NOT NULL COMMENT '站点ID',
  `product_sn` varchar(255) NOT NULL COMMENT '商品编号',
  `name` varchar(255) NOT NULL COMMENT '商品名称',
  `category_id` bigint(20) NOT NULL COMMENT '商品分类ID',
  `price` decimal(18,2) NOT NULL COMMENT '单独购价格',
  `market_price` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '市场价格',
  `group_price` decimal(18,2) NOT NULL COMMENT '团购价格',
  `group_limit` int(11) NOT NULL COMMENT '团购人数',
  `image` varchar(255) NOT NULL COMMENT '商品主图URL',
  `thumb` varchar(255) NOT NULL COMMENT '商品缩略图',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '商品状态',
  `detail` text COMMENT '商品详情',
  `desc` text COMMENT '商品摘要',
  `add_time` int(11) NOT NULL COMMENT '添加时间',
  `unit` varchar(255) NOT NULL COMMENT '单位',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  PRIMARY KEY (`product_sn`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gb_product`
--

LOCK TABLES `gb_product` WRITE;
/*!40000 ALTER TABLE `gb_product` DISABLE KEYS */;
INSERT INTO `gb_product` VALUES (2,1,'SAF1000','五味子',7,199.00,200.00,10.00,10,'/group_buy/upload/image/20161127/20161127142056_51025.jpg','/group_buy/upload/image/20161127/20161127142056_51025.jpg',1,'哈哈哈想不想知道[微笑]是怎么回事呢<img src=\"http://localhost/group_buy/plugins/common/kindeditor/plugins/emoticons/images/13.gif\" border=\"0\" alt=\"\" /><img src=\"http://localhost/group_buy/plugins/common/kindeditor/plugins/emoticons/images/105.gif\" border=\"0\" alt=\"\" />','五味子就是五味子咧',1481210360,'斤',50);
/*!40000 ALTER TABLE `gb_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gb_role`
--

DROP TABLE IF EXISTS `gb_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gb_role` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `purview` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gb_role`
--

LOCK TABLES `gb_role` WRITE;
/*!40000 ALTER TABLE `gb_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `gb_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gb_section`
--

DROP TABLE IF EXISTS `gb_section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gb_section` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `station_id` bigint(20) NOT NULL COMMENT '站点ID',
  `name` varchar(255) NOT NULL COMMENT '资讯分类名',
  `parent_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `path` varchar(255) DEFAULT NULL COMMENT '分类路径',
  `cover` varchar(255) DEFAULT NULL COMMENT '封面图片',
  `thumb` varchar(255) DEFAULT NULL COMMENT '缩略图',
  `sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gb_section`
--

LOCK TABLES `gb_section` WRITE;
/*!40000 ALTER TABLE `gb_section` DISABLE KEYS */;
INSERT INTO `gb_section` VALUES (1,1,'健康学院',0,'1,','/group_buy/upload/image/20161127/20161127101036_82413.jpg','/group_buy/upload/image/20161127/20161127142056_51025.jpg',50),(3,1,'系统分类',0,'3,','/group_buy/upload/image/20161127/20161127104844_58896.jpg','/group_buy/upload/image/20161127/20161127142056_51025.jpg',50),(4,1,'《健康就是这么简单》',0,'4,','/group_buy/upload/image/20161127/20161127100904_30333.jpg','/group_buy/upload/image/20161204/20161204100850_81233.jpg',50);
/*!40000 ALTER TABLE `gb_section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gb_sysconf`
--

DROP TABLE IF EXISTS `gb_sysconf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gb_sysconf` (
  `key` varchar(255) NOT NULL COMMENT '参数标识',
  `title` varchar(255) NOT NULL COMMENT '参数名',
  `type` varchar(255) NOT NULL COMMENT '参数类型',
  `group` varchar(255) NOT NULL COMMENT '参数组',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `value` varchar(255) DEFAULT NULL COMMENT '参数值',
  `station_id` int(11) NOT NULL DEFAULT '1' COMMENT '站点ID',
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gb_sysconf`
--

LOCK TABLES `gb_sysconf` WRITE;
/*!40000 ALTER TABLE `gb_sysconf` DISABLE KEYS */;
INSERT INTO `gb_sysconf` VALUES ('case_number','备案号','text','config',NULL,'粤ICP备-1234567890号',1),('company_address','公司地址','text','config',NULL,'广东省广州市天河区东方三路四号之一活动中心',1),('copyright','版权','text','config',NULL,'华农食品',1),('logo','logo','image','config',NULL,'/group_buy/upload/image/20170410/20170410155024_77349.png',1),('meta_description','站点描述','text','config',NULL,'碱康e家官网',1),('meta_keywords','站点关键词','text','config',NULL,'碱康电子商务,碱康e家',1),('service_phone','客服热线','text','config',NULL,'400-666-6666',1),('site_domain','域名','text','config',NULL,'http://localhost/group_buy/',1),('site_name','网站名称','text','config',NULL,'碱康e家',1),('site_theme','站点主题','text','config',NULL,'碱康e家，健康一家',1),('taobao_qrcode','淘宝二维码','image','config',NULL,'/group_buy/upload/image/20161218/20161218134914_38781.jpg',1),('wechat_qrcode','公众号二维码','image','config',NULL,'/group_buy/upload/image/20161218/20161218134914_38781.jpg',1);
/*!40000 ALTER TABLE `gb_sysconf` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-04-11  7:42:16
