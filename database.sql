CREATE TABLE `operations` (
  `id` int(11) NOT NULL,
  `ip` varchar(45) NOT NULL,
  `timestamp` int(10) NOT NULL,
  `operation` varchar(500) NOT NULL,
  `result` decimal(12,4) NOT NULL,
  `bonus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `operations`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `operations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;