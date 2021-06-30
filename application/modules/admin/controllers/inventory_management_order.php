<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class inventory_management_order extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->auth->is_logged_in();
        //$this->auth->check_access('1', true);
        $this->load->model("patient_model");
        $this->load->model("notes_model");
        $this->load->model("contact_model");
        $this->load->model("prescription_model");
        $this->load->model("setting_model");
        $this->load->model("custom_field_model");
        $this->load->model("invoice_model");
        $this->load->model("medical_test_model");
        $this->load->model("notification_model");
        $this->load->model("medicine_model");
        $this->load->model("disease_model");
        $this->load->model("instruction_model");
        $this->load->model("payment_mode_model");
        $this->load->model("appointment_model");
        $this->load->model("case_history_model");
        $this->load->model("lab_management_model");
        $this->load->model("supplier_model");
        $this->load->model("inventory_management_model");
        $this->load->library('form_validation');
        $this->load->library('session');
       // $this->load->model('inventory_management_order');
//error_reporting(0);
    }

    function index($id=false){
        $data['p_id']= $id;
        $admin = $this->session->userdata('admin');

        $data['name']= $this->supplier_model->get_medicine_categoory_by_doctor();
        //echo '<pre>'; print_r($_POST);die;
        $data['fields'] = $this->custom_field_model->get_custom_fields(6);
        if($admin['user_role']==1){
            $ad = $admin['id'];
        }
        if($admin['user_role']==3){
            $ad = $admin['doctor_id'];
        }
        $data['tests']= $this->inventory_management_model->get_medical_test_by_patient_order($ad);

        $data['page_title'] = lang('inventory_management_order');
        $data['body'] = 'inventory_management_order/inventory_management_order_list';
        $this->load->view('template/main', $data);

    }

    function add(){

        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
               $product=array();
            $admin = $this->session->userdata('admin');
            $inv_count = count($this->input->post('quantity'));
            for($i=0;$i<$inv_count;$i++) {
                $qty = $this->input->post('quantity')[$i];
                $name = $this->input->post('name')[$i];
                $save['name'] = $name;
                $product[]=$name;
                $save['quantity'] = $qty;
                /// $save['price'] = $this->input->post('price');
                $save['supplier'] = $this->input->post('supplier');
                $save['date'] = $this->input->post('dates');
                if ($admin['user_role'] == 1) {
                    $save['admin'] = $admin['id'];
                }
                if ($admin['user_role'] == 3) {
                    $save['admin'] = $admin['doctor_id'];
                }


                $inventory_management_key = $this->inventory_management_model->save1($save);

                $reply = $this->input->post('reply');
                if (!empty($reply)) {
                    foreach ($this->input->post('reply') as $key => $val) {
                        $save_fields[] = array(
                            'custom_field_id' => $key,
                            'reply' => $val,
                            'table_id' => $inventory_management_key,
                            'form' => 6,
                        );

                    }
                    $this->custom_field_model->save_answer($save_fields);
                }
            }
            $this->db->where('id',$save['supplier']);
            $data=$this->db->get('supplier')->row(0);
            $contact=$data->mobile;
            $pqr=$data->name;
            $product=json_encode($product);
            $authKey = "144872ArhHeSNu58c7bb84";

            //Multiple mobiles numbers separated by comma
            $mobileNumber = $contact;


            //Sender ID,While using route4 sender id should be 6 characters long.
            $senderId = "DOCTRI";

            //Your message to send, Add URL encoding here.
            $mesg = "Dear " . $pqr. ", Please send me the following product:\n".$product."\n\n"."Regards\n".$admin['name']."\n\nDownload Doctori8 App to secure your health records.\n"."http://bit.ly/2IoxEtl.";
            $message = urlencode($mesg);

            //Define route
            $route = 4;
            //Prepare you post parameters
            $postData = array(
                'authkey' => $authKey,
                'mobiles' => $mobileNumber,
                'message' => $message,
                'sender' => $senderId,
                'route' => $route
            );

            //API URL
            $url = "http://sms.globehost.com/api/sendhttp.php?";

            // init the resource
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $postData
                //,CURLOPT_FOLLOWLOCATION => true
            ));


            //Ignore SSL certificate verification
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


            //get response
            $output = curl_exec($ch);

            //Print error if any
            if (curl_errno($ch)) {
                echo 'error:' . curl_error($ch);
            }

            curl_close($ch);
          //  echo $contact;
            redirect('admin/inventory_management_order');
        }

    }

    function edit($id,$redirect=false){
        $this->auth->check_access('1', true);
        $admin = $this->session->userdata('admin');
        $data['name']= $this->supplier_model->get_medicine_categoory_by_doctor();
        $data['inventory_management'] = $this->inventory_management_model->get_payment_mode_by_id_order($id);
        $data['ids']=$id;
        //echo '<pre>'; print_r($_POST);die;
        $data['fields'] = $this->custom_field_model->get_custom_fields(6);
        $data['tests']= $this->inventory_management_model->get_medical_test_by_patient_order();
        $data['page_title'] = lang('inventory_management_order');
        $data['fields'] = $this->custom_field_model->get_custom_fields(6);
        $data['pateints'] = $this->patient_model->get_patients_by_doctor();

        $data['body'] = 'inventory_management_order/edit';
        $this->load->view('template/main', $data);
    }

    function update($id){
        $save['name'] = $this->input->post('name');
        $save['quantity'] = $this->input->post('quantity');
        $save['supplier'] = $this->input->post('supplier');
        $save['date'] =  $this->input->post('dates');
        $inventory_management_key = $this->inventory_management_model->update_order($save,$id);
        echo 1;
        redirect('admin/inventory_management_order');
    }

    function delete($id=false){

        if($id){
            $this->inventory_management_model->delete_order($id);
            $this->session->set_flashdata('message',"Inventory Order Deleted");
            redirect('admin/inventory_management_order');
        }
    }
}