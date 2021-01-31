# bitrix-id-mapper

Получение списка инфоблоков на проекте:

```php
  use Services\IblockService;
  
  $iblockService = new IblockService();
  $iblockList = new Constants($iblockService);
  
  /**
   * Получение ID инфоблока по ID его типа и коду
   */
  $iblockID = $iblockList->iblock_type_id["iblock_code"]["ID"];
```

Получение элемента инфоблока по его ID:

```php
  use Services\IblockElementService;
  
  /*...*/
  
  $elementService = new IblockElementService();
  $element = $elementService->getEntityByID($iblockID, $elementID);
```

Получение элемента инфоблока по его символьному коду:

```php
  use Services\IblockElementService;
  
  /*...*/
  
  $elementService = new IblockElementService(); //для разделов IblockSectionService
  $element = $elementService->getEntityByCode($iblockID, $elementCode);
```

Получение элементов инфоблока путем передачи фильтра:

```php
  use Services\IblockElementService, Bitrix\Main;
  
  /*...*/
  
  $elementService = new IblockElementService(); //для разделов IblockSectionService
  $elements = $elementService->getEntitiesByFilter($iblockID, $arFilter);
  
  foreach($elements as $element){
    /*...*/
  }
  
  /**
   * Передача массива $arSelect для выборки полей и свойств элементов
   */
    
   $arSelect = ["DETAIL_TEXT", "PROPERTY_GALLERY"];
   $elements = $elementService->getEntitiesByFilter($iblockID, $arFilter, $arSelect);
   
   /**
    * Кеширование
    */
    
   $elementService->setCacheTime(36000000);
   
   /**
    * Пагинация
    */
     
   $nav = new Main\UI\PageNavigation("pagination-example");
   $nav->allowAllRecords(true)
      ->setPageSize(10)
      ->initFromUri();
   $paginationSettings = [
      "offset" => $nav->getOffset(), 
      "limit" => $nav->getLimit(),
   ];
      
   $elements = $elementService->getEntitiesByFilter(
      $iblockID, 
      $arFilter, 
      $arSelect, 
      $paginationSettings
   );
   
```
