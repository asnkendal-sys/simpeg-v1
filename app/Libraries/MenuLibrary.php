<?php

namespace App\Libraries;

//use App\Modules\settings\contexts\Models\ContextModel;
//use App\Modules\settings\modules\Models\ModulesModel;

class MenuLibrary  {
    function __construct() {

    }
    //protected $open_menu ="<ul class=\"nav nav-sidebar\">";
    //protected $open_submenu ="<ul class=\"dropdown-menu first-menu\">";

    protected $open_menu ="<ul class='sidebar-menu'>";
    protected $open_submenu = '<ul class="treeview-menu">';
    
    public function createMenu(){
        $str_menu = $this->open_menu;
        $role_id = \Session::get('role_id');
        $user_id = \Session::get('user_id');

        /*cek data context user pengguna*/
        $rs = \DB::table('users')->where('id','=',$user_id)->first();
        if(($role_id > 1) and ($role_id != 5)){
            $idcontexts = explode(",",$rs->idcontexts);
            $contexts = \ContextModel::where('is_nav_bar', 1)
                ->where('flag', 1)
                ->whereIn('id', $idcontexts)
                ->orderBy('order')->get();
        }else{
            $contexts = \ContextModel::where('is_nav_bar', 1)
                ->where('flag', 1)
                ->orderBy('order')->get();
        }

        foreach($contexts as &$context ){
            $contextName = strtolower(str_replace(" ", "", $context->name));

            /*if($context->name == 'Web Services'){
                $cname = 'SIDATUK';
            }else{
                $cname = $context->name;
            }*/

            if($context->alias != ''){
                $cname = $context->alias;
            }else{
                $cname = $context->name;
            }

            if (\PermissionsLibrary::hasPermission('context-'.$contextName)){
                $route = \Request::path();
                //$active=(strpos($route, $contextName)!==false)?"open":"";
                if ($context->path !='') {
                    if (strtolower($context->name) == 'dashboard'){
                        $str_menu.="<li>";
                        $str_menu.="<a href='".url()."/dashboard'><i class='fa fa-dashboard'></i><span>".$cname."</span> <span class='".strtolower($contextName)."'></span></a>";
                        $str_menu.="</li>";                    
                    }
                    else{
                        $str_menu.="<li class='treeview'>";
                        $str_menu.="<i class='fa ".$context->icons."'></i><span>".$cname."</span> <span class='".strtolower($contextName)."'></span><i class='fa fa-angle-left pull-right'></i>";
                        $str_menu.="</li>";                    
                    }
                }else{
                    $str_menu.="<li class='treeview ".((session('role_id')>4)?'':'')."'>";
                    $str_menu.="<a href='#'><i class='fa ".$context->icons."'></i><span>".$cname."</span> <span class='".strtolower($contextName)."'></span><i class='fa fa-angle-left pull-right'></i></a>";
                    $str_menu.=$this->createSubMenu($cname, $context->id);
                    $str_menu.="</li>";
                }
            }            
        }
        $str_menu.="</ul>";
        return $str_menu;        
    }
    
    public function createMenuMhs(){
        $str_menu = $this->open_menu;
        $contexts = \MenumahasiswaModel::
//                where('is_nav_bar', 1)
//        ->where('flag', 1)
        orderBy('id')->get();
        foreach($contexts as &$context ){
            $contextName = strtolower(str_replace(" ", "", $context->judul));
            $route = \Request::path();
                //$active=(strpos($route, $contextName)!==false)?"open":"";
            if ($context->path !='') {
                $str_menu.="<li class='treeview'>";
                $str_menu.="<i class='fa ".@$context->icons."'></i><span>".$context->judul."</span><i class='fa fa-angle-left pull-right'></i>";
                $str_menu.="</li>";                    
            }else{
                $str_menu.="<li class='treeview'>";
                $str_menu.="<a href='#'><i class='fa ".$context->icons."'></i><span>".$context->name."</span><i class='fa fa-angle-left pull-right'></i></a>";
                $str_menu.=$this->createSubMenu($context->name, $context->id);
                $str_menu.="</li>";
            }
        }
        $str_menu.="</ul>";
        return $str_menu;        
    }
    
    /*private function createSubMenu($context, $context_id){
        $str_submenu = $this->open_submenu;
        $modules = \ContextModel::find($context_id)->modules()
                ->where('id_parent', '0')
                ->where('flag', 1)
                ->orderBy('order')->get();
        foreach($modules as &$module ){
            $module_name = str_replace(" ", "", $module->name);
            if (\PermissionsLibrary::hasPermission('mod-'.strtolower($module_name).'-index')){
                $have_child = \ModulesModel::where('id_parent',$module->id)->count();

                if($module->icons == ''){
                    $icon = 'fa-dot-circle-o';
                }else{
                    $icon = $module->icons;
                }
                    
                $str_submenu.="<li><a id='menu-akhir' href='".url().$module->path."'><i class='fa ".$icon."'></i>".$module->name."</a></li>";
            }
        }
        $str_submenu.="</ul>";
        return $str_submenu;
    }*/

    private function createSubMenu($context, $context_id){
        $str_submenu = $this->open_submenu;
        $modules = \ContextModel::find($context_id)->modules()
        ->where('id_parent', '0')
        ->where('flag', 1)
        ->orderBy('order')->get();
        foreach($modules as &$module ){
            $module_name = str_replace(" ", "", $module->name);
            if (\PermissionsLibrary::hasPermission('mod-'.strtolower($module_name).'-index')){
                $have_child = \ModulesModel::where('id_parent',$module->id)->orderBy('order')->get();

                if (count($have_child) > 0){
                    if($module->alias!=''){
                        $str_submenu.="<li class='".((session('role_id')==5)?'active':'')."'><a href='".url().$module->path."'><i class='fa ".$module->icons."'></i> ".$module->alias." <span class='".strtolower($module_name)."'></span><i class='fa fa-angle-left pull-right'></i></a><ul class='treeview-menu'>";
                    }else{
                        $str_submenu.="<li class='".((session('role_id')==5)?'active':'')."'><a href='".url().$module->path."'><i class='fa ".$module->icons."'></i> ".$module->name." <span class='".strtolower($module_name)."'></span><i class='fa fa-angle-left pull-right'></i></a><ul class='treeview-menu'>";}
                        foreach($have_child as &$module ){
                            $module_name2 = str_replace(" ", "", $module->name);
                            if (\PermissionsLibrary::hasPermission('mod-'.strtolower($module_name2).'-index')){
                                if($module->alias!='')
                                {
                                    $str_submenu.="<li><a id='menu-akhir' href='".url().$module->path."'><i class='fa ".$module->icons."'></i> ".$module->alias."<span class='".strtolower($module->name)." pull-right'></span></a></li>";
                                }else 
                                {
                                    if(session('role_id') == 3){
                                        if($module->name === 'Biodata'){
                                            $str_submenu.="<li><a id='menu-akhir' href='".url().$module->path."'><i class='fa ".$module->icons."'></i> ".$module->name."<span class='".strtolower($module_name2)." pull-right'></span></a></li>";
                                        }else{
                                            $str_submenu.="<li style='display: none'><a id='menu-akhir' href='".url().$module->path."'><i class='fa ".$module->icons."'></i> ".$module->name."<span class='".strtolower($module_name2)." pull-right'></span></a></li>";
                                        }
                                    }else{
                                        if($module->name == 'Biodata'){
                                            $str_submenu.="<li><a id='menu-akhir' href='".url().$module->path."'><i class='fa ".$module->icons."'></i> Data Pegawai<span class='".strtolower($module_name2)." pull-right'></span></a></li>";
                                        }else if($module->name == 'Data Pegawai'){
                                            if(session('role_id') != 5){
                                                $str_submenu.="<li><a id='menu-akhir' href='".url()."/epersonal/biodata/edit'><i class='fa ".$module->icons."'></i> Biodata<span class='".strtolower($module_name2)." pull-right'></span></a></li>";
                                            }
                                        }else {
                                            $str_submenu.="<li><a id='menu-akhir' href='".url().$module->path."'><i class='fa ".$module->icons."'></i> ".$module->name."<span class='".strtolower($module_name2)." pull-right'></span></a></li>";
                                        }
                                    }
                                }
                            }
                        }
                        $str_submenu.="</ul></li>";
                    }else{
                        $str_submenu.="<li><a id='menu-akhir' href='".url().$module->path."'><i class='fa ".$module->icons."'></i>".$module->name."<span class='".strtolower($module_name)." pull-right'></span></a></li>";
                    }
                }
            }
            $str_submenu.="</ul>";
            return $str_submenu;
        }


        private function createSubSubMenu($parent_id){
          $str_subsubmenu="<ul class=\"dropdown-menu\">";
          $str_subsubmenu .="<li role=\"presentation\" class=\"dropdown-header\">Sub Menu</li>";
          $modules = ModulesModel::where('id_parent', $parent_id)
          ->where('flag', 1)
          ->orderBy('order')->get();
          foreach($modules as $module ){
             $module_name = str_replace(" ", "", $module->name);
             if (\PermissionsLibrary::hasPermission('mod-'.strtolower($module_name).'-index')){
                $have_child = ModulesModel::where('id_parent',$module->id)->count();
                if ($have_child > 0){
                   $str_subsubmenu.="<li  class=\"dropdown-submenu\"><a href=\"". $module->path ."\">";
                   $str_subsubmenu.="<span class=\"glyphicon ". $module->icons ."\"></span> ". $module->name  ." </a>";

                   $str_subsubmenu.=$this->createSubSubMenu($module->id);
               }else{
                   $str_subsubmenu.="<li><a href=\"". $module->path ."\" class=\"".\Config::get('claravel::ajax')."\">";
                   $str_subsubmenu.="<span class=\"glyphicon ". $module->icons ."\"></span> ". $module->name  ." </a>";
               }
               $str_subsubmenu.="</li>";
           }
       } 
       $str_subsubmenu.="</ul>";
       return $str_subsubmenu;							  
   }
}

