<?php

class AS_API{

    var $login;
    var $password;
    var $client;
    var $site;

    function __construct($login, $password, $url, $site){
        $this->login = $login;
        $this->password = $password;
        $this->site = $site;
        $this->client = new nusoap_client($url, true);
        $this->client->soap_defencoding = 'UTF-8';
        $this->client->decode_utf8 = false;
    }
	
		public function checkConnection(){
		$params = array(
            'login' => $this->login,
            'password' => $this->password
        );
        $answer = $this->client->call('getCurrencies', $params);
        if(!$answer['resultXml'])
			return 0;
		else
			return 1;
	}

    public function getRegions(){
        $params = array(
            'login' => $this->login,
            'password' => $this->password
        );
        $answer = $this->client->call('getRegions', $params);
        $xml = new SimpleXMLElement($answer['resultXml']);

        $regions = array();

        foreach ($xml->regions[0]->region as $region){
            $attr = $region->attributes();
            $regions[strval($attr['id'])] = iconv("utf-8", 'windows-1251', strval($region->name));
        }
        return $regions;
    }

    public function getRegionsForProducts($ids){
        $params = array(
            'login' => $this->login,
            'password' => $this->password,
            'site' => $this->site,
            'ids' => $ids
        );
        $answer = $this->client->call('getRegionsForProducts', $params);
        $xml = new SimpleXMLElement($answer['resultXml']);

        $regions = array();

        foreach ($xml->regions[0]->region as $region){
            $attr = $region->attributes();
            $regions[strval($attr['id'])] = strval($region->name);
        }
        return $regions;
    }

    public function getCurrencies(){
        $params = array(
            'login' => $this->login,
            'password' => $this->password
        );
        $answer = $this->client->call('getCurrencies', $params);
        $xml = new SimpleXMLElement($answer['resultXml']);

        $currencies = array();

        foreach ($xml->currencies[0]->currency as $currency){
            $attr = $currency->attributes();
            $currencies[strval($attr['id'])] = iconv("utf-8", 'windows-1251', strval($currency->name));
        }
        return $currencies;
    }

    public function getPaymentTypes(){
        $params =  array(
            'login' => $this->login,
            'password' => $this->password
        );
        $answer = $this->client->call('getPaymentTypes', $params);
        $xml = new SimpleXMLElement($answer['resultXml']);

        $payments = array();

        foreach ($xml->payments[0]->payment as $payment){
            $attr = $payment->attributes();
            $payments[strval($attr['id'])] = strval($payment->name);
        }
        return $payments;
    }

    public function getDeliveryTypes(){
        $params = array(
            'login' => $this->login,
            'password' => $this->password
        );
        $answer = $this->client->call('getDeliveryTypes', $params);
        $xml = new SimpleXMLElement($answer['resultXml']);

        $deliveries = array();

        foreach ($xml->deliveries[0]->delivery as $delivery){
            $attr = $delivery->attributes();
            $deliveries[strval($attr['id'])] = strval($delivery->name);
        }
        return $deliveries;
    }

    public function getProductsByIds($currency, $ids){
        $params = array(
            'login' => $this->login,
            'password' => $this->password,
            'site' => $this->site,
            'currency' => $currency,
            'ids' => $ids
        );
        $answer = $this->client->call('getProductsForIds', $params);
        $xml = new SimpleXMLElement($answer['resultXml']);

        $products = array();

        foreach ($xml->products[0]->product as $product){
            $attr = $product->attributes();
            $products[] = new AS_PRODUCT_BEAN(
                strval($attr['wpid']),
                strval($attr['id']),
                iconv("utf-8", 'windows-1251', strval($product->name)),
                strval($product->price),
                strval($product->url)
            );
        }
        return $products;
    }

    public function getSelfDeliveriesForRegion($regionId){
        $params = array(
            'login' => $this->login,
            'password' => $this->password,
            'regionId' => $regionId
        );
        $answer = $this->client->call('getSelfDeliveriesForRegion', $params);
        $xml = new SimpleXMLElement($answer['resultXml']);

        $sdlist = array();

        foreach ($xml->sdlist[0]->sd as $sd){
            $attr = $sd->attributes();
            $sdlist[] = new AS_SELF_DELIVERY(
                strval($attr['id']),
                strval($sd->regionId),
                strval($sd->name),
                strval($sd->address),
                strval($sd->phone),
                strval($sd->workTime),
                strval($sd->deliveryTime)
            );
        }
        return $sdlist;
    }

    public function getCartItems($cart, $currency){
        $params = array(
            'login' => $this->login,
            'password' => $this->password,
            'site' => $this->site,
            'currency' => $currency,
            'cart' => $cart
        );
        $answer = $this->client->call('getCartItems', $params);
        $xml = new SimpleXMLElement($answer['resultXml']);
        $items = array();
        foreach ($xml->items[0]->item as $item){
            $attr = $item->attributes();
            $items[] = new AS_CART_ITEM(
                strval($attr['id']),
                iconv("utf-8", 'windows-1251', strval($item->name)),
                strval($item->price),
                strval($item->count)
            );
        }
        return $items;
    }

    public function getProductIdForArticul($articul){
        $params = array(
            'login' => $this->login,
            'password' => $this->password,
            'site' => $this->site,
            'articul' => $articul
        );
        $answer = $this->client->call('getProductIdForArticul', $params);
		if(!$answer['resultXml'])
			return 0;
		else
		{
        $xml = new SimpleXMLElement($answer['resultXml']);
        $idEl = $xml->id;
        $attr = $idEl->attributes();
        return $attr['id'];
		}
    }

    public function getCartDelivery($cart, $currency, $region){
        $params = array(
            'login' => $this->login,
            'password' => $this->password,
            'site' => $this->site,
            'currency' => $currency,
            'cart' => $cart,
            'region' => $region
        );
        $answer = $this->client->call('getCartDelivery', $params);
        $xml = new SimpleXMLElement($answer['resultXml']);
        $items = array();
        foreach ($xml->items[0]->item as $item){
            $attr = $item->attributes();
            $ditems = array();
            foreach($item->delivery as $delivery){
                $dattr = $delivery->attributes();
                $pays = array();

                foreach($delivery->payment as $payment){
                    $pattr = $payment->attributes();
                    $pays[] = new AS_DELIVERY_PAYMENT(strval($pattr['id']), strval($payment->sum));
                }

                $ditems[] = new AS_DELIVERY(
                    strval($dattr['id']),
                    $pays
                );
            }
            $items[] = new AS_CART_DELIVERY(
                strval($attr['id']),
                strval($item->count),
                $ditems
            );
        }
        return $items;
    }

    public function checkOrder($cart, $currency, $region, $zip){
        $params = array(
            'login' => $this->login,
            'password' => $this->password,
            'site' => $this->site,
            'currency' => $currency,
            'cart' => $cart,
            'region' => $region,
            'zip' => $zip
        );
        $answer = $this->client->call('checkOrder', $params);
        $xml = new SimpleXMLElement($answer['resultXml']);

        $items = array();
        foreach ($xml->items[0]->item as $item){
            $attr = $item->attributes();
            $items[] = new AS_CHECK_ORDER_ITEM(
                strval($attr['id']),
                strval($item->count),
                strval($item->price),
                strval($item->delivery),
                strval($item->sum),
                strval($item->days),
                strval($item->date)
            );
        }

        return new AS_CHECK_ORDER(
            strval($xml->order),
            strval($xml->cart),
            strval($xml->price),
            strval($xml->delivery),
            strval($xml->sum),
            strval($xml->days),
            strval($xml->date),
            $items
        );
    }

    public function submitOrder($cart, $currency, $region, $zip, $userSum, $userDate, $skipErrors,
                                $recipient, $sourceParam, $sourceRef){
        $params = array(
            'login' => $this->login,
            'password' => $this->password,
            'site' => $this->site,
            'currency' => $currency,
            'cart' => $cart,
            'region' => $region,
            'zip' => $zip,
            'userSum' => $userSum,
            'userDate' => $userDate,
            'skipErrors' => $skipErrors,
            'userInfo' => array(
                'name' => iconv("windows-1251", 'utf-8', $recipient->getName()),
                'address' => iconv("windows-1251", 'utf-8', $recipient->getAddress()),
                'phone1' => iconv("windows-1251", 'utf-8', $recipient->getPhone1()),
                'phoneTime1' => iconv("windows-1251", 'utf-8', $recipient->getPhoneTime1()),
                'phone2' => iconv("windows-1251", 'utf-8', $recipient->getPhone2()),
                'phoneTime2' => iconv("windows-1251", 'utf-8', $recipient->getPhoneTime2()),
                'email' => iconv("windows-1251", 'utf-8', $recipient->getEmail()),
                'addressComment' => iconv("windows-1251", 'utf-8', $recipient->getAddressComment()),
                'orgAddress' => iconv("windows-1251", 'utf-8', $recipient->getOrgAddress()),
                'orgBank' => iconv("windows-1251", 'utf-8', $recipient->getOrgBank()),
                'orgBankcity' => iconv("windows-1251", 'utf-8', $recipient->getOrgBankcity()),
                'orgBik' => iconv("windows-1251", 'utf-8', $recipient->getOrgBik()),
                'orgInn' => iconv("windows-1251", 'utf-8', $recipient->getOrgInn()),
                'orgKpp' => iconv("windows-1251", 'utf-8', $recipient->getOrgKpp()),
                'orgKs' => iconv("windows-1251", 'utf-8', $recipient->getOrgKs()),
                'orgName' => iconv("windows-1251", 'utf-8', $recipient->getOrgName()),
                'orgOkpo' => iconv("windows-1251", 'utf-8', $recipient->getOrgOkpo()),
                'orgOkved' => iconv("windows-1251", 'utf-8', $recipient->getOrgOkved()),
                'orgRs' => iconv("windows-1251", 'utf-8', $recipient->getOrgRs()),
                'orgType' => iconv("windows-1251", 'utf-8', $recipient->getOrgType())
            ),
            'sourceParam' => $sourceParam,
            'sourceRef' => $sourceRef
        );
        $answer = $this->client->call('submitOrder', $params);
        $xml = new SimpleXMLElement($answer['resultXml']);

        $items = array();
        foreach ($xml->items[0]->item as $item){
            $attr = $item->attributes();
            $items[] = new AS_CHECK_ORDER_ITEM(
                strval($attr['id']),
                strval($item->count),
                strval($item->price),
                strval($item->delivery),
                strval($item->sum),
                strval($item->days),
                strval($item->date)
            );
        }

        return new AS_SUBMIT_ORDER(
            strval($xml->id),
            strval($xml->cart),
            strval($xml->price),
            strval($xml->delivery),
            strval($xml->sum),
            strval($xml->days),
            strval($xml->date),
            strval($xml->url),
            iconv("utf-8", 'windows-1251', strval($xml->info1)),
            iconv("utf-8", 'windows-1251', strval($xml->info2)),
            $items
        );
    }

    public function createOrderTicket($name, $email, $text) {
        $params = array(
            'name' => iconv("windows-1251", 'utf-8', $name),
            'email' => iconv("windows-1251", 'utf-8', $email),
            'siteId' => $this->site,
            'text' => iconv("windows-1251", 'utf-8', $text),
        );
        $answer = $this->client->call('createOrderTicket', $params);
        if ($answer){
            return $answer;
        } else {
            return null;
        }
    }

}

class AS_SUBMIT_ORDER {
    var $orderId;
    var $cart;
    var $price;
    var $delivery;
    var $sum;
    var $days;
    var $date;
    var $url;
    var $info1;
    var $info2;
    var $items;

    function __construct($orderId, $cart, $price, $delivery, $sum, $days, $date, $url, $info1, $info2, $items){
        $this->orderId = $orderId;
        $this->cart = $cart;
        $this->price = $price;
        $this->delivery = $delivery;
        $this->sum = $sum;
        $this->days = $days;
        $this->date = $date;
        $this->url = $url;
        $this->info1 = $info1;
        $this->info2 = $info2;
        $this->items = $items;
    }

    public function getCart(){
        return $this->cart;
    }

    public function getDate(){
        return $this->date;
    }

    public function getDays(){
        return $this->days;
    }

    public function getDelivery(){
        return $this->delivery;
    }

    public function getInfo1(){
        return $this->info1;
    }

    public function getInfo2(){
        return $this->info2;
    }

    public function getItems(){
        return $this->items;
    }

    public function getOrderId(){
        return $this->orderId;
    }

    public function getPrice(){
        return $this->price;
    }

    public function getSum(){
        return $this->sum;
    }

    public function getUrl(){
        return $this->url;
    }
}

class AS_CHECK_ORDER{

    var $order;
    var $cart;
    var $price;
    var $delivery;
    var $sum;
    var $days;
    var $date;
    var $items;

    function __construct($order, $cart, $price, $delivery, $sum, $days, $date, $items){
        $this->order = $order;
        $this->cart = $cart;
        $this->price = $price;
        $this->delivery = $delivery;
        $this->sum = $sum;
        $this->days = $days;
        $this->date = $date;
        $this->items = $items;
    }

    public function getCart(){
        return $this->cart;
    }

    public function getDate(){
        return $this->date;
    }

    public function getDays(){
        return $this->days;
    }

    public function getDelivery(){
        return $this->delivery;
    }

    public function getOrder(){
        return $this->order;
    }

    public function getPrice(){
        return $this->price;
    }

    public function getSum(){
        return $this->sum;
    }

    public function getItems(){
        return $this->items;
    }


}

class AS_CHECK_ORDER_ITEM{

    var $pid;
    var $count;
    var $price;
    var $delivery;
    var $sum;
    var $days;
    var $date;

    function __construct($pid, $count, $price, $delivery, $sum, $days, $date){
        $this->pid = $pid;
        $this->count = $count;
        $this->price = $price;
        $this->delivery = $delivery;
        $this->sum = $sum;
        $this->days = $days;
        $this->date = $date;
    }

    public function getCount(){
        return $this->count;
    }

    public function getDate(){
        return $this->date;
    }

    public function getDays(){
        return $this->days;
    }

    public function getDelivery(){
        return $this->delivery;
    }

    public function getPid(){
        return $this->pid;
    }

    public function getPrice(){
        return $this->price;
    }

    public function getSum(){
        return $this->sum;
    }
}

class AS_CART_DELIVERY{

    var $pid;
    var $count;
    var $deliveries;

    function __construct($pid, $count, $deliveries){
        $this->pid = $pid;
        $this->count = $count;
        $this->deliveries = $deliveries;
    }

    public function getCount(){
        return $this->count;
    }

    public function getDeliveries(){
        return $this->deliveries;
    }

    public function getPid(){
        return $this->pid;
    }
}

class AS_DELIVERY{

    var $id;
    var $payments;

    function __construct($id, $payments){
        $this->id = $id;
        $this->payments = $payments;
    }

    public function getId(){
        return $this->id;
    }

    public function getPayments(){
        return $this->payments;
    }
}

class AS_DELIVERY_PAYMENT{

    var $id;
    var $sum;

    function __construct($id, $sum){
        $this->id = $id;
        $this->sum = $sum;
    }

    public function getId(){
        return $this->id;
    }

    public function getSum(){
        return $this->sum;
    }
}

class AS_CART_ITEM{

    var $pid;
    var $name;
    var $price;
    var $count;

    function __construct($pid, $name, $price, $count){
        $this->pid = $pid;
        $this->name = $name;
        $this->price = $price;
        $this->count = $count;
    }

    public function getCount(){
        return $this->count;
    }

    public function getName(){
        return $this->name;
    }

    public function getPid(){
        return $this->pid;
    }

    public function getPrice(){
        return $this->price;
    }
}

class AS_SELF_DELIVERY{

    var $id;
    var $regionId;
    var $name;
    var $address;
    var $phone;
    var $workTime;
    var $deliveryTime;

    function __construct($id, $regionId, $name, $address, $phone, $workTime, $deliveryTime){
        $this->id = $id;
        $this->regionId = $regionId;
        $this->name = $name;
        $this->address = $address;
        $this->phone = $phone;
        $this->workTime = $workTime;
        $this->deliveryTime = $deliveryTime;
    }

    public function getAddress(){
        return $this->address;
    }

    public function getDeliveryTime(){
        return $this->deliveryTime;
    }

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getPhone(){
        return $this->phone;
    }

    public function getRegionId(){
        return $this->regionId;
    }

    public function getWorkTime(){
        return $this->workTime;
    }

}

class AS_PRODUCT_BEAN{

    var $id;
    var $pid;
    var $name;
    var $price;
    var $url;

    function __construct($id, $pid, $name, $price, $url){
        $this->id = $id;
        $this->pid = $pid;
        $this->name = $name;
        $this->price = $price;
        $this->url = $url;
    }

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getPid(){
        return $this->pid;
    }

    public function getPrice(){
        return $this->price;
    }

    public function getUrl(){
        return $this->url;
    }


}

class AS_RECIPIENT{

    var $name;
    var $address;
    var $phone1;
    var $phoneTime1;
    var $phone2;
    var $phoneTime2;
    var $addressComment;
    var $email;
    var $orgAddress;
    var $orgBank;
    var $orgBankcity;
    var $orgBik;
    var $orgInn;
    var $orgKpp;
    var $orgKs;
    var $orgName;
    var $orgOkpo;
    var $orgOkved;
    var $orgRs;
    var $orgType;

    function __construct($name, $address, $phone1, $phoneTime1, $phone2, $phoneTime2, $addressComment,
        $orgAddress, $orgBank, $orgBankcity, $orgBik, $orgInn, $orgKpp, $orgKs, $orgName,
        $orgOkpo, $orgOkved, $orgRs, $orgType, $email){
        $this->name = $name;
        $this->address = $address;
        $this->phone1 = $phone1;
        $this->phoneTime1 = $phoneTime1;
        $this->phone2 = $phone2;
        $this->phoneTime2 = $phoneTime2;
        $this->addressComment = $addressComment;
        $this->email = $email;
        $this->orgAddress = $orgAddress;
        $this->orgBank = $orgBank;
        $this->orgBankcity = $orgBankcity;
        $this->orgBik = $orgBik;
        $this->orgInn = $orgInn;
        $this->orgKpp = $orgKpp;
        $this->orgKs = $orgKs;
        $this->orgName = $orgName;
        $this->orgOkpo = $orgOkpo;
        $this->orgOkved = $orgOkved;
        $this->orgRs = $orgRs;
        $this->orgType = $orgType;
    }

    public function getAddress(){
        return $this->address;
    }

    public function getAddressComment(){
        return $this->addressComment;
    }

    public function getName(){
        return $this->name;
    }

    public function getOrgAddress(){
        return $this->orgAddress;
    }

    public function getOrgBank(){
        return $this->orgBank;
    }

    public function getOrgBankcity(){
        return $this->orgBankcity;
    }

    public function getOrgBik(){
        return $this->orgBik;
    }

    public function getOrgInn(){
        return $this->orgInn;
    }

    public function getOrgKpp(){
        return $this->orgKpp;
    }

    public function getOrgKs(){
        return $this->orgKs;
    }

    public function getOrgName(){
        return $this->orgName;
    }

    public function getOrgOkpo(){
        return $this->orgOkpo;
    }

    public function getOrgOkved(){
        return $this->orgOkved;
    }

    public function getOrgRs(){
        return $this->orgRs;
    }

    public function getOrgType(){
        return $this->orgType;
    }

    public function getPhone1(){
        return $this->phone1;
    }

    public function getPhone2(){
        return $this->phone2;
    }

    public function getPhoneTime1(){
        return $this->phoneTime1;
    }

    public function getPhoneTime2(){
        return $this->phoneTime2;
    }

    public function getEmail(){
        return $this->email;
    }
}

?>