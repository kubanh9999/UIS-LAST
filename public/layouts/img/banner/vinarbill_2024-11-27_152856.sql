-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: vinarbill
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` varchar(255) NOT NULL,
  `customer_id` varchar(255) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`roles`)),
  `refresh_token` varchar(255) DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_app_id_customer_id` (`app_id`,`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'1776868214296652687','613926922415046293','[{\"name\": \"SystemAdmin\", \"permission\": [{\"name\": \"CRUD_Product\", \"description\": \"Permission allow a user create, update, delete products, categories, variant\"}, {\"name\": \"CRUD_Order\", \"description\": \"Permission allow a user create, update, delete Orders\"}, {\"name\": \"CRUD_Customer\", \"description\": \"Permission allow a user create, update, delete Customers\"}]}]',NULL,'2024-09-20 03:33:52','2024-09-20 03:39:09'),(2,'1535840779071353189','1879698721990979799','[{\"name\": \"SystemAdmin\", \"permission\": [{\"name\": \"CRUD_Product\", \"description\": \"Permission allow a user create, update, delete products, categories, variant\"}, {\"name\": \"CRUD_Order\", \"description\": \"Permission allow a user create, update, delete Orders\"}, {\"name\": \"CRUD_Customer\", \"description\": \"Permission allow a user create, update, delete Customers\"}]}]',NULL,'2024-09-20 03:33:52','2024-09-20 03:39:09'),(3,'1535840779071353189','6078126932713746840','[{\"name\": \"SystemAdmin\", \"permission\": [{\"name\": \"CRUD_Product\", \"description\": \"Permission allow a user create, update, delete products, categories, variant\"}, {\"name\": \"CRUD_Order\", \"description\": \"Permission allow a user create, update, delete Orders\"}, {\"name\": \"CRUD_Customer\", \"description\": \"Permission allow a user create, update, delete Customers\"}]}]',NULL,'2024-09-20 03:33:52','2024-09-20 03:39:09'),(4,'1841446655309015484','3656678047792415890','[{\"name\": \"SystemAdmin\", \"permission\": [{\"name\": \"CRUD_Product\", \"description\": \"Permission allow a user create, update, delete products, categories, variant\"}, {\"name\": \"CRUD_Order\", \"description\": \"Permission allow a user create, update, delete Orders\"}, {\"name\": \"CRUD_Customer\", \"description\": \"Permission allow a user create, update, delete Customers\"}]}]',NULL,'2024-09-20 03:33:52','2024-09-20 03:39:09');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES ('brgpv','Bộ Rung Gọi Phục Vụ','Bộ Rung Gọi Phục Vụ','https://cdn1.iconfinder.com/data/icons/aami-web-internet/64/aami7-29-256.png','0000-00-00 00:00:00','0000-00-00 00:00:00'),('btbbh','Bộ Thiết Bị Bán Hàng','Bộ Thiết Bị Bán Hàng','https://cdn2.iconfinder.com/data/icons/sale-and-discount/32/Sale_and_Discount-13-256.png','0000-00-00 00:00:00','0000-00-00 00:00:00'),('cdt','Cân Điện Tử','Cân Điện Tử','https://cdn0.iconfinder.com/data/icons/appliance-1-1-1/1024/weighing_machine3-64.png','0000-00-00 00:00:00','0000-00-00 00:00:00'),('gib','Giấy In Bild','Giấy In Bild','https://cdn1.iconfinder.com/data/icons/bill-and-payment-15/48/printing_payment_finance_dollar_paper_receipt_bill-256.png','0000-00-00 00:00:00','0000-00-00 00:00:00'),('gidtn','Giấy In Decal Tem Nhãn','Giấy In Decal Tem Nhãn','https://cdn1.iconfinder.com/data/icons/office-322/24/text-paper-printing-printer-print-fax-64.png','0000-00-00 00:00:00','0000-00-00 00:00:00'),('gppm','Giải Pháp Phần Mềm','Giải Pháp Phần Mềm','https://cdn0.iconfinder.com/data/icons/software-engineering-glyph/58/023_OS_Solutions-256.png','0000-00-00 00:00:00','0000-00-00 00:00:00'),('lkpk','Linh Kiện-Phụ Kiện','Linh Kiện-Phụ Kiện','https://cdn4.iconfinder.com/data/icons/tabler-vol-3/24/components-64.png','0000-00-00 00:00:00','0000-00-00 00:00:00'),('mhtg','Màn Hiển Thị Giá','Màn Hiển Thị Giá','https://cdn4.iconfinder.com/data/icons/usa-dollar-finances-whiteover/512/xxx038-256.png','0000-00-00 00:00:00','0000-00-00 00:00:00'),('mihd','Máy In Hóa Đơn','Máy In Hóa Đơn','https://cdn3.iconfinder.com/data/icons/internet-relative/200/Print-64.png','0000-00-00 00:00:00','0000-00-00 00:00:00'),('mimv','Máy In Mã Vạch','Máy In Mã Vạch','https://cdn3.iconfinder.com/data/icons/e-commerce-simple-ui-elements/100/TWalsh__print_barcode2-64.png','0000-00-00 00:00:00','0000-00-00 00:00:00'),('mpbh','Máy POST Bán Hàng','Máy POST Bán Hàng','https://cdn2.iconfinder.com/data/icons/sale-and-discount/32/Sale_and_Discount-05-512.png','0000-00-00 00:00:00','0000-00-00 00:00:00'),('mqmv','Máy Quyét Mã Vạch','Máy Quyét Mã Vạch','https://cdn2.iconfinder.com/data/icons/black-friday-outline-2/48/Black_Friday_Line_Artboard_32-256.png','0000-00-00 00:00:00','0000-00-00 00:00:00'),('mucin','Mực In Mã Vạch','Mực In Mã Vạch','https://cdn0.iconfinder.com/data/icons/printing-house/35/8-256.png','0000-00-00 00:00:00','0000-00-00 00:00:00'),('nktn','Ngăn Kéo Thu Ngân','Ngăn Kéo Thu Ngân','https://cdn2.iconfinder.com/data/icons/money-business-communication/48/25-256.png','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

--
-- Table structure for table `customeradmins`
--

DROP TABLE IF EXISTS `customeradmins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customeradmins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) DEFAULT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_id` (`admin_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `CustomerAdmins_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  CONSTRAINT `CustomerAdmins_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customeradmins`
--

/*!40000 ALTER TABLE `customeradmins` DISABLE KEYS */;
/*!40000 ALTER TABLE `customeradmins` ENABLE KEYS */;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `refresh_token` varchar(255) DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone_number` (`phone_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES ('4984166942559390206','Vỹ','84325598374','eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhcHBfaWQiOiIzNTQyODIzMzc4MDk1OTYxNjQxIiwidXNlcl9pZCI6IjQ5ODQxNjY5NDI1NTkzOTAyMDYiLCJpc0FkbWluIjp0cnVlLCJ0eXBlIjoicmVmcmVzaCIsImlhdCI6MTczMDcxMDAwOSwiZXhwIjoxNzMwNzk2NDA5fQ.eJWNzmMnb56Wg8Asrs7SGAFerHVe4xnLHMRscS2LyHM','2024-10-01 01:34:59','2024-11-04 08:46:49'),('613926922415046293','','84378966102','eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhcHBfaWQiOiIxNzc2ODY4MjE0Mjk2NjUyNjg3IiwidXNlcl9pZCI6IjYxMzkyNjkyMjQxNTA0NjI5MyIsImlzQWRtaW4iOnRydWUsInR5cGUiOiJyZWZyZXNoIiwiaWF0IjoxNzMyNjc2NDM4LCJleHAiOjE3MzI3NjI4Mzh9.clyMl2rAWmXPTSa_xlSYsOPykweWl6rY-thtZtMtQiU','2024-11-23 03:25:20','2024-11-27 03:00:38');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;

--
-- Table structure for table `discountconditions`
--

DROP TABLE IF EXISTS `discountconditions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discountconditions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `discount_id` int(11) NOT NULL,
  `conditionType` varchar(255) NOT NULL,
  `value` double NOT NULL,
  `description` text DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `discount_id` (`discount_id`),
  CONSTRAINT `DiscountConditions_ibfk_1` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `discountconditions`
--

/*!40000 ALTER TABLE `discountconditions` DISABLE KEYS */;
/*!40000 ALTER TABLE `discountconditions` ENABLE KEYS */;

--
-- Table structure for table `discounts`
--

DROP TABLE IF EXISTS `discounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `type` enum('percent','value') NOT NULL,
  `value` double NOT NULL,
  `description` text DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `discounts`
--

/*!40000 ALTER TABLE `discounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `discounts` ENABLE KEYS */;

--
-- Table structure for table `feedbacks`
--

DROP TABLE IF EXISTS `feedbacks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feedbacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_type` enum('Thái Độ','Sản Phẩm','Giá Cả','Khác') NOT NULL,
  `rating` enum('Quá tệ','Chưa tốt','Bình thường','Ổn','Quá tuyệt vời') NOT NULL,
  `comment` text NOT NULL,
  `customer_id` varchar(255) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedbacks`
--

/*!40000 ALTER TABLE `feedbacks` DISABLE KEYS */;
INSERT INTO `feedbacks` VALUES (1,'Thái Độ','Quá tuyệt vời','hấp dẫn kkk','608012972346918065','2024-09-20 04:27:17','2024-09-20 04:27:17'),(2,'Thái Độ','Quá tuyệt vời','hấp dẫn kkk','608012972346918065','2024-09-20 04:27:18','2024-09-20 04:27:18');
/*!40000 ALTER TABLE `feedbacks` ENABLE KEYS */;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `author` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (1,'<p>Máy in bill, hay máy in hóa đơn, là thiết bị quan trọng trong nhiều ngành kinh doanh, từ quán cà phê, quán ăn đến cửa hàng bán lẻ và cả các shop bán hàng online. Thiết bị này giúp in hóa đơn nhanh chóng, chính xác, mang lại sự tiện lợi cho cả nhân viên và khách hàng, đồng thời tăng tính chuyên nghiệp cho cửa hàng.</p>  <p>Phân phối máy in bill</p>  <p>1. Máy in bill là gì?</p> <p>Máy in bill là thiết bị không thể thiếu trong các hoạt động kinh doanh hiện đại. Đây là công cụ hỗ trợ in ra hóa đơn nhanh chóng, giúp doanh nghiệp tiết kiệm thời gian và nâng cao tính chuyên nghiệp.</p>  <p>Máy in sử dụng công nghệ in nhiệt hoặc in kim để tạo ra hóa đơn cho khách hàng. Với thiết kế nhỏ gọn và tiện lợi, máy in hóa đơn phù hợp cho nhiều loại hình kinh doanh từ quán cà phê đến cửa hàng bán lẻ.</p>  <p>2. Tác dụng của máy in hóa đơn</p> <p>Máy in hóa đơn mang lại rất nhiều lợi ích trong việc quản lý bán hàng và chăm sóc khách hàng. Nó không chỉ giúp lưu trữ thông tin giao dịch mà còn tạo sự tin tưởng và chuyên nghiệp.</p>  <p>2.1. In bill cầm tay cho quán cà phê</p> <p>Máy in bill cầm tay rất tiện lợi cho quán cà phê vì khả năng di động cao. Nhân viên có thể in hóa đơn trực tiếp cho khách tại bàn, tạo trải nghiệm tiện ích và tiết kiệm thời gian.</p>  <p>Máy in hóa đơn cầm tay giúp quản lý đơn hàng hiệu quả hơn, đặc biệt là trong các quán cà phê đông khách. Điều này giúp giảm tải cho quầy thu ngân và tăng cường hiệu suất làm việc.</p>  <p>2.2. Máy tính tiền in bill cho quán ăn</p> <p>Quán ăn thường có nhiều khách hàng và số lượng đơn hàng lớn trong giờ cao điểm. Máy in hóa đơn cầm tay giúp quán ăn xử lý đơn hàng nhanh chóng và chính xác.</p>  <p>Máy in hóa đơn cho quán ăn còn giúp kiểm soát doanh thu dễ dàng, giảm thiểu nhầm lẫn trong tính toán và tránh thất thoát tài chính.</p>  <p>2.3. Máy in hóa đơn cầm tay cho cửa hàng bán lẻ</p> <p>Cửa hàng bán lẻ có nhu cầu cao về in hóa đơn để khách hàng dễ dàng kiểm tra chi tiết giao dịch. Máy in bill cầm tay là giải pháp lý tưởng để đáp ứng nhu cầu này.</p>  <p>Ngoài ra, in bill cầm tay giúp cửa hàng tăng tính chuyên nghiệp và xây dựng niềm tin với khách hàng thông qua việc cung cấp hóa đơn chi tiết.</p>  <p>2.4. In bill bán hàng online</p> <p>Trong bối cảnh mua sắm trực tuyến phát triển mạnh mẽ. Máy in bill giúp in hóa đơn cho đơn hàng online dễ dàng và tiện lợi. Điều này giúp các shop online theo dõi đơn hàng và lưu trữ thông tin giao dịch.</p>  <p>Máy tính tiền in bill còn giúp người bán dễ dàng phân loại các đơn hàng. Ngoài ra có thể quản lý kho hàng và tối ưu hóa quy trình xử lý đơn hàng.</p>  <p>3. Đơn vị cung cấp máy in hóa đơn cầm tay</p>  <p>3.1. Về VinaBill Việt Nam</p> <p>VinaBill là đơn vị uy tín cung cấp các loại máy tính tiền in bill chất lượng cao tại Việt Nam. Chúng tôi cam kết mang đến cho khách hàng những sản phẩm in bill cầm tay hiệu quả và bền bỉ.</p>  <p>VinaBill sở hữu nhiều dòng máy in hóa đơn đa dạng. Phù hợp với mọi nhu cầu sử dụng của doanh nghiệp lớn nhỏ.</p>  <p>3.2. Chương trình của chúng tôi</p> <p>VinaBill Việt Nam cung cấp nhiều chương trình khuyến mãi và dịch vụ hậu mãi chuyên nghiệp. Chúng tôi luôn đồng hành cùng doanh nghiệp để phát triển kinh doanh thành công.</p>  <p>Các chương trình hỗ trợ bao gồm tư vấn miễn phí, bảo hành dài hạn và dịch vụ sửa chữa nhanh chóng.</p>  <p>3.3. Thông tin liên lạc</p> <p>Quý khách có thể liên hệ VinaBill Việt Nam qua số điện thoại 0916.84.7711 hoặc truy cập website vinabill.vn để được tư vấn thêm về sản phẩm máy tính tiền in bill.</p>  <p>Đội ngũ tư vấn chuyên nghiệp của VinaBill luôn sẵn sàng hỗ trợ mọi thắc mắc và nhu cầu của khách hàng.</p>  <p>Xem thêm: Máy in bill Đà Nẵng: Giải pháp hoàn hảo cho doanh nghiệp của bạn.</p>  <p>4. Kết luận</p> <p>Máy in bill là thiết bị quan trọng cho bất kỳ doanh nghiệp nào muốn nâng cao trải nghiệm khách hàng và quản lý bán hàng hiệu quả. Dù là quán cà phê, quán ăn hay cửa hàng bán lẻ, máy in hóa đơn cầm tay đều mang lại lợi ích thiết thực.</p>  <p>Nếu bạn đang tìm kiếm một máy in bill đáng tin cậy và chất lượng, hãy liên hệ với VinaBill để nhận tư vấn và ưu đãi đặc biệt. Chúng tôi cam kết mang lại giải pháp tốt nhất cho doanh nghiệp của bạn.</p>','2024-11-17 10:46:34','2024-11-23 04:04:47','http://vinabill.vn/wp-content/uploads/2024/11/may-in-bill.jpg','Máy in bill giúp tối ưu thời gian thanh toán','VINAR BILL'),(2,'<p><strong>Nên mua máy in hóa đơn tại CÔNG TY CỔ PHẦN VINA BILL VIỆT NAM ?</strong></p>  <p>1. CÔNG TY CỔ PHẦN VINA BILL VIỆT NAM với gần 11 năm tiên phong trong lĩnh vực nghiên cứu sản phẩm và cung cấp các sản phẩm máy in hóa đơn hay gọi là máy in bill tính tiền tại thị trường Việt Nam.</p>  <p>2. Khi mua bất kỳ các sản phẩm máy in bill nào từ chúng tôi, chúng tôi luôn cam kết hàng Chính Hãng chất lượng, sản phẩm được kiểm tra kỹ càng trước khi được giao đến cho người sử dụng.</p>  <p>3. Chúng tôi với đội ngũ nhân viên TRẺ – NĂNG ĐỘNG – NHIỆT TÌNH sẽ tư vấn cho doanh nghiệp bạn dòng máy in bill phù hợp nhất với nhu cầu sử dụng, tránh lãng phí cũng như mua phải những sản phẩm không đạt đúng nhu cầu sử dụng.</p>  <p>4. Chúng tôi là nhà phân phối các dòng máy in nhiệt nên giá mua tại chúng tôi luôn luôn TỐT NHẤT, Chính sách hỗ trợ giá khi mua số lượng và cho nhân viên thu mua siêu ưu đãi.</p>  <p>5. Chúng tôi cung cấp rất nhiều sản phẩm và có những sản phẩm được chúng tôi hỗ trợ bảo hành 1 đổi 1 siêu hấp dẫn.</p>  <p>……………………………………………………………</p>  <p><strong>CÔNG TY CỔ PHẦN VINA BILL VIỆT NAM.</strong></p> <p>Address: 49 ĐOÀN NHỮ HÀI, Q. THANH KHÊ, TP. ĐÀ NẴNG.</p> <p>KHO HÀNG: 1255/42 CMT8, P. PHÚ THỌ, TP. TDM, TỈNH BÌNH DƯƠNG.</p> <p>♻ HOTLINE/ZALO: 0916.84.7711. WEB: vinabillvietnam.com – facebook/tongkhogiayin</p>  <p>……………………………………………………………. </p>','2024-11-17 10:48:19','2024-11-23 04:05:19','https://www.vinabillvietnam.com/wp-content/uploads/2024/06/may-in-hoa-don-vinabill-3-350x350.jpeg','Cách chọn máy in bill','VINAR BILL');
/*!40000 ALTER TABLE `news` ENABLE KEYS */;

--
-- Table structure for table `orderdiscounts`
--

DROP TABLE IF EXISTS `orderdiscounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orderdiscounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(255) NOT NULL,
  `discount_id` int(11) NOT NULL,
  `applied_at` datetime NOT NULL,
  `discount_amount` double NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `discount_id` (`discount_id`),
  CONSTRAINT `OrderDiscounts_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `OrderDiscounts_ibfk_2` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orderdiscounts`
--

/*!40000 ALTER TABLE `orderdiscounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `orderdiscounts` ENABLE KEYS */;

--
-- Table structure for table `orderproducts`
--

DROP TABLE IF EXISTS `orderproducts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orderproducts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `order_id` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`options`)),
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `OrderProducts_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `OrderProducts_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orderproducts`
--

/*!40000 ALTER TABLE `orderproducts` DISABLE KEYS */;
INSERT INTO `orderproducts` VALUES (81,610,'63304477596781002529587535_1732524592948',1,5900000,'{}','2024-11-25 08:50:00','2024-11-25 08:50:00'),(82,612,'63304477596781002529587535_1732524592948',1,13900000,'{}','2024-11-25 08:50:00','2024-11-25 08:50:00'),(83,608,'63304477596781002529587535_1732676438389',1,13900000,'{}','2024-11-27 03:00:44','2024-11-27 03:00:44'),(84,647,'63304477596781002529587535_1732676438389',1,900000,'{}','2024-11-27 03:00:44','2024-11-27 03:00:44');
/*!40000 ALTER TABLE `orderproducts` ENABLE KEYS */;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` varchar(255) NOT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `shipping_address` text DEFAULT NULL,
  `shipping_fee` double NOT NULL,
  `total_amount` double DEFAULT NULL,
  `order_date` datetime NOT NULL,
  `note` text DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `Orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES ('566576860165010023168774549_1730709348818','4984166942559390206','Fd, Quảng Long, Hải Hà, Quảng Ninh',0,281000,'2024-11-04 08:35:56','','2024-11-04 08:35:56','2024-11-04 08:35:56'),('566576860165010023168774549_1730709712998','4984166942559390206','Fd, Quảng Long, Hải Hà, Quảng Ninh',0,97000,'2024-11-04 08:42:01','','2024-11-04 08:42:01','2024-11-04 08:42:01'),('63304477596781002529587535_1732524592948','613926922415046293','uuuu, Lộc Yên, Cao Lộc, Lạng Sơn',0,19800000,'2024-11-25 08:50:00','','2024-11-25 08:50:00','2024-11-25 08:50:00'),('63304477596781002529587535_1732676438389','613926922415046293','aa, Tân An, Nghĩa Lộ, Yên Bái',0,14800000,'2024-11-27 03:00:44','','2024-11-27 03:00:44','2024-11-27 03:00:44');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `amount` double NOT NULL,
  `description` text DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `Payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (49,'566576860165010023168774549_1730709348818','COD_SANDBOX','SUCCESS',281000,NULL,'2024-11-04 08:40:14','2024-11-04 08:40:14'),(50,'566576860165010023168774549_1730709712998','COD_SANDBOX','SUCCESS',97000,NULL,'2024-11-04 08:42:57','2024-11-04 08:42:57'),(51,'63304477596781002529587535_1732524592948','COD_SANDBOX','PENDING',19800000,'','2024-11-25 08:50:01','2024-11-25 08:50:01'),(52,'63304477596781002529587535_1732676438389','COD_SANDBOX','PENDING',14800000,'','2024-11-27 03:00:45','2024-11-27 03:00:45');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;

--
-- Table structure for table `productcategories`
--

DROP TABLE IF EXISTS `productcategories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productcategories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `category_id` varchar(255) DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `ProductCategories_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ProductCategories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=752 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productcategories`
--

/*!40000 ALTER TABLE `productcategories` DISABLE KEYS */;
INSERT INTO `productcategories` VALUES (700,603,'gib','0000-00-00 00:00:00','0000-00-00 00:00:00'),(701,604,'gib','0000-00-00 00:00:00','0000-00-00 00:00:00'),(702,605,'gib','0000-00-00 00:00:00','0000-00-00 00:00:00'),(703,606,'gib','0000-00-00 00:00:00','0000-00-00 00:00:00'),(704,607,'gib','0000-00-00 00:00:00','0000-00-00 00:00:00'),(705,608,'btbbh','0000-00-00 00:00:00','0000-00-00 00:00:00'),(706,609,'btbbh','0000-00-00 00:00:00','0000-00-00 00:00:00'),(707,610,'btbbh','0000-00-00 00:00:00','0000-00-00 00:00:00'),(708,611,'btbbh','0000-00-00 00:00:00','0000-00-00 00:00:00'),(709,612,'btbbh','0000-00-00 00:00:00','0000-00-00 00:00:00'),(710,613,'gidtn','0000-00-00 00:00:00','0000-00-00 00:00:00'),(711,614,'gidtn','0000-00-00 00:00:00','0000-00-00 00:00:00'),(712,615,'gidtn','0000-00-00 00:00:00','0000-00-00 00:00:00'),(713,616,'gidtn','0000-00-00 00:00:00','0000-00-00 00:00:00'),(714,617,'gidtn','0000-00-00 00:00:00','0000-00-00 00:00:00'),(715,618,'gidtn','0000-00-00 00:00:00','0000-00-00 00:00:00'),(716,619,'gidtn','0000-00-00 00:00:00','0000-00-00 00:00:00'),(717,620,'gidtn','0000-00-00 00:00:00','0000-00-00 00:00:00'),(718,621,'gidtn','0000-00-00 00:00:00','0000-00-00 00:00:00'),(719,622,'gidtn','0000-00-00 00:00:00','0000-00-00 00:00:00'),(720,623,'gidtn','0000-00-00 00:00:00','0000-00-00 00:00:00'),(721,624,'gidtn','0000-00-00 00:00:00','0000-00-00 00:00:00'),(722,625,'gidtn','0000-00-00 00:00:00','0000-00-00 00:00:00'),(723,626,'gidtn','0000-00-00 00:00:00','0000-00-00 00:00:00'),(724,627,'gidtn','0000-00-00 00:00:00','0000-00-00 00:00:00'),(725,628,'gidtn','0000-00-00 00:00:00','0000-00-00 00:00:00'),(726,629,'gidtn','0000-00-00 00:00:00','0000-00-00 00:00:00'),(727,630,'gppm','0000-00-00 00:00:00','0000-00-00 00:00:00'),(728,631,'gppm','0000-00-00 00:00:00','0000-00-00 00:00:00'),(729,632,'gppm','0000-00-00 00:00:00','0000-00-00 00:00:00'),(730,633,'gppm','0000-00-00 00:00:00','0000-00-00 00:00:00'),(731,634,'gppm','0000-00-00 00:00:00','0000-00-00 00:00:00'),(732,635,'lkpk','0000-00-00 00:00:00','0000-00-00 00:00:00'),(733,636,'lkpk','0000-00-00 00:00:00','0000-00-00 00:00:00'),(734,637,'lkpk','0000-00-00 00:00:00','0000-00-00 00:00:00'),(735,638,'lkpk','0000-00-00 00:00:00','0000-00-00 00:00:00'),(736,639,'lkpk','0000-00-00 00:00:00','0000-00-00 00:00:00'),(737,640,'mihd','0000-00-00 00:00:00','0000-00-00 00:00:00'),(738,641,'mihd','0000-00-00 00:00:00','0000-00-00 00:00:00'),(739,642,'mihd','0000-00-00 00:00:00','0000-00-00 00:00:00'),(740,643,'mihd','0000-00-00 00:00:00','0000-00-00 00:00:00'),(741,644,'mihd','0000-00-00 00:00:00','0000-00-00 00:00:00'),(742,645,'mihd','0000-00-00 00:00:00','0000-00-00 00:00:00'),(743,646,'mihd','0000-00-00 00:00:00','0000-00-00 00:00:00'),(744,647,'mihd','0000-00-00 00:00:00','0000-00-00 00:00:00'),(745,648,'mihd','0000-00-00 00:00:00','0000-00-00 00:00:00'),(746,649,'mimv','0000-00-00 00:00:00','0000-00-00 00:00:00'),(747,650,'mimv','0000-00-00 00:00:00','0000-00-00 00:00:00'),(748,651,'mimv','0000-00-00 00:00:00','0000-00-00 00:00:00'),(749,652,'nktn','0000-00-00 00:00:00','0000-00-00 00:00:00'),(750,653,'gib','2024-11-27 03:02:07','2024-11-27 03:02:07'),(751,653,'lkpk','2024-11-27 03:02:07','2024-11-27 03:02:07');
/*!40000 ALTER TABLE `productcategories` ENABLE KEYS */;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(2000) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  `isFeatured` tinyint(1) DEFAULT 0,
  `sale` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=654 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (603,'Gi ấy in bill 57*38','Thông tin sản phẩm:',-1,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/Logo-Vinabill.png',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,-1),(604,'Giấy in bill 57*45','Thông tin sản phẩm:',-1,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/Logo-Vinabill.png',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,-1),(605,'Giấy in bill 80*65','Thông tin sản phẩm:',-1,'https://www.vinabillvietnam.com/wp-content/uploads/2024/11/2024-11-14_22-47-45.png',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,-1),(606,'Giấy in bill 80*45','Thông tin sản phẩm:',3600,'https://www.vinabillvietnam.com/wp-content/uploads/2024/11/2024-11-09_10-44-32-2.png',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,4000),(607,'Giấy In Bill 80*80','Thông tin sản phẩm:\n<br>\nGiấy In Bill 80*80 Đường kính: 80 Chiều cao: 80 Nguyên Liệu: Nhập Khẩu Giấy được bọc bạc, dán tem hai đầu, chống ẩm',14000,'https://www.vinabillvietnam.com/wp-content/uploads/2024/11/2024-11-15_22-51-23.png',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,15000),(608,'TRỌN BỘ THIẾT BỊ BÁN HÀNG: MÁY BÁN HÀNG-MÁY IN HÓA ĐƠN-MÁY IN BÁO BẾP-PHẦN MỀM BÁN HÀNG-NGĂN KÉO ĐỰNG TIỀN-GIẤY IN HÓA ĐƠN Copy','Thông tin sản phẩm:\n<br>\n- Combo thiết bị cho mô hình Nhà hàng-Khách Sạn-Coffe-Bar-karaoke. - Giá siêu tốt. - Sản phẩm bảo hành 12 tháng, 1 đổi 1 trong tháng đầu. - Kỹ thuật viên lắp đặt và hướng dẫn tận tình. - Giao hàng và lắp đặt tận nơi.',13900000,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/Bo-thiet-bi-ban-hang-vinabill-1-1024x768.jpeg',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,14500000),(609,'TRỌN BỘ THIẾT BỊ BÁN HÀNG: MÁY IN HÓA ĐƠN-MÁY IN TEM NHÃN-MÁY QUÉT MÃ VẠCH-PHẦN MỀM BÁN HÀNG-GIẤY IN HÓA ĐƠN Copy','Thông tin sản phẩm:\n<br>\nCombo thiết bị cho mô hình shop – thời trang – tạp hóa – siêu thị mini Nhiều khuyến mãi hấp dẫn Giá siêu tốt Sản phẩm bảo hành 12 tháng, 1 đổi 1 trong tháng đầu Kỹ thuật viên lắp đặt và hướng dẫn tận tình Giao hàng và lắp đặt tận nơi.',5900000,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/Bo-thiet-bi-ban-hang-vinabill-3.jpeg',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,6800000),(610,'TRỌN BỘ THIẾT BỊ BÁN HÀNG: MÁY IN HÓA ĐƠN-MÁY IN TEM NHÃN-MÁY QUÉT MÃ VẠCH-PHẦN MỀM BÁN HÀNG-GIẤY IN HÓA ĐƠN','Thông tin sản phẩm:\n<br>\nCombo thiết bị cho mô hình shop – thời trang – tạp hóa – siêu thị mini Nhiều khuyến mãi hấp dẫn Giá siêu tốt Sản phẩm bảo hành 12 tháng, 1 đổi 1 trong tháng đầu Kỹ thuật viên lắp đặt và hướng dẫn tận tình Giao hàng và lắp đặt tận nơi.',5900000,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/Bo-thiet-bi-ban-hang-vinabill-3.jpeg',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,6800000),(611,'TRỌN BỘ THIẾT BỊ BÁN HÀNG: MÁY BÁN HÀNG-PHẦN MỀM BÁN HÀNG-MÁY IN HÓA ĐƠN-NGĂN KÉO ĐỰNG TIỀN-GIẤY IN HÓA ĐƠN','Thông tin sản phẩm:\n<br>\nCombo thiết bị cho mô hình Nhà hàng-Khách Sạn-Coffe-Bar-karaoke. Giá siêu tốt Sản phẩm bảo hành 12 tháng, 1 đổi 1 trong tháng đầu Kỹ thuật viên lắp đặt và hướng dẫn tận tình Giao hàng và lắp đặt tận nơi.',9900000,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/Bo-thiet-bi-ban-hang-vinabill-2.jpeg',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,10500000),(612,'TRỌN BỘ THIẾT BỊ BÁN HÀNG: MÁY BÁN HÀNG-MÁY IN HÓA ĐƠN-MÁY IN BÁO BẾP-PHẦN MỀM BÁN HÀNG-NGĂN KÉO ĐỰNG TIỀN-GIẤY IN HÓA ĐƠN','Thông tin sản phẩm:\n<br>\n- Combo thiết bị cho mô hình Nhà hàng-Khách Sạn-Coffe-Bar-karaoke. - Giá siêu tốt. - Sản phẩm bảo hành 12 tháng, 1 đổi 1 trong tháng đầu. - Kỹ thuật viên lắp đặt và hướng dẫn tận tình. - Giao hàng và lắp đặt tận nơi.',13900000,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/Bo-thiet-bi-ban-hang-vinabill-1-1024x768.jpeg',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,14500000),(613,'Decal thường 3 tem 35*22 (50m)','Thông tin sản phẩm:',-1,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/Logo-Vinabill.png',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,-1),(614,'Decal nhiệt 3 tem 35*22 (50m)','Thông tin sản phẩm:',-1,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/Logo-Vinabill.png',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,-1),(615,'Decal nhiệt tem A6 100*150 (500c)\nTệp A6','Thông tin sản phẩm:',-1,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/Logo-Vinabill.png',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,-1),(616,'Decal nhiệt tem A6 100*150 (50m)','Thông tin sản phẩm:',-1,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/Logo-Vinabill.png',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,-1),(617,'Decal nhiệt tem 76 liên tục (m)','Thông tin sản phẩm:',-1,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/Logo-Vinabill.png',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,-1),(618,'Decal nhiệt tem A7 75*100 (m)','Thông tin sản phẩm:',-1,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/Logo-Vinabill.png',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,-1),(619,'Decal nhiệt tem 58*40 ( m )\nTem Cân','Thông tin sản phẩm:',-1,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/Logo-Vinabill.png',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,-1),(620,'Decal nhiệt tem 50*30 (30m)','Thông tin sản phẩm:',-1,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/Logo-Vinabill.png',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,-1),(621,'Decal nhiệt tem 50*30 (25m)','Thông tin sản phẩm:',-1,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/Logo-Vinabill.png',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,-1),(622,'Decal nhiệt tem 40*30 ( )','Thông tin sản phẩm:',-1,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/Logo-Vinabill.png',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,-1),(623,'Decal nhiệt 2 tem 35*22 (30m)','Thông tin sản phẩm:',-1,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/Logo-Vinabill.png',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,-1),(624,'Decal nhiệt 2 tem 35*22 (25m)','Thông tin sản phẩm:',-1,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/Logo-Vinabill.png',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,-1),(625,'DECAL BẠC – DECAL PVC Copy','Thông tin sản phẩm:\n\nNhận làm Kích cỡ theo yêu cầu. Thông tin sản phẩm chính xác. Bảo vệ thương hiệu và hình ảnh công ty quý khách.',-1,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/decal-tem-nhan-vinabill-1.jpeg',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,-1),(626,'DECAL 35X22X50M – 3 CON TEM /HÀNG Copy','Thông tin sản phẩm:\n\nKích thước nhãn 35×22 mm. Giấy Fasson. Khổ giấy 110 mm, Dài 50 m. 3 con ngang bo góc. Số lượng càng nhiều giá càng rẻ. Giao hàng nhanh chóng ,tận nơi. (Hàng chất lượng, giá rẻ lúc nào cũng có sẵn hàng).',65000,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/decal-tem-nhan-vinabill-3-1024x768.jpeg',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,70000),(627,'DECAL 35X22X50M – 3 CON TEM /HÀNG','Thông tin sản phẩm:\n\nKích thước nhãn 35×22 mm. Giấy Fasson. Khổ giấy 110 mm, Dài 50 m. 3 con ngang bo góc. Số lượng càng nhiều giá càng rẻ. Giao hàng nhanh chóng ,tận nơi. (Hàng chất lượng, giá rẻ lúc nào cũng có sẵn hàng).',65000,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/decal-tem-nhan-vinabill-3-1024x768.jpeg',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,70000),(628,'GIẤY DECAL THƯỜNG – IN MÀU GIÁ LIÊN HỆ','Thông tin sản phẩm:\n\nNhận làm Kích cỡ theo yêu cầu. Thông tin sản phẩm chính xác. Bảo vệ thương hiệu và hình ảnh công ty quý khách.',-1,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/decal-tem-nhan-vinabill-2.jpeg',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,-1),(629,'DECAL BẠC – DECAL PVC','Thông tin sản phẩm:  Nhận làm Kích cỡ theo yêu cầu. Thông tin sản phẩm chính xác. Bảo vệ thương hiệu và hình ảnh công ty quý khách.',-1,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/decal-tem-nhan-vinabill-1.jpeg',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,-1),(630,'PHẦN MỀM QUẢN LÍ NHÀ THUỐC Copy','Thông tin sản phẩm:',1590000,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/Bo-thiet-bi-ban-hang-vinabill-1-1024x768.jpeg',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,1990000),(631,'GIỚI THIỆU VỀ PHẦN MỀM SHOP, SIÊU THỊ Copy','Thông tin sản phẩm:',1590000,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/Bo-thiet-bi-ban-hang-vinabill-1-1024x768.jpeg',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,1990000),(632,'GIỚI THIỆU VỀ PHẦN MỀM SHOP, SIÊU THỊ','Thông tin sản phẩm:',1590000,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/Bo-thiet-bi-ban-hang-vinabill-1-1024x768.jpeg',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,1990000),(633,'PHẦN MỀM QUẢN LÍ NHÀ THUỐC','Thông tin sản phẩm:',1590000,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/Bo-thiet-bi-ban-hang-vinabill-1-1024x768.jpeg',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,1990000),(634,'PHẦN MỀM QUẢN LÝ CỬA HÀNG','Thông tin sản phẩm:',1590000,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/Bo-thiet-bi-ban-hang-vinabill-1-1024x768.jpeg',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,1990000),(635,'ADAPTER MÁY POS 12V-5A Copy','Thông tin sản phẩm:',330000,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/Linh-kien-phu-kien-vinabill-2-1024x768.jpeg',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,350000),(636,'CHÂN ĐẾ MÁY QUÉT MÃ VẠCH HONEYWELL 1300G Copy','Thông tin sản phẩm:  Chân đế Máy Quét mã vạch Honeywell 1300G. Chất liệu nhựa, cứng cáp. Điều chỉnh được góc độ. Nhiều ưu đãi khi mua hàng.. Giao hàng tận nơi.',250000,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/Linh-kien-phu-kien-vinabill-3.jpeg',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,280000),(637,'CHÂN ĐẾ MÁY QUÉT MÃ VẠCH HONEYWELL 1300G Copy','Thông tin sản phẩm:\n\nChân đế Máy Quét mã vạch Honeywell 1300G. Chất liệu nhựa, cứng cáp. Điều chỉnh được góc độ. Nhiều ưu đãi khi mua hàng.. Giao hàng tận nơi.',250000,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/Linh-kien-phu-kien-vinabill-3.jpeg',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,280000),(638,'ADAPTER MÁY POS 12V-5A','Thông tin sản phẩm:',330000,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/Linh-kien-phu-kien-vinabill-2-1024x768.jpeg',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,350000),(639,'ADAPTER MÁY IN HÓA ĐƠN XPRINTER,ZYZWELL','Thông tin sản phẩm:',310000,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/Linh-kien-phu-kien-vinabill-1.jpeg',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,350000),(640,'Máy in bill Xprinter K200W (USB + WIFI)','Thông tin sản phẩm:\n\nĐặc điểm nổi bật của sản phẩm : Máy in hóa đơn Xprinter K200WF sử dụng phương pháp in: In nhiệt trực tiếp Chiều rộng in: Chiều rộng giấy 72mm Mật độ điểm: 576 điểm / dòng hoặc 512 điểm / dòng Tốc độ in: 200 mm/giây Cổng kết nối: USB + WIFI',-1,'https://www.vinabillvietnam.com/wp-content/uploads/2024/11/2024-11-10_09-40-46.png',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,NULL),(641,'Máy in bill Zywell 908 (USB + WIFI)','Thông tin sản phẩm:',-1,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/Logo-Vinabill.png',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,NULL),(642,'Máy in hóa đơn Zywell Q822 (USB , LAN)','Thông tin sản phẩm:',-1,'https://www.vinabillvietnam.com/wp-content/uploads/2024/11/2024-11-11_23-14-46.png',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,NULL),(643,'Máy in hóa đơn Zywell 303 (USB + LAN)','Thông tin sản phẩm:\n\nMáy in hóa đơn ZY303 đến từ thương hiệu ZYWELL với hiệu năng tốt, chất lượng in đẹp. Độ phân giải của máy là 203dpi. Chất lượng hóa đơn sẽ rõ nét và bay màu chậm. Tốc độ in nhanh 230mm/s. Khổ giấy phổ thông 80mm. Đầu in năng suất cao lên đến 150km khi in. Dao cắt chất lượng tốt khoảng 1,5 triệu lần cắt.',900000,'https://www.vinabillvietnam.com/wp-content/uploads/2024/11/2024-11-10_15-08-30.png',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,1000000),(644,'MÁY IN HÓA ĐƠN DKT-TS085 (USB, WIFI)','Thông tin sản phẩm:\n\nThông số kỹ thuật: Thương hiệu: DKT Model: DKT-TS085 Công nghệ in: in nhiệt trực tiếp Tốc độ in : 160mm/s Dao cắt: cắt tự động Độ bền đầu in: 150km Độ bền dao cắt: 1.500.000 lần cắt Cổng kết nối: USB, Wifi Khổ in: 76mm Giấy in: giấy khổ 80mm, đường kính cuộn tối đa 80mm Phần mềm bán hàng tương thích: Sapo, kiotivet, Pos365, ipos, ocha... Cân nặng: Kích thước: Nguồn điện sử dụng: DC24V - 2.5A Bảo hành 12 tháng.',-1,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/may-in-hoa-don-dkt-ts085-1024x768.jpg',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,NULL),(645,'MÁY IN TEM 365 DEMO Copy','Thông tin sản phẩm:\n\nCombo thiết bị cho mô hình Nhà hàng-Khách Sạn-Coffe-Bar-karaoke. Giá siêu tốt Sản phẩm bảo hành 12 tháng, 1 đổi 1 trong tháng đầu Kỹ thuật viên lắp đặt và hướng dẫn tận tình Giao hàng và lắp đặt tận nơi.',900000,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/may-in-hoa-don-vinabill-1-1024x768.jpeg',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,990000),(646,'MÁY IN HÓA ĐƠN XP-T80U Copy','Thông tin sản phẩm:  Máy in hóa đơn XP-T80U là dòng sản phẩm với chi phí sản xuất siêu tiết kiệm của hãng Xprinter. Sản phẩm được cung cấp với giá cực kỳ hấp dẫn dành cho các chủ quán và cửa hàng . Thiết kế máy với bo mạch chủ tất cả trong một. Hỗ trợ treo tường Hỗ trợ kết nối cổng USB Tốc độ in 230 mm / giây',790000,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/may-in-hoa-don-vinabill-2.jpeg',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,1190000),(647,'MÁY IN TEM 365 DEMO Copy','Thông tin sản phẩm:\n\nCombo thiết bị cho mô hình Nhà hàng-Khách Sạn-Coffe-Bar-karaoke. Giá siêu tốt Sản phẩm bảo hành 12 tháng, 1 đổi 1 trong tháng đầu Kỹ thuật viên lắp đặt và hướng dẫn tận tình Giao hàng và lắp đặt tận nơi.',900000,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/may-in-hoa-don-vinabill-1-1024x768.jpeg',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,990000),(648,'MÁY IN HÓA ĐƠN XP-T80U Copy','Thông tin sản phẩm:\n\nMáy in hóa đơn XP-T80U là dòng sản phẩm với chi phí sản xuất siêu tiết kiệm của hãng Xprinter. Sản phẩm được cung cấp với giá cực kỳ hấp dẫn dành cho các chủ quán và cửa hàng . Thiết kế máy với bo mạch chủ tất cả trong một. Hỗ trợ treo tường Hỗ trợ kết nối cổng USB Tốc độ in 230 mm / giây',790000,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/may-in-hoa-don-vinabill-2.jpeg',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,1900000),(649,'Máy in nhiệt tem nhãn Xprinter 350BM (USB + LAN)\nXprinter 350 (USB , LAN)','Thông tin sản phẩm:',-1,'https://www.vinabillvietnam.com/wp-content/uploads/2024/11/2024-11-12_23-09-04.png',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,NULL),(650,'Máy in nhiệt tem nhãn Xprinter 350B (USB)\nXprinter 350 (USB)','Thông tin sản phẩm:',-1,'https://www.vinabillvietnam.com/wp-content/uploads/2024/11/2024-11-12_23-09-04.png',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,NULL),(651,'Máy in tem nhiệt Xprinter 365B (USB + LAN)','Thông tin sản phẩm:',-1,'https://www.vinabillvietnam.com/wp-content/uploads/2024/06/Logo-Vinabill.png',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,NULL),(652,'Ngăn kéo thu ngân lớn ( 10 ngăn kẹp )','Thông tin sản phẩm:',-1,'https://www.vinabillvietnam.com/wp-content/uploads/2024/11/2024-11-11_23-09-18.png',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,NULL),(653,'aa','kkakak',19000,'https://res.cloudinary.com/dq3pxd9eq/image/upload/v1732676524/T-Coffee-Shop/tcofee_product_1732676523734_IMG_2044.png.png',0,'2024-11-27 03:02:07','2024-11-27 03:02:12',0,20000);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

--
-- Table structure for table `productvariants`
--

DROP TABLE IF EXISTS `productvariants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productvariants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `variant_id` varchar(255) DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `variant_id` (`variant_id`),
  CONSTRAINT `ProductVariants_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ProductVariants_ibfk_2` FOREIGN KEY (`variant_id`) REFERENCES `variants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productvariants`
--

/*!40000 ALTER TABLE `productvariants` DISABLE KEYS */;
/*!40000 ALTER TABLE `productvariants` ENABLE KEYS */;

--
-- Table structure for table `sequelizemeta`
--

DROP TABLE IF EXISTS `sequelizemeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sequelizemeta` (
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`name`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sequelizemeta`
--

/*!40000 ALTER TABLE `sequelizemeta` DISABLE KEYS */;
INSERT INTO `sequelizemeta` VALUES ('20240816100000-create-categories.js'),('20240816100100-create-products.js'),('20240816100200-create-variants.js'),('20240816100250-create-product-variant.js'),('20240816100280-create-variant-option.js'),('20240816100300-create-customers.js'),('20240816100400-create-orders.js'),('20240816100500-create-order-products.js'),('20240816100600-create-product-categories.js'),('20240816100700-create-payment.js'),('20240816100800-create-discounts.js'),('20240816100850-create-discount-conditions.js'),('20240816100900-create-order-discount.js'),('20240816101000-create-admins.js'),('20240816101100-create-customer_admins.js'),('20240917075254-create-feedbacks-table.js'),('20241104142104-create-news.js');
/*!40000 ALTER TABLE `sequelizemeta` ENABLE KEYS */;

--
-- Table structure for table `variantoptions`
--

DROP TABLE IF EXISTS `variantoptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `variantoptions` (
  `id` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `priceChange` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`priceChange`)),
  `variant_id` varchar(255) DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `variant_id` (`variant_id`),
  CONSTRAINT `VariantOptions_ibfk_1` FOREIGN KEY (`variant_id`) REFERENCES `variants` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `variantoptions`
--

/*!40000 ALTER TABLE `variantoptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `variantoptions` ENABLE KEYS */;

--
-- Table structure for table `variants`
--

DROP TABLE IF EXISTS `variants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `variants` (
  `id` varchar(255) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `type` enum('multiple','single') NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `variants`
--

/*!40000 ALTER TABLE `variants` DISABLE KEYS */;
/*!40000 ALTER TABLE `variants` ENABLE KEYS */;

--
-- Dumping routines for database 'vinarbill'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-27 15:29:01
