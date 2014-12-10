Emarsys API connector php class
===============================
##Usage:
####Include
```php
require('../emarsys_api_connector_php_class/emarsys_api_connector.class.php');
$emarsys = new Emarsys_API_Connector('campaignId');
```
####GET (events list)
```php
print_r($emarsys->get('event'));
```

####POST (get user fields)
```php
$list=array("user@mail.ru", "user2@gmail.com");
$params = array("keyId" => "3", "keyValues" => $list, "fields"=>array("1","2","3","31"));
$data_string = json_encode($params);
print_r($emarsys->post("contact/getdata", $data_string));
```

