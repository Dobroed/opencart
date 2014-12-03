<?php
class ControllerModuleJVProductsInM extends Controller {
	/* Johnny_vega */
	
	private function create_sorting_parametrs() { 
		/* Сортировка - Параметр */	
		$this->load->language('module/jv_products_in_m');	
		
		$array_sorting_parametrs = array();
		
		$array_sorting_parametrs[] = array(
			'sorting_parametrs_id' => 'pd.name',
			'name'        		=> $this->language->get('text_sorting_name')
		);
		
		$array_sorting_parametrs[] = array(
			'sorting_parametrs_id' => 'p.model',
			'name'        => $this->language->get('text_sorting_model')
		);
		
		$array_sorting_parametrs[] = array(
			'sorting_parametrs_id' => 'p.quantity',
			'name'        => $this->language->get('text_sorting_quantity')
		);
		
		$array_sorting_parametrs[] = array(
			'sorting_parametrs_id' => 'p.price',
			'name'        => $this->language->get('text_sorting_price')
		);	

		$array_sorting_parametrs[] = array(
			'sorting_parametrs_id' => 'rating',
			'name'        => $this->language->get('text_sorting_rating')
		);

		$array_sorting_parametrs[] = array(
			'sorting_parametrs_id' => 'p.sort_order',
			'name'        => $this->language->get('text_sorting_sort_order')
		);

		$array_sorting_parametrs[] = array(
			'sorting_parametrs_id' => 'p.date_added',
			'name'        => $this->language->get('text_sorting_date_added')
		);	
		
		return $array_sorting_parametrs;
		/* Сортировка - Параметр */	
	}
	
	private function create_rating_parametrs() { 
	/* Сортировка рейтинг */
		$array_rating_parametrs = array();
		for ($i = 0; $i < 6; $i++) { 
			$array_rating_parametrs[] = array(
				'rating_parametrs_id' => $i,
				'name'        => $i
			);
		};
	
		return $array_rating_parametrs;
	}	
	
	private function create_carousel_wrap_parametrs() { 
		$this->load->language('module/jv_products_in_m');
		
		$array_carousel_wrap_parametrs = array();
		
		$array_carousel_wrap_parametrs[] = array(
				'carousel_wrap_parametrs_id' => '',
				'name'        => $this->language->get('text_carousel_wrap_none')
		);
		
		$array_carousel_wrap_parametrs[] = array(
				'carousel_wrap_parametrs_id' => 'first',
				'name'        => $this->language->get('text_carousel_wrap_first')
		);
		
		$array_carousel_wrap_parametrs[] = array(
				'carousel_wrap_parametrs_id' => 'last',
				'name'        => $this->language->get('text_carousel_wrap_last')
		);
		
		$array_carousel_wrap_parametrs[] = array(
				'carousel_wrap_parametrs_id' => 'both',
				'name'        => $this->language->get('text_carousel_wrap_both')
		);
		
		$array_carousel_wrap_parametrs[] = array(
				'carousel_wrap_parametrs_id' => 'circular',
				'name'        => $this->language->get('text_carousel_wrap_circular')
		);
	
		return $array_carousel_wrap_parametrs;
	}	
	
	private $error = array(); 
	
	public $version = 'v1.88';
	
	public function index() {  

		$this->load->language('module/jv_products_in_m');

		$this->document->setTitle(strip_tags($this->language->get('heading_title')) . ' ' .  $this->version);
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('jv_products_in_m', $this->request->post);		

			$this->session->data['success'] = $this->language->get('text_success');
			
			if(isset($this->request->post['save_continue']) and $this->request->post['save_continue'])
				$this->redirect($this->url->link('module/jv_products_in_m', 'token=' . $this->session->data['token'], 'SSL'));
			else
				$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = strip_tags($this->language->get('heading_title')) . ' ' .  $this->version;		
				
		$lang_vars = array(
			
			'tab_text_common', 'tab_text_sorting',
			'tab_text_endedsorting', 'tab_text_carousel',
			
			'text_enabled', 'text_disabled',
			'text_select_all', 'text_unselect_all',
			
			'text_content_top', 'text_content_bottom',
			'text_column_left', 'text_column_right',
			
			'text_sorting_type_asc', 'text_sorting_type_desc',
			
			'text_rating', 'text_rating_from', 'text_rating_to',
			
			'text_quantity', 'text_quantity_from', 'text_quantity_to',
			
			'text_output_random', 'text_output_sequential',
			
			'entry_finalsorting',
			
			'text_recomended', 'text_specials',
			'text_bestsellers', 'text_latest',
			'text_popular',
			
			'entry_layout', 'entry_position',
			'entry_status', 'entry_sort_order',
			
			'entry_category', 'entry_headingtitle', 'entry_adding_class_to_box', 'entry_adding_id_to_box', 
			'entry_image', 'entry_limit',
			
			'entry_sorting',
			
			'entry_graphic_output', 'text_graphic_output_normal',
			'text_graphic_output_carousel', 'entry_carousel_scroll',
			'text_carousel_autoscroll', 'entry_carousel_direction',
			'text_carousel_direction_ltr', 'text_carousel_direction_rtl',
			
			'entry_carousel_time_autoscroll', 
			'entry_carousel_wrap',
			'entry_output',
			
			'button_save', 'button_save_stay',
			'button_cancel', 'button_add_module',
			'button_remove',
			
			'tab_module'
        );
		
        foreach ($lang_vars as $lang_var) {
			$this->data[$lang_var] = $this->language->get($lang_var);
        }		
		
		$this->data['carousel_wrap_parametrs'] = $this->create_carousel_wrap_parametrs();

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		$error_vars = array(
			'image' 					=> 'error_image',
			'limit' 					=> 'error_limit',
			'quantity_sorting' 			=> 'error_quantity_sorting',
			'carousel_scroll' 			=> 'error_carousel_scroll',
			'carousel_time_autoscroll' 	=> 'error_carousel_time_autoscroll'
        );
		
        foreach ($error_vars as $key => $value) {
			if (isset($this->error[$key])) {
				$this->data[$value] = $this->error[$key];
			} else {
				$this->data[$value] = array();
			}
        }

		// breadcrumbs
		
		$this->document->breadcrumbs = array();
		
		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);
		
		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' =>  ' :: '
   		);
		
		$this->data['breadcrumbs'][] = array(
       		'text'      => strip_tags($this->language->get('heading_title')) . ' ' .  $this->version,
			'href'      => $this->url->link('module/jv_products_in_m', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' =>  ' :: '
   		);
		// breadcrumbs
		
		$this->load->model('catalog/category');
		$results = $this->model_catalog_category->getCategories(0);

		foreach ($results as $result) {
			//	 
			$path = $this->model_catalog_category->getCategory($result['category_id']);
			
			$this->data['categories'][] = array(
				'category_id' => $result['category_id'],
				'name'        => $result['name'],
				'href'        => $this->url->link('catalog/category', 'token=' . $this->session->data['token'] . '&' . 'path=' . $path['category_id'],  'SSL')
				//
			);
		}
			
		$this->data['action'] = $this->url->link('module/jv_products_in_m', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['modules'] = array();	

		// НАСТРОЙКИ
		if (isset($this->request->post['jv_products_in_m_module'])) {
			$this->data['modules'] = $this->request->post['jv_products_in_m_module'];
		} elseif ($this->config->get('jv_products_in_m_module')) { 
			$this->data['modules'] = $this->config->get('jv_products_in_m_module');
		}	

		/* Сортировка - Параметр */	
		$this->data['sorting_parametrs'] = $this->create_sorting_parametrs();
		
		/* Сортировка рейтинг */
		$this->data['rating_parametrs'] = $this->create_rating_parametrs();
		
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		
		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		$this->template = 'module/jv_products_in_m.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/jv_products_in_m')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (isset($this->request->post['jv_products_in_m_module'])) {
			foreach ($this->request->post['jv_products_in_m_module'] as $key => $value) {
				if (!$value['image_width'] || !$value['image_height']) {
					$this->error['image'][$key] = $this->language->get('error_image');
				}
			}
		}
		
		if (isset($this->request->post['jv_products_in_m_module'])) {
			foreach ($this->request->post['jv_products_in_m_module'] as $key => $value) {
				if ( ($value['quantity_sorting_from'] < '0')  || ($value['quantity_sorting_to'] < '0') ) {
					$this->error['quantity_sorting'][$key] = $this->language->get('error_quantity_sorting');
				}
			}
		}	
		
		if (isset($this->request->post['jv_products_in_m_module'])) {
			foreach ($this->request->post['jv_products_in_m_module'] as $key => $value) {
				if ($value['limit'] < 1) {
					$this->error['limit'][$key] = $this->language->get('error_limit');
				}
			}
		}
		
		if (isset($this->request->post['jv_products_in_m_module'])) {
			foreach ($this->request->post['jv_products_in_m_module'] as $key => $value) {
				if ($value['carousel_scroll'] < 1) {
					$this->error['carousel_scroll'][$key] = $this->language->get('error_carousel_scroll');
				}
			}
		}
		
		if (isset($this->request->post['jv_products_in_m_module'])) {
			foreach ($this->request->post['jv_products_in_m_module'] as $key => $value) {
				if ($value['carousel_time_autoscroll'] < 1) {
					$this->error['carousel_time_autoscroll'][$key] = $this->language->get('error_carousel_time_autoscroll');
				}
			}
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}
?>