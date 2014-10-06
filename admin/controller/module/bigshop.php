<?php

class ControllerModuleBigshop extends Controller {
    
    private $error = array(); 
    
    public function index() {   
        //Load the language file for this module
        $language = $this->load->language('module/bigshop');
        $this->data = array_merge($this->data, $language);

        //Set the title from the language file $_['heading_title'] string
        $this->document->setTitle($this->language->get('heading_title'));
        
        //Load the settings model. You can also add any other models you want to load here.
        $this->load->model('setting/setting');
        
        $this->load->model('tool/image');    
        
        //Save the settings if the user has submitted the admin form (ie if someone has pressed save).
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('bigshop', $this->request->post);    

                
                    
            $this->session->data['success'] = $this->language->get('text_success');
        
                        
            $this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
            $this->data['text_image_manager'] = 'Image manager';
                    $this->data['token'] = $this->session->data['token'];       
        
        $text_strings = array(
                'heading_title',
                'text_enabled',
                'text_disabled',
                'text_content_top',
                'text_content_bottom',
                'text_column_left',
                'text_column_right',
                'entry_status',
                'entry_sort_order',
                'button_save',
                'button_cancel',
        );
        
        foreach ($text_strings as $text) {
            $this->data[$text] = $this->language->get($text);
        }
        

        // store config data
        
        $config_data = array(

        'bigshop_status',

        'bigshop_background_color',
        'bigshop_top_header_color',
        'bigshop_title_color',
        'bigshop_bodytext_color',
        'bigshop_header_text_color',
		'bigshop_top_right_link_color',
        'bigshop_menu_color',
        'bigshop_links_color',

        'bigshop_button_color',
        'bigshop_button_hover_color',
        'bigshop_button_text_color',

        'bigshop_footer_heading_text_color',
        'bigshop_sub_link_text_color',
        'bigshop_powerd_by_text_color',        

        'bigshop_pattern_overlay',
        'bigshop_custom_image',
        'bigshop_custom_pattern',
        'bigshop_image_preview',
        'bigshop_pattern_preview',

		'bigshop_social_title',
		'bigshop_facebook_id',
		
        'bigshop_twitter_username',
        'bigshop_gplus_id',
		'bigshop_pint_id',
		
		'bigshop_about_title',
        'bigshop_footer_info_text',
		
		'bigshop_title_font',
        'bigshop_body_font',
        'bigshop_small_font',
		
		'bigshop_facebook_id',
		'twitter_column_header',
        'twitter_number_of_tweets',
        'twitter_username',
		'bigshop_theme_color',
		
		'bigshop_address',
		'bigshop_mobile',
		'bigshop_email',
		'bigshop_fax',
        );
        
        foreach ($config_data as $conf) {
            if (isset($this->request->post[$conf])) {
                $this->data[$conf] = $this->request->post[$conf];
            } else {
                $this->data[$conf] = $this->config->get($conf);
            }
        }
    
        //This creates an error message. The error['warning'] variable is set by the call to function validate() in this controller (below)
        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }
        
        //SET UP BREADCRUMB TRAIL. YOU WILL NOT NEED TO MODIFY THIS UNLESS YOU CHANGE YOUR MODULE NAME.
        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_module'),
            'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );
        
        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('module/bigshop', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );
        
        $this->data['action'] = $this->url->link('module/bigshop', 'token=' . $this->session->data['token'], 'SSL');
        
        $this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

    
        //This code handles the situation where you have multiple instances of this module, for different layouts.
        if (isset($this->request->post['bigshop_module'])) {
            $modules = explode(',', $this->request->post['bigshop_module']);
        } elseif ($this->config->get('bigshop_module') != '') {
            $modules = explode(',', $this->config->get('bigshop_module'));
        } else {
            $modules = array();
        }           
                
        $this->load->model('design/layout');
        
        $this->data['layouts'] = $this->model_design_layout->getLayouts();
                
        foreach ($modules as $module) {
            if (isset($this->request->post['bigshop_' . $module . '_layout_id'])) {
                $this->data['bigshop_' . $module . '_layout_id'] = $this->request->post['bigshop_' . $module . '_layout_id'];
            } else {
                $this->data['bigshop_' . $module . '_layout_id'] = $this->config->get('bigshop_' . $module . '_layout_id');
            }   
            
            if (isset($this->request->post['bigshop_' . $module . '_position'])) {
                $this->data['bigshop_' . $module . '_position'] = $this->request->post['bigshop_' . $module . '_position'];
            } else {
                $this->data['bigshop_' . $module . '_position'] = $this->config->get('bigshop_' . $module . '_position');
            }   
            
            if (isset($this->request->post['bigshop_' . $module . '_status'])) {
                $this->data['bigshop_' . $module . '_status'] = $this->request->post['bigshop_' . $module . '_status'];
            } else {
                $this->data['bigshop_' . $module . '_status'] = $this->config->get('bigshop_' . $module . '_status');
            }   
                        
            if (isset($this->request->post['bigshop_' . $module . '_sort_order'])) {
                $this->data['bigshop_' . $module . '_sort_order'] = $this->request->post['bigshop_' . $module . '_sort_order'];
            } else {
                $this->data['bigshop_' . $module . '_sort_order'] = $this->config->get('bigshop_' . $module . '_sort_order');
            }               
        }
        

        
        $this->data['modules'] = $modules;
        
        if (isset($this->request->post['bigshop_module'])) {
            $this->data['bigshop_module'] = $this->request->post['bigshop_module'];
        } else {
            $this->data['bigshop_module'] = $this->config->get('bigshop_module');
        }

        //Choose which template file will be used to display this request.
        $this->template = 'module/bigshop.tpl';
        $this->children = array(
            'common/header',
            'common/footer',
        );

        if (isset($this->data['bigshop_custom_pattern']) && $this->data['bigshop_custom_pattern'] != "" && file_exists(DIR_IMAGE . $this->data['bigshop_custom_pattern'])) {
            $this->data['bigshop_pattern_preview'] = $this->model_tool_image->resize($this->data['bigshop_custom_pattern'], 70, 70);
        } else {
            $this->data['bigshop_pattern_preview'] = $this->model_tool_image->resize('no_image.jpg', 70, 70);
        }
        
        
        if (isset($this->data['bigshop_custom_image']) && $this->data['bigshop_custom_image'] != "" && file_exists(DIR_IMAGE . $this->data['bigshop_custom_image'])) {
            $this->data['bigshop_image_preview'] = $this->model_tool_image->resize($this->data['bigshop_custom_image'], 70, 70);
        } else {
            $this->data['bigshop_image_preview'] = $this->model_tool_image->resize('no_image.jpg', 70, 70);
        }

        $this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 70, 70);

        //Send the output.
        $this->response->setOutput($this->render());
    }
    
    /*
     * 
     * This function is called to ensure that the settings chosen by the admin user are allowed/valid.
     * You can add checks in here of your own.
     * 
     */
    
    private function validate() {
        if (!$this->user->hasPermission('modify', 'module/bigshop')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        
        if (!$this->error) {
            return TRUE;
        } else {
            return FALSE;
        }   
    }


}
?>