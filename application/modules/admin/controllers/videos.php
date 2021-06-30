<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class videos extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->auth->check_session();
		error_reporting(0);
        $this->load->model("videos_model"); 
	}
	

	
	function index()
	{	

		$admin_se = $this->session->userdata('admin');
		if(!isset($admin_se['id']) || empty($admin_se['id'])){
			redirect('admin');
		}else{
			$id = $admin_se['id'];
		}
		
		$data['page_title']		= lang('Videos');
		
		
		
			if($admin_se['user_role']=='Admin'){
				$data['body'] = 'videos/admin';
			}else{
				$data['body'] = 'videos/list';
			}
			
			$this->load->view('template/main', $data);
		
	}
	
	function VideoNameAutoComplete(){
            $term = $this->input->get('term');
            $data = $this->videos_model->search($term);

            $data = json_decode(json_encode($data),TRUE);
            $result = array( );
            foreach ($data as $key => $value) {
                # code...
                foreach ($value as $key2 => $value2) {
                    # code...
                    array_push($result,$value2);
                }
                
                
            }

            echo json_encode($result);
	}


	function GetVideos (){

        $term = $this->input->get('name');
        $data = $this->videos_model->search_by_title($term);
        $data = json_decode(json_encode($data),TRUE);

        

		$html = '<style type="text/css">
            .videodiv {
                font-size: 14px !important;
                color: #333 !important;
                font-weight: bold !important;
                text-align: center;
                padding: 25px;
                font-family: Arial;
                display: none;
            }
            .title {
                white-space:pre;
                overflow:hidden;
                text-overflow: ellipsis;
                margin-top: 5px;
                color: #333 !important;
                font-weight: bold !important; 
               
            }
           
        </style>';

        
            $result = array( );
            foreach ($data as $key => $value) {
                # code...
               
            $html .=  '<div class="col-md-3 col-sm-6 col-xs-12 videodiv" style="cursor: pointer; display: block;" data-href="https://www.youtube.com/embed/'.$value['key'].'?autoplay=1" data-title="'.$value['title'].'">
                    <a>
                        <img class="youtube-videogallery-img" src="https://img.youtube.com/vi/'.$value['key'].'/0.jpg" style="width:100%;"><div class="title">'.$value['title'].'</div>

                    </a>
                    </div>';
                
                
            }

        
          
$html .=  '<div class="input-group-btn text-center">
        <a href="#" id="loadMore" class="btn btn-md btn-primary" style="">Load More</a>
    </div>

        <div id="popupvideo" class="modal fade ">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">

                        <button type="button" id="CancelVideo" data-dismiss="modal" class="btn btn-sm pull-right btn-primary"><i class="fa fa-times"></i></button>
                        <h3 class="modal-title heading_modal "></h3>
                    </div>
                    <div class="modal-body">


                        <div><iframe id="youtube-videogallery-iframe" width="100%" height="400px" src="about:blank" allowfullscreen=""></iframe></div>
                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script language="javascript" type="text/javascript">
      
        $(document).ready(function () {


                if (screen.availWidth > 980) {
                    $("#mobscreen").html("");

                    $("#bigscreen").show();
                    $("#expensefilter").css("left", "45%");
                }
                else {
                    $("#bigscreen").html("");
                    $("#mobscreen").show();
                }


		});
               
            $(document).ready(function () {

                
                $("#popupvideo").on("hidden.bs.modal", function (e) {
                  
                    $("#popupvideo iframe").removeAttr("src");
                });
            

                $(function () {
                    $(".videodiv").slice(0, 12).show();
                    if ($(".videodiv").length > 12)
                    {
                        $("#loadMore").show();
                    }
                    
                    $("#loadMore").on("click", function (e) {
                        e.preventDefault();
                        
                        if ($(".videodiv:hidden").length > 0) {
                            
                            $(".videodiv:hidden").slice(0, 48).slideDown();
                        }
                        else {
                            $("#loadMore").hide();
                            DisplayMessage("No more videos available.")
                        }
                        if ($("div:hidden").length == 0) {
                            $("#load").fadeOut("slow");
                        }
                        $("html,body").animate({
                            scrollTop: $(this).offset().top
                        }, 1500);
                    
                });
            
                });

                $(".videodiv").on("click", function () {

                    console.log("clicked function called.");
                    $("#popupvideo").modal("show");

                    $("#youtube-videogallery-iframe").attr("src", $(this).attr("data-href"));
                    $("#popupvideo .modal-title").text($(this).attr("data-title"));
                });

                $("#popupvideo").modal("hide");
               

                $("#popupvideo").on("hidden.bs.modal", function (e) {
                    // do something...
                    $("#youtube-videogallery-iframe").attr("src", $("#youtube-videogallery-iframe").attr("src"));
                });
            });


        </script>';

        echo $html;

	}
	
	
	function add()
	{	

        if ($this->input->server('REQUEST_METHOD') === 'POST') {

           

            $admin_se = $this->session->userdata('admin');
            if(!isset($admin_se['id']) || empty($admin_se['id'])){
                  echo 'Error occurred while saving record!';
                  exit();
            } else{
              
                if($admin_se['user_role']=='Admin'){
                    $save['title'] = $this->input->post('title');
                    $save['link'] = $this->input->post('link');
                    $save['key'] = $this->input->post('key');

                     $this->videos_model->save($save);

                    echo '1';
                }else{
                
                    echo 'Error occurred while saving record!';
                     exit();
                }
        }
            
           
        }else{

            echo 'Error occurred while saving record!';

        }	
	}
	
	function check_username($str)
	{
		$email = $this->auth->check_username($str, $this->admin_id);
		if ($email)
		{
			$this->form_validation->set_message('check_username', lang('username_is_taken'));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
}