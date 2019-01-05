CREATE TABLE `tb0101_teams` (
  `tb0101_id` bigint(20) NOT NULL,
  `tb0101_name` varchar(50) NOT NULL DEFAULT '',
  `tb0101_group` char(1) NOT NULL DEFAULT 'A',
  `tb0101_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Команды';

-- --------------------------------------------------------

--
-- Table structure for table `tb0102_matches`
--

CREATE TABLE `tb0102_matches` (
  `tb0102_id` bigint(20) NOT NULL,
  `tb0102_tb0101_id1` bigint(20) NOT NULL DEFAULT '0',
  `tb0102_tb0101_id2` bigint(20) NOT NULL DEFAULT '0',
  `tb0102_score1` int(11) NOT NULL DEFAULT '0',
  `tb0102_score2` int(11) NOT NULL DEFAULT '0',
  `tb0102_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb0103_playoff`
--

CREATE TABLE `tb0103_playoff` (
  `tb0103_id` bigint(20) NOT NULL,
  `tb0103_tb0101_id` bigint(20) NOT NULL DEFAULT '0',
  `tb0103_score` int(11) NOT NULL DEFAULT '0',
  `tb0103_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb0104_playoff`
--

CREATE TABLE `tb0104_playoff` (
  `tb0104_id` bigint(20) NOT NULL,
  `tb0104_tb0101_id1` bigint(20) NOT NULL DEFAULT '0',
  `tb0104_tb0101_id2` bigint(20) NOT NULL DEFAULT '0',
  `tb0104_score1` int(11) NOT NULL DEFAULT '0',
  `tb0104_score2` int(11) NOT NULL DEFAULT '0',
  `tb0104_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb0105_final`
--

CREATE TABLE `tb0105_final` (
  `tb0105_id` bigint(20) NOT NULL,
  `tb0105_tb0101_id1` bigint(20) NOT NULL DEFAULT '0',
  `tb0105_tb0101_id2` bigint(20) NOT NULL DEFAULT '0',
  `tb0105_score1` int(11) NOT NULL DEFAULT '0',
  `tb0105_score2` int(11) NOT NULL DEFAULT '0',
  `tb0105_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb0101_teams`
--
ALTER TABLE `tb0101_teams`
  ADD PRIMARY KEY (`tb0101_id`),
  ADD KEY `tb0101_group` (`tb0101_group`),
  ADD KEY `tb0101_created` (`tb0101_created`),
  ADD KEY `tb0101_name` (`tb0101_name`) USING BTREE;

--
-- Indexes for table `tb0102_matches`
--
ALTER TABLE `tb0102_matches`
  ADD PRIMARY KEY (`tb0102_id`),
  ADD KEY `tb0102_tb0101_id1` (`tb0102_tb0101_id1`),
  ADD KEY `tb0102_tb0101_id2` (`tb0102_tb0101_id2`),
  ADD KEY `tb0102_score2` (`tb0102_score2`),
  ADD KEY `tb0102_score1` (`tb0102_score1`),
  ADD KEY `tb0102_created` (`tb0102_created`);

--
-- Indexes for table `tb0103_playoff`
--
ALTER TABLE `tb0103_playoff`
  ADD PRIMARY KEY (`tb0103_id`),
  ADD KEY `tb0102_tb0101_id1` (`tb0103_tb0101_id`),
  ADD KEY `tb0102_score1` (`tb0103_score`),
  ADD KEY `tb0102_created` (`tb0103_created`);

--
-- Indexes for table `tb0104_playoff`
--
ALTER TABLE `tb0104_playoff`
  ADD PRIMARY KEY (`tb0104_id`),
  ADD KEY `tb0102_tb0101_id1` (`tb0104_tb0101_id1`),
  ADD KEY `tb0102_tb0101_id2` (`tb0104_tb0101_id2`),
  ADD KEY `tb0102_score2` (`tb0104_score2`),
  ADD KEY `tb0102_score1` (`tb0104_score1`),
  ADD KEY `tb0102_created` (`tb0104_created`);

--
-- Indexes for table `tb0105_final`
--
ALTER TABLE `tb0105_final`
  ADD PRIMARY KEY (`tb0105_id`),
  ADD KEY `tb0102_tb0101_id1` (`tb0105_tb0101_id1`),
  ADD KEY `tb0102_tb0101_id2` (`tb0105_tb0101_id2`),
  ADD KEY `tb0102_score2` (`tb0105_score2`),
  ADD KEY `tb0102_score1` (`tb0105_score1`),
  ADD KEY `tb0102_created` (`tb0105_created`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb0101_teams`
--
ALTER TABLE `tb0101_teams`
  MODIFY `tb0101_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb0102_matches`
--
ALTER TABLE `tb0102_matches`
  MODIFY `tb0102_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb0103_playoff`
--
ALTER TABLE `tb0103_playoff`
  MODIFY `tb0103_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb0104_playoff`
--
ALTER TABLE `tb0104_playoff`
  MODIFY `tb0104_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb0105_final`
--
ALTER TABLE `tb0105_final`
  MODIFY `tb0105_id` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;
