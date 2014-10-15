<?php
class ControllerToolYML extends Controller {
	private $error = array();
	
	public function index()
	{
		ini_set('max_execution_time', 9999999);
		if (!isset($this->session->data['token'])) {
			$this->session->data['token'] = 0;
		}		
		$this->data['token'] = $this->session->data['token'];
	
		$this->load->language('tool/yml');

		$this->document->setTitle = $this->language->get('heading_title');

		$this->load->model('tool/yml');
		
				if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) 
				{
					if (is_uploaded_file($this->request->files['yml_import']['tmp_name'])) 
					{
						$content = file_get_contents($this->request->files['yml_import']['tmp_name']);
						
						
						//$content= iconv('Windows-1251', 'UTF-8', $content);
						//$content = mb_convert_encoding($content, "UTF-8", "Windows-1251");
							
						$filename = $this->request->files['yml_import']['tmp_name'];
					} else 
					{
					$content = false;
					}
					if ($content) 
					{
						$xml = new SimpleXMLElement($content);
						$this->load->model('tool/yml');
						
						$data=array();
						$data_prod=array();
						$this->model_tool_yml->deleteCategories();
						foreach($xml->shop->categories->category as $category)
						{
							$data['category_description']['1']['name']=$category;
							$data['category_description'][1]['meta_keyword']="";
							$data['category_description'][1]['meta_description']="";
							$data['category_description'][1]['description']="";
							$data['category_description'][1]['seo_title']="";
							$data['category_description'][1]['seo_h1']="";
							$data['category_store'][0]=0;
							$data['parent_id']=0;
							$data['column']=1;
							$data['sort_order']=0;
							$data['status']=1;
							$data['top']=1;
							$data['keyword']=0;
							$category_id=$this->model_tool_yml->addCategory($data);
							foreach($xml->shop->offers->offer as $offer)
							{
								set_time_limit(600);
								if($category['id']==(int)$offer->categoryId)
								{
									
									if(isset($offer->pictures->picture))
									{
										$i=0;
										$data_prod['product_image']=array();
										$data_prod['product_image']=array();
										foreach($offer->pictures->picture as $picture)
										{
												$pic_name=basename($picture);
												$local='../image/data/'.$pic_name;
												if(file_put_contents($local, file_get_contents($picture)))
												{
												$data_prod['product_image'][$i]['image']='data/'.$pic_name;
												$data_prod['product_image'][$i]['sort_order']=0;
												$i++;
												}
										}
										$data_prod['image']=$data_prod['product_image'][0]['image'];
									}
								
									$data_prod['model']=str_replace('"', '', $offer->model);
									$data_prod['price']=$offer->price;
									$data_prod['sku']=$offer->articul;
									$data_prod['upc']="";
									$data_prod['ean']="";
									$data_prod['jan']="";
									$data_prod['isbn']="";
									$data_prod['mpn']="";
									$data_prod['location']="";
									$data_prod['quantity']=1;
									$data_prod['minimum']=1;
									$data_prod['subtract']=0;
									$data_prod['shipping']=1;
									$data_prod['points']="";
									$data_prod['weight']="1";
									$data_prod['length']="";
									$data_prod['length_class_id']="";
									$data_prod['tax_class_id']=0;
									$data_prod['sort_order']=1;
									$data_prod['width']="";
									$data_prod['height']="";
									$data_prod['keyword']="";
									$data_prod['status']=1;
									$data_prod['weight_class_id']="";
									$data_prod['stock_status_id']=7;
									$data_prod['date_available']="";
									$data_prod['manufacturer_id']=0;
									$data_prod['product_store'][0]=0;
									
									$data_prod['product_description'][1]['meta_keyword']="";
									$data_prod['product_description'][1]['tag']="";
									$data_prod['product_description'][1]['meta_description']="";
									$data_prod['product_description'][1]['seo_title']="";
									$data_prod['product_description'][1]['seo_h1']="";
									$data_prod['product_description']['1']['name']=$offer->name;
									$data_prod['product_description']['1']['description']=$offer->description;
									$data_prod['main_category_id']=$category_id;
									if(!$this->model_tool_yml->productExist($data_prod['sku']))
									$this->model_tool_yml->addProduct($data_prod);
									else
									$this->model_tool_yml->editProduct($this->model_tool_yml->productExist($data_prod['sku']), $data_prod);
									
								}
							}
						}
						
						$this->session->data['success'] = $this->language->get('text_success');
						$this->redirect(HTTPS_SERVER . 'index.php?route=tool/yml&token=' . $this->session->data['token']);
					} 
					else 
					{
						$this->error['warning'] = $this->language->get('error_empty');
					}
				}
		$this->data['heading_title'] = $this->language->get('heading_title');



		
		$this->data['entry_import'] = $this->language->get('entry_import');

		$this->data['button_restore'] = $this->language->get('button_restore');

		$this->data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=tool/yml&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);

		$this->data['restore'] = HTTPS_SERVER . 'index.php?route=tool/yml&token=' . $this->session->data['token'];

		$this->data['yml'] = HTTPS_SERVER . 'index.php?route=tool/yml/yml&token=' . $this->session->data['token'];

		$this->data['yml_import'] = HTTPS_SERVER . 'index.php?route=tool/yml&token=' . $this->session->data['token'];
		
		$this->template = 'tool/yml.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	
		private function validate() {
		if (!$this->user->hasPermission('modify', 'tool/yml')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	
}