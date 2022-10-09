<?php 
/**************************************************
* Layout Controller Library
* Create Date: 2022.10.08
* Last Update:
**************************************************/

class Layout {
   private $obj;
   private $layout;
   private $title;
   private $layout_data = array();
   private $site_idx;
   private $group_idx;
   private $react =false;


   public function get_obj() {
      return $this->obj;
   }

   public function __construct($layout = 'layout/layout_content') {
      $this->obj = &get_instance();
      $this->layout = $layout;

      $this->obj->load->model('Admin_menu_Model');
      $this->obj->load->model('Menu_Model');
      $this->obj->load->model('Helper_Model' , 'help');

      $this->obj->load->library('session');
      $this->obj->load->library('javascript');
      $this->obj->load->library('assets');
      $this->obj->load->library('asset_const');

      if($this->obj->help->select_fetch(array(), 'mobile')->mobileSiteType == '3'){   //사이트가 반응형인가
         $this->react = true;
      }
//      $this->layout_data['library_src'] = $this->obj->jquery->script();
//      $this->layout_data['script_head'] = $this->obj->jquery->_compile();
      $this->layout_data['assets'] = $this->obj->assets->get_data();
      $this->layout_data['consts'] = $this->obj->asset_const->get_resources();

      $this->site_idx = $this->layout_data['assets']['site']['siteIdx'];
      $this->group_idx = $this->layout_data['assets']['group']['groupIdx'];

      $this->layout_data['menu_upload_path'] = $this->layout_data['assets']['upload_path'].'menu/';

      //사이트 비활성상태시 차단
      if (intval($this->layout_data['assets']['site']['siteEnabled']) === 0) {
         show_error($this->layout_data['assets']['site']['siteCloseReason'], 500, '이 사이트는 현재 관리자에 의해 비활성화 되었습니다.');
      }

      $user = $this->obj->help->select_fetch(array('memberIdx' => $this->obj->session->userdata('member_idx') ) , 'member');
      if($user){
         $this->layout_data['memberName'] = $user->memberName;
      }

   }

   public function layout_view($layout) {
      $this->layout = $layout;
   }

   public function view($view, $data = null, $return = false) {
      $this->layout_data['content_for_layout'] = $this->obj->load->view($view, $data, true);
      $this->set_view_data($data);

      if($return) {
         $output = $this->obj->load->view($this->layout, $this->layout_data, true);
         return $output;
      } else {
         if($this->react){
            $this->obj->load->reactView($this->layout, $this->layout_data, false);
         }else{
            $this->obj->load->view($this->layout, $this->layout_data, false);
         }
      }
   }

   public function views($views, $data = null, $return = false) {
      $this->layout_data['content_for_layout'] = '';
      foreach ($views as $view) {
         $this->layout_data['content_for_layout'] .= $this->obj->load->view($view, $data, true);
      }
      $this->set_view_data($data);

      if($return) {
         $output = $this->obj->load->view($this->layout, $this->layout_data, true);
         return $output;
      } else {
         $this->obj->load->view($this->layout, $this->layout_data, false);
      }
   }

   public function title($title) {
      $this->title = $title;
   }










   //뷰에 사용되는 변수 세팅
   private function set_view_data($data) {

      $assets = $this->obj->assets->get_data();

      $this->layout_data['menu_code'] = $data['menu_code'];
      $this->layout_data['menu_idx'] = $data['menu_idx'];

      $this->layout_data['home_title'] = $this->layout_data['assets']['site']['siteName'];

      $this->layout_data['title_for_layout'] = $this->title;
      $this->layout_data['assets'] = $assets;


      $this->layout_data['menu'] = $this->get_current_menu($this->layout_data['menu_idx']);
      $this->layout_data['menu_list'] = $this->obj->Menu_Model->get_site_menu_list($this->site_idx, $this->group_idx);
      $this->layout_data['left_menu_list'] = $this->obj->Menu_Model->get_site_menu_list__defined('', array('root'=>$this->layout_data['menu']->root, 'siteIdx'=>$this->layout_data['assets']['site']['siteIdx'], 'groupIdx'=>$this->layout_data['assets']['site']['groupIdx']), array('step'=>'asc',));

      $this->layout_data['root_menu'] = $this->get_current_root_menu($this->layout_data['menu']->root);
      $this->layout_data['top_menus'] = $this->get_top_menu_list();
      $this->layout_data['left_menus'] = $this->get_left_menu_list($this->layout_data['menu']->root);
      $this->layout_data['site_menus'] = $this->get_main_menu_list();
      $this->layout_data['tab_menus'] = $this->get_tab_menu_list($this->layout_data['menu'], $this->layout_data['menu_list']);
      $this->layout_data['page_locations'] = $this->get_page_location();

      $this->layout_data['left_menus2'] = $this->get_left_menu_list2($this->layout_data['menu']->root, $this->layout_data['menu']->refer);
   }



   //현재메뉴 가져오기
   private function get_current_menu($menu_idx) {


      $menu = $this->obj->Menu_Model->get_site_menu_data($menu_idx, $this->site_idx, $this->group_idx);
      if (count($menu) == 0) {
         $menu = new stdClass;
         $fields = $this->obj->Menu_Model->get_site_menu_fields();
         foreach ($fields as $field) {
            $menu->$field = null;
         }
      }
      return $menu;
   }



   //현재메뉴의 주메뉴 가져오기
   private function get_current_root_menu($root) {
      $menu = $this->obj->Menu_Model->get_site_menu_data__defined('', array('root'=>$root, 'refer'=>0, 'siteIdx'=>$this->site_idx, 'groupIdx'=>$this->group_idx,));
      if (count($menu) == 0) {
         $menu = new stdClass;
         $fields = $this->obj->Menu_Model->get_site_menu_fields();
         foreach ($fields as $field) {
            $menu->$field = null;
         }
      }
      return $menu;
   }



   //[Top Menu]특수 메뉴 가져오기(GNB: Global Navigation Bar)
   private function get_top_menu_list() {
      $top_menu_list = array();
      $gnb_menu_list = $this->obj->Menu_Model->get_site_menu_list__defined('', array('refer'=>0, 'menuExclusiveCode'=>'GNB',), array('root'=>'asc', 'step'=>'asc'));
      foreach ($gnb_menu_list as $gnb_menu) {
         $menu_list = util_menu::extract_sub_menu_list($gnb_menu->menuIdx, $this->layout_data['menu_list']);

         //표시되어야할 메뉴만 추출
         foreach ($menu_list as $menu) {
            if ($menu->menuProperty == 0 //메뉴속성이 부가메뉴가 아니거나
               || $menu->menuActivated == 0 //메뉴가 비활성이거나
               || $menu->menuExpose == 9 //메뉴에 접근금지이거나
               || ($menu->menuExpose == 1 && intval($this->obj->session->userdata('member_idx')) > 0) //비로그인상태에만 보이는 메뉴에 로그인상태이거나
               || ($menu->menuExpose == 2 && intval($this->obj->session->userdata('member_idx')) == 0) //로그인상태에만 보이는 메뉴에 비로그인상태이거나
               || ($menu->menuExclusiveCode != 'SITEMAP' //사이트맵
                  && $menu->menuExclusiveCode != 'SEARCH' //통합검색
                  && $menu->menuExclusiveCode != 'LOGIN' //로그인
                  && $menu->menuExclusiveCode != 'SIGNUP' //회원가입
                  //&& $menu->menuExclusiveCode != 'LOST_ACCOUNT' //아이디/암호찾기
                  && $menu->menuExclusiveCode != 'LOGOUT' //로그아웃
                  && $menu->menuExclusiveCode != 'EDIT_ACCOUNT' //회원정보수정
                  //&& $menu->menuExclusiveCode != 'WITHDRAW' //회원탈퇴
               )
            ) continue; //건너뜀
            $top_menu_list[] = $menu;
         }
      }
      $xml = util_menu::XmlGNBMenu($top_menu_list, $this->layout_data['menu']->menuIdx, '/'.$this->layout_data['menu_upload_path'], false);
      $xml = preg_replace('/\<\?[a-z0-9 \=\"\.\-]+\?\>/i', '', $xml); //XML선언 제거
      return $xml;
   }



   //[Main Menu]전체 일반메뉴 가져오기(LNB: Local Navigation Bar)
   private function get_main_menu_list() {
      $menu_list = $this->layout_data['menu_list'];
      $menu_1step_list = array();


      //일반메뉴에서 받아내야할 root값만 받는다.
      $menuCheck = false;
      $user = $this->obj->help->select_fetch(array('memberIdx' => $this->obj->session->userdata('member_idx')), 'member');

      $allowMenu = array();
      if($user->memberCustType == 'adm' && $user->memberCustLevel != '최고관리자'){   //타입이 관리자일경우
         $menuCheck = true;
         $levels = $this->obj->help->select_fetch(array('levelName' => $user->memberCustLevel) , 'customer_level');

         if($levels){
            if($levels->levelAuth != ""){
               $levelJson = json_decode($levels->levelAuth);
               foreach($levelJson as $row){
                  //$menuRoot = $this->obj->help->select_fetch(array('menuName' => $row) , 'site_menu' , array('root'));
                  //depth=0 값만 호출(201106 ej.seo)
                  $menuRoot = $this->obj->help->select_fetch(array('menuName' => $row, 'depth' => '0') , 'site_menu' , array('root'));
                  $allowMenu[] = $menuRoot->root;
               }
            }
         }else{
            $this->obj->help->alert('사용자 권한이 달라 메뉴를 로드하지못하였습니다');
         }

      }else if($user->memberCustType == 'out'){   //타입이 협력업체일경우
         $menuCheck = true;
      }


      //표시되어야할 메뉴만 추출
      foreach ($menu_list as $menu) {

         $propertyCheck = true;
         if($user->memberCustType == 'out'){
            $propertyCheck = $menu->menuProperty <2 ? true:false;
         }else{
            $propertyCheck = $menu->menuProperty > 0 ? true:false;
         }

         if ($menu->depth > 1 //서브메뉴가 1단계보다 크거나
            || $propertyCheck //메뉴속성이 일반메뉴가 아니거나
            || $menu->menuActivated == 0 //메뉴가 비활성이거나
            || $menu->menuExpose == 9 //메뉴에 접근금지이거나
            || ($menu->menuExpose == 1 && intval($this->obj->session->userdata('member_idx')) > 0) //비로그인상태에만 보이는 메뉴에 로그인상태이거나
            || ($menu->menuExpose == 2 && intval($this->obj->session->userdata('member_idx')) == 0) //로그인상태에만 보이는 메뉴에 비로그인상태이거나
         ) continue; //건너뜀

         if($menuCheck && sizeOf($allowMenu) > 0){
            if(!in_array($menu->root , $allowMenu)){
               continue;
            }
         }

         $menu_1step_list[] = $menu;
      }

      $xml = util_menu::XmlLNBMenu($menu_1step_list, $this->layout_data['menu']->menuIdx, '/'.$this->layout_data['menu_upload_path'], true);
      $xml = preg_replace('/\<\?[a-z0-9 \=\"\.\-]+\?\>/i', '', $xml); //XML선언 제거
      return $xml;
   }



   //[Left Menu]현재 주메뉴의 하위메뉴 가져오기(SNB: Sub Navigation Bar)
   private function get_left_menu_list($root) {
      $menu_list = $this->obj->Menu_Model->get_site_menu_list__defined('', array('root'=>$root, 'siteIdx'=>$this->layout_data['assets']['site']['siteIdx'], 'groupIdx'=>$this->layout_data['assets']['site']['groupIdx']), array('step'=>'asc',));
      $left_menu_list = array();
      $tab_level = -1;

      //표시되어야할 메뉴만 추출
      foreach ($menu_list as $menu) {
         if ($menu->menuActivated == 0 //메뉴가 비활성이거나
            || $menu->menuExpose == 9 //메뉴에 접근금지이거나
            || ($menu->menuExpose == 1 && intval($this->obj->session->userdata('member_idx')) > 0) //비로그인상태에만 보이는 메뉴에 로그인상태이거나
            || ($menu->menuExpose == 2 && intval($this->obj->session->userdata('member_idx')) == 0) //로그인상태에만 보이는 메뉴에 비로그인상태이거나
            || ($tab_level != -1 && $tab_level < $menu->depth) //탭메뉴이거나
         ) continue; //건너뜀
         $tab_level = $menu->menuShape == 1 ? $menu->depth : -1;if ($tab_level != -1 && $tab_level <= $menu->depth) continue;
         $left_menu_list[] = $menu;
      }

      $xml = util_menu::XmlSNBMenu($left_menu_list, $this->layout_data['menu']->menuIdx, '/'.$this->layout_data['menu_upload_path']);
      $xml = preg_replace('/\<\?[a-z0-9 \=\"\.\-]+\?\>/i', '', $xml); //XML선언 제거
      return $xml;
   }



   //[Left Menu]현재 주메뉴의 하위메뉴 가져오기(SNB: Sub Navigation Bar)
   private function get_left_menu_list2($root, $refer) {
      $menu_list = $this->obj->Menu_Model->get_site_menu_list__defined('', array('root'=>$root, 'siteIdx'=>$this->layout_data['assets']['site']['siteIdx'], 'groupIdx'=>$this->layout_data['assets']['site']['groupIdx'], 'refer'=>$refer, 'depth'=>'3'), array('step'=>'asc',));
      $left_menu_list = array();
      $tab_level = -1;

      //표시되어야할 메뉴만 추출
      foreach ($menu_list as $menu) {
         if ($menu->menuActivated == 0 //메뉴가 비활성이거나
            || $menu->menuExpose == 9 //메뉴에 접근금지이거나
            || ($menu->menuExpose == 1 && intval($this->obj->session->userdata('member_idx')) > 0) //비로그인상태에만 보이는 메뉴에 로그인상태이거나
            || ($menu->menuExpose == 2 && intval($this->obj->session->userdata('member_idx')) == 0) //로그인상태에만 보이는 메뉴에 비로그인상태이거나
            || ($tab_level != -1 && $tab_level < $menu->depth) //탭메뉴이거나
         ) continue; //건너뜀
         $tab_level = $menu->menuShape == 1 ? $menu->depth : -1;if ($tab_level != -1 && $tab_level <= $menu->depth) continue;
         $left_menu_list[] = $menu;
      }

      $xml = util_menu::XmlSNBMenu2($left_menu_list, $this->layout_data['menu']->menuIdx, '/'.$this->layout_data['menu_upload_path']);
      $xml = preg_replace('/\<\?[a-z0-9 \=\"\.\-]+\?\>/i', '', $xml); //XML선언 제거
      return $xml;
   }



   //[Tab Menu]현재 메뉴의 탭메뉴 가져오기
   private function get_tab_menu_list($menu, $menu_list) {
      $tab_menus = '<ul>';
      $affiliated = false;
      $tab_refer = $menu->refer;

      //표시되어야할 탭메뉴만 추출
      foreach ($menu_list as $sm) {
         if ($sm->menuActivated == 0 //메뉴가 비활성이거나
            || $sm->menuExpose == 9 //메뉴에 접근금지이거나
            || ($sm->menuExpose == 1 && intval($this->obj->session->userdata('member_idx')) > 0) //비로그인상태에만 보이는 메뉴에 로그인상태이거나
            || ($sm->menuExpose == 2 && intval($this->obj->session->userdata('member_idx')) == 0) //로그인상태에만 보이는 메뉴에 비로그인상태이거나
            || $sm->refer != $menu->refer //현재의 주메뉴그룹에 속하지 않거나
            || $sm->depth < 2 //탭메뉴 가능레벨이 아니거나
            || $sm->menuShape != 1 //탭메뉴 설정이 안되어 있거나
            || ($sm->refer != $menu->menuIdx && $sm->depth != $menu->depth) //현재메뉴의 하위메뉴도 아니고 탭메뉴와 같은 레벨도 아니거나
            || ($sm->step < $menu->step && $tab_refer != $sm->refer) //현재메뉴보다 이전메뉴이거나
         ) continue; //건너뜀
         if ($tab_refer != 0 && $tab_refer != $sm->refer) break;
         $tab_refer = intval($sm->refer);
         if ($sm->menuIdx == $menu->menuIdx || ($sm->refer == $menu->menuIdx && $menu->depth + 1 == $sm->depth)) $affiliated = true; //현재메뉴가 자식탭메뉴를 갖고 있는지 또는 탭메뉴 레벨에 소속되어 있는지를 한번이상 거쳐야만 탭메뉴 표시
         $menu_name = $sm->menuType == 1 ? '<img src="'.'/'.$this->layout_data['menu_upload_path'].($sm->menuIdx == $menu->menuIdx ? $sm->imageMenuHover : $sm->imageMenu).'" alt="" />' : ($sm->menuIdx == $menu->menuIdx ? '<strong>'.$sm->menuName.'</strong>' : $sm->menuName);
         $tab_menus .= '<li><a href="'.$this->layout_data['assets']['index'].'/content/'.$sm->menuIdx.'">'.$menu_name.'</a></li>';
      }
      $tab_menus .= '</ul>';
      return $affiliated ? $tab_menus : null;
   }



   //[Page Location]현재 메뉴의 경로 가져오기(PN: Page Navigation)
   private function get_page_location() {
      $page_locations = array();
      $temp_step = $this->layout_data['menu']->step;
      $temp_depth = $this->layout_data['menu']->depth;
      $menu_list = $this->layout_data['menu_list'];
      $menu_list = array_reverse($menu_list);

      foreach ($menu_list as $menu) {
         $menu_idx = intval($menu->menuIdx);
         $root = intval($menu->root);
         $refer = intval($menu->refer);
         $step = intval($menu->step);
         $depth = intval($menu->depth);
         $menu_name = $menu->menuName;

         //주메뉴일 경우
         if ($this->layout_data['menu']->refer == 0) {
            $page_locations[] = (object)array('menuIdx'=>$this->layout_data['menu']->menuIdx, 'menuName'=>$this->layout_data['menu']->menuName);
            break;
         }

         //부모메뉴 검색
         while ($root == $this->layout_data['menu']->root && $step <= $temp_step - 1 && $depth <= $temp_depth - 1) {
            $page_locations[] = (object)array('menuIdx'=>$menu_idx, 'menuName'=>$menu_name);

            $temp_step = $step;
            $temp_depth = $depth;

            if ($refer == 0) { break 2; }
         }
      }

      return array_reverse($page_locations);
   }


}