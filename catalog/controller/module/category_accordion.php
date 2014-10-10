<?php
class ControllerModuleCategoryAccordion extends Controller {
	protected $category_id = 0;
	protected $parent_id = 0;
	protected $path = array();
       
      
   


        /*------------------------------------------------------------------------------*/

	protected function index() {
            
                    
                    
		$this->language->load('module/category_accordion');
	   	$this->data['heading_title'] = $this->language->get('heading_title');
		$this->load->model('catalog/category');
		
		if (isset($this->request->get['path'])) {
			$this->path = explode('_', $this->request->get['path']);
			
			$this->category_id = end($this->path);
		}
		
		$this->data['category_accordion'] = $this->loadCategories(0, '','', $this->category_id);
		$this->data['category_accordion_cid'] = $this->category_id;
		$this->data['category_accordion_jquery_path'] = $this->config->get('config_url') . '/catalog/view/javascript/jquery';
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/category_accordion.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/category_accordion.tpl';
		} else {
			$this->template = 'default/template/module/category_accordion.tpl';
		}
	
		$this->render();
	}
	
	/*------------------------------------------------------------------------------*/
        
	protected function loadCategories($parent_id, $current_path = '', $level='',$cid = '') {
           

                $category_id = array_shift($this->path);
                $this->getCategoriesFromdb($category_id);
		
		$results = $this->model_catalog_category->getCategories($parent_id);
                
             
		$ret_string = '';
		if ($results & $parent_id == 0 ) { 
		$ret_string .= '<ul id="mega-1" class="mega-menu right">'; 
		
		}
		
		foreach ($results as $result) {	
                  
			if (!$current_path) {
                        $new_path = $result['category_id'];
			} else {
                          $new_path = $current_path . '_' . $result['category_id'];
			}
			
			
			$children = '';
                        if ($result['top']==1) {
                       $ret_string .= '<li data-submenu-id="sub' . $result['category_id'] . '" class="dc-mega-li">';
                      
                          
                        
                        if ($cid == $result['category_id']) {
				$classactive = 'activemenu';
			} else {
				$classactive = '';
			}
                         $children = $this->loadChildrens($result['category_id'], $new_path);   
			
                         
                        if ($children) {
                            $ret_string .= '<a class="dc-mega ' . $classactive . '" href="' . $this->url->link('product/category','path=' .  $new_path)  . '">' . $result['name'] . '<span class="dc-mega-icon"> </span></a> ';
                            $ret_string .= $children;
                        } else {
                            $ret_string .= '<a class="dc-mega ' . $classactive . '" href="' . $this->url->link('product/category','path=' .  $new_path)  . '">' . $result['name'] . '</a> ';
                      
                        }
			
        	$ret_string .= '</li>'; 
		}
                }
                
 		
		if ($results) $ret_string .= '</ul>';   
		return $ret_string;
                
	}
        
        protected function loadChildrens($parent_id, $current_path = '',$last='' ) {
            $results = $this->model_catalog_category->getCategories($parent_id);
            
            $child_string = '';
            if ($results && empty($last) ) {
            $child_string.='<div  id="sub'.$parent_id.'" class="sub-container mega" style="display:none;min-width:500px"><ul class="sub">';
            }
             if ($last=='last')
             { $child_string.="<ul>";
                 for ($l=0,$size = count($results);$l < $size;$l++) {
                   $new_path = $current_path . '_' . $results[$l]['category_id'];  
                   if ($l<$this->config->get('menu_elements'))
                   {
                    $child_string.='<li><a href="'.$this->url->link('product/category','path=' . $new_path).'">'.$results[$l]['name'].'</a></li>';
                   } elseif ($l==$this->config->get('menu_elements')) {
                       $child_string.="<li class=\"showall\"><span class=\"dashed\" onclick=\"var ul=$(this).closest('UL');$(this).remove();ul.children('*').removeClass('hidden');\">ПОКАЗАТЬ ВСЕ ПОДГРУППЫ</span></li>";
                   } else {
                    $child_string.='<li class="hidden"><a href="'.$this->url->link('product/category','path=' . $new_path).'">'.$results[$l]['name'].'</a></li>';
                   }
                       
                   
                   }
                 $child_string.="</ul>";
                 return $child_string;
             }
             
         
            for ($j=0,$size = count($results);$j < $size;$j+=3) {
                $child_string.='<div class="row first" style="width: 900px;">';
                
                 for ($i=$j;$i < $j+3 && $i<$size;$i++) {
                                                            
             $new_path = $current_path . '_' . $results[$i]['category_id']; 
                            
             $child_string.='<li class="mega-unit mega-hdr"><a href="'.$this->url->link('product/category','path=' . $new_path).'" class="mega-hdr-a" style="height: 16px;">'.$results[$i]['name'].'</a>';
              
                     $lastchilds='';
                    $lastchilds=$this->loadChildrens($results[$i]['category_id'],$new_path,'last');
                    $child_string.=$lastchilds."</li>";
              }
                $child_string.='</div>';
                }
                
           if ($results) {
           $child_string.='</ul></div>';  
            }
            return $child_string;
          
           
        }
             
 
	/*------------------------------------------------------------------------------*/
	
	protected function getCategoriesFromdb($category_id) {
		if($category_id <=0) return false;
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'");
	
		if ($query->row['parent_id'] == 0) {
			$this->parent_id = $category_id;
		} else { 
			$this->getCategoriesFromdb($query->row['parent_id']);
		}
	}	
}
?>