-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql301.infinityfree.com
-- Generation Time: Feb 26, 2025 at 09:51 AM
-- Server version: 10.6.19-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_38174637_voting_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$8FpU.d9yqRHqC1/Qr8MN8.G9LN69IwZOWs7D2mUGvyL7glh4D7Jte', '2024-12-29 13:28:43');

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` int(11) NOT NULL,
  `election_id` int(11) DEFAULT NULL,
  `student_id` varchar(20) DEFAULT NULL,
  `position` varchar(50) NOT NULL,
  `platform` text DEFAULT NULL,
  `votes` int(11) DEFAULT 0,
  `candidate_type` enum('partylist','independent') NOT NULL DEFAULT 'independent',
  `partylist_name` varchar(100) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `achievements` text DEFAULT NULL,
  `vision` text DEFAULT NULL,
  `mission` text DEFAULT NULL,
  `status` enum('active','withdrawn','disqualified') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `election_id`, `student_id`, `position`, `platform`, `votes`, `candidate_type`, `partylist_name`, `image_url`, `achievements`, `vision`, `mission`, `status`, `created_at`) VALUES
(69, 13, '172525130050', 'President', 'Encouraging, Cultivate, Inspired, Continue Maintain school (policies, cleanliness, and beautification), Teaching or seminar for (Love and leaders), and Witness student capabilities. \r\nThis platforms improve as a student is being inspired to desire for the integrity and moral of our school.\r\n', 0, 'partylist', 'YAP PARTY ', 'uploads/candidates/67bf141e92998.jpg', NULL, 'To improve the school behaviors,also bring motivation for every student to be a confident in socializing otherâ€™s, and cultivate for being aware in terms of love, leadership, and being a good resilience of a school.', 'Introduce the voices of student in our school to improve the leadership and giving a opportunity for students to give there feedback about any events, activities, and project that are exclusive for everyone.', 'active', '2025-02-26 13:16:14'),
(70, 13, '108136130295', 'Vice President', 'Operation Sparkle: Clean School, Clean Spirit, letâ€™s embrace it!\r\n\r\nMy platform centers around creating a cleaner, more welcoming school environment. Proposes organizing monthly general clean-up drive, engaging the entire student body in improving our shared spaces. This initiative will  also foster school pride and a healthier learning atmosphere.\r\n', 0, 'partylist', 'YAP PARTY ', 'uploads/candidates/67bf1502da946.jpg', NULL, 'A dynamic and innovative learning environment that fosters creativity, critical thinking, and collaboration, preparing students for success in a rapidly changing world.', 'To lead with integrity and vision, working collaboratively with students, staff, and the wider community to create a dynamic and enriching school environment that empowers students to excel academically, socially, and personally.', 'active', '2025-02-26 13:20:02'),
(71, 13, '112007150068', 'Secretary', 'Stop Bullying, Cooperation, and Communication', 0, 'partylist', 'YAP PARTY ', 'uploads/candidates/67bf15aedaf80.jpg', NULL, 'Details where the organization aspires to go. ', 'Organization businesses, its object, how it will reach these objects.', 'active', '2025-02-26 13:22:54'),
(72, 13, '111984160013', 'Treasurer', 'I will ensure transparent and efficient management of our schoolâ€™s finances, utilizing every peso wisely for the schoolâ€™s benefit.â€', 0, 'partylist', 'YAP PARTY ', 'uploads/candidates/67bf165be6fb0.jpg', NULL, 'â€œTo become a model of excellence in secondary education, where learners are inspired to reach their full potential, and where our community is enriched by the skills, knowledge, and character of our graduates.â€', 'â€œTo empower learners to become active citizens, critical thinkers, and creative problem-solvers, and to provide a supportive and inclusive learning environment that fosters academic excellence, personal growth, and social responsibility.â€', 'active', '2025-02-26 13:25:47'),
(73, 13, '111984150038', 'Auditor', 'As a leader, I am committed to listening to the concerns and ideas of my fellow students, and to working collaboratively with teachers, administrators, and parents to address the challenges we face. I am passionate about making a difference and leaving a lasting impact on our school.', 0, 'partylist', 'YAP PARTY ', 'uploads/candidates/67bf16d027a06.jpg', NULL, 'As a student leader, my mission is to inspire and empower my fellow students to become active participants in our school.  Envision a school where everyone feels valued. ', 'My goal is to foster a culture of inclusivity, respect, and open communication, where every student has a voice and is heard. I believe that by working together, we can create a positive and supportive learning environment that benefits everyone.', 'active', '2025-02-26 13:27:44'),
(74, 13, '111989170028', 'PIO', 'CAMPUS EVENTS, HALLWAYS BULLETIN ALWAYS UPDATED\r\n\r\nâ€¢	Iâ€™ll keep the hallway bulletin boards regularly updated with bright advertising upcoming events poster, deadlines, and key announcements that will surely attract students attention.\r\n', 0, 'partylist', 'YAP PARTY ', 'uploads/candidates/67bf17424aba5.jpg', NULL, 'To create a school community in which respectful communication leads to a bond that enables each studentâ€™s voice to be heard.', 'Connecting students for a clear and interesting information so everyone can feel heard and kept informed of school events and projects.', 'active', '2025-02-26 13:29:38'),
(75, 13, '107524170021', 'Protocol Officer', 'â€œCommunity outreach to establish partnership with local businesses, organization, and community groups to promote mutual understanding and support.\"', 0, 'partylist', 'YAP PARTY ', 'uploads/candidates/67bf17ce1dfb4.jpg', NULL, 'â€œTo establish that SSLG as a dynamic and influential student government body, empowering students to actively participate in decision -making processes and contribute meaningfully to the school communityâ€.', 'â€œTo actively represent and advocate for the needs interests, and welfare of all students within the school, fostering a positive and inclusive learning environment through effective leadership and student engagementâ€.', 'active', '2025-02-26 13:31:58'),
(76, 13, '111989170031', 'Grade 8 Representative', 'My top priorities are better communication between students and teachers, a stronger school community, and increased support services for all students.  I will work to create more opportunities for student voices to be heard and for students to connect with each other and their teachers.  My goal is a more positive and supportive learning environment for everyone. ', 0, 'partylist', 'YAP PARTY ', 'uploads/candidates/67bf192cbdc9f.jpg', NULL, 'A better school environment for all student and a school community where everyone works together to achieve shared goal.', 'To effectively represent the needs and concern of all students also to foster collaboration and teamwork between students and administration.', 'active', '2025-02-26 13:37:48'),
(77, 13, '111990170028', 'Grade 8 Representative', '  Improved Communication and Clean School\r\n\r\nMy platform will help find ways to improve our learning. This could be by organizing study groups, finding additional resources, or liaising with our teachers for additional support.Proposes organizing monthly general clean-up drive, engaging the entire student body in improving our shared SPACES.\r\n', 0, 'partylist', 'YAP PARTY ', 'uploads/candidates/67bf1b070b6dd.jpg', NULL, 'I believe in a class that is active, happy, and collaborative. A class where everyone feels valued, respected, and has the opportunity to thrive. A class that encourages unity, teamwork, and the pursuit of success, not only in academics but also in personal growth.', 'As your representative, my mission is to be a bridge between you and our teachers and administration. I will listen to your concerns, advocate for your rights, and do everything in my power to address your needs. I will be transparent in my actions, and I will always be ready to listen and engage. ', 'active', '2025-02-26 13:45:43'),
(78, 13, '111987160023', 'Grade 9 Representative', 'Clean School, Clean Mind, Love and Learn to us.\r\nMy platform is cleaning our school,  clean minds, build a strong communication.', 0, 'partylist', 'YAP PARTY ', 'uploads/candidates/67bf1ba9f118c.jpg', NULL, 'To develop each student to achieve their full academic potential and cultivate a love of learning.', 'To build a strong and inclusive school community where students, teachers work together to create a supportive and enriching learning experience that fosters personal growth and academic achievement.', 'active', '2025-02-26 13:48:25'),
(79, 13, '111987160006', 'Grade 9 Representative', 'Creating relationship to clubs, continue and improving school environment, leading with ure heart and serving.', 0, 'partylist', 'YAP PARTY ', 'uploads/candidates/67bf1cd5f2d2e.jpg', NULL, 'To promote social interaction of students to other students also in there teachers, improving the schoolâ€™s program.', 'To cultivate student being aware in what they do and say.', 'active', '2025-02-26 13:53:26'),
(80, 13, '111984150003', 'Grade 10 Representative', '-be respectful to all people\r\n-use or wear an ID\r\n-avoid wearing pants\r\n-teach reading to students who you know have difficulty reading English and Filipino\r\n', 0, 'partylist', 'YAP PARTY ', 'uploads/candidates/67bf1d8e11c33.jpg', NULL, 'Studentâ€™s communication, reading, and following the activities that must be followed, such as wearing the proper uniform.', 'Student have a broader mind, learn to participate, and each student has good communication, and must be more refined in reading, and follow all the rules that must be followed.', 'active', '2025-02-26 13:56:30'),
(81, 13, '136419150552', 'Grade 10 Representative', 'Mural Painting Contest: Besides making the school more beautiful, this will also showcase the talents of the student artists.', 0, 'partylist', 'YAP PARTY ', 'uploads/candidates/67bf1e0ef422f.jpg', NULL, 'As a representative, I am committed to be a role model. I will eagerly serve as your voice, in order to nurture the campus into a safe, friendly, and comfortable zone for each and every one. I ask for your trust, your support, and your belief in the change we can create together. Letâ€™s make this vision a reality.', 'Together, we can foster a school community that is united, inclusive, and full of opportunities. I promise to work tirelessly to ensure that each one of you feels seen, heard, and valued!', 'active', '2025-02-26 13:58:39'),
(82, 13, '111979140023', 'Grade 11 Representative', 'Empowering Studentsâ€™ Voices\r\nI believe that every student deserves to be heard. As your representative, I promise to:\r\n-	Provide a platform for students to express their thoughts, concerns, and ideas\r\n', 0, 'partylist', 'YAP PARTY ', 'uploads/candidates/67bf1ed4a4e45.jpg', NULL, 'My vision is to create an inclusive and supportive environment where every student has a voice, is heard, and has access to opportunities that enhance their academic, personal, and professional growth.', 'As your representative, my mission is to inspire and empower my fellow students to achieve their dreams and goals.', 'active', '2025-02-26 14:01:56'),
(83, 13, '111984140032', 'Grade 11 Representative', 'I can help boost the confidence of students who are shy and donâ€™t communicate much with others. My approach is to share my own story of overcoming challenges that I thought had no solution. One of these was the feeling of hopelessness I experienced when I doubted my ability to become an honor student, or at least avoid failing grades. But I remembered that I shouldnâ€™t break myself down because God is always guiding me and everyone. Through Him, I learned to be a diligent student and to respect my own abilities.\r\n \r\nBy sharing my experience, I hope to motivate students to boost their confidence as learners. I believe every student has the potential to achieve what their peers can, because God created us all with the ability to overcome our challenges.\r\n \r\nThatâ€™s why I want to be your listening ear. You can tell me about your problems, and I will listen attentively. I will also offer simple advice to help you.\r\n', 0, 'partylist', 'YAP PARTY ', 'uploads/candidates/67bf2013a5491.jpg', NULL, 'As a candidate for the SSLG Grade 11 representative, my vision is to support every student who dreams of achieving their aspirations in life.  One way I will do this is by boosting their confidence to participate in any school activity.', 'Why am I running for SSLG Grade 11 representative?  Itâ€™s because Iâ€™m a student who studies with honor, and I want to showcase my abilities and talents that I havenâ€™t fully been able to share with everyone.', 'active', '2025-02-26 14:07:15'),
(85, 13, '111993130018', 'Grade 12 Representative', 'â€œYour Voice, My Commitment!â€\r\nI will work to bridge the gap between students and school leaders, advocate for student concerns, and promote a more inclusive and engaging school environment. Through open communication and collaboration, I will strive to make a positive difference for everyone.\r\n', 0, 'partylist', 'YAP PARTY ', 'uploads/candidates/67bf21f881561.jpg', NULL, 'A school where every student is represented, empowered, and given opportunities to grow and succeed.', 'To be a strong and reliable voice for my fellow students, ensuring that their concerns, ideas, and needs are heard and addressed.', 'active', '2025-02-26 14:15:20'),
(86, 13, '111981130043', 'Grade 12 Representative', 'Unity and helping the teacher and parents to develop our school will do everything possible for our school, like spreading waste in the school we should all be united and we expect your help to develop our school.', 0, 'partylist', 'YAP PARTY ', 'uploads/candidates/67bf22c926990.jpg', NULL, 'To become a school that learns, supports, and unites, producing students with high academic achievement and citizens with compassion and unity.', 'To provide a unified and supportive community of students, teachers, and parents, fostering unity, hope, and compassion.', 'active', '2025-02-26 14:18:49'),
(87, 13, '111993130011', 'President', '1.	CLEAN UP DRIVE- The SSLG OFFICERS, CLUB OFFICERS AND STUDENTS will be having a Clean Up Drive once a week.\r\n2.	CLASSROOM BEAUTIFICATION CONTEST- The SSLG OFFICERS will be doing to (mag lilibot) and also theyâ€™re going to see or list what classroom that has a CLEANED areas.\r\n3.	FREEDOM FASHION DAY- Where the students can wear whatever they want. There can be a theme per Month. It will happen once a month. But the student must wear decent clothes \r\n4.	LOST AND FOUND BOX- This platform will help students to find their lost items.\r\n', 0, 'partylist', 'STRIVE PARTY', 'uploads/candidates/67bf28710d0b8.png', NULL, 'As a leader I will do my  best shot to serve all of you, not only to the students but also in our school. Leadership is not only powers, but itâ€™s our choice. My vision is seeing the changes of our school under of my leadership.', 'As aspiring president, my goal as leader to be a way or voice. I am not only a students because all of us are leaders. Iâ€™m running for this position to be an example that what ever or who ever you are, be confidentially to face your fears. My main goal as leader is to maintain the cleanliness of our classrooms, not only classrooms but also the comfort rooms and our school.', 'active', '2025-02-26 14:25:32'),
(89, 13, '111985130007', 'Secretary', '1.	BAYANIHAN AS ONE- The organization collaboration of all the students governance from the learners, classroom and club officers together with sslg officers to fulfill their ones project.\r\n2.	Maintaining/Enhancing  the existing policies and regulations of the school in accordance in cleanliness.\r\n3.	Peace and Order\r\n', 0, 'partylist', 'STRIVE PARTY', 'uploads/candidates/67bf259b273e1.jpg', NULL, 'As a leader I will do my  best beyond my power to serve all of you, to build a better school environment for everyone and also provide them a better action regarding with their concerns. Because Leadership is not only powers, but itâ€™s our choice. My vision is seeing the changes of our school under of my leadership.', 'As a student leader, I will do my best in my service to promotes the balance and organize matter to our school to assure that everyone is the priority in my power.', 'active', '2025-02-26 14:30:51'),
(90, 13, '111993140002', 'Auditor', '1.	Tama na sumusobra ka na!!\r\nBased on *Republic Act No. 11576 or Anti-discrimination based on sexual orientation, gender identity, and expression. \r\n- dumarami na kase ang mga member ng LGBTQIA+ sa paaralan ng INHS. May mga nadaragdag kaya mas nadaragdagan naman ang mga  na-didiscriminate, kaya dapat na mabigyan parin sila ng respeto at tamang pagtingin dahil may karapatan din silang pantao, at upang mapanatili natin ang Gender Equality.\r\n*Republic Act No. 11313 or the law that protects persons with disabilities from discrimination.\r\n-ito naman ay para sa mga taong may kapansanan na na-didiscriminate dahilan para magbigay sakanila ng hindi maayos na pakikisama ng iba o kadalasan ay nahihiya. Ito ay para maisaayos ang pag-uugali ng mga studyante at magbigay sakanila ng gabay upang mapanatili ang moralidad sa kanilang isipan.\r\n', 0, 'partylist', 'STRIVE PARTY', 'uploads/candidates/67bf26f565b80.jpg', NULL, 'To create a positive and impactful school experience for all students by promoting inclusivity, leadership, and service to the community.  This will be accomplished, in part, by nurturing and developing essential student leadership skills.', 'To uphold the highest standards of integrity and professionalism as an SSLG officer, dedicated to serving our school community with transparency, accountability, and compassion. With my experience in student leadership and community service, I ensure that every studentâ€™s voice is heard and valued. I commit to continuous learning and improvement, staying updated with best practices in student leadership and governance to enhance our schoolâ€™s learner government program.', 'active', '2025-02-26 14:36:37'),
(91, 13, '111984170036', 'Grade 8 Representative', '1. Matatag na pamumuno,Masiglang, Mag-aaral, Maunlad na Paaral \r\n2.Pagsasagawa ng sustainable environmental project tulad ng tree planting at waste management campaigns. \r\n3.Pakikipagtulungan sa guro para sa mas epektibong study habits at career guidance.\r\n4. always willing to earn and grow\r\n', 0, 'partylist', 'STRIVE PARTY', 'uploads/candidates/67bf28d3966d5.jpg', NULL, 'A united and proactive supreme student learner government that inspires and empowers Evey student to be a responsible leader,  a compassionate peer, and a catalyst for positive charge in our school and community.', 'To serve as the voice of the student body, promoting inclusivity, integrity, and excellence. We strive to create \r\n Meaningful programs that enhance student welfare, spirit of unity and service among learners. \r\n', 'active', '2025-02-26 14:44:35');

-- --------------------------------------------------------

--
-- Table structure for table `candidate_requirements`
--

CREATE TABLE `candidate_requirements` (
  `id` int(11) NOT NULL,
  `candidate_id` int(11) DEFAULT NULL,
  `requirement_name` varchar(100) DEFAULT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `remarks` text DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `elections`
--

CREATE TABLE `elections` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` enum('pending','active','completed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `elections`
--

INSERT INTO `elections` (`id`, `title`, `description`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
(13, 'SSLG voting election 2025', 'test', '2025-02-24 23:10:00', '2025-02-28 23:10:00', 'active', '2025-02-25 15:10:50', '2025-02-25 15:10:51');

-- --------------------------------------------------------

--
-- Table structure for table `partylists`
--

CREATE TABLE `partylists` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `platform` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `partylists`
--

INSERT INTO `partylists` (`id`, `name`, `description`, `logo_url`, `platform`, `status`, `created_at`) VALUES
(6, 'STRIVE PARTY', 'STRIVE PARTYLIST aims to be the voice for those who are often left behind. Also this party list is going to be an example for doing the task that assign to the students', 'uploads/partylists/67be7eba6058c.jpg', NULL, 'active', '2025-02-26 02:38:50'),
(7, 'YAP PARTY ', 'To improve the next generation of leadership  in our school and prove the quote â€œAng Kabataan Ang Pag - Asa Ng Bayan\" that serve as a speak of calling for every teenager in campus that are not yet understand what are the meaning of serving, loving, leading and continue learning.', 'uploads/partylists/67be7fb7f1601.jpg', NULL, 'active', '2025-02-26 02:43:03');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `StudentID` varchar(20) NOT NULL,
  `FullName` varchar(100) NOT NULL,
  `Grade` varchar(20) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `ContactNumber` varchar(20) NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`StudentID`, `FullName`, `Grade`, `Email`, `ContactNumber`, `CreatedAt`) VALUES
('101374110008', 'IBARBIA, JOHN RUSSEL', 'Grade 12', 'ibarbiarussel.101374110008@sslg.edu.ph', 'N/A', '2025-02-26 02:05:44'),
('101374150011', 'IBARBIA, ANGEL D.', 'Grade 10', 'ibarbiad.101374150011@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('104768160096', 'HIPOLITO,AIRA JANE, LOYOLA', 'Grade 10', 'hipolitoairaloyola.104768160096@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('104913130186', 'BRITANICO,MAYKA ELBANO', 'Grade 11', 'britanicomaykaelbano.104913130186@sslg.edu.ph', 'N/A', '2025-02-25 21:20:51'),
('105011160023', 'AGUILAR,ERZEL SHANE, BATA', 'Grade 10', 'aguilarerzelbata.105011160023@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('105144170188', 'PALACIO, BRIARROSE GANGAN', 'Grade 7', 'palaciogangan.105144170188@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('105340160023', 'MEDINA, GABRIEL CASIAO', 'Grade 7', 'medinacasiao.105340160023@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('105741160129', 'DE BELLEN SHERWIN', 'Grade 8', 'desherwin.105741160129@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('107049170056', 'MARAYAN,CHRIS JANE, SANORJO', 'Grade 10', 'marayanchrissanorjo.107049170056@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('107141170144', 'CASTAÃ‘EDA, JONALYN MENDOZA', 'Grade 7', 'castaedamendoza.107141170144@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('107487170177', 'MATANGUIHAN, REYMART,.', 'Grade 7', 'matanguihanreymart.107487170177@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('107524170021', 'BORBE, ALTHEA,', 'Grade 7', 'borbealthea.107524170021@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('107594150215', 'JIMENEZ,STEVEN LLOYD, BIERSO', 'Grade 9', 'jimenezstevenbierso.107594150215@sslg.edu.ph', 'N/A', '2025-02-26 02:33:32'),
('108111140120', 'CENITA, ALYECSA MAE, RAMOS', 'Grade 10', 'cenitaramos.108111140120@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('108114160009', 'Cenita , Noleen  M.', 'Grade 8', 'cenitam.108114160009@sslg.edu.ph', 'N/A', '2025-02-26 01:32:53'),
('108136130295', 'RICAMATA, YVON RAIN HEART OLASO', 'Grade 11', 'ricamataolaso.108136130295@sslg.edu.ph', 'N/A', '2025-02-26 00:37:46'),
('108167120256', 'SAMANIEGO, PEEJAY SUMABAN', 'Grade 11', 'samaniegosumaban.108167120256@sslg.edu.ph', 'N/A', '2025-02-26 00:37:46'),
('108221170074', 'IBAÃ‘EZ, ELYSE LEANNA ARIAS', 'Grade 7', 'ibaezarias.108221170074@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('108239150068', 'CRUZ, MARC AERIEL BIERSO', 'Grade 11', 'cruzbierso.108239150068@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('108444130124', 'RELLEVE, MYLENE, MALAZA', 'Grade 10', 'rellevemalaza.108444130124@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('108473160204', 'SALCEDO, MARK BRYAN ARCONES', 'Grade 9', 'salcedoarcones.108473160204@sslg.edu.ph', 'N/A', '2025-02-26 07:11:28'),
('108641160105', 'De Mesa, Ma. Fatima C.', 'Grade 8', 'dec.108641160105@sslg.edu.ph', 'N/A', '2025-02-26 12:49:01'),
('108675150060', 'Paison, Althea', 'Grade 8', 'paisonalthea.108675150060@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('109327171360', 'SARIO, KHRISIA DENISE,.', 'Grade 7', 'sariodenise.109327171360@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('109357160130', 'Cells , Rhea', 'Grade 8', 'cellsrhea.109357160130@sslg.edu.ph', 'N/A', '2025-02-26 01:32:53'),
('109397150008', 'APDAL,GILBERT, BELGA', 'Grade 9', 'apdalgilbertbelga.109397150008@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('109525150122', 'ANDES, CHRISTIAN, B.', 'Grade 7', 'andesb.109525150122@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('109538170179', 'MENDOZA, JANDY CLYTH, S.', 'Grade 7', 'mendozas.109538170179@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('109540140366', 'Sayson, Renda, Monton', 'Grade 10', 'saysonmonton.109540140366@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('109717160228', 'Zoreta, Princess Ann R.', 'Grade 8', 'zoretar.109717160228@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('1108239150068', 'CRUZ, MARC ARIEL BIERSO', 'Grade 11', 'cruzbierso.1108239150068@sslg.edu.ph', 'N/A', '2025-02-25 14:54:33'),
('111589170032', 'BARRAMEDA MONIQUE MELLA', 'Grade 7', 'barramedamella.111589170032@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('111635140034', 'RAÃ‘OSA,ALDRIN, BOCAYA', 'Grade 10', 'raosaaldrinbocaya.111635140034@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111635150079', 'RANOSA JOSELB', 'Grade 8', 'ranosajoselb.111635150079@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('111762140390', 'Perillo, Cristel Joy, ViÃ±as', 'Grade 10', 'perillovias.111762140390@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('111795130019', 'TORALDE, JHON MARK, TALAGTAG', 'Grade 10', 'toraldetalagtag.111795130019@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111816140065', 'BALANG, RICSEL ANICA D.', 'Grade 10', 'balangd.111816140065@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('111865150027', 'BO, JARALYN B.', 'Grade 9', 'bob.111865150027@sslg.edu.ph', 'N/A', '2025-02-26 13:25:55'),
('111904160020', 'SARSALE, KATE YOHAN-A', 'Grade 8', 'sarsaleyohana.111904160020@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('111907160031', 'LAUREL MAPRINCESS', 'Grade 8', 'laurelmaprincess.111907160031@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('111928150057', 'DE LEON, JOMEL RED', 'Grade 9', 'dered.111928150057@sslg.edu.ph', 'N/A', '2025-02-26 07:11:28'),
('111939160006', 'Ripo ,  Queenie  Mae  R.', 'Grade 8', 'ripor.111939160006@sslg.edu.ph', 'N/A', '2025-02-26 01:32:54'),
('111949160021', 'Sario, Richard S.', 'Grade 8', 'sarios.111949160021@sslg.edu.ph', 'N/A', '2025-02-26 12:49:01'),
('111964170035', 'LASTRA CRIS ANDREI ALCOY', 'Grade 7', 'lastraalcoy.111964170035@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('111965170004', 'BOLON REYVEN SANORJO', 'Grade 7', 'bolonsanorjo.111965170004@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('111969160015', 'RAGODON, ANGILECAR', 'Grade 8', 'ragodonangilecar.111969160015@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('111979100009', 'BERTILLO, JOSH PEDRERA', 'Grade 11', 'bertillopedrera.111979100009@sslg.edu.ph', 'N/A', '2025-02-26 00:37:46'),
('111979120010', 'TIODONES,JOHN CEZAR SARIO', 'Grade 12', 'tiodonesjohnsario.111979120010@sslg.edu.ph', 'N/A', '2025-02-26 01:59:26'),
('111979120012', 'BELARDO,AIZEL BENIPAYO', 'Grade 12', 'belardoaizelbenipayo.111979120012@sslg.edu.ph', 'N/A', '2025-02-25 22:19:19'),
('111979120056', 'MONDA,HANNAH AMARO', 'Grade 12', 'mondahannahamaro.111979120056@sslg.edu.ph', '', '2025-02-25 22:19:19'),
('111979130005', 'BELGA, AIVAN JAY SARIO', 'Grade 11', 'belgasario.111979130005@sslg.edu.ph', 'N/A', '2025-02-25 14:54:33'),
('111979130013', 'BALBALOSA, CHARLENE SY', 'Grade 11', 'balbalosasy.111979130013@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('111979130014', 'MONDA,JAY, BRECIA', 'Grade 9', 'mondajaybrecia.111979130014@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111979130019', 'MONDA,KYLA, BRECIA', 'Grade 9', 'mondakylabrecia.111979130019@sslg.edu.ph', 'N/A', '2025-02-25 21:29:13'),
('111979130025', 'SARIO, ERIC REMOVLAS', 'Grade 11', 'sarioremovlas.111979130025@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('111979130036', 'SAÃ‘ADO, YVAN DACUYA', 'Grade 11', 'saadodacuya.111979130036@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('111979130043', 'REBATIS, RAYMOND NARES', 'Grade 11', 'rebatisnares.111979130043@sslg.edu.ph', 'N/A', '2025-02-26 00:37:46'),
('111979130044', 'VERGARA, JOHN CHARLES CESTINA', 'Grade 11', 'vergaracestina.111979130044@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('111979140015', 'BRON, LAISA, BIERSO', 'Grade 10', 'bronbierso.111979140015@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('111979140021', 'NARES,ALYSSA JANE, DEL ROSARIO', 'Grade 10', 'naresalyssarosario.111979140021@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111979140023', 'REBATIS, JESSA C.', 'Grade 10', 'rebatisc.111979140023@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('111979140027', 'BELARDO,MARK JOSEPH, BON', 'Grade 10', 'belardomarkbon.111979140027@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111979140029', 'CAMILLO, CARL P.', 'Grade 10', 'camillop.111979140029@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('111979140035', 'NARIS,JOSHUA, PORTEM', 'Grade 10', 'narisjoshuaportem.111979140035@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111979150004', 'BROQUEZA,JOHN REAN, BAÃ‘ARES', 'Grade 9', 'broquezajohnbaares.111979150004@sslg.edu.ph', 'N/A', '2025-02-25 21:29:13'),
('111979150009', 'RECTO,RENZ, MONDA', 'Grade 9', 'rectorenzmonda.111979150009@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111979150018', 'CRUZ,AIKA FEB, BIERSO', 'Grade 9', 'cruzaikabierso.111979150018@sslg.edu.ph', 'N/A', '2025-02-26 02:33:32'),
('111979150021', 'SARIO, CRISTINE GRACE BOTIN', 'Grade 9', 'sariobotin.111979150021@sslg.edu.ph', 'N/A', '2025-02-26 07:11:28'),
('111979150023', 'BALMAS,JOHN ADRIAN, ENCILA', 'Grade 9', 'balmasjohnencila.111979150023@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111979150032', 'SALVANTE,RYNE GABRIEL, ROBRIGADO', 'Grade 9', 'salvanterynerobrigado.111979150032@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111979160001', 'BACILAN, JOSEL-OR', 'Grade 8', 'bacilanjoselor.111979160001@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('111979160003', 'BERTILLO, ZAIJAN B.', 'Grade 8', 'bertillob.111979160003@sslg.edu.ph', 'N/A', '2025-02-26 13:48:43'),
('111979160005', 'Burac , Rolly  N.', 'Grade 8', 'buracn.111979160005@sslg.edu.ph', 'N/A', '2025-02-26 01:32:53'),
('111979160012', 'BASE, JOHN DAVE S.', 'Grade 8', 'bases.111979160012@sslg.edu.ph', 'N/A', '2025-02-26 13:48:43'),
('111979160014', 'BELARDO MAYCA JOY-BA', 'Grade 8', 'belardojoyba.111979160014@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('111979160016', 'Samper, Shalanie Pearl  V.', 'Grade 8', 'samperv.111979160016@sslg.edu.ph', 'N/A', '2025-02-26 01:32:54'),
('111979170003', 'BROQUEZA ALEXA MAE BAÃ‘ARES', 'Grade 7', 'broquezabaares.111979170003@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('111979170006', 'DIAZ, PRINCESS NICOLE', 'Grade 7', 'diaznicole.111979170006@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('111979170008', 'SARTURIO, GESSABEL ANNE SALVANTE', 'Grade 7', 'sarturiosalvante.111979170008@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('111979170010', 'NOCILLADO, CARLO,', 'Grade 7', 'nocilladocarlo.111979170010@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('111979170011', 'ALCANTARA, JAIRUZ MUNDA', 'Grade 7', 'alcantaramunda.111979170011@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('111979170015', 'BIERSO, MARK JOSEPH,', 'Grade 7', 'biersojoseph.111979170015@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('111979170017', 'MERCADO,JEROME, BARCINAS', 'Grade 10', 'mercadojeromebarcinas.111979170017@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('111979170023', 'SARILLA ALBERT CAMONOGA', 'Grade 7', 'sarillacamonoga.111979170023@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('111979170029', 'LOTIVO, SYVELL KATELYN LLANETA', 'Grade 7', 'lotivollaneta.111979170029@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('111979170034', 'CUEVAS, JULIA MAE J.', 'Grade 7', 'cuevasj.111979170034@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('111980160054', 'MANEGO, ANGELA S.', 'Grade 9', 'manegos.111980160054@sslg.edu.ph', 'N/A', '2025-02-26 13:25:55'),
('111981120097', 'LASIN,JENNYLYN ORAYE', 'Grade 12', 'lasinjennylynoraye.111981120097@sslg.edu.ph', 'N/A', '2025-02-25 22:19:19'),
('111981120116', 'CANEO,ABEGAIL MORA', 'Grade 12', 'caneoabegailmora.111981120116@sslg.edu.ph', 'N/A', '2025-02-25 22:19:19'),
('111981120118', 'CARIAGA,CRISTINE PEFANIO', 'Grade 12', 'cariagacristinepefanio.111981120118@sslg.edu.ph', 'N/A', '2025-02-26 01:59:26'),
('111981120124', 'PIANDIONG,PAULINE CARIAGA', 'Grade 12', 'piandiongpaulinecariaga.111981120124@sslg.edu.ph', 'N/A', '2025-02-26 01:59:26'),
('111981130017', 'SANAO,JOHN LOUIE ROBAS', 'Grade 12', 'sanaojohnrobas.111981130017@sslg.edu.ph', 'N/A', '2025-02-26 01:59:26'),
('111981130023', 'ARIOLA, JAY MARK, FRAGINAL', 'Grade 10', 'ariolafraginal.111981130023@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111981130042', 'LOPEZ, GILLIAN BENITEZ', 'Grade 11', 'lopezbenitez.111981130042@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('111981130043', 'LOPEZ, JELLY ROSE CAL', 'Grade 11', 'lopezcal.111981130043@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('111981130048', 'NAVARRO, JUVY BELARDO', 'Grade 11', 'navarrobelardo.111981130048@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('111981130057', 'TUSCANO, JHASMINE LOBOS', 'Grade 11', 'tuscanolobos.111981130057@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('111981130066', 'BALLARAN, EMMALYN M', 'Grade 11', 'ballaranm.111981130066@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('111981130067', 'BALLARAN, LYKA JOY ALBANIA', 'Grade 11', 'ballaranalbania.111981130067@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('111981130068', 'BEJENO, JESSA MAE BELMONTE', 'Grade 11', 'bejenobelmonte.111981130068@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('111981130069', 'BODINO, NARISSA LABIT', 'Grade 11', 'bodinolabit.111981130069@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('111981130086', 'BRITANICO, MAYKA ELBANO', 'Grade 11', 'britanicoelbano.111981130086@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('111981140029', 'Arenas, John Mark, Bermeo', 'Grade 10', 'arenasbermeo.111981140029@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111981140031', 'Bolano, Earl Jule, Rapirap', 'Grade 10', 'bolanorapirap.111981140031@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111981140035', 'MARISCOTES, FRANZ ERN D.', 'Grade 10', 'mariscotesd.111981140035@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('111981140036', 'MARTICIO, REDGIE REX M.', 'Grade 10', 'marticiom.111981140036@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('111981140038', 'MORANO, JOHN CODY L.', 'Grade 10', 'moranol.111981140038@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('111981140042', 'SABEROLA,JARED, MONTE', 'Grade 10', 'saberolajaredmonte.111981140042@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111981140045', 'BASILAN,JONA ALEXA, SAPIERA', 'Grade 10', 'basilanjonasapiera.111981140045@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111981140049', 'Lasin, Angelica, Oraye', 'Grade 10', 'lasinoraye.111981140049@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('111981150001', 'AGARIN,MAE IVY, ORILA', 'Grade 9', 'agarinmaeorila.111981150001@sslg.edu.ph', 'N/A', '2025-02-26 02:33:32'),
('111981150005', 'SAMANIEGO,QUEEN NERICA, MARTICIO', 'Grade 9', 'samaniegoqueenmarticio.111981150005@sslg.edu.ph', 'N/A', '2025-02-26 02:33:32'),
('111981150007', 'NELSON, SHAMEL P.', 'Grade 9', 'nelsonp.111981150007@sslg.edu.ph', 'N/A', '2025-02-26 13:25:55'),
('111981150011', 'CAPUZ,ANGEL TRISHA MAE, CARIAGA', 'Grade 9', 'capuzangelcariaga.111981150011@sslg.edu.ph', 'N/A', '2025-02-25 21:29:13'),
('111981150012', 'BUE,ARCHEL, OCCIDENTAL', 'Grade 9', 'buearcheloccidental.111981150012@sslg.edu.ph', 'N/A', '2025-02-26 02:33:32'),
('111981150013', 'SABABAN,ARLHAN DWAYNE, RAGUAL', 'Grade 9', 'sababanarlhanragual.111981150013@sslg.edu.ph', 'N/A', '2025-02-26 02:33:32'),
('111981150014', 'NAVARRO,JHAMIL, BELARDO', 'Grade 9', 'navarrojhamilbelardo.111981150014@sslg.edu.ph', 'N/A', '2025-02-25 21:29:13'),
('111981150015', 'MARISCOTES,PAUL JAKE, BARBOSA', 'Grade 9', 'mariscotespaulbarbosa.111981150015@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111981150019', 'BELLO,KEN ANGELU, RAMOS', 'Grade 9', 'bellokenramos.111981150019@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111981150023', 'LUZON,JEBOY, MICOLITA', 'Grade 9', 'luzonjeboymicolita.111981150023@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111981150028', 'BUE,JUSTINE ROI, DELUMBRIA', 'Grade 9', 'buejustinedelumbria.111981150028@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111981150032', 'MADARA,JAY-AR, ELVIRA', 'Grade 9', 'madarajayarelvira.111981150032@sslg.edu.ph', 'N/A', '2025-02-25 21:29:13'),
('111981150036', 'MADRELEJOS, MARINIEL J.', 'Grade 9', 'madrelejosj.111981150036@sslg.edu.ph', 'N/A', '2025-02-26 13:25:55'),
('111981160001', 'REA, JAY LORD M.', 'Grade 8', 'ream.111981160001@sslg.edu.ph', 'N/A', '2025-02-26 13:48:43'),
('111981160003', 'Lopez, Jay-Ar B.', 'Grade 8', 'lopezb.111981160003@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111981160004', 'MARCELINO, EARL JOHN R.', 'Grade 8', 'marcelinor.111981160004@sslg.edu.ph', 'N/A', '2025-02-26 13:48:43'),
('111981160005', 'Navarro, Jerome B', 'Grade 8', 'navarrob.111981160005@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111981160008', 'AÅ„onuevo, Jeaneca B.', 'Grade 8', 'aonuevob.111981160008@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111981160009', 'Madrelejos, Jonavie L.', 'Grade 8', 'madrelejosl.111981160009@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111981170006', 'CASAIS, JEREMY BELARDO', 'Grade 7', 'casaisbelardo.111981170006@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('111981170007', 'COPE CRISTON HORTA', 'Grade 7', 'copehorta.111981170007@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('111981170008', 'NELSON, JADE PADILLA', 'Grade 7', 'nelsonpadilla.111981170008@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('111981170009', 'MARTINEZ RIC ALBERT SAMANIEGO', 'Grade 7', 'martinezsamaniego.111981170009@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('111981170010', 'MARTICIO, RHENZO,', 'Grade 7', 'marticiorhenzo.111981170010@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('111981170015', 'ARIOLA, ANGEL, C.', 'Grade 7', 'ariolac.111981170015@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('111981170016', 'BAROÃ‘A, DANICA EUBRA', 'Grade 7', 'baroaeubra.111981170016@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('111981170020', 'LASIN,LEILA, ORAYE', 'Grade 10', 'lasinleilaoraye.111981170020@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('111981170021', 'LOPEZ, LYKA MAE RISARE', 'Grade 7', 'lopezrisare.111981170021@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('111981170022', 'MADARA, JILLIAN,..', 'Grade 7', 'madarajillian.111981170022@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('111981170028', 'BASILAN, JAYCO, S.', 'Grade 7', 'basilans.111981170028@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('111981170029', 'FERANDEZ, CRISILDA YAGIL', 'Grade 7', 'ferandezyagil.111981170029@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('111981170030', 'ONRUBIA, RICO PELAYO', 'Grade 7', 'onrubiapelayo.111981170030@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('111981170034', 'VIÃ‘AS, JOVIT RABUSA', 'Grade 7', 'viasrabusa.111981170034@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('111982120002', 'BERGANIO,JAYMAR PANDAY', 'Grade 12', 'berganiojaymarpanday.111982120002@sslg.edu.ph', 'N/A', '2025-02-26 01:59:26'),
('111982120008', 'ABAÃ‘O,ALMERA MAE DIAZ', 'Grade 12', 'abaoalmeradiaz.111982120008@sslg.edu.ph', 'N/A', '2025-02-25 22:19:19'),
('111982120016', 'TADURAN,JHEA ROSE ROMULO', 'Grade 12', 'taduranjhearomulo.111982120016@sslg.edu.ph', '', '2025-02-25 22:19:19'),
('111982130003', 'BERGANIO, ANDRE JACINTO', 'Grade 11', 'berganiojacinto.111982130003@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('111982130008', 'IBARRETA,ANGELICA VILLA', 'Grade 11', 'ibarretaangelicavilla.111982130008@sslg.edu.ph', 'N/A', '2025-02-25 21:20:51'),
('111982130015', 'TADURAN, KURL JHURIE VASQUEZ', 'Grade 11', 'taduranvasquez.111982130015@sslg.edu.ph', 'N/A', '2025-02-26 00:37:46'),
('111982130016', 'BAGAYAWA,MARK JOHN PAUL RAMOS', 'Grade 12', 'bagayawamarkramos.111982130016@sslg.edu.ph', 'N/A', '2025-02-26 02:05:44'),
('111982130017', 'BALTAR,RYAN JAMES MARCOS', 'Grade 12', 'baltarryanmarcos.111982130017@sslg.edu.ph', 'N/A', '2025-02-26 01:59:26'),
('111982130020', 'OCBIAN,JOJIE BROÃ‘OSA', 'Grade 12', 'ocbianjojiebroosa.111982130020@sslg.edu.ph', 'N/A', '2025-02-26 01:59:26'),
('111982130030', 'PORTUGAL,JELIAN TALE', 'Grade 12', 'portugaljeliantale.111982130030@sslg.edu.ph', '', '2025-02-25 22:19:19'),
('111982140003', 'RELLON, RENZ LUIGI DANGALAN', 'Grade 11', 'rellondangalan.111982140003@sslg.edu.ph', 'N/A', '2025-02-26 00:37:46'),
('111982140014', 'RATO,JAY-AR, ABILA', 'Grade 10', 'ratojayarabila.111982140014@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111982140015', 'TADURAN,CLARENZ DWAYNE, BALTAR', 'Grade 10', 'taduranclarenzbaltar.111982140015@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111982150002', 'BALTAR,JAKE, MALLARI', 'Grade 9', 'baltarjakemallari.111982150002@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111982150003', 'MARTINEZ,PAUL ALLEN, SANAO', 'Grade 9', 'martinezpaulsanao.111982150003@sslg.edu.ph', 'N/A', '2025-02-25 21:29:13'),
('111982150005', 'BAGAYAWAM MARK JESTER', 'Grade 9', 'bagayawamjester.111982150005@sslg.edu.ph', 'N/A', '2025-02-26 13:25:55'),
('111982150006', 'ABANO,  ADRIAN D.', 'Grade 9', 'abanod.111982150006@sslg.edu.ph', 'N/A', '2025-02-26 13:25:55'),
('111982150007', 'BALTAR, ERICK SALCEDO', 'Grade 9', 'baltarsalcedo.111982150007@sslg.edu.ph', 'N/A', '2025-02-26 07:11:28'),
('111982150009', 'GARCIA,GERALD, ABAÃ‘O', 'Grade 9', 'garciageraldabao.111982150009@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111982150012', 'PABELONIA, LUIS O', 'Grade 8', 'pabeloniao.111982150012@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('111982150013', 'PANGHILINO,MARK JERICK, PORTUGAL', 'Grade 9', 'panghilinomarkportugal.111982150013@sslg.edu.ph', 'N/A', '2025-02-25 21:29:13'),
('111982150015', 'NACARIO,BEA JANINE, YANSON', 'Grade 9', 'nacariobeayanson.111982150015@sslg.edu.ph', 'N/A', '2025-02-26 02:33:32'),
('111982150016', 'SARTURIO, RHIANNA V.', 'Grade 9', 'sarturiov.111982150016@sslg.edu.ph', 'N/A', '2025-02-26 13:25:55'),
('111982150018', 'INGUITO, DARREN SANAO', 'Grade 7', 'inguitosanao.111982150018@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('111982150020', 'Chaves, Denver Bolano', 'Grade 10', 'chavesbolano.111982150020@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111982160001', 'Bellen, Edsel B.', 'Grade 8', 'bellenb.111982160001@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111982160003', 'Bombane , Jamiel  A.', 'Grade 8', 'bombanea.111982160003@sslg.edu.ph', 'N/A', '2025-02-26 01:32:53'),
('111982160006', 'Gonzales, Jake S.', 'Grade 8', 'gonzaless.111982160006@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111982160007', 'Nacario ,  Jayrol  P.', 'Grade 8', 'nacariop.111982160007@sslg.edu.ph', 'N/A', '2025-02-26 01:32:53'),
('111982160010', 'BERGANIO, LHEA ROSE', 'Grade 8', 'berganiorose.111982160010@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('111982160011', 'LIBARRETA, ARIANNE', 'Grade 8', 'libarretaarianne.111982160011@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('111982160012', 'OPE?A, CYRIL P.', 'Grade 8', 'opeap.111982160012@sslg.edu.ph', 'N/A', '2025-02-26 13:55:03'),
('111982160013', 'Taduran, Aires O.', 'Grade 8', 'tadurano.111982160013@sslg.edu.ph', 'N/A', '2025-02-26 12:49:01'),
('111982160014', 'Ocbian, James R.', 'Grade 8', 'ocbianr.111982160014@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111982160015', 'Rato , Joshua  A.', 'Grade 8', 'ratoa.111982160015@sslg.edu.ph', 'N/A', '2025-02-26 01:32:53'),
('111982170001', 'BALTAR, JOHN M.', 'Grade 7', 'baltarm.111982170001@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('111982170002', 'BALTAR LEIANMART-', 'Grade 7', 'baltarleianmart.111982170002@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('111982170006', 'NOLASCO, JHIAN KHIAN KHENE,', 'Grade 7', 'nolascokhene.111982170006@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('111982170010', 'TADURAN, JAMES ERON ROMOLO', 'Grade 7', 'taduranromolo.111982170010@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('111982170012', 'SANDAGON, YSABELLE TADURAN', 'Grade 7', 'sandagontaduran.111982170012@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('111982170013', 'PEREZ,SOFHIA, TADURAN', 'Grade 10', 'perezsofhiataduran.111982170013@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('111982170015', 'VEGA, MERRY ANN,', 'Grade 7', 'vegaann.111982170015@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('111983160024', 'Cas, Princess Althea B.', 'Grade 8', 'casb.111983160024@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111983170003', 'BARANDA, MARVIE ENRIQUEZ', 'Grade 7', 'barandaenriquez.111983170003@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('111984120004', 'BARRAMEDA,LARRY JR BANAYBANAY', 'Grade 11', 'barramedalarrybanaybanay.111984120004@sslg.edu.ph', 'N/A', '2025-02-26 00:37:46'),
('111984120043', 'SAÃ‘ADO,WILSON JR  MATRIZ', 'Grade 12', 'saadowilsonmatriz.111984120043@sslg.edu.ph', 'N/A', '2025-02-26 02:05:44'),
('111984120069', 'MATRIZ, MARK JERALD CISTER', 'Grade 11', 'matrizcister.111984120069@sslg.edu.ph', 'N/A', '2025-02-26 00:37:46'),
('111984120071', 'RAGUAL, JOHN KIVEN DIAZ', 'Grade 11', 'ragualdiaz.111984120071@sslg.edu.ph', 'N/A', '2025-02-26 00:37:46'),
('111984120081', 'MOLATO,GERALDINE TALE', 'Grade 12', 'molatogeraldinetale.111984120081@sslg.edu.ph', '', '2025-02-25 22:19:19'),
('111984120084', 'SAPO,KRISSIA MAE FRAGINAL', 'Grade 12', 'sapokrissiafraginal.111984120084@sslg.edu.ph', '', '2025-02-25 22:19:19'),
('111984120087', 'SARTURIO,JANNA ROSE POLLERO', 'Grade 12', 'sarturiojannapollero.111984120087@sslg.edu.ph', '', '2025-02-25 22:19:19'),
('111984120089', 'SARTURIO,RONNA MAE VILLA', 'Grade 12', 'sarturioronnavilla.111984120089@sslg.edu.ph', '', '2025-02-25 22:19:19'),
('111984120090', 'TALANGAN,LEIZEL SALCEDO', 'Grade 12', 'talanganleizelsalcedo.111984120090@sslg.edu.ph', '', '2025-02-25 22:19:19'),
('111984120100', 'ABANEL,JOHN LEOMER FUENTES', 'Grade 12', 'abaneljohnfuentes.111984120100@sslg.edu.ph', 'N/A', '2025-02-25 22:19:19'),
('111984130003', 'AGARIN,KIM M', 'Grade 12', 'agarinkimm.111984130003@sslg.edu.ph', 'N/A', '2025-02-25 22:19:19'),
('111984130015', 'BAÃ‘ARES,ANGELA CAMILIO', 'Grade 12', 'baaresangelacamilio.111984130015@sslg.edu.ph', 'N/A', '2025-02-26 01:59:26'),
('111984130016', 'BACUDIO,MITCH NICOLE SALEM', 'Grade 12', 'bacudiomitchsalem.111984130016@sslg.edu.ph', 'N/A', '2025-02-25 22:19:19'),
('111984130040', 'SAMANIEGO,LEOLYN A', 'Grade 12', 'samaniegoleolyna.111984130040@sslg.edu.ph', 'N/A', '2025-02-26 01:59:26'),
('111984130042', 'SALAZAR,CATHLEEN DIAZ', 'Grade 12', 'salazarcathleendiaz.111984130042@sslg.edu.ph', '', '2025-02-25 22:19:19'),
('111984130044', 'CARULLO, JOHN MICHAEL B.', 'Grade 10', 'carullob.111984130044@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('111984130047', 'BaÃ±ares, John Carlo, Gadil', 'Grade 10', 'baaresgadil.111984130047@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111984130051', 'CANABAL, MATT ANDREY BELMONTE', 'Grade 11', 'canabalbelmonte.111984130051@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('111984130066', 'BALLARAN,EMMALYN M', 'Grade 11', 'ballaranemmalynm.111984130066@sslg.edu.ph', 'N/A', '2025-02-25 21:20:51'),
('111984130071', 'GARCIA,KYLA B', 'Grade 11', 'garciakylab.111984130071@sslg.edu.ph', 'N/A', '2025-02-25 21:20:51'),
('111984130079', 'RET, MA. ALEXANDRA D.', 'Grade 10', 'retd.111984130079@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('111984140012', 'ESTRADA,MARK JOHN, BRONCANO', 'Grade 10', 'estradamarkbroncano.111984140012@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111984140013', 'Malate, Reymond, Baldeo', 'Grade 10', 'malatebaldeo.111984140013@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111984140020', 'TOLEDO,ANGELO, SARTURIO', 'Grade 10', 'toledoangelosarturio.111984140020@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111984140022', 'SAPO,DANIEL, BELGA', 'Grade 10', 'sapodanielbelga.111984140022@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111984140024', 'BAÃ‘EZ,ALYSSA IRISHE, NALICAT', 'Grade 10', 'baezalyssanalicat.111984140024@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111984140025', 'BONDAL,ASHLY NICOLE, ENCISO', 'Grade 10', 'bondalashlyenciso.111984140025@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111984140027', 'HAPIN,MARIA AILEEN, SARTORIO', 'Grade 10', 'hapinmariasartorio.111984140027@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111984140028', 'SALCEDO,ZYRENE, BAGASBAS', 'Grade 10', 'salcedozyrenebagasbas.111984140028@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111984140029', 'Samorin, Angelica, BasquiÃ±ez', 'Grade 10', 'samorinbasquiez.111984140029@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('111984140032', 'TAÃ‘IOLA, RONNA MAE T.', 'Grade 10', 'taiolat.111984140032@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('111984140036', 'DOCTOR,JHESUN, NORTE', 'Grade 9', 'doctorjhesunnorte.111984140036@sslg.edu.ph', 'N/A', '2025-02-25 21:29:13'),
('111984140040', 'REA,JOEL, II MORAN', 'Grade 10', 'reajoelmoran.111984140040@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111984140042', 'BACUDIO,RAFAEL, SALEM', 'Grade 10', 'bacudiorafaelsalem.111984140042@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111984140044', 'Sarturio, Rex, Pollero', 'Grade 10', 'sarturiopollero.111984140044@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111984140050', 'BIÃ‘AN,JENNY ROSE, JAVINES', 'Grade 10', 'bianjennyjavines.111984140050@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('111984140053', 'CORPUZ, EHRA MAE, SARTURIO', 'Grade 10', 'corpuzsarturio.111984140053@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('111984140058', 'RELLORCASA, LEA MAE, ENGITO', 'Grade 10', 'rellorcasaengito.111984140058@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('111984140062', 'MOLATO, ROMY TALE', 'Grade 11', 'molatotale.111984140062@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('111984150001', 'CAYA, LEA LAGAHIT', 'Grade 9', 'cayalagahit.111984150001@sslg.edu.ph', 'N/A', '2025-02-26 07:11:28'),
('111984150003', 'MATA, SAIJAN DIAZ', 'Grade 9', 'matadiaz.111984150003@sslg.edu.ph', 'N/A', '2025-02-26 07:11:28'),
('111984150006', 'SAMLERO,JOHN CARLO, STA ROMANA', 'Grade 9', 'samlerojohnromana.111984150006@sslg.edu.ph', 'N/A', '2025-02-26 02:33:32'),
('111984150009', 'BRONCANO, ELUIZA MAY E.', 'Grade 9', 'broncanoe.111984150009@sslg.edu.ph', 'N/A', '2025-02-26 13:25:55'),
('111984150010', 'BRONCANO, JASMINE POMARIO', 'Grade 9', 'broncanopomario.111984150010@sslg.edu.ph', 'N/A', '2025-02-26 07:11:28'),
('111984150011', 'BRONCANO, XYRIEL ANNE R.', 'Grade 9', 'broncanor.111984150011@sslg.edu.ph', 'N/A', '2025-02-26 13:25:55'),
('111984150012', 'CANABAL, KYLA BELMONTE', 'Grade 9', 'canabalbelmonte.111984150012@sslg.edu.ph', 'N/A', '2025-02-26 07:11:28'),
('111984150013', 'CRUZ, KIM REONAL', 'Grade 9', 'cruzreonal.111984150013@sslg.edu.ph', 'N/A', '2025-02-26 07:11:28'),
('111984150015', 'DELA CRUZ,ANDREA MAE, COPE', 'Grade 9', 'delacope.111984150015@sslg.edu.ph', 'N/A', '2025-02-26 02:33:32'),
('111984150016', 'HERNANDEZ, ZAIRA NICOLE JOVEN', 'Grade 9', 'hernandezjoven.111984150016@sslg.edu.ph', 'N/A', '2025-02-26 07:11:28'),
('111984150018', 'RAGODON, CHLOE SABORDO', 'Grade 9', 'ragodonsabordo.111984150018@sslg.edu.ph', 'N/A', '2025-02-26 07:11:28'),
('111984150021', 'ROMAGOS,JOHN RAFAEL, RUBIANES', 'Grade 9', 'romagosjohnrubianes.111984150021@sslg.edu.ph', 'N/A', '2025-02-26 02:33:32'),
('111984150025', 'DELA CRUZ, EVOW B.', 'Grade 9', 'delab.111984150025@sslg.edu.ph', 'N/A', '2025-02-26 13:25:55'),
('111984150026', 'ECLEO, CHETO D.', 'Grade 9', 'ecleod.111984150026@sslg.edu.ph', 'N/A', '2025-02-26 13:25:55'),
('111984150027', 'HERNANDEZ,KURT MAVERICK, BARBOSA', 'Grade 9', 'hernandezkurtbarbosa.111984150027@sslg.edu.ph', 'N/A', '2025-02-26 02:33:32'),
('111984150032', 'BUENAVIDES,GERALDEN, RUBIANES', 'Grade 9', 'buenavidesgeraldenrubianes.111984150032@sslg.edu.ph', 'N/A', '2025-02-25 21:29:13'),
('111984150036', 'OBIDA,ALYANA JANE, JUTAJERO', 'Grade 9', 'obidaalyanajutajero.111984150036@sslg.edu.ph', 'N/A', '2025-02-26 02:33:32'),
('111984150037', 'PERILLO,JOANA, BARBOSA', 'Grade 9', 'perillojoanabarbosa.111984150037@sslg.edu.ph', 'N/A', '2025-02-25 21:29:13'),
('111984150038', 'RED,JELLIAN, GORONAL', 'Grade 9', 'redjelliangoronal.111984150038@sslg.edu.ph', 'N/A', '2025-02-25 21:29:13'),
('111984150039', 'SALEM, RACHELLE ANNE,', 'Grade 7', 'salemanne.111984150039@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('111984150045', 'DELA CRUZ, ANGELA B.', 'Grade 9', 'delab.111984150045@sslg.edu.ph', 'N/A', '2025-02-26 13:25:55'),
('111984150046', 'BARQUEZ,VINCENT JOREN, SACEDA', 'Grade 9', 'barquezvincentsaceda.111984150046@sslg.edu.ph', 'N/A', '2025-02-26 02:33:32'),
('111984150047', 'SARSALE,ASHANTI KAYE, BOLANO', 'Grade 9', 'sarsaleashantibolano.111984150047@sslg.edu.ph', 'N/A', '2025-02-25 21:29:13'),
('111984150048', 'CAYA,CHARLIE, JR LAGAHIT', 'Grade 9', 'cayacharlielagahit.111984150048@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111984150049', 'ORLAIN, ALJON LAWRENCE B.', 'Grade 9', 'orlainb.111984150049@sslg.edu.ph', 'N/A', '2025-02-26 13:25:55'),
('111984150051', 'BRONCANO,ELDRIN, ALCARAZ', 'Grade 9', 'broncanoeldrinalcaraz.111984150051@sslg.edu.ph', 'N/A', '2025-02-25 21:29:13'),
('111984160004', 'BERGANIO, JOHN PAUL SERGIO', 'Grade 7', 'berganiosergio.111984160004@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('111984160005', 'CAS ZAIDHAN B', 'Grade 8', 'casb.111984160005@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('111984160008', 'GONGORA, ZEIN CHARLES S.', 'Grade 8', 'gongoras.111984160008@sslg.edu.ph', 'N/A', '2025-02-26 13:48:43'),
('111984160009', 'LAJARA,CHESTER, ABANEL', 'Grade 10', 'lajarachesterabanel.111984160009@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('111984160010', 'Red , Joshua  G.', 'Grade 8', 'redg.111984160010@sslg.edu.ph', 'N/A', '2025-02-26 01:32:53'),
('111984160013', 'Vinas , Joel  Jr. S.', 'Grade 8', 'vinass.111984160013@sslg.edu.ph', 'N/A', '2025-02-26 01:32:53'),
('111984160015', 'RaÃ±a, John Leanard S.', 'Grade 8', 'raas.111984160015@sslg.edu.ph', 'N/A', '2025-02-26 12:49:01'),
('111984160021', 'Tanola , Shiela Mae  T.', 'Grade 8', 'tanolat.111984160021@sslg.edu.ph', 'N/A', '2025-02-26 01:32:54'),
('111984160023', 'Lagong, Rhianna B.', 'Grade 8', 'lagongb.111984160023@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111984160024', 'ATE, MARC RUELL', 'Grade 8', 'ateruell.111984160024@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('111984160025', 'Basabe, Zaijan I.', 'Grade 8', 'basabei.111984160025@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111984160026', 'Bodino,Aldrin James', 'Grade 8', 'bodinoaldrinjames.111984160026@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111984160033', 'Sapo, Harvey F.', 'Grade 8', 'sapof.111984160033@sslg.edu.ph', 'N/A', '2025-02-26 12:49:01'),
('111984160034', 'Sarion, Andrew james B.', 'Grade 8', 'sarionb.111984160034@sslg.edu.ph', 'N/A', '2025-02-26 12:49:01'),
('111984160035', 'Sarsale, Joshua James B.', 'Grade 8', 'sarsaleb.111984160035@sslg.edu.ph', 'N/A', '2025-02-26 12:49:01'),
('111984160036', 'Villanueva, Jody Jr. S.', 'Grade 8', 'villanuevas.111984160036@sslg.edu.ph', 'N/A', '2025-02-26 12:49:01'),
('111984160037', 'ABILA, HSYLA MAE S.', 'Grade 8', 'abilas.111984160037@sslg.edu.ph', 'N/A', '2025-02-26 13:48:43'),
('111984160039', 'Barbosa, Xyrel S.', 'Grade 8', 'barbosas.111984160039@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111984160040', 'BI?AN, PRINCESS L.', 'Grade 8', 'bianl.111984160040@sslg.edu.ph', 'N/A', '2025-02-26 13:48:43'),
('111984160045', 'Sarandon, Angel Nika M.', 'Grade 8', 'sarandonm.111984160045@sslg.edu.ph', 'N/A', '2025-02-26 12:49:01'),
('111984160046', 'ARMEA, ROMILYN M.', 'Grade 8', 'armeam.111984160046@sslg.edu.ph', 'N/A', '2025-02-26 13:48:43'),
('111984160047', 'Buenavides, Joanne R.', 'Grade 8', 'buenavidesr.111984160047@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111984160049', 'MALATE RENELYN', 'Grade 8', 'malaterenelyn.111984160049@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('111984160050', 'VEGA, KIAH A.', 'Grade 8', 'vegaa.111984160050@sslg.edu.ph', 'N/A', '2025-02-26 13:55:03'),
('111984170001', 'ABANEL, JOHN ELJAY,.', 'Grade 7', 'abaneleljay.111984170001@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('111984170004', 'CANARIA, MARK BALBIN', 'Grade 7', 'canariabalbin.111984170004@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('111984170005', 'CILOT ENDREI FERDZ DIMACUYA', 'Grade 7', 'cilotdimacuya.111984170005@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('111984170009', 'RIVERA, ALKHIN LOUIS NALICAT', 'Grade 7', 'riveranalicat.111984170009@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('111984170010', 'SABORDO JERVEY DIESTRO', 'Grade 7', 'sabordodiestro.111984170010@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('111984170011', 'SAÃ‘OSA,JOHN LOUIE, MUNDA', 'Grade 10', 'saosajohnmunda.111984170011@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('111984170014', 'VERGARA, JOHN DALE LOPEZ', 'Grade 7', 'vergaralopez.111984170014@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('111984170015', 'VILLACER, JOHN KEN VIÃ‘AS', 'Grade 7', 'villacervias.111984170015@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('111984170016', 'VIÃ‘AS, JAY MARK BAQUE', 'Grade 7', 'viasbaque.111984170016@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('111984170017', 'VIÃ‘AS, JEROME SANCHEZ', 'Grade 7', 'viassanchez.111984170017@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('111984170020', 'CARULLO, RICHEL, B.', 'Grade 7', 'carullob.111984170020@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('111984170021', 'DADUYA DAHNEA KARYLL ANCHETA', 'Grade 7', 'daduyaancheta.111984170021@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('111984170024', 'GARCIA, JESSICA BRONCANO', 'Grade 7', 'garciabroncano.111984170024@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('111984170026', 'PERILLO, ANGELINE BARBOSA', 'Grade 7', 'perillobarbosa.111984170026@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('111984170028', 'RED, JESYL JADE REGMALOS', 'Grade 7', 'redregmalos.111984170028@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('111984170030', 'SANDRO, JAQUIELYN, R.', 'Grade 7', 'sandror.111984170030@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('111984170032', 'VEGA, DANIELA MAE BOLANO', 'Grade 7', 'vegabolano.111984170032@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('111984170036', 'SARTURIO, PRINCESS ALEXA MAY, B.', 'Grade 7', 'sarturiob.111984170036@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('111984170037', 'OSMA IVAN RONCESVALLES', 'Grade 7', 'osmaroncesvalles.111984170037@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('111984170039', 'RAGODON, JEMWEL,', 'Grade 7', 'ragodonjemwel.111984170039@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('111984170044', 'TANAY, REYMARK MOLINA', 'Grade 7', 'tanaymolina.111984170044@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('111984170051', 'MONTAÃ‘EZ,MA ROSEGEL, -', 'Grade 10', 'montaezma.111984170051@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('111984170053', 'NIEBRES, REIN,', 'Grade 7', 'niebresrein.111984170053@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('111984170054', 'SALCEDO, JANELLE MAY,.', 'Grade 7', 'salcedomay.111984170054@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('111984170056', 'SARSALE, ASHIANA SHLEIN BOLANO', 'Grade 7', 'sarsalebolano.111984170056@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('111984170057', 'SARTURIO, MARIA ANGELINE INOLA', 'Grade 7', 'sarturioinola.111984170057@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('111984170058', 'SISTER, CHLOE SHARINA CENITA', 'Grade 7', 'sistercenita.111984170058@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('111984170061', 'ONRUBIA, ELLA MAE RUBIANES', 'Grade 7', 'onrubiarubianes.111984170061@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('111984260032', 'Rimbao, Troy', 'Grade 8', 'rimbaotroy.111984260032@sslg.edu.ph', 'N/A', '2025-02-26 12:49:01'),
('111985100018', 'MONTERAS,MARK SONNY, DE GUIA', 'Grade 9', 'monterasmarkguia.111985100018@sslg.edu.ph', 'N/A', '2025-02-25 21:29:13'),
('111985120003', 'SANTULLO,JOHN REY RAMILO', 'Grade 12', 'santullojohnramilo.111985120003@sslg.edu.ph', 'N/A', '2025-02-26 02:05:44'),
('111985120012', 'SALUDO,AMANDO JR MALINIS', 'Grade 12', 'saludoamandomalinis.111985120012@sslg.edu.ph', 'N/A', '2025-02-26 01:59:26'),
('111985120015', 'SARSALE,ARIES BOLANO', 'Grade 12', 'sarsaleariesbolano.111985120015@sslg.edu.ph', 'N/A', '2025-02-26 01:59:26'),
('111985120016', 'BOLANO,MARK ELY FERNANDEZ', 'Grade 12', 'bolanomarkfernandez.111985120016@sslg.edu.ph', 'N/A', '2025-02-26 01:59:26'),
('111985120019', 'CESTINA,ROSE ANN MARISCOTES', 'Grade 12', 'cestinarosemariscotes.111985120019@sslg.edu.ph', 'N/A', '2025-02-26 01:59:26'),
('111985130006', 'BARATILLA,REYNIER BELLEN', 'Grade 11', 'baratillareynierbellen.111985130006@sslg.edu.ph', 'N/A', '2025-02-26 00:37:46'),
('111985130007', 'CARLIT, ANGELO MONTERAS', 'Grade 11', 'carlitmonteras.111985130007@sslg.edu.ph', 'N/A', '2025-02-26 00:37:46'),
('111985130008', 'CESTINA, JOHN REY BATALLER', 'Grade 11', 'cestinabataller.111985130008@sslg.edu.ph', 'N/A', '2025-02-26 00:37:46'),
('111985130019', 'WASNON EARL JOSHUA BARATILLA', 'Grade 11', 'wasnonbaratilla.111985130019@sslg.edu.ph', 'N/A', '2025-02-26 00:37:46'),
('111985130026', 'MONTERAS, HACEL ANNE, BUELLA', 'Grade 10', 'monterasbuella.111985130026@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111985130028', 'SARSALE,CHRISTINE MAE BOLANO', 'Grade 11', 'sarsalechristinebolano.111985130028@sslg.edu.ph', 'N/A', '2025-02-25 21:20:51'),
('111985130041', 'MONTERAS DHAINE KURT BASE', 'Grade 11', 'monterasbase.111985130041@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('111985140005', 'BARIA,ANGELO, MORCO', 'Grade 10', 'bariaangelomorco.111985140005@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111985140006', 'Bejeno, John Carl -', 'Grade 10', 'bejeno.111985140006@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111985140007', 'DIESTRO,EMMAN CARLOS, CAGADOC', 'Grade 9', 'diestroemmancagadoc.111985140007@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111985140009', 'LANGA,ARON, RAMELO', 'Grade 10', 'langaaronramelo.111985140009@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111985140010', 'IBARRIENTOS,MARVIN, SANTULLO', 'Grade 10', 'ibarrientosmarvinsantullo.111985140010@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111985140012', 'Monteras, Justine C.', 'Grade 8', 'monterasc.111985140012@sslg.edu.ph', 'N/A', '2025-02-26 12:49:01'),
('111985140015', 'CARLIT, DANILLA MONTERAS', 'Grade 10', 'carlitmonteras.111985140015@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111985140017', 'CESTINA, RACHELLE B.', 'Grade 10', 'cestinab.111985140017@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('111985140018', 'ESTEMBER, STEPHANIE L.', 'Grade 10', 'estemberl.111985140018@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('111985140019', 'GAJILAN, JANIELLE T.', 'Grade 10', 'gajilant.111985140019@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('111985140020', 'OLASO, SARAH MAE M.', 'Grade 10', 'olasom.111985140020@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('111985140022', 'SARSALE,RICA MAE, BASE', 'Grade 10', 'sarsalericabase.111985140022@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111985150002', 'MONTERAS,MARK SHANE, BASE', 'Grade 9', 'monterasmarkbase.111985150002@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111985150003', 'VALIENTE,MARK JOHN, SARSALE', 'Grade 9', 'valientemarksarsale.111985150003@sslg.edu.ph', 'N/A', '2025-02-26 02:33:32'),
('111985150013', 'REGALARIO, ERIKA MAE B.', 'Grade 9', 'regalariob.111985150013@sslg.edu.ph', 'N/A', '2025-02-26 13:25:55'),
('111985150014', 'CESTINA,JANICE, NAVARRO', 'Grade 9', 'cestinajanicenavarro.111985150014@sslg.edu.ph', 'N/A', '2025-02-25 21:29:13'),
('111985150016', 'SANDAGON, NICOLE T.', 'Grade 9', 'sandagont.111985150016@sslg.edu.ph', 'N/A', '2025-02-26 13:25:55'),
('111985150017', 'SANDAGON, KRYSTAL T.', 'Grade 9', 'sandagont.111985150017@sslg.edu.ph', 'N/A', '2025-02-26 13:25:55'),
('111985150018', 'SARSALE,SHANE ALIYAH, BELMONTE', 'Grade 9', 'sarsaleshanebelmonte.111985150018@sslg.edu.ph', 'N/A', '2025-02-26 02:33:32'),
('111985150019', 'ALCALA,JILLIAN, DIAZ', 'Grade 9', 'alcalajilliandiaz.111985150019@sslg.edu.ph', 'N/A', '2025-02-26 02:33:32'),
('111985150020', 'BARATILLA,PRINCESS YVONE, BELEN', 'Grade 9', 'baratillaprincessbelen.111985150020@sslg.edu.ph', 'N/A', '2025-02-26 02:33:32'),
('111985150024', 'SALEM,KATHEN JOY, NOVA', 'Grade 9', 'salemkathennova.111985150024@sslg.edu.ph', 'N/A', '2025-02-26 02:33:32'),
('111985160004', 'Chavez, Angela', 'Grade 8', 'chavezangela.111985160004@sslg.edu.ph', 'N/A', '2025-02-26 12:49:01'),
('111985160009', 'Sandagon, Chuck Bruce C.', 'Grade 8', 'sandagonc.111985160009@sslg.edu.ph', 'N/A', '2025-02-26 12:49:01'),
('111985160013', 'Wasnon, Rizza Mae', 'Grade 8', 'wasnonmae.111985160013@sslg.edu.ph', 'N/A', '2025-02-26 12:49:01'),
('111985160014', 'Olaso, Josel O.', 'Grade 8', 'olasoo.111985160014@sslg.edu.ph', 'N/A', '2025-02-26 12:49:01'),
('111985160015', 'BARIA ANDREIM', 'Grade 8', 'bariaandreim.111985160015@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('111985170002', 'AUSTRIA, ERIC BOBIS', 'Grade 7', 'austriabobis.111985170002@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('111985170005', 'CAMONOGA, SONNY JR. D.', 'Grade 7', 'camonogad.111985170005@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('111985170008', 'MARILAG, MARK KERWIN,', 'Grade 7', 'marilagkerwin.111985170008@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('111985170010', 'REGALARIO, JORDAN, B.', 'Grade 7', 'regalariob.111985170010@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('111985170013', 'BARATILLA, MA GUENE,.', 'Grade 7', 'baratillaguene.111985170013@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('111985170015', 'BRITANICO.RONICA LYCA BIDOL', 'Grade 7', 'britanicoronicabidol.111985170015@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('111985170016', 'BOBIS,GERLIN MAE, BALASTA', 'Grade 10', 'bobisgerlinbalasta.111985170016@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('111985170018', 'CESTINA, AGNES NAVARRO', 'Grade 7', 'cestinanavarro.111985170018@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('111985170020', 'MONTERAS, KRISXIA MAE, C.', 'Grade 7', 'monterasc.111985170020@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('111986130008', 'AGUIRRE, HUNYLYN VISTA', 'Grade 11', 'aguirrevista.111986130008@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('111986140009', 'NEALEGA,ALREN MAE, AGUIRRE', 'Grade 10', 'nealegaalrenaguirre.111986140009@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111987110007', 'Canaria, Ryan Lester', 'Grade 10', 'canarialester.111987110007@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111987120002', 'BOBIS,JERWIN POLVORIZA', 'Grade 12', 'bobisjerwinpolvoriza.111987120002@sslg.edu.ph', 'N/A', '2025-02-25 22:19:19'),
('111987120006', 'CERILLO,JAMES BENEDICT CABILES', 'Grade 12', 'cerillojamescabiles.111987120006@sslg.edu.ph', 'N/A', '2025-02-25 22:19:19'),
('111987120014', 'ATANANTE,JOYCE VELASCO', 'Grade 12', 'atanantejoycevelasco.111987120014@sslg.edu.ph', 'N/A', '2025-02-25 22:19:19'),
('111987120016', 'CABLING,ANA FE BERCES', 'Grade 12', 'cablinganaberces.111987120016@sslg.edu.ph', 'N/A', '2025-02-25 22:19:19'),
('111987120019', 'ESTADO,MELISSA JANE LONTAYAO', 'Grade 12', 'estadomelissalontayao.111987120019@sslg.edu.ph', 'N/A', '2025-02-26 01:59:26'),
('111987120028', 'LAGUNO, JERWIN CANARIA', 'Grade 11', 'lagunocanaria.111987120028@sslg.edu.ph', 'N/A', '2025-02-25 14:54:33'),
('111987120031', 'RABAGO,ARRON JUSTINE MOIT', 'Grade 12', 'rabagoarronmoit.111987120031@sslg.edu.ph', 'N/A', '2025-02-26 01:59:26'),
('111987120040', 'NAVALES,NIANA MARIE DORIMON', 'Grade 12', 'navalesnianadorimon.111987120040@sslg.edu.ph', '', '2025-02-25 22:19:19'),
('111987130037', 'VILLAREAL, ANGELINE PEDRO', 'Grade 12', 'villarealpedro.111987130037@sslg.edu.ph', 'N/A', '2025-02-26 01:59:26'),
('111987130046', 'ILARDE,JOSHUA LAURAYA', 'Grade 11', 'ilardejoshualauraya.111987130046@sslg.edu.ph', 'N/A', '2025-02-26 00:37:46'),
('111987130063', 'MARTINEZ,JOYCE ANGELLA MAGBANUA', 'Grade 11', 'martinezjoycemagbanua.111987130063@sslg.edu.ph', 'N/A', '2025-02-25 21:20:51'),
('111987130073', 'PREME, MA. OFELIA SWW.', 'Grade 10', 'premesww.111987130073@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('111987130081', 'SARION,VAN OLIVER, -', 'Grade 10', 'sarionvan.111987130081@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('1119871400110', 'RAMBOYONG, AXCEL', 'Grade 8', 'ramboyongaxcel.1119871400110@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('111987140015', 'BULAWAN,MA JENITA BARAN', 'Grade 11', 'bulawanmabaran.111987140015@sslg.edu.ph', 'N/A', '2025-02-25 21:20:51'),
('111987140016', 'SABIDO,MATT REDDEN, BARATILLA', 'Grade 10', 'sabidomattbaratilla.111987140016@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111987140022', 'BORIGAS, JOEYLYN A.', 'Grade 10', 'borigasa.111987140022@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('111987140023', 'BATAN, JAMAICA S.', 'Grade 10', 'batans.111987140023@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('111987140025', 'Cabiles, Zaireen, Borigas', 'Grade 10', 'cabilesborigas.111987140025@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('111987140028', 'CERILLO,ALTHEA, CABILES', 'Grade 10', 'cerilloaltheacabiles.111987140028@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111987140030', 'RAMOS,ANGELA MONIQUE, BOTIAL', 'Grade 10', 'ramosangelabotial.111987140030@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111987140035', 'BEA,SANTINO, PADILLA', 'Grade 10', 'beasantinopadilla.111987140035@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111987140036', 'BUSA, REDEN, GUIRIÃ‘A', 'Grade 10', 'busaguiria.111987140036@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('111987140040', 'LAGGUI, DEXTER R.', 'Grade 10', 'lagguir.111987140040@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('111987140043', 'CEDRO,LYKA, GUIRIÃ‘A', 'Grade 10', 'cedrolykaguiria.111987140043@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('111987140045', 'OCSAN, CRISTEL, MARIÃ‘AS', 'Grade 10', 'ocsanmarias.111987140045@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('111987140047', 'SALAZAR, AILEEN L.', 'Grade 10', 'salazarl.111987140047@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('111987140049', 'Sanglay, Jasmine, Mariano', 'Grade 10', 'sanglaymariano.111987140049@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('111987140050', 'Villarosa, April Camille, Berces', 'Grade 10', 'villarosaberces.111987140050@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('111987150020', 'CALLOS, MARICAR M.', 'Grade 9', 'callosm.111987150020@sslg.edu.ph', 'N/A', '2025-02-26 13:25:55'),
('111987150025', 'MORA, ELAINE S.', 'Grade 9', 'moras.111987150025@sslg.edu.ph', 'N/A', '2025-02-26 13:25:55'),
('111987150026', 'SANGLAY, DAISY M.', 'Grade 9', 'sanglaym.111987150026@sslg.edu.ph', 'N/A', '2025-02-26 13:25:55'),
('111987150043', 'MORA, MARK JADE B.', 'Grade 9', 'morab.111987150043@sslg.edu.ph', 'N/A', '2025-02-26 13:25:55'),
('111987150057', 'POLVORIZA, JOHN MICHAEL CANARIA', 'Grade 9', 'polvorizacanaria.111987150057@sslg.edu.ph', 'N/A', '2025-02-26 07:11:28'),
('111987150058', 'Rambuyong, Aivan S.', 'Grade 8', 'rambuyongs.111987150058@sslg.edu.ph', 'N/A', '2025-02-26 12:49:01'),
('111987160004', 'Tuscano, Jim Carlo L.', 'Grade 8', 'tuscanol.111987160004@sslg.edu.ph', 'N/A', '2025-02-26 12:49:01'),
('111987160006', 'Batan, Jamila S.', 'Grade 8', 'batans.111987160006@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111987160013', 'Mella , Micaela  S.', 'Grade 8', 'mellas.111987160013@sslg.edu.ph', 'N/A', '2025-02-26 01:32:53'),
('111987160014', 'Capuz , Regina  E.', 'Grade 8', 'capuze.111987160014@sslg.edu.ph', 'N/A', '2025-02-26 01:32:53'),
('111987160016', 'BERCES, REYMOND MONTE', 'Grade 7', 'bercesmonte.111987160016@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52');
INSERT INTO `students` (`StudentID`, `FullName`, `Grade`, `Email`, `ContactNumber`, `CreatedAt`) VALUES
('111987160018', 'CANUEL JAMES-A', 'Grade 8', 'canueljamesa.111987160018@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('111987160019', 'SANEZ MARK JIMUEL', 'Grade 8', 'sanezjimuel.111987160019@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('111987160020', 'ZACARIAS, PETER NATHANIEL', 'Grade 8', 'zacariasnathaniel.111987160020@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('111987160022', 'Cenita , Janine  M.', 'Grade 8', 'cenitam.111987160022@sslg.edu.ph', 'N/A', '2025-02-26 01:32:53'),
('111987160023', 'Navales, Noahlyn D.', 'Grade 8', 'navalesd.111987160023@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111987160025', 'Caspi ,  Manny  B.', 'Grade 8', 'caspib.111987160025@sslg.edu.ph', 'N/A', '2025-02-26 01:32:53'),
('111987160026', 'Cabiles , Reymark  B.', 'Grade 8', 'cabilesb.111987160026@sslg.edu.ph', 'N/A', '2025-02-26 01:32:53'),
('111987160030', 'DE ASIS, JORISSAR', 'Grade 8', 'dejorissar.111987160030@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('111987170002', 'CABILES,CARL DAVE', 'Grade 7', 'cabilescarldave.111987170002@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('111987170016', 'CLET, MARIA GAUDENE, N.', 'Grade 7', 'cletn.111987170016@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('111987170022', 'AÃ‘ONUEVO, SEMION BENIGNO, B.', 'Grade 7', 'aonuevob.111987170022@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('111987170023', 'JOVEN, JHONELE NACE', 'Grade 7', 'jovennace.111987170023@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('111987170025', 'SALALIMA NAZARIOUS ISAAC-', 'Grade 7', 'salalimaisaac.111987170025@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('111987170028', 'BOCAYA, CASANDRA LEA MATRIZ', 'Grade 7', 'bocayamatriz.111987170028@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('111987170031', 'SARION, ZHABRINA FHAYE PANTE', 'Grade 7', 'sarionpante.111987170031@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('111987170033', 'MARTINEZ, MAXINE, P.', 'Grade 7', 'martinezp.111987170033@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('111987170037', 'VERAS, MARLAH PAGLINAWAN', 'Grade 7', 'veraspaglinawan.111987170037@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('111987170038', 'VIBARES, MARY JOY C.', 'Grade 7', 'vibaresc.111987170038@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('111987170040', 'ENCEPTO, JESSA MAE UMANDUM', 'Grade 7', 'enceptoumandum.111987170040@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('111987170041', 'SAÃ‘EZ, JUSTINE, O.', 'Grade 7', 'saezo.111987170041@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('111989110003', 'BODINO,MONICA LABID', 'Grade 12', 'bodinomonicalabid.111989110003@sslg.edu.ph', 'N/A', '2025-02-25 22:19:19'),
('111989120004', 'SABIDO,RHOVIC MELGAR', 'Grade 12', 'sabidorhovicmelgar.111989120004@sslg.edu.ph', 'N/A', '2025-02-25 22:19:19'),
('111989120014', 'TOLOSA,MONICA JANE BARRAMEDA', 'Grade 11', 'tolosamonicabarrameda.111989120014@sslg.edu.ph', 'N/A', '2025-02-25 21:20:51'),
('111989120016', 'BALAURO,CYRUS JASPER MORA', 'Grade 12', 'balaurocyrusmora.111989120016@sslg.edu.ph', 'N/A', '2025-02-25 22:19:19'),
('111989120018', 'CATANGUI,JHON KENNETH, CERILLANO', 'Grade 9', 'catanguijhoncerillano.111989120018@sslg.edu.ph', 'N/A', '2025-02-26 02:33:32'),
('111989120021', 'LOPEZ,JAVIER JR LOYOLA', 'Grade 12', 'lopezjavierloyola.111989120021@sslg.edu.ph', 'N/A', '2025-02-26 01:59:26'),
('111989120031', 'BAGASALA,SOPHIA ROSE LOPEZ', 'Grade 12', 'bagasalasophialopez.111989120031@sslg.edu.ph', 'N/A', '2025-02-26 01:59:26'),
('111989120038', 'SANTOS,CHARMAINE LOYOLA', 'Grade 12', 'santoscharmaineloyola.111989120038@sslg.edu.ph', 'N/A', '2025-02-26 01:59:26'),
('111989120039', 'TABUITE,ANGELA BAGASALA', 'Grade 12', 'tabuiteangelabagasala.111989120039@sslg.edu.ph', 'N/A', '2025-02-26 01:59:26'),
('111989130022', 'SABIDO,ALHEA GAITE', 'Grade 12', 'sabidoalheagaite.111989130022@sslg.edu.ph', '', '2025-02-25 22:19:19'),
('111989130026', 'AREVALO, LYKA MAE OPEÃ‘A', 'Grade 11', 'arevaloopea.111989130026@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('111989130030', 'LOBOS, JEEN RAY BERIÃ‘A', 'Grade 11', 'lobosberia.111989130030@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('111989130035', 'ORCALES, JOHN KENITH POLVORIZA', 'Grade 11', 'orcalespolvoriza.111989130035@sslg.edu.ph', 'N/A', '2025-02-26 00:37:46'),
('111989130036', 'SAÃ‘ADO,YVAN DACUYA', 'Grade 11', 'saadoyvandacuya.111989130036@sslg.edu.ph', 'N/A', '2025-02-25 21:20:51'),
('111989130043', 'VIÃ‘AS, JHAN JHAN NABONG', 'Grade 11', 'viasnabong.111989130043@sslg.edu.ph', 'N/A', '2025-02-26 00:37:46'),
('111989130046', 'DIGAY, JOHN CEDRIC LANGCAWON', 'Grade 11', 'digaylangcawon.111989130046@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('111989130047', 'BODINO,NARISSA LABID', 'Grade 11', 'bodinonarissalabid.111989130047@sslg.edu.ph', 'N/A', '2025-02-25 21:20:51'),
('111989130056', 'REMANDO,MYREL SARION', 'Grade 11', 'remandomyrelsarion.111989130056@sslg.edu.ph', 'N/A', '2025-02-25 21:20:51'),
('111989140002', 'RUBIANES, YOHANE RAFAEL SALEM', 'Grade 11', 'rubianessalem.111989140002@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('111989140005', 'AQUINO,VINCE JOSEPH, MORA', 'Grade 9', 'aquinovincemora.111989140005@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111989140006', 'BAGASALA, JASTINE L.', 'Grade 10', 'bagasalal.111989140006@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('111989140007', 'BAGASALA,KENJIE DREW, ESCASINAS', 'Grade 10', 'bagasalakenjieescasinas.111989140007@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111989140008', 'BALAURO, JOHN MKIGUEL M.', 'Grade 10', 'balaurom.111989140008@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('111989140009', 'BALLARAN, ELJAY B.', 'Grade 9', 'ballaranb.111989140009@sslg.edu.ph', 'N/A', '2025-02-26 13:25:55'),
('111989140010', 'BALLARAN,JOHN DAVID, BASABE', 'Grade 10', 'ballaranjohnbasabe.111989140010@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111989140011', 'BUIZON,MARVIN JAY, LOBO', 'Grade 10', 'buizonmarvinlobo.111989140011@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111989140015', 'DEYTO,MARK CRISTIAN, BAÃ‘ARES', 'Grade 10', 'deytomarkbaares.111989140015@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111989140026', 'SARANDON,NATHAN ANGELO, -', 'Grade 10', 'sarandonnathan.111989140026@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111989140032', 'BAROTILLA, JASMINE, SARALDE', 'Grade 10', 'barotillasaralde.111989140032@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111989140034', 'Bolima, Roselyn, Tabayag', 'Grade 10', 'bolimatabayag.111989140034@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('111989140036', 'CALBILO, ZYRA C.', 'Grade 10', 'calbiloc.111989140036@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('111989140044', 'PIÃ‘ON, BABE JEAN, MAGALONA', 'Grade 10', 'pionmagalona.111989140044@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('111989140045', 'PIÃ‘ON,DANICAH, BODINO', 'Grade 10', 'piondanicahbodino.111989140045@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111989140046', 'RAGODON, GLAIREX ANGEL B.', 'Grade 10', 'ragodonb.111989140046@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('111989140047', 'REMANDO,MYKA, SARION', 'Grade 10', 'remandomykasarion.111989140047@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('111989140048', 'SANTOS,ANGELICA, LOYOLA', 'Grade 10', 'santosangelicaloyola.111989140048@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('111989140049', 'TABAYAG, SARAH NICOLE, SAMANIEGO', 'Grade 10', 'tabayagsamaniego.111989140049@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('111989140051', 'TUSCANO, KRIZZIA, BIA', 'Grade 10', 'tuscanobia.111989140051@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('111989150003', 'BORROMEO,EUGENE, LLAGONO', 'Grade 9', 'borromeoeugenellagono.111989150003@sslg.edu.ph', 'N/A', '2025-02-25 21:29:13'),
('111989150006', 'LOYOLA,KYLLE JUSTINE, GAJETO', 'Grade 9', 'loyolakyllegajeto.111989150006@sslg.edu.ph', 'N/A', '2025-02-26 02:33:32'),
('111989150008', 'RAGODON,JOSH, ARCEGA', 'Grade 9', 'ragodonjosharcega.111989150008@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111989150009', 'REFORSADO,RENZO,', 'Grade 9', 'reforsadorenzoreforsadorenzo.111989150009@sslg.edu.ph', 'N/A', '2025-02-25 21:29:13'),
('111989150010', 'SALCEDA, JIAN FRETZ MORA', 'Grade 9', 'salcedamora.111989150010@sslg.edu.ph', 'N/A', '2025-02-26 07:11:28'),
('111989150011', 'SAPO, JOHN REY R.', 'Grade 9', 'sapor.111989150011@sslg.edu.ph', 'N/A', '2025-02-26 13:25:55'),
('111989150013', 'TABUETE, CHRISTIAN BAGASALA', 'Grade 9', 'tabuetebagasala.111989150013@sslg.edu.ph', 'N/A', '2025-02-26 07:11:28'),
('111989150014', 'BARRAMEDA,STEFFANY SHIEN, MELLA', 'Grade 9', 'barramedasteffanymella.111989150014@sslg.edu.ph', 'N/A', '2025-02-25 21:29:13'),
('111989150015', 'BONDALO, VIEN ALKEA RAÃ‘ADA', 'Grade 9', 'bondaloraada.111989150015@sslg.edu.ph', 'N/A', '2025-02-26 07:11:28'),
('111989150020', 'SANADO, RHIANN', 'Grade 9', 'sanadorhiann.111989150020@sslg.edu.ph', 'N/A', '2025-02-26 13:25:55'),
('111989150022', 'SARALDE, LADY ANNE A.', 'Grade 9', 'saraldea.111989150022@sslg.edu.ph', 'N/A', '2025-02-26 13:25:55'),
('111989150023', 'TOLOSA, RIECY JOY,.', 'Grade 7', 'tolosajoy.111989150023@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('111989150026', 'FABIA, SHELA MAE BAÃ‘ARES', 'Grade 9', 'fabiabaares.111989150026@sslg.edu.ph', 'N/A', '2025-02-26 07:11:28'),
('111989160001', 'Barrameda, Jacob Loyola', 'Grade 8', 'barramedaloyola.111989160001@sslg.edu.ph', 'N/A', '2025-02-26 12:49:01'),
('111989160002', 'Bodino, John Lorenz C.', 'Grade 8', 'bodinoc.111989160002@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111989160003', 'OLASO, JAN JANSEN A', 'Grade 8', 'olasoa.111989160003@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('111989160004', 'ROXAS, EDMOND JR. B.', 'Grade 8', 'roxasb.111989160004@sslg.edu.ph', 'N/A', '2025-02-26 13:48:43'),
('111989160005', 'Salceda, Jairuz John M.', 'Grade 8', 'salcedam.111989160005@sslg.edu.ph', 'N/A', '2025-02-26 12:49:01'),
('111989160008', 'ViÃ±as, Clarence R.', 'Grade 8', 'viasr.111989160008@sslg.edu.ph', 'N/A', '2025-02-26 12:49:01'),
('111989160010', 'BI?AN, CHRISHA MAE N.', 'Grade 8', 'biann.111989160010@sslg.edu.ph', 'N/A', '2025-02-26 13:48:43'),
('111989160012', 'Loyola , Axel Joy  T.', 'Grade 8', 'loyolat.111989160012@sslg.edu.ph', 'N/A', '2025-02-26 01:32:53'),
('111989160013', 'MOLANO, VERRA MAE M.', 'Grade 8', 'molanom.111989160013@sslg.edu.ph', 'N/A', '2025-02-26 13:55:03'),
('111989160014', 'Nialega, Princess Ivy V.', 'Grade 8', 'nialegav.111989160014@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111989160017', 'RA?ADA, KIM JILLIAN P.', 'Grade 8', 'raadap.111989160017@sslg.edu.ph', 'N/A', '2025-02-26 13:55:03'),
('111989160018', 'RA?ADA, KIM JULLIAN P.', 'Grade 8', 'raadap.111989160018@sslg.edu.ph', 'N/A', '2025-02-26 13:55:03'),
('111989160020', 'SANTOS, LEZIEL L.', 'Grade 8', 'santosl.111989160020@sslg.edu.ph', 'N/A', '2025-02-26 13:55:03'),
('111989160021', 'Tolosa, Trisha Kaye M.', 'Grade 8', 'tolosam.111989160021@sslg.edu.ph', 'N/A', '2025-02-26 12:49:01'),
('111989160022', 'ESPLANA ANGELITO', 'Grade 8', 'esplanaangelito.111989160022@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('111989160023', 'BALLARAN,EDCEL, BONGCALOS', 'Grade 10', 'ballaranedcelbongcalos.111989160023@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('111989160024', 'REODIQUE, CLEA N.', 'Grade 8', 'reodiquen.111989160024@sslg.edu.ph', 'N/A', '2025-02-26 13:55:03'),
('111989170002', 'AZARCON,MARC ARJAY, CEPE', 'Grade 10', 'azarconmarccepe.111989170002@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('111989170003', 'BAGASALA, RUEL,', 'Grade 7', 'bagasalaruel.111989170003@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('111989170004', 'BARQUEZ, HYACINTH JUDE,', 'Grade 7', 'barquezjude.111989170004@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('111989170005', 'BOLIMA, JOHN REYMART, T.', 'Grade 7', 'bolimat.111989170005@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('111989170006', 'BONDALO,VINCENT JOBEN, RANADA', 'Grade 10', 'bondalovincentranada.111989170006@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('111989170007', 'BORROMEO, UAN LLAGONO', 'Grade 7', 'borromeollagono.111989170007@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('111989170010', 'NARIS,KEIAN, SALEM', 'Grade 10', 'nariskeiansalem.111989170010@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('111989170012', 'PIÃ‘ON, DAVE BALINGBING', 'Grade 7', 'pionbalingbing.111989170012@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('111989170014', 'REFORSADO, MARK JACOB,', 'Grade 7', 'reforsadojacob.111989170014@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('111989170015', 'SABIDO JAY MARK GAITE', 'Grade 7', 'sabidogaite.111989170015@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('111989170016', 'SAÃ‘ADO, RYAN JR, D.', 'Grade 7', 'saadod.111989170016@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('111989170017', 'TABAYAG,DAVE AREST, REFORMADO', 'Grade 10', 'tabayagdavereformado.111989170017@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('111989170019', 'BINAN, ERICA ????,', 'Grade 7', 'binan.111989170019@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('111989170022', 'DEYTO, MARICRIS,', 'Grade 7', 'deytomaricris.111989170022@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('111989170023', 'LOBOS,RIZALIE JANE, BERIÃ‘A', 'Grade 10', 'lobosrizalieberia.111989170023@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('111989170025', 'REFORSADO, ANGELICA SANTOS', 'Grade 7', 'reforsadosantos.111989170025@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('111989170026', 'SAPO , ROSE LYN RIPARIP', 'Grade 7', 'saporiparip.111989170026@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('111989170027', 'SARALDE,SHAME KYLA, MONTERO', 'Grade 10', 'saraldeshamemontero.111989170027@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('111989170028', 'TABAYAG, ALTHEA,', 'Grade 7', 'tabayagalthea.111989170028@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('111989170029', 'TORALDE, CHIN HEART BULANO', 'Grade 7', 'toraldebulano.111989170029@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('111989170031', 'REYES,RACE, -', 'Grade 10', 'reyesrace.111989170031@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('111989170033', 'TORALDE,JUSTINE, LANGCAWON', 'Grade 10', 'toraldejustinelangcawon.111989170033@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('111990120002', 'BELLEN,PRINCE DAVE YAGO', 'Grade 12', 'bellenprinceyago.111990120002@sslg.edu.ph', 'N/A', '2025-02-26 01:59:26'),
('111990120028', 'GONZALES,JOHN MICHAEL BENAVENTE', 'Grade 12', 'gonzalesjohnbenavente.111990120028@sslg.edu.ph', 'N/A', '2025-02-26 02:05:44'),
('111990130096', 'MENGUITO,JHIESIL MAE YAGO', 'Grade 12', 'menguitojhiesilyago.111990130096@sslg.edu.ph', '', '2025-02-25 22:19:19'),
('111990140020', 'VALENZUELA, BRYAN CORBILLA', 'Grade 11', 'valenzuelacorbilla.111990140020@sslg.edu.ph', 'N/A', '2025-02-26 00:37:46'),
('111990140024', 'BODINO, CLARISE B.', 'Grade 10', 'bodinob.111990140024@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('111990140032', 'PEREZ,MARK KHEISLER, BADONG', 'Grade 10', 'perezmarkbadong.111990140032@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111990140036', 'BELLEN,DARYL, VERGARA', 'Grade 10', 'bellendarylvergara.111990140036@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111990140039', 'VILLAMOR,RENEIR MIKE, CERDENIO', 'Grade 10', 'villamorreneircerdenio.111990140039@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111990140041', 'AGUIRRE, ZAIRA MAE, MORA', 'Grade 10', 'aguirremora.111990140041@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('111990140046', 'ORIBIANA,RHEA ANN, SATIADA', 'Grade 10', 'oribianarheasatiada.111990140046@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111990140047', 'BroÃ±osa, Emmie, Cestina', 'Grade 10', 'broosacestina.111990140047@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('111990140051', 'VALENZUELA,JOVELYN, BOLIMA', 'Grade 10', 'valenzuelajovelynbolima.111990140051@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111990150002', 'AGUIRRE,NIETHAN, MORA', 'Grade 9', 'aguirreniethanmora.111990150002@sslg.edu.ph', 'N/A', '2025-02-25 21:29:13'),
('111990150011', 'BARNIDO,RAIZA MAE, BOLIMA', 'Grade 9', 'barnidoraizabolima.111990150011@sslg.edu.ph', 'N/A', '2025-02-25 21:29:13'),
('111990150018', 'ENRIQUEZ,KAITLIN, CEREZO', 'Grade 9', 'enriquezkaitlincerezo.111990150018@sslg.edu.ph', 'N/A', '2025-02-26 02:33:32'),
('111990160012', 'MENGUITO, SAIRA SHEIN Y.', 'Grade 8', 'menguitoy.111990160012@sslg.edu.ph', 'N/A', '2025-02-26 13:55:03'),
('111990170001', 'BALISA, DOMINIQUE,', 'Grade 7', 'balisadominique.111990170001@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('111990170008', 'CEREZO, KIAN, C.', 'Grade 7', 'cerezoc.111990170008@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('111990170009', 'ENRIQUEZ, KEITH RUSELL CEREZO', 'Grade 7', 'enriquezcerezo.111990170009@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('111990170010', 'GONZALES,MIKE JOSEPH, BENAVENTE', 'Grade 10', 'gonzalesmikebenavente.111990170010@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('111990170013', 'VALENZUELA, A-JAY,.', 'Grade 7', 'valenzuelaajay.111990170013@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('111990170016', 'AGUIRRE NATAHLIE MORA', 'Grade 7', 'aguirremora.111990170016@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('111990170019', 'BODINO,ROSALYN, BARRA', 'Grade 10', 'bodinorosalynbarra.111990170019@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('111990170021', 'BROÃ‘OSA, KIM, C.', 'Grade 7', 'broosac.111990170021@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('111990170028', 'VILLAMOR,RIZZA MAE, CERDENIO', 'Grade 10', 'villamorrizzacerdenio.111990170028@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('111993120010', 'BALLARAN,JOYLA MAE FRANCISCO', 'Grade 12', 'ballaranjoylafrancisco.111993120010@sslg.edu.ph', 'N/A', '2025-02-26 01:59:26'),
('111993120017', 'BENDAÃ‘A, HAROLD ODOÃ‘O', 'Grade 11', 'bendaaodoo.111993120017@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('111993130008', 'CONTANTE, ROGIE VIÃ‘AS', 'Grade 11', 'contantevias.111993130008@sslg.edu.ph', 'N/A', '2025-02-25 14:54:33'),
('111993130009', 'CONTANTE, ROGIE VIÃ‘AS', 'Grade 11', 'contantevias.111993130009@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('111993130011', 'ORLAIN, CHRISTIAN CELESTINO', 'Grade 11', 'orlaincelestino.111993130011@sslg.edu.ph', 'N/A', '2025-02-26 00:37:46'),
('111993130015', 'BALLARAN,LYKA JOY ALBANIA', 'Grade 11', 'ballaranlykaalbania.111993130015@sslg.edu.ph', 'N/A', '2025-02-25 21:20:51'),
('111993130017', 'BAUTISTA, JESSICA, ELYAYA', 'Grade 10', 'bautistaelyaya.111993130017@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('111993130018', 'BEJENO,JESSA MAE BELMONTE', 'Grade 11', 'bejenojessabelmonte.111993130018@sslg.edu.ph', 'N/A', '2025-02-25 21:20:51'),
('111993130021', 'CONTANTE,HAZEL MAE BRIONES', 'Grade 11', 'contantehazelbriones.111993130021@sslg.edu.ph', 'N/A', '2025-02-25 21:20:51'),
('111993140002', 'BENDAÃ‘A,MARK GENIO, BARIA', 'Grade 10', 'bendaamarkbaria.111993140002@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111993140003', 'ENCILA,KYLE ANDREI, BELGA', 'Grade 10', 'encilakylebelga.111993140003@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111993140004', 'LISITIVO, JOHN MARK B.', 'Grade 10', 'lisitivob.111993140004@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('111993140007', 'MUSA,NIEL JOHN WARREN, RELLEVE', 'Grade 10', 'musanielrelleve.111993140007@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111993140010', 'Redelicia, Louie Albert, Caballo', 'Grade 10', 'redeliciacaballo.111993140010@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('111993140020', 'RELLEVE, LEVY ROSE, BANZUELA', 'Grade 10', 'rellevebanzuela.111993140020@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('111993150002', 'BALLARAN,JHON CARLO, ESTEBAN', 'Grade 9', 'ballaranjhonesteban.111993150002@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111993150003', 'BALLARAN,JOHN NOMEL, BO', 'Grade 9', 'ballaranjohnbo.111993150003@sslg.edu.ph', 'N/A', '2025-02-26 02:33:32'),
('111993150008', 'FRAGINAL, JHON RIBEN B.', 'Grade 9', 'fraginalb.111993150008@sslg.edu.ph', 'N/A', '2025-02-26 13:25:55'),
('111993150009', 'BELGA,CHRISTIAN LORENCE, PRIEL', 'Grade 9', 'belgachristianpriel.111993150009@sslg.edu.ph', 'N/A', '2025-02-26 02:33:32'),
('111993150016', 'BELCHES, MARIA ANGELA EPIFANIO', 'Grade 9', 'belchesepifanio.111993150016@sslg.edu.ph', 'N/A', '2025-02-26 07:11:28'),
('111993150017', 'CANARIA, RHEANA SHANE CORRALES', 'Grade 9', 'canariacorrales.111993150017@sslg.edu.ph', 'N/A', '2025-02-26 07:11:28'),
('111993150021', 'MAGBAGO,ZYRIL ROSE, CONTANTE', 'Grade 9', 'magbagozyrilcontante.111993150021@sslg.edu.ph', 'N/A', '2025-02-26 02:33:32'),
('111993150023', 'RELLEVE,SAMANTHA ASHLEY, PERINA', 'Grade 9', 'rellevesamanthaperina.111993150023@sslg.edu.ph', 'N/A', '2025-02-26 02:33:32'),
('111993150025', 'SERDON,LOVELY, ORLAIN', 'Grade 9', 'serdonlovelyorlain.111993150025@sslg.edu.ph', 'N/A', '2025-02-26 02:33:32'),
('111993160001', 'BALAURO-JAMES-ANGELOW', 'Grade 8', 'balaurojamesangelowbalaurojamesangelow.111993160001@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('111993160002', 'Ballaran , Mark Jonel  B.', 'Grade 8', 'ballaranb.111993160002@sslg.edu.ph', 'N/A', '2025-02-26 01:32:53'),
('111993160003', 'BELGA, ANGELO GABRIEL B.', 'Grade 8', 'belgab.111993160003@sslg.edu.ph', 'N/A', '2025-02-26 13:48:43'),
('111993160005', 'Labadora, Orlando Jr. Balauro', 'Grade 8', 'labadorabalauro.111993160005@sslg.edu.ph', 'N/A', '2025-02-26 12:49:01'),
('111993160006', 'MALTO, JOHN LESTER B.', 'Grade 8', 'maltob.111993160006@sslg.edu.ph', 'N/A', '2025-02-26 13:48:43'),
('111993160007', 'Redelicia, Reymond P.', 'Grade 8', 'redeliciap.111993160007@sslg.edu.ph', 'N/A', '2025-02-26 12:49:01'),
('111993160012', 'NIPAS, ISABELLA B', 'Grade 8', 'nipasb.111993160012@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('111993160014', 'SALIMBAO, CLARIBELLE M.', 'Grade 8', 'salimbaom.111993160014@sslg.edu.ph', 'N/A', '2025-02-26 13:55:03'),
('111993160017', 'PENOLIO, CRIS JULIAN B.', 'Grade 8', 'penoliob.111993160017@sslg.edu.ph', 'N/A', '2025-02-26 13:48:43'),
('111993170002', 'SANORJO, CRISHA MAE, R.', 'Grade 7', 'sanorjor.111993170002@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('111993170005', 'LOYOLA,DIVINE, BELGA', 'Grade 10', 'loyoladivinebelga.111993170005@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('111993170006', 'CONTANTE MA. ELOISA BRIONES', 'Grade 7', 'contantebriones.111993170006@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('111993170008', 'BELGA,BRENA JOY, COLARINA', 'Grade 10', 'belgabrenacolarina.111993170008@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('111993170009', 'VALDIVIA, LEMUEL ORLAIN', 'Grade 7', 'valdiviaorlain.111993170009@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('111993170010', 'LISITIVO LORIE MARIE BAÃ‘ARES', 'Grade 7', 'lisitivobaares.111993170010@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('111993170011', 'WASNON, RANIEL BARATILLA', 'Grade 7', 'wasnonbaratilla.111993170011@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('111993170013', 'REDELICIA, MARK KEVIN SABEROLA', 'Grade 7', 'redeliciasaberola.111993170013@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('111993170016', 'BELGA, ASH LINARD VIÃ‘AS', 'Grade 7', 'belgavias.111993170016@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('111993170017', 'BEJENO,DANIEL, REDELICIA', 'Grade 10', 'bejenodanielredelicia.111993170017@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('111993170018', 'VERGARA, SEAN DENVER BELGA', 'Grade 7', 'vergarabelga.111993170018@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('111993170019', 'TOLEDO, RHENJAY AGUIRRE', 'Grade 7', 'toledoaguirre.111993170019@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('111993170023', 'BAROTIA, BASER DENJAR VIRATA', 'Grade 7', 'barotiavirata.111993170023@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('111993170026', 'MALAZA, MARK CHRISTIAN, B.', 'Grade 7', 'malazab.111993170026@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('111994120049', 'CAMORAL,KRISCEL ORLAIN', 'Grade 12', 'camoralkriscelorlain.111994120049@sslg.edu.ph', 'N/A', '2025-02-25 22:19:19'),
('111994130007', 'MADRELEJOS,JHANRY MARILAG', 'Grade 12', 'madrelejosjhanrymarilag.111994130007@sslg.edu.ph', 'N/A', '2025-02-25 22:19:19'),
('111994140007', 'BAS, BRYAN PAULE', 'Grade 11', 'baspaule.111994140007@sslg.edu.ph', 'N/A', '2025-02-26 00:37:46'),
('111994140012', 'BERIDO, GERSON A.', 'Grade 10', 'beridoa.111994140012@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('111994140016', 'Pomario, Boboy, Orlain', 'Grade 10', 'pomarioorlain.111994140016@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('111994140020', 'BAS,PRECIOUS RAYNE, -', 'Grade 10', 'basprecious.111994140020@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111994140022', 'BAYNADO,MYLENE, BARCOMA', 'Grade 10', 'baynadomylenebarcoma.111994140022@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111994150011', 'POMARIO,JANSEN, MALATE', 'Grade 9', 'pomariojansenmalate.111994150011@sslg.edu.ph', 'N/A', '2025-02-25 21:29:13'),
('111994160003', 'Borja, Jay-ar Barbosa', 'Grade 8', 'borjabarbosa.111994160003@sslg.edu.ph', 'N/A', '2025-02-26 12:49:01'),
('111994160009', 'BELLEN, OONABEL B', 'Grade 8', 'bellenb.111994160009@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('111994160024', 'DACUYA, EDRIAN B.', 'Grade 8', 'dacuyab.111994160024@sslg.edu.ph', 'N/A', '2025-02-26 13:48:43'),
('111994170004', 'BAYNADO,JEMALYN, BARCOMA', 'Grade 10', 'baynadojemalynbarcoma.111994170004@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('111995130143', 'SARION,RIAN MAE, SODSOD', 'Grade 10', 'sarionriansodsod.111995130143@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111995140114', 'WU,JAKE, BOCAYA', 'Grade 10', 'wujakebocaya.111995140114@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111995140178', 'BROTONEL,GABRIELLA', 'Grade 10', 'brotonelgabriellabrotonelgabriella.111995140178@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('111995150136', 'CAAYAO, CARL JUSTINE, MONGCAL', 'Grade 10', 'caayaomongcal.111995150136@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('1119951600100', 'MONTERAS ZYRENE OR', 'Grade 8', 'monterasor.1119951600100@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('111995160099', 'Sandro , Kert Lexter  I.', 'Grade 8', 'sandroi.111995160099@sslg.edu.ph', 'N/A', '2025-02-26 01:32:53'),
('111995170135', 'SALIRE, GABRIEL ARENAS', 'Grade 7', 'salirearenas.111995170135@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('111998110001', 'ALCANTARA,ANGELO MORALEDA', 'Grade 12', 'alcantaraangelomoraleda.111998110001@sslg.edu.ph', 'N/A', '2025-02-26 02:05:44'),
('111998120006', 'CAMO,JERRYCHO MORALIDA', 'Grade 12', 'camojerrychomoralida.111998120006@sslg.edu.ph', 'N/A', '2025-02-26 02:05:44'),
('111998130010', 'EUBRA,MERRY JOY MARAÃ‘O', 'Grade 11', 'eubramerrymarao.111998130010@sslg.edu.ph', 'N/A', '2025-02-25 21:20:51'),
('111998140018', 'PERDIGONES,EJAY, MONTALBO', 'Grade 9', 'perdigonesejaymontalbo.111998140018@sslg.edu.ph', 'N/A', '2025-02-25 21:29:13'),
('111998150004', 'Bolano , John Mark', 'Grade 8', 'bolanomark.111998150004@sslg.edu.ph', 'N/A', '2025-02-26 01:32:53'),
('111998160005', 'PERDIGONES, MIKE DENIEL', 'Grade 8', 'perdigonesdeniel.111998160005@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('111998160006', 'Rabelas, Mark Josh M.', 'Grade 8', 'rabelasm.111998160006@sslg.edu.ph', 'N/A', '2025-02-26 12:49:01'),
('111998160007', 'Samalea  , Al  C.', 'Grade 8', 'samaleac.111998160007@sslg.edu.ph', 'N/A', '2025-02-26 01:32:53'),
('111998160013', 'MADRELIJOS, JANNETH', 'Grade 8', 'madrelijosjanneth.111998160013@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('111998160014', 'ROSALDO.TRICIA MARIE CALBELO', 'Grade 7', 'rosaldotriciacalbelo.111998160014@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('111998170003', 'BEJERANO, GILBERT, B.', 'Grade 7', 'bejeranob.111998170003@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('111998170007', 'MINA KIRBY BRONIA', 'Grade 7', 'minabronia.111998170007@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('111998170009', 'ROMERO, MARC DANIELLE,', 'Grade 7', 'romerodanielle.111998170009@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('111998170013', 'DIO, JANINE PERDIGONES', 'Grade 7', 'dioperdigones.111998170013@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('111998170015', 'KATIGBAK, MYLEN,.', 'Grade 7', 'katigbakmylen.111998170015@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('111998170016', 'MORALEDA, SARAH JANE, B.', 'Grade 7', 'moraledab.111998170016@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('112007130050', 'CATANGUI,JAMAICA BODINO', 'Grade 11', 'catanguijamaicabodino.112007130050@sslg.edu.ph', 'N/A', '2025-02-25 21:20:51'),
('112007150068', 'CALIG,RACHELLE MAE, CAMONOGA', 'Grade 9', 'caligrachellecamonoga.112007150068@sslg.edu.ph', 'N/A', '2025-02-25 21:29:13'),
('112009140072', 'BALTAR,REDEL, AMANTE', 'Grade 9', 'baltarredelamante.112009140072@sslg.edu.ph', 'N/A', '2025-02-25 21:29:13'),
('112011140188', 'NORIEGA,ERIC JAY, BALANA', 'Grade 10', 'noriegaericbalana.112011140188@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('112011140276', 'RECIPROCO, JAMES G.', 'Grade 10', 'reciprocog.112011140276@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('112062150035', 'PE?A, JAKE JOSHUA MORA', 'Grade 9', 'peamora.112062150035@sslg.edu.ph', 'N/A', '2025-02-26 07:11:28'),
('112389140039', 'SABROSO, MARIAN, ALCOY', 'Grade 10', 'sabrosoalcoy.112389140039@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('112390140186', 'Resurreccion, Glezhel Anne, O.', 'Grade 10', 'resurrecciono.112390140186@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('112390170141', 'RESURRECCION,ACE NATHAN, OBELIDOR', 'Grade 10', 'resurreccionaceobelidor.112390170141@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('112394120019', 'SANDAGON,JOVY BELCHES', 'Grade 12', 'sandagonjovybelches.112394120019@sslg.edu.ph', 'N/A', '2025-02-26 01:59:26'),
('112394120020', 'SAN JUAN,ROXANNE FLORENCIO', 'Grade 12', 'sanflorencio.112394120020@sslg.edu.ph', '', '2025-02-25 22:19:19'),
('112394130024', 'ILARDE,JEREME MELGAR', 'Grade 11', 'ilardejerememelgar.112394130024@sslg.edu.ph', 'N/A', '2025-02-25 21:20:51'),
('112394140001', 'BELDA,JOHN PATRICK, IBARBIA', 'Grade 10', 'beldajohnibarbia.112394140001@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('112394160007', 'CADAG CHELSEY-VR', 'Grade 8', 'cadagchelseyvr.112394160007@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('112394160008', 'Cadag , Shamsey  V.', 'Grade 8', 'cadagv.112394160008@sslg.edu.ph', 'N/A', '2025-02-26 01:32:53'),
('112394160011', 'BARBIA, ISRAEL JR Mo', 'Grade 8', 'barbiamo.112394160011@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('112394170007', 'ILARDE, OLIVER MELGAR', 'Grade 7', 'ilardemelgar.112394170007@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('112394170011', 'SARCIA, CLITE LUIS QUEBRAL', 'Grade 7', 'sarciaquebral.112394170011@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('112394170022', 'BAÃ‘ARES,JAKE LAWRENCE, BOMBASE', 'Grade 10', 'baaresjakebombase.112394170022@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('112397130003', 'BONDAD, JERALD VILLAGRACIA', 'Grade 11', 'bondadvillagracia.112397130003@sslg.edu.ph', 'N/A', '2025-02-26 00:37:46'),
('112397160008', 'Bondad , Jewel Irish  V.', 'Grade 8', 'bondadv.112397160008@sslg.edu.ph', 'N/A', '2025-02-26 01:32:53'),
('112397170017', 'CORIGAL, ANGELA CERILLO', 'Grade 7', 'corigalcerillo.112397170017@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('112403140045', 'BALBALOSA, SHARMAINE, SY', 'Grade 10', 'balbalosasy.112403140045@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('112405130022', 'SARAO, NERISSA CELORICO', 'Grade 11', 'saraocelorico.112405130022@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('112406120020', 'BAGASALA,LYN-LYN SANGLAY', 'Grade 12', 'bagasalalynlynsanglay.112406120020@sslg.edu.ph', 'N/A', '2025-02-25 22:19:19'),
('112406120032', 'MALATE,MA BERNADETH CASTRO', 'Grade 12', 'malatemacastro.112406120032@sslg.edu.ph', 'N/A', '2025-02-26 01:59:26'),
('112406120033', 'MALATE, MA. LUISA C.', 'Grade 10', 'malatec.112406120033@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('112406120035', 'MANAOG,KRIZEL MAE MOLINA', 'Grade 12', 'manaogkrizelmolina.112406120035@sslg.edu.ph', '', '2025-02-25 22:19:19'),
('112406130001', 'ABILA, ARIES NAVERGAS', 'Grade 11', 'abilanavergas.112406130001@sslg.edu.ph', 'N/A', '2025-02-25 14:54:33'),
('112406140005', 'Gonowon, Edmund Rafael, M.', 'Grade 10', 'gonowonm.112406140005@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('112406140025', 'BRONZAL, MA. ANGELA D.', 'Grade 10', 'bronzald.112406140025@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('112406150001', 'ABILA,ARNEL, JR NAVERGAS', 'Grade 9', 'abilaarnelnavergas.112406150001@sslg.edu.ph', 'N/A', '2025-02-25 21:29:13'),
('112406150003', 'BALDONADO, JAY-AR BELLEN', 'Grade 9', 'baldonadobellen.112406150003@sslg.edu.ph', 'N/A', '2025-02-26 07:11:28'),
('112406150012', 'GONOWON, MARK JHON M.', 'Grade 9', 'gonowonm.112406150012@sslg.edu.ph', 'N/A', '2025-02-26 13:25:55'),
('112406150014', 'Manaog, John Eric T.', 'Grade 8', 'manaogt.112406150014@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('1124061500154', 'MANAOG REYNER R', 'Grade 8', 'manaogr.1124061500154@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('112406150036', 'GORONAL VENUS ESTRERA', 'Grade 7', 'goronalestrera.112406150036@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('112406150053', 'VILLAREAL,PRINCESS MARIAN, PRETISTA', 'Grade 9', 'villarealprincesspretista.112406150053@sslg.edu.ph', 'N/A', '2025-02-25 21:29:13'),
('112406160001', 'ABANEL, JOHN LAURENCE, M.', 'Grade 7', 'abanelm.112406160001@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('112406160021', 'Malate, Ann C.', 'Grade 8', 'malatec.112406160021@sslg.edu.ph', 'N/A', '2025-02-26 12:49:01'),
('112406160022', 'MALATE, MARGIE CLAPIS', 'Grade 7', 'malateclapis.112406160022@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('112406160024', 'Manaog, Maica Angel M.', 'Grade 8', 'manaogm.112406160024@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('112406170014', 'MALATE MARK GEL CASTRO', 'Grade 7', 'malatecastro.112406170014@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('112406170015', 'MALATE, MARK RAFAEL C.', 'Grade 7', 'malatec.112406170015@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('112406170016', 'MALATE, ROSSEL', 'Grade 7', 'malaterossel.112406170016@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('112406170026', 'VILLAREAL,JOHN WYNE, BRONZAL', 'Grade 10', 'villarealjohnbronzal.112406170026@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('112406170027', 'GORONAL, JAY, B.', 'Grade 7', 'goronalb.112406170027@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('112406170028', 'ABILA ANGELINE NAVERGAS', 'Grade 7', 'abilanavergas.112406170028@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('112415080090', 'SAHURDA EDCEL DEGAMO', 'Grade 12', 'sahurdadegamo.112415080090@sslg.edu.ph', 'N/A', '2025-02-26 02:05:44'),
('112415130072', 'ESTRADA,JESSA, MALATE', 'Grade 9', 'estradajessamalate.112415130072@sslg.edu.ph', 'N/A', '2025-02-25 21:29:13'),
('112415140017', 'BUCARCAR, GLAIZHA MAGNE B.', 'Grade 10', 'bucarcarb.112415140017@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('112415150032', 'PRIMA, JOHN VINCENT MEJOS', 'Grade 9', 'primamejos.112415150032@sslg.edu.ph', 'N/A', '2025-02-26 07:11:28'),
('112415150037', 'FABIA, SOFHIA S.', 'Grade 9', 'fabias.112415150037@sslg.edu.ph', 'N/A', '2025-02-26 13:25:55'),
('112415150042', 'San Pablo, Kayla Vin Ann E.', 'Grade 8', 'sane.112415150042@sslg.edu.ph', 'N/A', '2025-02-26 12:49:01'),
('112415160047', 'Carullo ,  Jillian  C.', 'Grade 8', 'carulloc.112415160047@sslg.edu.ph', 'N/A', '2025-02-26 01:32:53'),
('112421140007', 'NOBLEZA,JHON RIAL, SAN JUAN', 'Grade 10', 'noblezajhonjuan.112421140007@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('112471130290', 'DERAMAS,ROSEMARIE CALBELO', 'Grade 12', 'deramasrosemariecalbelo.112471130290@sslg.edu.ph', 'N/A', '2025-02-25 22:19:19'),
('112478160006', 'DIALOGO FRANCO SANCHEZ', 'Grade 7', 'dialogosanchez.112478160006@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('112490170104', 'RELLEVE, MA. ELIZA CAITH ALCANTARA', 'Grade 7', 'rellevealcantara.112490170104@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('112565130008', 'CAS,MARK LORENZ METAS', 'Grade 11', 'casmarkmetas.112565130008@sslg.edu.ph', 'N/A', '2025-02-26 00:37:46'),
('112677170158', 'ASIBOR ALLAIZA NOVA BAYLON', 'Grade 7', 'asiborbaylon.112677170158@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('112785130247', 'SAN JOSE,RONA MAY SARION', 'Grade 12', 'sansarion.112785130247@sslg.edu.ph', '', '2025-02-25 22:19:19'),
('112830160018', 'GABARDA-RICHALYN M', 'Grade 8', 'gabardarichalynm.112830160018@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('112989130046', 'DIGAY, JOHN CEDRIC LANGCAWON', 'Grade 11', 'digaylangcawon.112989130046@sslg.edu.ph', 'N/A', '2025-02-25 14:54:33'),
('113143170035', 'AYURO, AILEEN, A.', 'Grade 7', 'ayuroa.113143170035@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('114372160057', 'Bechayda, Jomarie V.', 'Grade 8', 'bechaydav.114372160057@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('114420140078', 'MARTINEZ,MARK JOHN SAMANIEGO', 'Grade 11', 'martinezmarksamaniego.114420140078@sslg.edu.ph', 'N/A', '2025-02-26 00:37:46'),
('114460170017', 'CALIBOSO, MARK CLARENCE,.', 'Grade 7', 'calibosoclarence.114460170017@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('114481150251', 'BORBE,SHAINA MAE, SAMONTE', 'Grade 9', 'borbeshainasamonte.114481150251@sslg.edu.ph', 'N/A', '2025-02-26 02:33:32'),
('115751170004', 'JARCIA, CEAN DAVE SALIMBAO', 'Grade 7', 'jarciasalimbao.115751170004@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('119851600003', 'Casais, Trishia Mae A.', 'Grade 8', 'casaisa.119851600003@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('122728170022', 'BORMATE,ASHLLY NICOLE, CANTOS', 'Grade 10', 'bormateashllycantos.122728170022@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('128608140053', 'BENARAO, PRINCES ANNE H.', 'Grade 10', 'benaraoh.128608140053@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('129696140020', 'BELLEN,HAYACENTH, BELMONTE', 'Grade 10', 'bellenhayacenthbelmonte.129696140020@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('129712150188', 'AGUILAR, LETECIA NICOLE SAPAULA', 'Grade 9', 'aguilarsapaula.129712150188@sslg.edu.ph', 'N/A', '2025-02-26 07:11:28'),
('136419150552', 'TIRADOS,JADE WELL, CANARIA', 'Grade 9', 'tiradosjadecanaria.136419150552@sslg.edu.ph', 'N/A', '2025-02-26 02:33:32'),
('136533160161', 'LO, ALEXIS HARVEY O.', 'Grade 8', 'loo.136533160161@sslg.edu.ph', 'N/A', '2025-02-26 13:48:43'),
('136606150229', 'CASPIANDREW B', 'Grade 8', 'caspiandrewb.136606150229@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('136641150313', 'Zacarias, King Abraham', 'Grade 8', 'zacariasabraham.136641150313@sslg.edu.ph', 'N/A', '2025-02-26 12:49:01'),
('136718131639', 'KINGKING,JOHN EMIL MONTES', 'Grade 12', 'kingkingjohnmontes.136718131639@sslg.edu.ph', 'N/A', '2025-02-26 01:59:26'),
('136797160657', 'GILI, ELIJAH SAM O.', 'Grade 8', 'gilio.136797160657@sslg.edu.ph', 'N/A', '2025-02-26 13:48:43'),
('136815140403', 'BALDOVINO,JOHN LOURENCE PALERMO', 'Grade 11', 'baldovinojohnpalermo.136815140403@sslg.edu.ph', 'N/A', '2025-02-26 00:37:46'),
('136872160055', 'Belmonte, John Cyrill', 'Grade 8', 'belmontecyrill.136872160055@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('136879130102', 'TANAY, GEROL ALTIMO', 'Grade 11', 'tanayaltimo.136879130102@sslg.edu.ph', 'N/A', '2025-02-26 00:37:46'),
('136903140520', 'MIRANDILLA,KING DENNIEL, QUEBRAL', 'Grade 10', 'mirandillakingquebral.136903140520@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('136904160271', 'Mirandilla, Shann Kennedy Q.', 'Grade 8', 'mirandillaq.136904160271@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('163003130006', 'DELOS SANTOS, NATHAN DELA CRUZ', 'Grade 11', 'deloscruz.163003130006@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('163003140032', 'DELOS SANTOS,ANGELO, DELA CRUZ', 'Grade 9', 'deloscruz.163003140032@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('172522130009', 'NATIVIDAD,MARK ANTHONY SARIBA', 'Grade 11', 'natividadmarksariba.172522130009@sslg.edu.ph', 'N/A', '2025-02-25 21:20:51'),
('172522130011', 'Virata ,  Marvin', 'Grade 8', 'viratamarvin.172522130011@sslg.edu.ph', 'N/A', '2025-02-26 01:32:53'),
('172522130012', 'BRON, AREAN BOROJA', 'Grade 11', 'bronboroja.172522130012@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('172522130025', 'CESTINA,DYLINE BROÃ‘OSA', 'Grade 12', 'cestinadylinebroosa.172522130025@sslg.edu.ph', 'N/A', '2025-02-25 22:19:19'),
('172522140001', 'AGUILAR,GIAN CARLO, BELGA', 'Grade 10', 'aguilargianbelga.172522140001@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('172522140002', 'BALDONADO,JESTHONY, BEJERANO', 'Grade 10', 'baldonadojesthonybejerano.172522140002@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('172522140003', 'BARIS,MART ANTHONY, BUEBOS', 'Grade 10', 'barismartbuebos.172522140003@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('172522140006', 'Colorico, Jhon Carl, Bron', 'Grade 10', 'coloricobron.172522140006@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('172522140007', 'NATIVIDAD,LEONEL, ARCENAL', 'Grade 10', 'natividadleonelarcenal.172522140007@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('172522140009', 'BAGACINA, JINKY T.', 'Grade 10', 'bagacinat.172522140009@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('172522140010', 'BROÃ‘OSA, EDEN M.', 'Grade 10', 'broosam.172522140010@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('172522140012', 'CRISTO, MARCHELLA, BALDONADO', 'Grade 10', 'cristobaldonado.172522140012@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('172522140014', 'LLAGAS, GIESEL PALERMO', 'Grade 9', 'llagaspalermo.172522140014@sslg.edu.ph', 'N/A', '2025-02-26 07:11:28'),
('172522140018', 'NACE, ZAIRAH BINARAO', 'Grade 9', 'nacebinarao.172522140018@sslg.edu.ph', 'N/A', '2025-02-26 07:11:28'),
('172522140020', 'BOTIN, CENDY, CARIÃ‘O', 'Grade 10', 'botincario.172522140020@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('172522150001', 'BON, HILBERT CERVANTES', 'Grade 9', 'boncervantes.172522150001@sslg.edu.ph', 'N/A', '2025-02-26 07:11:28'),
('172522150002', 'BOTIN,DANMARK, NATIVIDAD', 'Grade 9', 'botindanmarknatividad.172522150002@sslg.edu.ph', 'N/A', '2025-02-25 21:29:13'),
('172522150003', 'BORROMEO,JRUS, REBUCAS', 'Grade 9', 'borromeojrusrebucas.172522150003@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('172522150006', 'MELGAR,KEVIN, REODIQUE', 'Grade 9', 'melgarkevinreodique.172522150006@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('172522150007', 'BAGACINA, ASHLEY MELGAR', 'Grade 9', 'bagacinamelgar.172522150007@sslg.edu.ph', 'N/A', '2025-02-26 07:11:28'),
('172522150008', 'BONGALON,CATHLYN, PANCHO', 'Grade 9', 'bongaloncathlynpancho.172522150008@sslg.edu.ph', 'N/A', '2025-02-25 21:29:13'),
('172522150009', 'BRITANICO,DANIELA, NATIVIDAD', 'Grade 9', 'britanicodanielanatividad.172522150009@sslg.edu.ph', 'N/A', '2025-02-25 21:29:13'),
('172522150011', 'COPE,ANGELIE NICOLE, NACE', 'Grade 9', 'copeangelienace.172522150011@sslg.edu.ph', 'N/A', '2025-02-26 02:33:32'),
('172522150012', 'IBAYAN, IRA N.', 'Grade 7', 'ibayann.172522150012@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('172522160001', 'BELLEZA, JHARED B.', 'Grade 8', 'bellezab.172522160001@sslg.edu.ph', 'N/A', '2025-02-26 13:48:43'),
('172522160003', 'Carullo, Edzel R.', 'Grade 8', 'carullor.172522160003@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('172522160004', 'LLAGAS, EJAY LLORCA', 'Grade 7', 'llagasllorca.172522160004@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('172522160005', 'Nace , Zaijan  B.', 'Grade 8', 'naceb.172522160005@sslg.edu.ph', 'N/A', '2025-02-26 01:32:53'),
('172522160008', 'Belga , Shenna Marie  C.', 'Grade 8', 'belgac.172522160008@sslg.edu.ph', 'N/A', '2025-02-26 01:32:53'),
('172522160009', 'BONGALON, PRINCESS MAY, B.', 'Grade 7', 'bongalonb.172522160009@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('172522160011', 'BRON, AIRIL, B.', 'Grade 7', 'bronb.172522160011@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('172522160012', 'Bron, Necen C.', 'Grade 8', 'bronc.172522160012@sslg.edu.ph', 'N/A', '2025-02-26 12:49:01'),
('172522160014', 'CRISTO, ALYSSA MARIANE C.', 'Grade 8', 'cristoc.172522160014@sslg.edu.ph', 'N/A', '2025-02-26 13:55:03'),
('172522160016', 'NACE, MARIBEL D.', 'Grade 8', 'naced.172522160016@sslg.edu.ph', 'N/A', '2025-02-26 13:55:03'),
('172522160017', 'Nace ,Mary Ann', 'Grade 8', 'naceann.172522160017@sslg.edu.ph', 'N/A', '2025-02-26 01:32:53'),
('172522160018', 'Delos Santos, Jaypee', 'Grade 8', 'delosjaypee.172522160018@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('172522160019', 'BRITANICO, RYZA JULIANEZ', 'Grade 7', 'britanicojulianez.172522160019@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('172522160020', 'Minificiado, Ronalyn M.', 'Grade 8', 'minificiadom.172522160020@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('172522160021', 'Buebos, Mark Genesis D.', 'Grade 8', 'buebosd.172522160021@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('172522160022', 'BAGACINA AKIESHA MAER', 'Grade 8', 'bagacinamaer.172522160022@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('172522170005', 'CRISTO, CHRISTIAN ANGELO NACE', 'Grade 7', 'cristonace.172522170005@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('172522170008', 'MARTINEZ, MARK CHRISTIAN BINARAO', 'Grade 7', 'martinezbinarao.172522170008@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('1725221700104', 'BORDAS.CHRISANDRA BON', 'Grade 7', 'bordaschrisandrabon.1725221700104@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('172522170012', 'BONGALON, PRINCESS,', 'Grade 7', 'bongalonprincess.172522170012@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('172522170013', 'CARULLO, LOREEN', 'Grade 7', 'carulloloreen.172522170013@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('172522170014', 'CAMU, MECA,.', 'Grade 7', 'camumeca.172522170014@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('172522170016', 'DELOS SANTOS, IRA MAE', 'Grade 7', 'delosmae.172522170016@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('172522170019', 'BON,HUBERT, CERVANTES', 'Grade 10', 'bonhubertcervantes.172522170019@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('172524100002', 'Guevara, Donna Marie O.', 'Grade 8', 'guevarao.172524100002@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('172524110004', 'IBARRETA,MARIA', 'Grade 12', 'ibarretamariaibarretamaria.172524110004@sslg.edu.ph', 'N/A', '2025-02-25 22:19:19'),
('172524130017', 'LOYOLA, EUGENE OLIVEROS', 'Grade 11', 'loyolaoliveros.172524130017@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('172524130018', 'RAÃ‘OSA, JOSHUA LOJEDA', 'Grade 11', 'raosalojeda.172524130018@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('172524140003', 'Oriel, Rocky, Canchela', 'Grade 10', 'orielcanchela.172524140003@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('172524140007', 'LOPEZ, JENNIFER, NACE', 'Grade 10', 'lopeznace.172524140007@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('172524140009', 'Mendiola, Diane, Borbe', 'Grade 10', 'mendiolaborbe.172524140009@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('172524140011', 'MENDIOLA,KEYCEE LYN BORBE', 'Grade 12', 'mendiolakeyceeborbe.172524140011@sslg.edu.ph', '', '2025-02-25 22:19:19'),
('172524150001', 'GOLGOTA, JESSA MAE CASOCO', 'Grade 9', 'golgotacasoco.172524150001@sslg.edu.ph', 'N/A', '2025-02-26 07:11:28'),
('172524150008', 'Oliveros , Sherwin Jr.  R.', 'Grade 8', 'oliverosr.172524150008@sslg.edu.ph', 'N/A', '2025-02-26 01:32:53'),
('172524160001', 'Jimenez, Angel L.', 'Grade 8', 'jimenezl.172524160001@sslg.edu.ph', 'N/A', '2025-02-26 12:49:01'),
('172524160003', 'Golgota, Chloe A.', 'Grade 8', 'golgotaa.172524160003@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('172524160004', 'CORNEL, FRANCHISCA MAE F.', 'Grade 8', 'cornelf.172524160004@sslg.edu.ph', 'N/A', '2025-02-26 13:55:03'),
('172524160006', 'Palma ,  Eljay  C.', 'Grade 8', 'palmac.172524160006@sslg.edu.ph', 'N/A', '2025-02-26 01:32:53'),
('172524160007', 'Balbalosa, John Mike O.', 'Grade 8', 'balbalosao.172524160007@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('172524160010', 'RANOSA ALEXANDER', 'Grade 8', 'ranosaalexander.172524160010@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('172524170001', 'BALBALOSA,CHRISTIAN, OLIVEROS', 'Grade 10', 'balbalosachristianoliveros.172524170001@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('172524170002', 'BOTIN, DANIEL,', 'Grade 7', 'botindaniel.172524170002@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('172524170006', 'PALMA, EMMAN JAYE, ..', 'Grade 7', 'palma.172524170006@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('172524170008', 'GUEVARA,JONA, OLIVEROS', 'Grade 10', 'guevarajonaoliveros.172524170008@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('172525130001', 'BALTAZAR,NEIL BORIS CUARTO', 'Grade 12', 'baltazarneilcuarto.172525130001@sslg.edu.ph', 'N/A', '2025-02-25 22:19:19'),
('172525130005', 'CANABE,GERALD MANUEL', 'Grade 12', 'canabegeraldmanuel.172525130005@sslg.edu.ph', 'N/A', '2025-02-26 01:59:26'),
('172525130006', 'CELIS,MARK JASPER CELORICO', 'Grade 12', 'celismarkcelorico.172525130006@sslg.edu.ph', 'N/A', '2025-02-26 02:05:44'),
('172525130009', 'NATIVIDAD, MARK ANTHONY SARIBA', 'Grade 11', 'natividadsariba.172525130009@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('172525130016', 'ZAMORA,SOPHIA DAISYREE BALTAZAR', 'Grade 12', 'zamorasophiabaltazar.172525130016@sslg.edu.ph', 'N/A', '2025-02-26 01:59:26'),
('172525130047', 'MELGAR, SHERWIN JAMES NEPOMUCENO', 'Grade 11', 'melgarnepomuceno.172525130047@sslg.edu.ph', 'N/A', '2025-02-25 15:10:05'),
('172525130050', 'ZAMORA, JUSTIN ANDREW BUSMENTE', 'Grade 11', 'zamorabusmente.172525130050@sslg.edu.ph', 'N/A', '2025-02-26 00:37:46'),
('172525140017', 'CAMO,LOUIEGIE, BODINO', 'Grade 10', 'camolouiegiebodino.172525140017@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('172525140020', 'ISIDRO, JOHN PATRICK MERCADIJAS', 'Grade 10', 'isidromercadijas.172525140020@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('172525140024', 'RIPO,DENVER, CEREZO', 'Grade 10', 'ripodenvercerezo.172525140024@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('172525140032', 'RIPO, DANICA C.', 'Grade 10', 'ripoc.172525140032@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('172525140033', 'Sarion, Catherine Joy, Cerezo', 'Grade 10', 'sarioncerezo.172525140033@sslg.edu.ph', 'N/A', '2025-02-25 20:57:36'),
('172525150004', 'BERTUMEN,CHRISTIAN JEB, OCAMPO', 'Grade 9', 'bertumenchristianocampo.172525150004@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('172525150011', 'NEPOMUCENO, TOM CYRUZ C.', 'Grade 9', 'nepomucenoc.172525150011@sslg.edu.ph', 'N/A', '2025-02-26 13:25:55'),
('172525150013', 'RIPO,STEVEN, OLMEDILLO', 'Grade 9', 'ripostevenolmedillo.172525150013@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('172525150016', 'BORILLA,BHEBIEL, CELORICO', 'Grade 9', 'borillabhebielcelorico.172525150016@sslg.edu.ph', 'N/A', '2025-02-26 02:33:32'),
('172525150020', 'DINEIGA, ZYRINE JOY BRUCE', 'Grade 9', 'dineigabruce.172525150020@sslg.edu.ph', 'N/A', '2025-02-26 07:11:28'),
('172525160004', 'Celorico, Romel O.', 'Grade 8', 'celoricoo.172525160004@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('172525160005', 'LIM, FLORENZ GIAN T.', 'Grade 8', 'limt.172525160005@sslg.edu.ph', 'N/A', '2025-02-26 13:48:43'),
('172525160012', 'Perillo ,  Xavier  V.', 'Grade 8', 'perillov.172525160012@sslg.edu.ph', 'N/A', '2025-02-26 01:32:53');
INSERT INTO `students` (`StudentID`, `FullName`, `Grade`, `Email`, `ContactNumber`, `CreatedAt`) VALUES
('172525160013', 'Carilla ,  Jane  D.', 'Grade 8', 'carillad.172525160013@sslg.edu.ph', 'N/A', '2025-02-26 01:32:53'),
('172525160016', 'BORBE, ROSECHELE ANNE L.', 'Grade 8', 'borbel.172525160016@sslg.edu.ph', 'N/A', '2025-02-26 13:55:03'),
('172525160019', 'Zamora, Marriane B.', 'Grade 8', 'zamorab.172525160019@sslg.edu.ph', 'N/A', '2025-02-26 12:49:01'),
('172525160021', 'Zamora , Rovi Ann  B.', 'Grade 8', 'zamorab.172525160021@sslg.edu.ph', 'N/A', '2025-02-26 01:32:54'),
('172525170002', 'BODINO, ADRIAN SARTE', 'Grade 7', 'bodinosarte.172525170002@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('172525170003', 'CAMO, CEJAY,', 'Grade 7', 'camocejay.172525170003@sslg.edu.ph', 'N/A', '2025-02-26 02:44:44'),
('172525170004', 'CARILLA, JOHN RICO DEL ROSARIO', 'Grade 7', 'carillarosario.172525170004@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('172525170006', 'RAÃ‘ADA, VJAY, P.', 'Grade 7', 'raadap.172525170006@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('172525170007', 'SARION,GIAN CARLO CEREZO', 'Grade 7', 'sariongiancerezo.172525170007@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('172525170009', 'AÃ‘ONUEVO, BABY JEAN, P.', 'Grade 7', 'aonuevop.172525170009@sslg.edu.ph', 'N/A', '2025-02-26 13:59:11'),
('172525170011', 'CANABE,SHANE, LAUTA', 'Grade 10', 'canabeshanelauta.172525170011@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('172525170012', 'MENDINUETA, TRISHA MAE CASOCO', 'Grade 7', 'mendinuetacasoco.172525170012@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('172525170014', 'VILLAMOR,RIA SHANE, VALENZUELA', 'Grade 10', 'villamorriavalenzuela.172525170014@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('172525170015', 'CEREZO, KYLE IAN TESORERO', 'Grade 7', 'cerezotesorero.172525170015@sslg.edu.ph', 'N/A', '2025-02-26 01:43:56'),
('173517150003', 'AVILA, SHENEL LOREN SENA', 'Grade 9', 'avilasena.173517150003@sslg.edu.ph', 'N/A', '2025-02-26 07:11:28'),
('173520130004', 'GAITE, AURIEL V.', 'Grade 10', 'gaitev.173520130004@sslg.edu.ph', 'N/A', '2025-02-26 00:26:00'),
('311993120017', 'BEDANA, HAROLD ODOÃ‘O', 'Grade 11', 'bedanaodoo.311993120017@sslg.edu.ph', 'N/A', '2025-02-25 14:54:33'),
('403680150091', 'CARULLO, FRENCHIE MADEE, M.', 'Grade 10', 'carullom.403680150091@sslg.edu.ph', 'N/A', '2025-02-25 20:39:20'),
('403680170004', 'PEREZ,JAZRENE KYLE, BADONG', 'Grade 10', 'perezjazrenebadong.403680170004@sslg.edu.ph', 'N/A', '2025-02-26 00:03:50'),
('407260160005', 'BOBIS, JUSTIN JARED CARAMAT', 'Grade 9', 'bobiscaramat.407260160005@sslg.edu.ph', 'N/A', '2025-02-26 07:11:28'),
('407260170016', 'BOBIS, JOHN MARCUS', 'Grade 8', 'bobismarcus.407260170016@sslg.edu.ph', 'N/A', '2025-02-26 03:50:39'),
('4111981170031', 'MELITANTE.LOVELY SATPARAM', 'Grade 7', 'melitantelovelysatparam.4111981170031@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('424251170009', 'DEMETRIO, RONNIE JESSEY MALATE', 'Grade 7', 'demetriomalate.424251170009@sslg.edu.ph', 'N/A', '2025-02-26 01:27:52'),
('485590150661', 'Kingking, James Peter M.', 'Grade 8', 'kingkingm.485590150661@sslg.edu.ph', 'N/A', '2025-02-26 05:59:33'),
('6111981170025', 'OCCIDENTAL PRINCESS BIANCA CANOSA', 'Grade 7', 'occidentalcanosa.6111981170025@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('7111984170047', 'BRONCANO, TRISHA ALCARAZ', 'Grade 7', 'broncanoalcaraz.7111984170047@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('7172525160021', 'SABEROLA JANINE GARCIA', 'Grade 7', 'saberolagarcia.7172525160021@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37'),
('9172522170001', 'CEDRO MARY JOY BAS', 'Grade 7', 'cedrobas.9172522170001@sslg.edu.ph', 'N/A', '2025-02-26 02:37:37');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `election_id` int(11) DEFAULT NULL,
  `student_id` varchar(20) DEFAULT NULL,
  `candidate_id` int(11) DEFAULT NULL,
  `candidate_position` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `election_id` (`election_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `position` (`position`);

--
-- Indexes for table `candidate_requirements`
--
ALTER TABLE `candidate_requirements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidate_id` (`candidate_id`);

--
-- Indexes for table `elections`
--
ALTER TABLE `elections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partylists`
--
ALTER TABLE `partylists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`StudentID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`,`candidate_id`),
  ADD KEY `election_id` (`election_id`),
  ADD KEY `candidate_id` (`candidate_id`),
  ADD KEY `candidate_position` (`candidate_position`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `candidate_requirements`
--
ALTER TABLE `candidate_requirements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `elections`
--
ALTER TABLE `elections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `partylists`
--
ALTER TABLE `partylists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `candidates`
--
ALTER TABLE `candidates`
  ADD CONSTRAINT `candidates_ibfk_1` FOREIGN KEY (`election_id`) REFERENCES `elections` (`id`),
  ADD CONSTRAINT `candidates_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`StudentID`);

--
-- Constraints for table `candidate_requirements`
--
ALTER TABLE `candidate_requirements`
  ADD CONSTRAINT `candidate_requirements_ibfk_1` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`);

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`election_id`) REFERENCES `elections` (`id`),
  ADD CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`StudentID`),
  ADD CONSTRAINT `votes_ibfk_3` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`),
  ADD CONSTRAINT `votes_ibfk_4` FOREIGN KEY (`candidate_position`) REFERENCES `candidates` (`position`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
