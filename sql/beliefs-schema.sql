create table beliefs (
    belief_id int(11) not null auto_increment primary key,
    belief_text varchar(1000),
    username varchar(100),
    probability_point_estimate float(7,4),
    probability_lower_bound float(7,4),
    probability_upper_bound float(7,4),
    likert_response enum('Strongly agree','Agree','Uncertain','Disagree','Strongly disagree','No opinion'),
    confidence enum('1','2','3','4','5','6','7','8','9','10'),
    belief_date date,
    belief_date_precision enum('day','month','year','multi-year'),
    belief_expression_date date,
    belief_expression_date_precision enum('day','month','year','multi-year'),
    belief_expression_url varchar(200),
    belief_entry_date datetime,
    works_consumed varchar(2000),
    entry_method enum('add.php','manual SQL entry','probability method','likert method'),
    notes varchar(2000) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15239276 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
