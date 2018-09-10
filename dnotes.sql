create table `dnotes` (
	`id` double ,
	`order_num` varchar (64) ,
	`amount` varchar (90),
	`address` varchar (150),
	`invoice_num` varchar (60),
	`tolerance` varchar (30),
	`confirmations_num` double ,
	`date` datetime DEFAULT NULL, 
	`state` varchar (45)
); 
