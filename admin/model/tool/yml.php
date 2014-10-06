<?php

class ModelToolYML extends Model {

    public function categoryExist($fake_category_id) {
        $query = "SELECT category_id, fake_category_id FROM " . DB_PREFIX . "category WHERE fake_category_id='" . (int) $fake_category_id . "'";
        $res = $this->db->query($query);

       if ($res->num_rows >= 1) {
            return $res->row['category_id'];
        } else
            return FALSE;
    }

    public function editCategory($data) {
        if (isset($data['image'])) {
            $this->db->query("UPDATE " . DB_PREFIX . "category SET image = '" . (string) $data['image'] . "', parent_id = '" . (int) $data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int) $data['top'] : 0) . "', `column` = '" . (int) $data['column'] . "', sort_order = '" . (int) $data['sort_order'] . "', status = '" . (int) $data['status'] . "', date_modified = NOW(), date_added = NOW() WHERE fake_category_id='" . $data['fake_category_id'] . "';");
            $cat_id = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "category WHERE fake_category_id='" . $data['fake_category_id'] . "';")->row['category_id'];

            foreach ($data['category_description'] as $language_id => $value) {
                $this->db->query("UPDATE " . DB_PREFIX . "category_description SET language_id = '" . (int) $language_id . "', name = '" . $this->db->escape($value['name']) . "' WHERE category_id='" . $cat_id . "';");
            }
        } else {
            $this->db->query("UPDATE " . DB_PREFIX . "category SET parent_id = '" . (int) $data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int) $data['top'] : 0) . "', `column` = '" . (int) $data['column'] . "', sort_order = '" . (int) $data['sort_order'] . "', status = '" . (int) $data['status'] . "', date_modified = NOW(), date_added = NOW() WHERE fake_category_id='" . $data['fake_category_id'] . "';");
           $cat_id = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "category WHERE fake_category_id='" . $data['fake_category_id'] . "';")->row['category_id'];

            foreach ($data['category_description'] as $language_id => $value) {
                $this->db->query("UPDATE " . DB_PREFIX . "category_description SET language_id = '" . (int) $language_id . "', name = '" . $this->db->escape($value['name']) . "' WHERE category_id='" . $cat_id . "';");
            }
        }
    }

    public function addCategory($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "category SET parent_id = '" . (int) $data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int) $data['top'] : 0) . "', `column` = '" . (int) $data['column'] . "', sort_order = '" . (int) $data['sort_order'] . "', status = '" . (int) $data['status'] . "', date_modified = NOW(), date_added = NOW(),fake_category_id='" . $data['fake_category_id'] . "';");

        $category_id = $this->db->getLastId();

        if (isset($data['image'])) {
            $this->db->query("UPDATE " . DB_PREFIX . "category SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE category_id = '" . (int) $category_id . "'");
        }

        foreach ($data['category_description'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int) $category_id . "', language_id = '" . (int) $language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "', seo_title = '" . $this->db->escape($value['seo_title']) . "', seo_h1 = '" . $this->db->escape($value['seo_h1']) . "'");
        }

        if (isset($data['category_store'])) {
            foreach ($data['category_store'] as $store_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "category_to_store SET category_id = '" . (int) $category_id . "', store_id = '" . (int) $store_id . "'");
            }
        }

        if (isset($data['category_layout'])) {
            foreach ($data['category_layout'] as $store_id => $layout) {
                if ($layout['layout_id']) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "category_to_layout SET category_id = '" . (int) $category_id . "', store_id = '" . (int) $store_id . "', layout_id = '" . (int) $layout['layout_id'] . "'");
                }
            }
        }
/*
        if ($data['keyword']) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int) $category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
        }
*/
        $this->cache->delete('category');
        return $category_id;
    }

    public function deleteCategories() {
        $this->db->query("DELETE FROM " . DB_PREFIX . "category");
        $this->db->query("DELETE FROM " . DB_PREFIX . "category_description");
        $this->db->query("DELETE FROM " . DB_PREFIX . "category_to_store");
        $this->db->query("DELETE FROM " . DB_PREFIX . "category_to_layout");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category");

        $this->cache->delete('category');
    }

    public function productExist($articul) {

        $query = "SELECT * FROM " . DB_PREFIX . "product WHERE sku='" . (int) $articul . "'";
        //$res=mysql_query($query);
        $res = $this->db->query($query);
        if ($res->num_rows >= 1) {
            return $res->row['product_id'];
        } else
            return FALSE;
    }

    public function addProduct($data) {
        
        if (isset($data['image'])) {
                   
        $this->db->query("INSERT INTO " . DB_PREFIX . "product SET model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', upc = '" . $this->db->escape($data['upc']) . "', ean = '" . $this->db->escape($data['ean']) . "', jan = '" . $this->db->escape($data['jan']) . "', isbn = '" . $this->db->escape($data['isbn']) . "', mpn = '" . $this->db->escape($data['mpn']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int) $data['quantity'] . "', minimum = '" . (int) $data['minimum'] . "', subtract = '" . (int) $data['subtract'] . "', stock_status_id = '" . (int) $data['stock_status_id'] ."', image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturer_id = '" . (int) $data['manufacturer_id'] . "', shipping = '" . (int) $data['shipping'] . "', price = '" . (float) $data['price'] . "', points = '" . (int) $data['points'] . "', weight = '" . (float) $data['weight'] . "', weight_class_id = '" . (int) $data['weight_class_id'] . "', length = '" . (float) $data['length'] . "', width = '" . (float) $data['width'] . "', height = '" . (float) $data['height'] . "', length_class_id = '" . (int) $data['length_class_id'] . "', status = '" . (int) $data['status'] . "', tax_class_id = '" . $this->db->escape($data['tax_class_id']) . "', sort_order = '" . (int) $data['sort_order'] . "', date_added = NOW()");

        $product_id = $this->db->getLastId();
        $prod_id = $product_id;
         } else {
              $this->db->query("INSERT INTO " . DB_PREFIX . "product SET model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', upc = '" . $this->db->escape($data['upc']) . "', ean = '" . $this->db->escape($data['ean']) . "', jan = '" . $this->db->escape($data['jan']) . "', isbn = '" . $this->db->escape($data['isbn']) . "', mpn = '" . $this->db->escape($data['mpn']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int) $data['quantity'] . "', minimum = '" . (int) $data['minimum'] . "', subtract = '" . (int) $data['subtract'] . "', stock_status_id = '" . (int) $data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturer_id = '" . (int) $data['manufacturer_id'] . "', shipping = '" . (int) $data['shipping'] . "', price = '" . (float) $data['price'] . "', points = '" . (int) $data['points'] . "', weight = '" . (float) $data['weight'] . "', weight_class_id = '" . (int) $data['weight_class_id'] . "', length = '" . (float) $data['length'] . "', width = '" . (float) $data['width'] . "', height = '" . (float) $data['height'] . "', length_class_id = '" . (int) $data['length_class_id'] . "', status = '" . (int) $data['status'] . "', tax_class_id = '" . $this->db->escape($data['tax_class_id']) . "', sort_order = '" . (int) $data['sort_order'] . "', date_added = NOW()");

        $product_id = $this->db->getLastId();
        $prod_id = $product_id;
         }

     foreach ($data['product_description'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int) $product_id . "', language_id = '" . (int) $language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "', seo_title = '" . $this->db->escape($value['seo_title']) . "', seo_h1 = '" . $this->db->escape($value['seo_h1']) . "'");
        }

        if (isset($data['product_store'])) {
            foreach ($data['product_store'] as $store_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int) $product_id . "', store_id = '" . (int) $store_id . "'");
            }
        }

        if (isset($data['product_attribute'])) {
            foreach ($data['product_attribute'] as $product_attribute) {
                if ($product_attribute['attribute_id']) {
                    $this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int) $product_id . "' AND attribute_id = '" . (int) $product_attribute['attribute_id'] . "'");

                    foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int) $product_id . "', attribute_id = '" . (int) $product_attribute['attribute_id'] . "', language_id = '" . (int) $language_id . "', text = '" . $this->db->escape($product_attribute_description['text']) . "'");
                    }
                }
            }
        }

        if (isset($data['product_option'])) {
            foreach ($data['product_option'] as $product_option) {
                if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int) $product_id . "', option_id = '" . (int) $product_option['option_id'] . "', required = '" . (int) $product_option['required'] . "'");

                    $product_option_id = $this->db->getLastId();

                    if (isset($product_option['product_option_value'])) {
                        foreach ($product_option['product_option_value'] as $product_option_value) {
                            $this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_id = '" . (int) $product_option_id . "', product_id = '" . (int) $product_id . "', option_id = '" . (int) $product_option['option_id'] . "', option_value_id = '" . (int) $product_option_value['option_value_id'] . "', quantity = '" . (int) $product_option_value['quantity'] . "', subtract = '" . (int) $product_option_value['subtract'] . "', price = '" . (float) $product_option_value['price'] . "', price_prefix = '" . $this->db->escape($product_option_value['price_prefix']) . "', points = '" . (int) $product_option_value['points'] . "', points_prefix = '" . $this->db->escape($product_option_value['points_prefix']) . "', weight = '" . (float) $product_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($product_option_value['weight_prefix']) . "'");
                        }
                    }
                } else {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int) $product_id . "', option_id = '" . (int) $product_option['option_id'] . "', option_value = '" . $this->db->escape($product_option['option_value']) . "', required = '" . (int) $product_option['required'] . "'");
                }
            }
        }

        if (isset($data['product_discount'])) {
            foreach ($data['product_discount'] as $product_discount) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int) $product_id . "', customer_group_id = '" . (int) $product_discount['customer_group_id'] . "', quantity = '" . (int) $product_discount['quantity'] . "', priority = '" . (int) $product_discount['priority'] . "', price = '" . (float) $product_discount['price'] . "', date_start = '" . $this->db->escape($product_discount['date_start']) . "', date_end = '" . $this->db->escape($product_discount['date_end']) . "'");
            }
        }

        if (isset($data['product_special'])) {
            foreach ($data['product_special'] as $product_special) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int) $product_id . "', customer_group_id = '" . (int) $product_special['customer_group_id'] . "', priority = '" . (int) $product_special['priority'] . "', price = '" . (float) $product_special['price'] . "', date_start = '" . $this->db->escape($product_special['date_start']) . "', date_end = '" . $this->db->escape($product_special['date_end']) . "'");
            }
        }


        if (isset($data['product_image']) && !is_null($data['product_image'])) {
            $this->db->query("LOCK TABLES " . DB_PREFIX . "product_image WRITE;");
            $query = "INSERT INTO " . DB_PREFIX . "product_image (`product_image_id`,`product_id`,`image`,`sort_order`) VALUES ";

            for ($i = 0, $end = count($data['product_image']); $i < $end; $i++) {
                $delimeter = ($i == $end - 1) ? ";" : ",";
                $query.="(NULL,'" . (int) $product_id . "','" . $this->db->escape(html_entity_decode($data['product_image'][$i]['image'], ENT_QUOTES, 'UTF-8')) . "','" . (int) $data['product_image'][$i]['sort_order'] . "')" . $delimeter;
            
                
            }
              $this->db->query($query);
            $this->db->query("UNLOCK TABLES;");
          
        }

        if (isset($data['product_download'])) {
            foreach ($data['product_download'] as $download_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_download SET product_id = '" . (int) $product_id . "', download_id = '" . (int) $download_id . "'");
            }
        }

        if (isset($data['product_category'])) {
            foreach ($data['product_category'] as $category_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int) $product_id . "', category_id = '" . (int) $category_id . "'");
            }
        }

        if (isset($data['main_category_id']) && $data['main_category_id'] > 0) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int) $product_id . "' AND category_id = '" . (int) $data['main_category_id'] . "'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int) $product_id . "', category_id = '" . (int) $data['main_category_id'] . "', main_category = 1");
        } elseif (isset($data['product_category'][0])) {
            $this->db->query("UPDATE " . DB_PREFIX . "product_to_category SET main_category = 1 WHERE product_id = '" . (int) $product_id . "' AND category_id = '" . (int) $data['product_category'][0] . "'");
        }

        if (isset($data['product_related'])) {
            foreach ($data['product_related'] as $related_id) {
                $this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int) $product_id . "' AND related_id = '" . (int) $related_id . "'");
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int) $product_id . "', related_id = '" . (int) $related_id . "'");
                $this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int) $related_id . "' AND related_id = '" . (int) $product_id . "'");
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int) $related_id . "', related_id = '" . (int) $product_id . "'");
            }
        }

        if (isset($data['product_reward'])) {
            foreach ($data['product_reward'] as $customer_group_id => $product_reward) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_reward SET product_id = '" . (int) $product_id . "', customer_group_id = '" . (int) $customer_group_id . "', points = '" . (int) $product_reward['points'] . "'");
            }
        }

        if (isset($data['product_layout'])) {
            foreach ($data['product_layout'] as $store_id => $layout) {
                if ($layout['layout_id']) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_layout SET product_id = '" . (int) $product_id . "', store_id = '" . (int) $store_id . "', layout_id = '" . (int) $layout['layout_id'] . "'");
                }
            }
        }

        if ($data['keyword']) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int) $product_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
        }

        $this->cache->delete('product');
    }

    public function editProduct($product_id, $data) {
        if (isset($data['image'])) {
            $this->db->query("UPDATE " . DB_PREFIX . "product SET  price = '" . (float) $data['price'] . "', date_modified = NOW(), stock_status_id ='" . (int) $data['stock_status_id'] . "', image='" . (string) $data['image'] . "', model='".$this->db->escape($data['model'])."' WHERE product_id = '" . (int) $product_id . "'");
        } else {
            $this->db->query("UPDATE " . DB_PREFIX . "product SET  price = '" . (float) $data['price'] . "', date_modified = NOW(), stock_status_id ='" . (int) $data['stock_status_id'] . "', model='".$this->db->escape($data['model'])."' WHERE product_id = '" . (int) $product_id . "'");
        }
        if (isset($data['main_category_id']) && $data['main_category_id'] > 0) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int) $product_id . "' AND category_id = '" . (int) $data['main_category_id'] . "'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int) $product_id . "', category_id = '" . (int) $data['main_category_id'] . "', main_category = 1");
        } elseif (isset($data['product_category'])) {
            $this->db->query("UPDATE " . DB_PREFIX . "product_to_category SET main_category = 1 WHERE product_id = '" . (int) $product_id . "' AND category_id = '" . (int) $data['product_category'][0] . "'");
        }
    }



  public function getParentId($id) {
         
     
      $parent_id=['98'=>'1','19'=>'8','21'=>'8','1899'=>'9','1991'=>'10','1934'=>'10','56'=>'10','1923'=>'10','59'=>'10','60'=>'10','53'=>'10','37'=>'10','1992'=>'10',
          '988'=>'11','977'=>'11','982'=>'11','3223'=>'11','2216'=>'11','1030'=>'12','996'=>'13','1021'=>'13','1002'=>'13','994'=>'13','2117'=>'13','1014'=>'13','1011'=>'13',
          '2116'=>'13','1006'=>'13','1010'=>'13','1024'=>'13','1005'=>'13','1007'=>'13','1019'=>'13','991'=>'13','2132'=>'13','998'=>'13','2133'=>'13','1016'=>'13','3189'=>'13','999'=>'13',
          '2121'=>'13','993'=>'13','1022'=>'13','2129'=>'13','1008'=>'13','2135'=>'13','2127'=>'13','990'=>'13','1020'=>'13','3225'=>'15','156'=>'15','128'=>'14','2502'=>'14',
          '2628'=>'16','2626'=>'16','2645'=>'16','2646'=>'16','2638'=>'16','2644'=>'16','171'=>'16','163'=>'16','162'=>'16','2642'=>'16','2621'=>'16','159'=>'16','2632'=>'16','161'=>'16','2583'=>'17',
          '940'=>'4','947'=>'4','2760'=>'4','2712'=>'18','2717'=>'18','2716'=>'18','2713'=>'18','2709'=>'18','2708'=>'18','2711'=>'18',
          '936'=>'19','2719'=>'19','938'=>'19','1156'=>'5','1155'=>'5','1124'=>'5','3228'=>'5','1144'=>'5','1174'=>'5','3229'=>'5','2185'=>'20','2183'=>'20','2174'=>'20',
          '2231'=>'21','496'=>'22','2044'=>'22','497'=>'22','499'=>'22','503'=>'22','2047'=>'22','498'=>'22','504'=>'22','506'=>'22','2048'=>'22','2052'=>'22','2053'=>'22',
          '412'=>'23','3206'=>'23','414'=>'23','413'=>'23','2082'=>'23','415'=>'23','409'=>'23','410'=>'23','2081'=>'23','3175'=>'7',
          '3210'=>'24','1657'=>'25','1653'=>'25','1655'=>'25','3106'=>'25','3151'=>'25','3159'=>'25','3116'=>'25','1651'=>'25','3127'=>'25','1686'=>'25','1661'=>'25','1667'=>'25','1664'=>'25','1662'=>'25','1665'=>'25','3107'=>'25','3115'=>'25','1684'=>'25','1699'=>'25',
          '1732'=>'26','1385'=>'26','1721'=>'26','1393'=>'26','1720'=>'26','1730'=>'26','1381'=>'26','1735'=>'26','1379'=>'26' ];

        return $parent_id[(string)$id];        
      
      
  }
  }