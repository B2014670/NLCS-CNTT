-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2023 at 05:37 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id_cart` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `unit` varchar(10) NOT NULL DEFAULT 'bó'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id_cart`, `user_id`, `pid`, `quantity`, `unit`) VALUES
(268, 21, 18, 1, 'bó');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `id_user` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `content` varchar(255) NOT NULL,
  `vote` int(255) NOT NULL DEFAULT 5,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `id_user`, `pid`, `content`, `vote`, `time`) VALUES
(5, 24, 16, 'dep', 2, '2023-03-17 06:17:14'),
(8, 21, 13, 'dep', 5, '2023-03-27 07:08:33');

-- --------------------------------------------------------

--
-- Table structure for table `detail_orders`
--

CREATE TABLE `detail_orders` (
  `id_order` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit` varchar(10) NOT NULL,
  `price` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_orders`
--

INSERT INTO `detail_orders` (`id_order`, `pid`, `quantity`, `unit`, `price`) VALUES
(58, 19, 2, 'bó', 150000),
(59, 18, 1, 'bó', 110000),
(72, 13, 1, 'cành', 12000),
(72, 16, 1, 'bó', 130000),
(73, 13, 1, 'cành', 12000),
(73, 16, 2, 'bó', 130000),
(76, 19, 2, 'bó', 150000);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(1, 14, 'shaikh anas', 'shaikh@gmail.com', '0987654321', 'hi, how are you?');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `total_price` int(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `placed_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `payment_status` varchar(20) NOT NULL DEFAULT 'đang xử lý',
  `name_receive` varchar(100) NOT NULL,
  `number_receive` varchar(12) NOT NULL,
  `message_card` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `method`, `placed_on`, `payment_status`, `name_receive`, `number_receive`, `message_card`) VALUES
(58, 21, 300000, 'thanh toán khi giao hàng', '2023-01-29 02:46:25', 'đang xử lý', '', '', ''),
(59, 21, 110000, 'thanh toán khi giao hàng', '2023-02-24 04:43:15', 'đang xử lý', '', '', ''),
(72, 24, 142000, 'thanh toán khi giao hàng', '2023-04-03 13:38:20', 'đang xử lý', '', '', ''),
(73, 24, 272000, 'thanh toán khi giao hàng', '2023-04-03 14:52:24', 'hoàn thành', '', '', ''),
(76, 24, 300000, 'thanh toán khi giao hàng', '2023-04-05 02:42:21', 'đang xử lý', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `id_type` int(11) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` int(100) NOT NULL,
  `giacanh` int(100) NOT NULL,
  `sale_price` int(10) NOT NULL,
  `soluongkho` int(11) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `id_type`, `details`, `price`, `giacanh`, `sale_price`, `soluongkho`, `image`) VALUES
(13, 'Hoa hồng ', 1, 'Ý nghĩa của hoa hồng phấn là lòng biết ơn và sự ngưỡng mộ. Chúng là sự lựa chọn hoàn hảo cho những người bạn đánh giá cao nhất, như bạn bè, anh chị em hoặc giáo viên của bạn. Hoa hồng màu hồng cũng có thể đại diện cho sự nữ tính và sang trọng, khiến chúng trở nên hoàn hảo cho các sự kiện như tiệc đính hôn, vũ hội và tiệc mừng em bé chào đời.', 120000, 12000, 10, 10, 'pink roses.jpg'),
(16, 'Hoa hồng oải hương', 1, ' Màu sắc nhẹ nhàng của hoa oải hương tượng trưng cho tình yêu từ cái nhìn đầu tiên hoặc thậm chí là sự thích thú. Những người đang yêu hoặc ngưỡng mộ đối tác và các thành viên trong gia đình của họ sẽ thấy hoa oải hương là biểu tượng hoàn hảo để thể hiện tình cảm thực sự của họ.', 130000, 0, 0, 10, 'lavendor rose.jpg'),
(17, 'Tulip vàng', 4, 'Hoa tulip vàng bây giờ đại diện cho hạnh phúc, vui vẻ và hy vọng. Người Victoria thậm chí còn tin rằng hoa tulip vàng có nghĩa đen là “Có ánh nắng trong nụ cười của bạn”. Chính vì lý do này mà hoa tulip vàng đã trở thành món quà “chỉ vì” phổ biến, vì chúng chắc chắn sẽ mang lại nụ cười trên khuôn mặt của bất kỳ ai.\r\n', 140000, 0, 0, 10, 'yellow tulipa.jpg'),
(18, 'Tulip đỏ', 4, 'Màu đỏ đậm của chúng gợi lên cảm giác đam mê, tình yêu và ham muốn — khiến chúng trở thành lựa chọn đặc biệt phổ biến cho các cặp đôi mới, trẻ tuổi. Chúng cũng có thể có nghĩa là \"hãy tin tôi\" hoặc \"cảm xúc của tôi là thật.\" Vì vậy, lần tới khi bạn cố gắng tán tỉnh người mà bạn ngưỡng mộ, hãy gửi cho họ một bó hoa tulip đỏ quyến rũ.', 110000, 0, 0, 10, 'red tulipa.jpg'),
(19, 'Hoa hồng leo Nahema Pháp', 1, 'Hoa màu hồng tượng trưng cho sự duyên dáng, dịu dàng và hạnh phúc. Bất kể hình dạng của hoa - từ những nụ nhỏ, chặt chẽ của hoa hồng vườn hồng đến những cánh hoa mỏng manh, mở rộng của hoa mẫu đơn màu hồng đang nở rộ - những bông hoa màu hồng thể hiện tuổi trẻ, sự ngây thơ và niềm vui. Mua hoa màu hồng.', 150000, 0, 0, 1009, 'pink bouquet.jpg'),
(20, 'Hoa hồng phấn nữ hoàng', 1, 'Hoa có mùi thơm rất nồng, mùi nước hoa cổ thụ rất quyến rũ. Tất cả những gì cần thiết là một bó hoa và một vài bông hoa để có một căn phòng thơm.  ', 230000, 23000, 10, 50, 'pink queen rose.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id_type` int(11) NOT NULL,
  `name_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id_type`, `name_type`) VALUES
(1, 'hoa hồng'),
(2, 'hoa huệ'),
(3, 'lavender'),
(4, 'hoa tulip');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` char(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user',
  `avatar` varchar(100) DEFAULT 'avtDefault.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `password`, `user_type`, `avatar`) VALUES
(1, 'admin A', 'admin01@gmail.com', '', '', '698d51a19d8a121ce581499d7b701668', 'admin', 'avtDefault.png'),
(20, 'ad', 'ad@gmail.com', '', '', 'ad', 'admin', 'avtDefault.png'),
(21, 'luan1', 'luan1@gmail.com', '0111111111', 'Mậu Thân, Ninh kiều, Cần Thơ', '1', 'user', 'avtDefault.png'),
(24, 'luan', 'a@gmail.com', '012345678910', '3/2, Ninh kiều, Cần Thơ', '1', 'user', 'avtface.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id_cart`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `detail_orders`
--
ALTER TABLE `detail_orders`
  ADD PRIMARY KEY (`id_order`,`pid`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_id_user` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_id_type` (`id_type`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id_type`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id_cart` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=315;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`pid`) REFERENCES `products` (`id`);

--
-- Constraints for table `detail_orders`
--
ALTER TABLE `detail_orders`
  ADD CONSTRAINT `detail_orders_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FK_id_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
