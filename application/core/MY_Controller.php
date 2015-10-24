<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public $userId;
    public $userfullName;
    public $previlages;

    function __construct() {
        parent::__construct();
//        $this->userId = $this->session->userdata('userId');
//        $this->userfullName = $this->session->userdata('fullName');
//        if (empty($this->userId)) {
//            redirect('login');
//        } else {
//            $this->previlages = $this->session->userdata('previlages');
//        }
    }

    public function render($page, $data) {
        $this->load->view('template', $data);
    }

    public function render2($page = '', $data = '', $menu = 0, $jqValidateReq = FALSE) {
        $css = '';
        $navcolor = $this->session->userdata('navcolor');
        $color = $this->master_model->getNavColor($navcolor);
        if (!empty($data['page']) && $data['page'] == 'home') {
            $color = 'ffffff|0089D6|9BF7FF';
        }
        $color = explode('|', $color);
        if (!empty($color[0]) && !empty($color[1]) && !empty($color[2])) {
            $fontcolor = '#' . $color[0];
            $fromColor = '#' . $color[1];
            $toColor = '#' . $color[2];
            $css = '.navbar-inner {
					background-image: -moz-linear-gradient(top, ' . $fromColor . ', ' . $toColor . ');
					background-image: -webkit-gradient(linear, 0 0, 0 100%, from(' . $fromColor . '), to(' . $toColor . '));
					background-image: -webkit-linear-gradient(top, ' . $fromColor . ', ' . $toColor . ');
					background-image: -o-linear-gradient(top, ' . $fromColor . ', ' . $toColor . ');
					background-image: linear-gradient(to bottom, ' . $fromColor . ', ' . $toColor . ');
					}

					.navbar .nav > li > a {
					color: ' . $fontcolor . ' !important;
					}
					';
        }

        $menu['navcolorcss'] = $css;
        $menu['hide_ads'] = 1;
        $menu['jumbotron'] = $this->session->userdata('jumbotron');
        $menu['userid'] = $this->session->userdata('userid');
        $menu['username'] = $this->session->userdata('username');
        $usergroupid = $this->session->userdata('usergroupid');
        $groupdata = $this->master_model->Get_Group($usergroupid);
        $menu['usergroup'] = $groupdata[0]->MG_NAMEGROUP;
        $menu['groupid'] = $this->session->userdata('usergroupid');
        $menu['defaultappid'] = $this->session->userdata['defaultappid'];
        $fdata['jqValidateReq'] = $jqValidateReq;
        $fdata['isSessionAlive'] = (!empty($this->userid) && $this->userid > 0) ? 1 : 0;
        $this->load->view('header', $menu);
        $this->load->view($page, $data);
        $this->load->view('footer', $fdata);
    }

}

?>