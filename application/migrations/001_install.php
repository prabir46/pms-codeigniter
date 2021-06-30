<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Install extends CI_Migration {
    
    public function up()
    {
		   
	   $this->_table_appointments();
	   $this->_table_assistant_payment();
	   $this->_table_blood_group_type();
	   $this->_table_canned_messages();
	   $this->_table_case_history();
	   $this->_table_contacts();
	   $this->_table_custom_fields();
	   $this->_table_days();
	   $this->_table_disease();
	   $this->_table_doctor_payment();
	   $this->_table_event_calendar();
	   $this->_table_fees();
	   $this->_table_fixed_schedule();
	   $this->_table_hospitals();
	   $this->_table_hospital_type();
	   $this->_table_instruction();
	   $this->_table_jqcalendar();
	   $this->_table_language();
	   $this->_table_manufacturing_company();
	   $this->_table_medical_college();
	   $this->_table_medical_test();
	   $this->_table_medicine();
	   $this->_table_medicine_category();
	   $this->_table_message();
	   $this->_table_monthly_schedule();
	   $this->_table_notes();
	   $this->_table_notification_setting();
	   $this->_table_other_schedule();
	   $this->_table_payment_modes();
	   $this->_table_pimages();
	   $this->_table_prescription();
	   $this->_table_prescription_template();
	  // $this->_table_rel_days_doctors();
	   $this->_table_rel_form_custom_fields();
	   $this->_table_reports();
	   $this->_table_settings();
	   $this->_table_to_do_list();
	   $this->_table_users();
	}
    
    public function down()
    {
        // Migration 1 has no rollback 
    }
    
	
	
	
		
	private function _table_appointments()
    {
        if(!$this->db->table_exists('appointments'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
                'title' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),
               'doctor_id' => array(
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            ),
			    'whom' => array(
                            'type' => 'tinyint',
                            'constraint' => 1,
							'null' => TRUE,
                            ),	
				'patient_id' => array(
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
							'null' => TRUE,
                            ),
				'contact_id' => array(
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
							'null' => TRUE,
                            ),
				'other' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),	
				'date' => array(
                            'type' => 'datetime',
							'null' => TRUE,
                              ),			
				'end_date' => array(
                            'type' => 'datetime',
							'null' => TRUE,
                              ),						  	
				'motive' => array(
                            'type' => 'text',
							'null' => TRUE,
							),	
						
				'notes' => array(
                            'type' => 'text',
							'null' => TRUE,
                            ),	
				'status' => array(
                            'type' => 'tinyint',
                            'constraint' => 1,
							 'default' => 0
                            ),	
				'is_view' => array(
                            'type' => 'tinyint',
                            'constraint' => 1,
							 'default' => 0
                            ),
				'is_paid' => array(
                            'type' => 'tinyint',
                            'constraint' => 1,
							 'default' => 0
                            ),
				'is_closed' => array(
                            'type' => 'tinyint',
                            'constraint' => 1,
							 'default' => 0
                            ),	
				'Color' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
							),										
				 																  					
				
            ));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('appointments', true);

        }
    }
	
	private function _table_assistant_payment()
    {
        if(!$this->db->table_exists('assistant_payment'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
               'assistant_id' => array(
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            ),
				'payment_mode_id' => array(
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            ),			
			    'date' => array(
                            'type' => 'date',
                            'null' => TRUE,
							),	
			
				'invoice' => array(
                            'type' => 'int',
                            'constraint' => 10,
                            'unsigned' => true,
                            ),
				'amount' => array(
                        	'type' => 'decimal(10,2)',
							'null' => TRUE,
						    ),	
														  					
				
            ));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('assistant_payment', true);

        }
    }
	
	
	private function _table_blood_group_type()
    {
        if(!$this->db->table_exists('blood_group_type'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
               'name' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),		  					
				
            ));
			//add the default Days
			
			$records = array( 
                    array('id'=>'1', 
                    'name'=>'O-',
                    ),
					array('id'=>'2', 
                    'name'=>'O+',
                    ),
					array('id'=>'3', 
                    'name'=>'A-',
                    ),
					array('id'=>'4', 
                    'name'=>'A+',
                    ),
					array('id'=>'5', 
                    'name'=>'B-',
                    ),
					array('id'=>'6', 
                    'name'=>'B+',
                    ),
					array('id'=>'7', 
                    'name'=>'AB-',
                    ),
					array('id'=>'8', 
                    'name'=>'AB+',
                    )
            );

            $this->db->insert_batch('blood_group_type', $records);


            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('blood_group_type', true);

        }
    }
	
	private function _table_canned_messages()
    {
        if(!$this->db->table_exists('canned_messages'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 10,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
				'deletable' => array(
                                'type' => 'tinyint',
                                'constraint' => 1,
                                'null' => TRUE,
                                'default' => 1
                                ),
                    'type' => array(
                                'type' => 'varchar',
                                'constraint' => 255,
                                'null' => TRUE,
                                ),
                    'name' => array(
                                'type' => 'varchar',
                                'constraint' => 50,
                                'null' => TRUE,
                                ),
                    'subject' => array(
                                'type' => 'varchar',
                                'constraint' => 100,
                                'null' => TRUE,
                                ),
                    'content' => array(
                                'type' => 'text',
								'null' => TRUE,
                                )								
				
            ));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('canned_messages', true);
			
			/*$this->db->insert('canned_messages', array('type'=>'order', 'name'=>'Forgot Password Message', 'subject'=>'Password Reset Link at {site_name}!' ,'content'=>'<p>Dear {customer_name},</p><p>If you forget your password, on the login page, click the Following link and you can change your account password</p><p>Username - {username}</p><p>{reset_link}</p><p>Thanks,<br>{site_name}</p>')); */
			
        }
    }
	
	
	
	
	
	
	private function _table_case_history()
    {
        if(!$this->db->table_exists('case_history'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
				'name' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),
				'doctor_id' => array(
                            'type' => 'int',
                            'constraint' => 10,
							 'unsigned' => true,											
				)	
			));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('case_history', true);

        }
    }
	
	private function _table_contacts()
    {
        if(!$this->db->table_exists('contacts'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
				'name' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),
				'contact' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),
				'email' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),
				'address' => array(
                            'type' => 'text',
							'null' => TRUE,
                            ),	
				'doctor_id' => array(
                            'type' => 'int',
                            'constraint' => 10,
							 'unsigned' => true,											
				),
			));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('contacts', true);

        }
    }
	
	
	
	private function _table_custom_fields()
    {
        if(!$this->db->table_exists('custom_fields'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
				'name' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),
				'field_type' => array(
                            'type' => 'int',
                            'constraint' => 10,
							'null' => TRUE,
                            ),
				'form' => array(
                            'type' => 'int',
                            'constraint' => 10,
							'null' => TRUE,
                            ),
				'values' => array(
                            'type' => 'text',
							'null' => TRUE,
                            ),										
				'doctor_id' => array(
                            'type' => 'int',
                            'constraint' => 10,
							 'unsigned' => true,
							), 
			));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('custom_fields', true);

        }
    }
	
	
	private function _table_days()
    {
        if(!$this->db->table_exists('days'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
				'name' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),
			));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('days', true);
		
			//add the default Days
			
			$records = array( 
                    array('id'=>'1', 
                    'name'=>'Mon',
                    ),
					array('id'=>'2', 
                    'name'=>'Tue',
                    ),
					array('id'=>'3', 
                    'name'=>'Wed',
                    ),
					array('id'=>'4', 
                    'name'=>'Thu',
                    ),
					array('id'=>'5', 
                    'name'=>'Fri',
                    ),
					array('id'=>'6', 
                    'name'=>'Sat',
                    ),
					array('id'=>'7', 
                    'name'=>'Sun',
                    )
					
					
            );

            $this->db->insert_batch('days', $records);
		
        }
    }
	
	private function _table_disease()
    {
        if(!$this->db->table_exists('disease'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
				'name' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),
				'description' => array(
                            'type' => 'text',
                            ),					
				'doctor_id' => array(
                            'type' => 'int',
                            'constraint' => 10,
							 'unsigned' => true,								
							)
			));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('disease', true);

        }
    }
	
	private function _table_doctor_payment()
    {
        if(!$this->db->table_exists('doctor_payment'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
               'doctor_id' => array(
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            ),
				'payment_mode_id' => array(
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            ),			
			    'date' => array(
                            'type' => 'date',
							'null' => TRUE,
                            ),	
			
				'invoice' => array(
                            'type' => 'int',
                            'constraint' => 10,
                            'unsigned' => true,
                            ),
				'amount' => array(
                        	'type' => 'decimal(10,2)',
							'null' => TRUE,
						    ),	
														  					
				
            ));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('doctor_payment', true);

        }
    }
	
	private function _table_event_calendar()
    {
        if(!$this->db->table_exists('event_calendar'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
               'title' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),
				'starttime' => array(
                            'type' => 'datetime',
							'null' => TRUE,
                            ),	
				'endtime' => array(
                            'type' => 'datetime',
							'null' => TRUE,
                            ),				
				'schedule_category_id' => array(
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            ),
				'doctor_id' => array(
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            ),				
														  					
				
            ));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('event_calendar', true);

        }
    }
	
	private function _table_fees()
    {
        if(!$this->db->table_exists('fees'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
				'prescription_id' => array(
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            ),
				'payment_mode_id' => array(
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            ),						
				'amount' => array(
                           'type' => 'decimal(10,2)',
						   'null' => TRUE,
                            ),
				'total' => array(
                           'type' => 'decimal(10,2)',
						   'null' => TRUE,
                            ),			
				'date' => array(
                            'type' => 'date',
                            ),
				'invoice' => array(
                             'type' => 'int',
                            'constraint' => 10,
							'null' => TRUE,
                            ),		
				'patient_id' => array(
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            ),
				'payment_for' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),
				'balance' => array(
                           'type' => 'decimal(10,2)',
						   'null' => TRUE,
                            ),																		
				
			));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('fees', true);

        }
    }
	
	
	private function _table_fixed_schedule()
    {
        if(!$this->db->table_exists('fixed_schedule'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
				'doctor_id' => array(
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            ),
				'day' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),						
				'timing_to' => array(
                           'type' => 'time',
						   'null' => TRUE,
                            ),
				'timing_from' => array(
                           'type' => 'time',
						   'null' => TRUE,
                            ),	
				'work' => array(
                           'type' => 'text',
						   'null' => TRUE,
                            ),	
				'hospital' => array(
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            ),
				'type' => array(				//1 for hospital ,2for medical college
                            'type' => 'tinyint',
                            'constraint' => 2,
                            'null' => TRUE,
                            ),											
				
			));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('fixed_schedule', true);

        }
    }
	
	private function _table_hospitals()
    {
        if(!$this->db->table_exists('hospitals'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
				'name' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),				
				'doctor_id' => array(
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            ),
				'address' => array(
                            'type' => 'text',
							'null' => TRUE,
                            ),	
				'phone' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),	
				'hospital_type' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),
			));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('hospitals', true);

        }
    }
	
	private function _table_hospital_type()
    {
        if(!$this->db->table_exists('hospital_type'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
				'type' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),				
				
			));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('hospital_type', true);

        }
    }
	
	
	private function _table_instruction()
    {
        if(!$this->db->table_exists('instruction'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
				'name' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),
				'type' => array(
                            'type' => 'tinyint',
                            'constraint' => 2,
							'null' => TRUE,
                            ),
				'doctor_id' => array(
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            ),										
				
			));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('instruction', true);

        }
    }
	
	private function _table_jqcalendar()
    {
        if(!$this->db->table_exists('jqcalendar'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'Id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
				'Subject' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => true
                            ),
				'Location' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => true
                            ),
				'Description' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => true
                            ),
				'StartTime' => array(
                            'type' => 'datetime',
							'null' => true
                            ),
				'EndTime' => array(
                            'type' => 'datetime',
							'null' => true
                            ),												
				'IsAllDayEvent' => array(
                            'type' => 'smallint',
                            'constraint' => 6,
                            ),
				'Color' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => true
                            ),	
				'RecurringRule' => array(
                            'type' => 'varchar',
                            'constraint' => 500,
							'null' => true
                            ),						
				'doctor_id' => array(
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            ),	
				'type_id' => array(
                            'type' => 'tinyint',
                            'constraint' => 4,
                            'default' => 5,
                            ),													
				
			));

            $this->dbforge->add_key('Id', true);
            $this->dbforge->create_table('jqcalendar', true);

        }
    }
	
	
	private function _table_language()
    {
        if(!$this->db->table_exists('language'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
                'name' => array(
                            'type' => 'varchar',
                            'constraint' => 32,
                            'null' => true
                            ),
                'flag' => array(
                            'type' => 'text',
							'null' => TRUE,
                            ),
				'file' => array(
                            'type' => 'text',
							'null' => TRUE,
                            )			
             
            ));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('language', true);

            //add the default user
           // $this->db->insert('language', array('name'=>'french', 'flag'=>'french-flag4.jpeg', 'file'=>'admin_lang.php'));
        }
    }
	
	private function _table_manufacturing_company()
    {
        if(!$this->db->table_exists('manufacturing_company'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
				'name' => array(  
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),
				'description' => array(  
                            'type' => 'text',
							'null' => TRUE,
                            ),				
				'doctor_id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
							'null' => true,
                            ),			
                'start_date' => array(
                            'type' => 'date',
							'null' => true,
                            ),
				'end_date' => array(
                            'type' => 'date',
							'null' => true,
                            ),			
				
            ));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('manufacturing_company', true);

		}
    }
	
	
	private function _table_medical_college()
    {
        if(!$this->db->table_exists('medical_college'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
				'name' => array(  
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),
				'address' => array(  
                            'type' => 'text',
							'null' => TRUE,
                            ),	
				'phone' => array(  
                            'type' => 'varchar',
                            'constraint' => 32,
							'null' => TRUE,
                            ),
						
				'doctor_id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
							'null' => TRUE,
                            ),			
                			
				
            ));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('medical_college', true);

		}
    }
	
	private function _table_medical_test()
    {
        if(!$this->db->table_exists('medical_test'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
				'name' => array(  
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),
						
				'doctor_id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
							'null' => TRUE,
                            ),			
                			
				
            ));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('medical_test', true);

		}
    }
	
	
	
	
	private function _table_medicine()
    {
        if(!$this->db->table_exists('medicine'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
				'name' => array(  
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),
				'category_id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
							'null' => TRUE,
							),
				'company_id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
							'null' => TRUE,
							),			
				'description' => array(  
                            'type' => 'text',
                            ),
				'price' => array(  
                            'type' => 'decimal(10,2)',
							'null' => TRUE,
                            ),				
				'status' => array(  
                            'type' => 'tinyint',
                            'constraint' => 1,
							'null' => TRUE,
							),			
				'doctor_id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
							'null' => TRUE,
                            ),			
                			
				
            ));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('medicine', true);

		}
    }
	
	private function _table_medicine_category()
    {
        if(!$this->db->table_exists('medicine_category'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
				'name' => array(  
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),
						
				'doctor_id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
							'null' => TRUE,
                            ),			
                			
				
            ));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('medicine_category', true);

		}
    }

		
	private function _table_message()
    {
        if(!$this->db->table_exists('message'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
				'message' => array(
                            'type' => 'text',
							'null' => TRUE,
                            ),
				'from_id' => array(
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
							'null' => TRUE,
                            ),
				'to_id' => array(
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            ),				
				'is_view_from' => array(
                            'type' => 'int',
                            'constraint' => 9,
                            'default' => 0,
                            ),
				'is_view_to' => array(
                            'type' => 'int',
                            'constraint' => 9,
                            'default' => 0,
                            ),	'date_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP',					
				
			));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('message', true);

        }
    }
	
	
	
	private function _table_monthly_schedule()
    {
        if(!$this->db->table_exists('monthly_schedule'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 2,
                            'UNSIGNED' => true,
                            'auto_increment' => true
                            ),
				 'date_id' => array(  
                            'type' => 'int',
                            'constraint' => 2,
                            'UNSIGNED ZEROFILL' => true,
                            ),	
				'doctor_id' => array(
                            'type' => 'int',
                            'constraint' => 11,
                            'unsigned' => true,
                            ),	
				'timing_from' => array(
                            'type' => 'time',
							'null' => TRUE,
                            ),	
				'timing_to' => array(
                            'type' => 'time',
							'null' => TRUE,
                            ),
				'work' => array(
                            'type' => 'text',
							'null' => TRUE,
                            ),														
				'hospital' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            )
			));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('monthly_schedule', true);
		
			
        }
    }
	
	private function _table_notes()
    {
	
        if(!$this->db->table_exists('notes'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'UNSIGNED' => true,
                            'auto_increment' => true
                            ),
				'patient_id' => array(
                            'type' => 'int',
                            'constraint' => 11,
                            'unsigned' => true,
                            ),
				'doctor_id' => array(
                            'type' => 'int',
                            'constraint' => 11,
                            'unsigned' => true,
                            ),	
				'notes' => array(
                            'type' => 'text',
							'null' => TRUE,
                            ),
				'datetime TIMESTAMP DEFAULT CURRENT_TIMESTAMP',				
			));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('notes', true);
			
        }
    }
	
		private function _table_notification_setting()
    {
        if(!$this->db->table_exists('notification_setting'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
              'to_do_alert' => array(
                            'type' => 'int',
                            'constraint' => 10,
							'null' => TRUE,
                            ),
				'appointment_alert' => array(
                            'type' => 'int',
                            'constraint' => 10,
							'null' => TRUE,
                            ),	
				'doctor_id' => array(
                            'type' => 'int',
                            'constraint' => 10,
							 'unsigned' => true,
                            ),									
              		
             
            ));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('notification_setting', true);

        
		}
    }
	
	
	private function _table_other_schedule()
    {
        if(!$this->db->table_exists('other_schedule'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 2,
                            'UNSIGNED' => true,
                            'auto_increment' => true
                            ),
			
				'doctor_id' => array(
                            'type' => 'int',
                            'constraint' => 11,
                            'unsigned' => true,
                            ),	
				'dates' => array(
                            'type' => 'date',
							'null' => TRUE,
                            ),				
				'timing_from' => array(
                            'type' => 'time',
							'null' => TRUE,
                            ),	
				'timing_to' => array(
                            'type' => 'time',
							'null' => TRUE,
                            ),
				'work' => array(
                            'type' => 'text',
							'null' => TRUE,
                            ),														
				'hospital_id' => array(
                            'type' => 'int',
                            'constraint' => 9,
                            'UNSIGNED' => true,
                            )
			));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('other_schedule', true);
		
			
        }
    }
	
	
	
	private function _table_payment_modes()
    {
        if(!$this->db->table_exists('payment_modes'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
				'name' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),
				'doctor_id' => array(
                            'type' => 'int',
                            'constraint' => 11,
                            'unsigned' => true,
							'null' => TRUE,
                            ),												
				
			));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('payment_modes', true);

        }
    }
	
	private function _table_pimages()
    {
        if(!$this->db->table_exists('pimages'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
				'title' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),
				'file_name' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),	
				'user_id' => array(
                            'type' => 'int',
                            'constraint' => 11,
                            'unsigned' => true,
							'null' => TRUE,
                            ),						
				'doctor_id' => array(
                            'type' => 'int',
                            'constraint' => 11,
                            'unsigned' => true,
							'null' => TRUE,
                            ),												
				
			));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('pimages', true);

        }
    }
	
	
	private function _table_prescription()
    {
        if(!$this->db->table_exists('prescription'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
				'prescription_id' => array(
                            'type' => 'int',
                            'constraint' => 11,
                            'unsigned' => true,
                            ),
				'patient_id' => array(
                            'type' => 'int',
                            'constraint' => 11,
                            'unsigned' => true,
                            ),	
				'medicines' => array(
                            'type' => 'text',
							'null' => TRUE,
                            ),	
				'tests' => array(
                            'type' => 'text',
							'null' => TRUE,
                            ),		
				'test_instructions' => array(
                            'type' => 'text',
							'null' => TRUE,
                            ),
				'disease' => array(
                            'type' => 'text',
							'null' => TRUE,
                            ),	
				'oe_description' => array(
                            'type' => 'text',
							'null' => TRUE,
                            ),		
				'date_time' => array(
                            'type' => 'datetime',
							'null' => TRUE,
                            ),																						
				'name' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),
				'remark' => array(
                            'type' => 'text',
							'null' => TRUE,
                            ),	
				'medicine_instruction' => array(
                            'type' => 'text',
							'null' => TRUE,
                            ),
				'case_history' => array(
                            'type' => 'text',
							'null' => TRUE,
                            ),										
				'case_history_id' => array(
                            'type' => 'text',
							'null' => TRUE,
                            ),	
													
			));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('prescription', true);

        }
    }
	
	private function _table_prescription_template()
    {
        if(!$this->db->table_exists('prescription_template'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
				'header' => array(
                            'type' => 'text',
							'null' => true,
                            ),
				'footer' => array(
                            'type' => 'text',
                            'null' => true,
							),			
				'doctor_id' => array(
                            'type' => 'int',
                            'constraint' => 11,
                            'unsigned' => true,
							'null' => true,
                            ),												
				
			));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('prescription_template', true);

        }
    }
	
	
	
	private function _table_rel_form_custom_fields()
    {
        if(!$this->db->table_exists('rel_form_custom_fields'))
        {

            // create the table
            $this->dbforge->add_field(array(
               'custom_field_id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
				'reply' => array(
                            'type' => 'text',
							'null' => TRUE,
                            ),
				'table_id' => array(
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            ),
				'form' => array(
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            )
            ));

            $this->dbforge->add_key('custom_field_id', true);
            $this->dbforge->create_table('rel_form_custom_fields', true);

        }
    }

	
	
	private function _table_reports()
    {
        if(!$this->db->table_exists('reports'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
				'prescription_id' => array(
                            'type' => 'int',
                            'constraint' => 11,
                            'unsigned' => true,
                            ),
				'date_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP',			
				'type_id' => array(
                            'type' => 'int',
                            'constraint' => 11,
                            'unsigned' => true,
                            ),	
				'file' => array(
                            'type' => 'text',
							'null' => TRUE,
                            ),	
				'remark' => array(
                            'type' => 'text',
							'null' => TRUE,
                            ),	
				'from_id' => array(
                            'type' => 'int',
                            'constraint' => 11,
                            'unsigned' => true,
                            ),	
				'to_id' => array(
                            'type' => 'int',
                            'constraint' => 11,
                            'unsigned' => true,
                            ),		
				'is_view_to' => array(
                            'type' => 'tinyint',
                            'constraint' => 1,
                            'default' => 1,
                            ),										
													
			));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('reports', true);

        }
    }
	
	
	private function _table_settings()
    {
        if(!$this->db->table_exists('settings'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 9,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
                'name' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),
				 'image' => array(
                            'type' => 'text',
							'null' => TRUE,
                            ),
				
				 'address' => array(
                            'type' => 'text',
							'null' => TRUE,
                            ),
				 'contact' => array(
                            'type' => 'varchar',
                            'constraint' => 32,
							'null' => TRUE,
                            ),	
				 'email' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),
				'doctor_id' => array(
                            'type' => 'int',
                            'constraint' => 11,
							'null' => TRUE,
                            ),			
							
				'invoice' => array(
                            'type' => 'int',
							'constraint' => 10,
							'default' => 1,
                            ),				
				 'date_format' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),
							
				 'timezone' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),
				'smtp_host' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),
				'smtp_user' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),
							
				'smtp_pass' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),
							
				'smtp_port' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
                            ),	
				'session_hours' => array(
                            'type' => 'int',
                            'constraint' => 11,
							'default' => '2',
                            ),																								
            ));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('settings', true);

            //add the default user
            $this->db->insert('settings', array('name'=>'Doctor', 'email'=>'doctor@doctor.com'));
        }
    }
	
	
	
	
	private function _table_to_do_list()
    {
        if(!$this->db->table_exists('to_do_list'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 10,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
				'title' => array(
                            'type' => 'varchar',
							'constraint' => 255,
							'null' => TRUE,
                            ),
				'description' => array(
                            'type' => 'text',
							'null' => TRUE,
                            ),			
				'date' => array(
                            'type' => 'date',
							'null' => TRUE,
                            ),
				'is_view' => array(
                            'type' => 'int',
                            'constraint' => 10,
                            'default' => 0,
                            ),				
				 'doctor_id' => array(  
                            'type' => 'int',
                            'constraint' => 10,
                            'unsigned' => true,
                            ),
				'Color' => array(
                            'type' => 'varchar',
                            'constraint' => 255,
							'null' => TRUE,
							),				
			));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('to_do_list', true);

        }
    }
	
	private function _table_users()
    {
        if(!$this->db->table_exists('users'))
        {

            // create the table
            $this->dbforge->add_field(array(
                'id' => array(  
                            'type' => 'int',
                            'constraint' => 10,
                            'unsigned' => true,
                            'auto_increment' => true
                            ),
							
				'name' => array(
                            'type' => 'varchar',
							'constraint' => 255,
							'null' => TRUE,
                            ),
				'blood_group_id' => array(
                            'type' => 'int',
                            'constraint' => 10,
							'null' => TRUE,
                            ),				
				'image' => array(
                            'type' => 'text',
							'null' => TRUE,
                            ),
				'username' => array(
                            'type' => 'varchar',
							'constraint' => 255,
							'null' => TRUE,
                            ),	
				'password' => array(
                            'type' => 'varchar',
							'constraint' => 40,
							'null' => TRUE,
                            ),				
				'gender' => array(
                            'type' => 'varchar',
							'constraint' => 40,
							'null' => TRUE,
                            ),							
				'dob' => array(
                            'type' => 'int',
							'constraint' => 11,
							'null' => TRUE,
                            ),
				'email' => array(
                            'type' => 'varchar',
							'constraint' => 255,
							'null' => TRUE,
                            ),
				'contact' => array(
                            'type' => 'varchar',
							'constraint' => 32,
							'null' => TRUE,
                            ),
				'address' => array(
                            'type' => 'text',
							'null' => TRUE,
                            ),
				'user_role' => array(
                            'type' => 'varchar',
                            'constraint' => 8,
							'null' => TRUE,
                            ),	
				'doctor_id' => array(
                            'type' => 'int',
                            'constraint' => 10,
							'null' => TRUE,
                            ),			
				'token' => array(
                            'type' => 'varchar',
							'constraint' => 255,
							'null' => TRUE,
                            ),			
				'appointment_alert' => array(
                            'type' => 'int',
                            'constraint' => 10,
                            'default' => 1,
                            ),	
							
				'to_do_alert' => array(
                            'type' => 'int',
                            'constraint' => 10,
                            'unsigned' => true,
							'default' => 1,
                            ),
				'schedule' => array(
                            'type' => 'tinyint',
                            'constraint' => 1,
                            'default' => 0,
							'null' => TRUE,
                            ),'add_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
											
			));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('users', true);

        }
    }
	
	
	
	

}