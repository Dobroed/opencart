<?php
	function cmp_name_asc($a, $b) {
		return strcmp(strtoupper($a["name"]), strtoupper($b["name"]));
	}
	
	function cmp_name_desc($a, $b) {
		return strcmp(strtoupper($b["name"]), strtoupper($a["name"]));
	}

	function cmp_model_asc($a, $b) {
		return strcmp(strtoupper($a["model"]), strtoupper($b["model"]));
	}
	
	function cmp_model_desc($a, $b) {
		return strcmp(strtoupper($b["model"]), strtoupper($a["model"]));
	}

	function cmp_quantity_asc($a, $b) {
		if ($a["quantity"] == $b["quantity"]) {
        return 0;
		}
    return ($a["quantity"] < $b["quantity"]) ? -1 : 1;
	}
	
	function cmp_quantity_desc($a, $b) {
		if ($a["quantity"] == $b["quantity"]) {
        return 0;
		}
    return ($a["quantity"] > $b["quantity"]) ? -1 : 1;
	}	
	
	function cmp_price_asc($a, $b) {
		if ( isset($a["special"]) && !isset($b["special"]) ) {
			if ($a["special"] == $b["price"]) {
				return 0;
			}
			return ($a["special"] < $b["price"]) ? -1 : 1;
		}
		
		if ( !isset($a["special"]) && $b["special"] ) {
			if ($a["price"] == $b["special"]) {
				return 0;
			}
			return ($a["price"] < $b["special"]) ? -1 : 1;
		}

		if ( isset($b["special"]) && isset($b["special"]) ) {
			if ($a["special"] == $b["special"]) {
				return 0;
			}
			return ($a["special"] < $b["special"]) ? -1 : 1;
		}
		

		if ($a["price"] == $b["price"]) {
			return 0;
		}
			return ($a["price"] < $b["price"]) ? -1 : 1;
	}
	
	function cmp_price_desc($a, $b) {
		
		if ( isset($a["special"]) && !isset($b["special"]) ) {
			if ($a["special"] == $b["price"]) {
				return 0;
			}
			return ($a["special"] > $b["price"]) ? -1 : 1;
		}
		
		if ( !isset($a["special"]) && $b["special"] ) {
			if ($a["price"] == $b["special"]) {
				return 0;
			}
			return ($a["price"] > $b["special"]) ? -1 : 1;
		}

		if ( isset($b["special"]) && isset($b["special"]) ) {
			if ($a["special"] == $b["special"]) {
				return 0;
			}
			return ($a["special"] > $b["special"]) ? -1 : 1;
		}
		

		if ($a["price"] == $b["price"]) {
			return 0;
		}
			return ($a["price"] > $b["price"]) ? -1 : 1;
	}	

	function cmp_rating_asc($a, $b) {
		if ($a["rating"] == $b["rating"]) {
        return 0;
		}
    return ($a["rating"] < $b["rating"]) ? -1 : 1;
	}
	
	function cmp_rating_desc($a, $b) {
		if ($a["rating"] == $b["rating"]) {
        return 0;
		}
    return ($a["rating"] > $b["rating"]) ? -1 : 1;
	}	
	
	function cmp_sort_order_asc($a, $b) {
		if ($a["sort_order"] == $b["sort_order"]) {
        return 0;
		}
    return ($a["sort_order"] < $b["sort_order"]) ? -1 : 1;
	}
	
	function cmp_sort_order_desc($a, $b) {
		if ($a["sort_order"] == $b["sort_order"]) {
        return 0;
		}
    return ($a["sort_order"] > $b["sort_order"]) ? -1 : 1;
	}		
	
	function cmp_date_added_asc($a, $b) {
		if ($a["date_added"] == $b["date_added"]) {
        return 0;
		}
    return ($a["date_added"] < $b["date_added"]) ? -1 : 1;
	}
	
	function cmp_date_added_desc($a, $b) {
		if ($a["date_added"] == $b["date_added"]) {
        return 0;
		}
    return ($a["date_added"] > $b["date_added"]) ? -1 : 1;
	}		

class ControllerModuleJVProductsInM extends Controller {
	
	protected function index($setting) {
		static $module = 0;
	
		$this->language->load('module/jv_products_in_m');
		
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		$this->load->model('catalog/review');
		
		// ���������
      	if ($setting['headingtitle']) {
			$this->data['heading_title'] = $setting['headingtitle'][$this->config->get('config_language_id')];
			} else {
				$this->data['heading_title'] = $this->language->get('heading_title');
		}					
		
		$this->data['adding_class_to_box'] = $setting['adding_class_to_box'];
		$this->data['adding_id_to_box'] = $setting['adding_id_to_box'];
		
		$this->data['button_cart'] = $this->language->get('button_cart');

		$this->data['position'] = $setting['position'];  // ������� ������
		
		$this->data['products'] = array();
		$results = array();
		
		$this->load->model('catalog/category');
		$categories = $this->model_catalog_category->getCategories(0); // �������� ��� ���������
		foreach ($setting['category'] as $value) {  
			{
				$data = array(
					'filter_category_id' => $value,  
					'sort'  =>  $setting['sorting_parametr'],  
					'order' =>  $setting['sorting_type'],  
					'start' => 0,
					'limit' => 100   //$setting['limit']
				);
				
				$results_iteration = $this->model_catalog_product->getProducts($data); // �������� �� ��������� ���������
				$results = $results + $results_iteration; 
			}
		}	
		
		// �������//
		// �������������
		if  (isset($setting['recomended']) && ($setting['recomended'] == 'yes')) {    
			$featured_products = $this->config->get('featured_product');
			if ($featured_products) {
					$sep_par = ',';
					$matches_featured_products = explode($sep_par, $featured_products);
			}		
		}

		// �����������
		if  (isset($setting['specials']) && ($setting['specials'] == 'yes')) {    
			$limit = 100;
			$special_data = array(
				'sort'  => 'pd.name',
				'order' => 'ASC',
				'start' => 0,
				'limit' => $limit
			);
			$special_results = $this->model_catalog_product->getProductSpecials($special_data);
		}	
		
		// ���� ������
		if  (isset($setting['bestsellers']) && ($setting['bestsellers'] == 'yes')) {    
			$limit = 100;
			$bestseller_results = $this->model_catalog_product->getBestSellerProducts($limit);
		}	
		
		// ������� (���������)
		if  (isset($setting['latest']) && ($setting['latest'] == 'yes')) {    
			$limit = 100;
			$latest_results = $this->model_catalog_product->getLatestProducts($limit);
		}

		// ���������� (����� ���������������)
		if  (isset($setting['popular']) && ($setting['popular'] == 'yes')) {    
			$limit = 100;
			$popular_results = $this->model_catalog_product->getPopularProducts($limit);
                       // var_dump($popular_results);
		}	
		
		$temp_results = array ();	
		foreach ($results as $result) {
                   
			if  ( (isset($featured_products)) && (in_array($result['product_id'], $matches_featured_products)) ) {
				$temp_results[] = $result;
				continue;
			}

			if  ( (isset($special_results)) && (isset($special_results[$result['product_id']])) ) {
				$temp_results[] = $result;
				continue;
			}
			
			if  ( (isset($bestseller_results)) && (isset($bestseller_results[$result['product_id']])) ) {
				
                            $temp_results[] = $result;
				continue;
			}
			
			if  ( (isset($latest_results)) && (isset($latest_results[$result['product_id']])) ) {
				$temp_results[] = $result;
				continue;
			}
			
			if  ( (isset($popular_results)) && (isset($popular_results[$result['product_id']])) ) {
				$temp_results[] = $result;
				continue;
			}
			
		}
	
		if ( (isset($featured_products)) || (isset($special_results)) || (isset($bestseller_results)) || (isset($latest_results)) || (isset($popular_results)) ) {
			$results = $temp_results;
		}	
		
		/* ������� ��...�� �� ���-�� */
		$temp_results = array ();
		foreach ($results as $result) {
			if (($result['quantity'] >= $setting['quantity_sorting_from']) && ($result['quantity'] <= $setting['quantity_sorting_to'])) {
				$temp_results[] = $result;
			}
		}
		$results = $temp_results;
		/* ������� ��...�� �� ���-�� */
			
		/* ������� ��...�� �� �������� */
		$temp_results = array ();
		// �� <= �� 
		if ( abs($setting['rating_sorting_from']) <=  abs($setting['rating_sorting_to'])) {
			foreach ($results as $result) {
				if (($result['rating'] >= $setting['rating_sorting_from']) && ($result['rating'] <= $setting['rating_sorting_to'])) {
					$temp_results[] = $result;
				}
			}
		}
		
		// �� > �� 
		if ( abs($setting['rating_sorting_from']) >  abs($setting['rating_sorting_to'])) {
			foreach ($results as $result) {
				if (($result['rating'] <= $setting['rating_sorting_from']) && ($result['rating'] >= $setting['rating_sorting_to'])) {
					$temp_results[] = $result;
				}
			}
		}
		
		$results = $temp_results;
		/* ������� ��...�� �� �������� */
	
		// �������//
		
		if ($setting['output'] == 'sequential') {  // ���������������� ����� 
			
			if (($setting['sorting_parametr'] == 'pd.name') && ($setting['sorting_type'] == 'ASC') ) {
				uasort($results, 'cmp_name_asc'); 
			}	
			 
			if (($setting['sorting_parametr'] == 'pd.name') && ($setting['sorting_type'] == 'DESC') ) {
				uasort($results, 'cmp_name_desc'); 
			}
			
			if (($setting['sorting_parametr'] == 'p.model') && ($setting['sorting_type'] == 'ASC') ) {
				uasort($results, 'cmp_model_asc'); 
			}	
			 
			if (($setting['sorting_parametr'] == 'p.model') && ($setting['sorting_type'] == 'DESC') ) {
				uasort($results, 'cmp_model_desc'); 
			}	
			
			if ($setting['sorting_parametr'] == 'p.quantity') {
			
				if ($setting['sorting_type'] == 'ASC') {
					uasort($results, 'cmp_quantity_asc'); 
				} else {
					uasort($results, 'cmp_quantity_desc'); 
				}
			}	
				
			if (($setting['sorting_parametr'] == 'p.price') && ($setting['sorting_type'] == 'ASC') ) {
				uasort($results, 'cmp_price_asc'); 
			}	
			 
			if (($setting['sorting_parametr'] == 'p.price') && ($setting['sorting_type'] == 'DESC') ) {
				uasort($results, 'cmp_price_desc'); 
			}
					
			if (($setting['sorting_parametr'] == 'rating') && ($setting['sorting_type'] == 'ASC') ) {
				
				uasort($results, 'cmp_rating_asc'); 
			}	
			 
			if (($setting['sorting_parametr'] == 'rating') && ($setting['sorting_type'] == 'DESC') ) {

				uasort($results, 'cmp_rating_desc'); 
			}
			
			if (($setting['sorting_parametr'] == 'p.sort_order') && ($setting['sorting_type'] == 'ASC') ) {
				uasort($results, 'cmp_sort_order_asc'); 
			}	
			 
			if (($setting['sorting_parametr'] == 'p.sort_order') && ($setting['sorting_type'] == 'DESC') ) {
				uasort($results, 'cmp_sort_order_desc'); 
			}		
			
			if (($setting['sorting_parametr'] == 'p.date_added') && ($setting['sorting_type'] == 'ASC') ) {
				uasort($results, 'cmp_date_added_asc'); 
			}	
			 
			if (($setting['sorting_parametr'] == 'p.date_added') && ($setting['sorting_type'] == 'DESC') ) {
				uasort($results, 'cmp_date_added_desc'); 
			}			
		}
		
		if ($setting['output'] == 'random') {   // ��������� 
			shuffle($results); }
		
		// �����
		if ($setting['limit'] < 1) {
			$setting['limit'] = 5;
		}
		
		$results = array_slice($results, 0, $setting['limit'], true);	// �������� ������ ���-�
		
		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']);
			} else {
				if (file_exists (DIR_IMAGE . 'no_image.jpg')) {
					$image = $this->model_tool_image->resize('no_image.jpg', $setting['image_width'], $setting['image_height']);
				} else {
					$image = false;
				}	
			}

			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = false;
			}
					
			if ((float)$result['special']) { 
				$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$special = false;
			}
			
			if ($this->config->get('config_review_status')) {
				$rating = $result['rating'];
			} else {
				$rating = false;
			}
		
			$this->data['products'][] = array(
				'product_id' => $result['product_id'],
				'thumb'   	 => $image,
				'name'    	 => $result['name'],
				'price'   	 => $price,
				'special' 	 => $special,
				'rating'     => $rating,
				'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
				'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
			);
		}
		
		if ($setting['graphic_output'] == 'graphic_output_normal') {
		
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/jv_products_in_m.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/jv_products_in_m.tpl';
			} else {
				$this->template = 'default/template/module/jv_products_in_m.tpl';
			}
		
			$this->render();
		}
		
		if ($setting['graphic_output'] == 'graphic_output_carousel') {
		
			$this->data['module'] = $module++; 
			
			$this->document->addScript('catalog/view/javascript/jquery/jquery.jcarousel.min.js');
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/jv_jcarousel/jcarousel-skin-opencart/scin.css');
					
			$this->data['scroll'] = $setting['carousel_scroll'];
			$this->data['carousel_autoscroll'] = $setting['carousel_autoscroll'];		
			$this->data['carousel_direction'] = $setting['carousel_direction'];
			$this->data['carousel_time_autoscroll'] = $setting['carousel_time_autoscroll'];
			$this->data['carousel_wrap'] = $setting['carousel_wrap'];
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/jv_products_in_m_carousel.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/jv_products_in_m_carousel.tpl';
			} else {
				$this->template = 'default/template/module/jv_products_in_m_carousel.tpl';
			}
			
			$this->render();
		}		
	}	
}
?>