-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2025 at 03:26 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbcafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menu`
--

CREATE TABLE `tbl_menu` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(200) NOT NULL,
  `harga_menu` decimal(10,2) NOT NULL,
  `jumlah` int(100) NOT NULL,
  `deskripsi` varchar(200) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_menu`
--

INSERT INTO `tbl_menu` (`id_menu`, `nama_menu`, `harga_menu`, `jumlah`, `deskripsi`, `image_url`, `kategori`) VALUES
(1, 'Cinnamon Apple French Toast', '38.00', 8, 'Thick slices of brioche soaked in cinnamon-apple batter, served with maple syrup and fresh apples', 'cinnamonapplefrenchtoast.jpg', 'Breakfast'),
(2, 'Lemon Lavender Shortbread', '35.00', 20, 'Buttery shortbread cookies infused with zesty lemon and calming lavender for a perfect treat', 'lemonlavendershortbreadcookie.jpg', 'pastries'),
(3, 'Tropical Bliss Serenade', '38.00', 40, 'Creamy latte infused with coconut and pineapple', 'tropicalblisslatte.jpg', 'Coffee and Beverages'),
(5, 'Savory Breakfast Tacos', '40.00', 30, 'Corn tortillas filled with scrambled eggs, spicy chorizo, and topped with salsa verde', 'savorybreakfasttacos.jpg', 'Breakfast'),
(6, 'Veggie & Feta Omelette', '35.00', 20, 'Fluffy omelette loaded with seasonal veggies and crumbled feta cheese, served with toast', 'veggie&fetaomelette.jpg', 'Breakfast'),
(7, 'Honey Almond Croissant', '35.00', 35, 'Flaky croissant drizzled with honey and sprinkled with toasted almonds for a delightful crunch', 'honeyalmondcroissant.jpg', 'Pastries'),
(8, 'Choco Hazelnut Pinwheel', '35.00', 15, 'Swirled pastry filled with rich chocolate and crunchy hazelnuts, baked to golden perfection', 'chocohazelnutpinwheel.jpg', 'Pastries'),
(9, 'Moonlit Mystic Mocha', '38.00', 25, 'A rich blend of espresso and dark chocolate topped with whipped cream and a sprinkle of cocoa', 'moonlitmysticmocha.jpg', 'Coffee and Beverages'),
(11, 'Spiced Chai Fusion', '38.00', 15, 'A warm and aromatic blend of chai spices and steamed milk, finished with a hint of vanilla', 'spicedchaifusion.jpg', 'Coffee and Beverages');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(10) NOT NULL,
  `role` enum('user','staf') NOT NULL,
  `foto_profil` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `nama`, `email`, `password`, `role`, `foto_profil`) VALUES
(2, 'Jeno', 'jeno@gmail.com', '3', 'staf', ''),
(3, 'Mark', 'mark@gmail.com', '6', 'user', 'GLXQR00aYAA03li.jpg'),
(4, 'Jisu', 'jisu@gmail.com', '1', 'user', '[240405] Jisoo Bubble Update.jpeg'),
(5, 'Na Jaemin', 'nana@gmail.com', '2', 'user', '🐰.jpeg'),
(6, 'Zayne', 'zayne@gmail.com', '3', 'user', ''),
(7, 'Taeyeon', 'taeyeon@gmail.com', '4', 'staf', '');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(10) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('pending','cancelled','confirmed') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `email`, `product_name`, `quantity`, `total_price`, `created_at`, `status`) VALUES
(4, 4, 'jisu@gmail.com', 'Honey Almond Croissant', 1, '35000.00', '2025-01-07 13:39:52', 'pending'),
(7, 4, 'jisu@gmail.com', 'Savory Breakfast Taco', 1, '40000.00', '2025-01-07 14:06:39', 'pending'),
(8, 4, 'jisu@gmail.com', 'Cloud Nine Croissant Delights', 1, '35000.00', '2025-01-07 14:08:54', 'pending'),
(9, 4, 'jisu@gmail.com', 'Tropical Bliss Latte Serenade', 1, '38000.00', '2025-01-07 14:20:41', 'pending'),
(11, 4, 'jisu@gmail.com', 'Savory Breakfast Taco', 1, '40000.00', '2025-01-07 14:23:00', 'confirmed');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_menu`
--
ALTER TABLE `tbl_menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_menu`
--
ALTER TABLE `tbl_menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
