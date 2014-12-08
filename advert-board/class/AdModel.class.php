<?php
// Requirements
define('__ROOT__', dirname(dirname(__FILE__)));
require_once __ROOT__.'/datastore_connect/Model.php';

/**
 * Model class for ad objects
 */
class AdModel extends Model {

  const AD_MODEL_KIND = 'AdModel';
  const TITLE_NAME = 'title';
  const PRICE_NAME = 'price';
  const DATE_NAME = 'date';

  private $ad_title;
  private $ad_price;
  private $ad_date;

  public function __construct($title, $price, $date) {
    parent::__construct();
    $this->key_name = sha1($title);
    $this->ad_title = $title;
    $this->ad_price = $price;
    $this->ad_date = $date;
  }

  public function getTitle() {
    return $this->ad_title;
  }

  public function getPrice() {
    return $this->ad_price;
  }

  public function getDate() {
    return (new DateTime($this->ad_date))->format("d/m/Y H:i");
  }

  protected static function getKindName() {
    return self::AD_MODEL_KIND;
  }

  /**
   * Generate the entity property map from the ad object fields.
   */
  protected function getKindProperties() {
    $property_map = [];

    $property_map[self::TITLE_NAME] =
        parent::createStringProperty($this->ad_title, true);

    $property_map[self::PRICE_NAME] =
        parent::createStringProperty($this->ad_price, false); // TODO : Number property ?

    $property_map[self::DATE_NAME] =
        parent::createDateProperty($this->ad_date, false);

    return $property_map;
  }


  /**
   * Fetch an ad object given its title.  If get a cache miss, fetch from the Datastore.
   * @param $title is the title of the ad.
   */
  public static function get($title) {
    $mc = new Memcache();
    $key = self::getCacheKey($title);
    $response = $mc->get($key);
    if ($response) {
      return [$response];
    }

    $query = parent::createQuery(self::AD_MODEL_KIND);
    $title_filter = parent::createStringFilter(self::TITLE_NAME, $title);
    $filter = parent::createCompositeFilter([$title_filter]);
    $query->setFilter($filter);
    $results = parent::executeQuery($query);
    $extracted = self::extractQueryResults($results);
    return $extracted;
  }

  /**
   * This method will be called after a Datastore put.
   */
  protected function onItemWrite() {
    $mc = new Memcache();
    try {
      $key = self::getCacheKey($this->ad_title);
      $mc->add($key, $this, 0, 120);
    }
    catch (Google_Cache_Exception $ex) {
      syslog(LOG_WARNING, "in onItemWrite: memcache exception");
    }
  }

  /**
  * This method will be called prior to a datastore delete
  */
  protected function beforeItemDelete() {
    $mc = new Memcache();
    $key = self::getCacheKey($this->ad_title);
    $mc->delete($key);
  }

  /**
   * Extract the results of a Datastore query into AdModel objects
   * @param $results Datastore query results
   */
  protected static function extractQueryResults($results) {
    $query_results = [];
    foreach($results as $result) {
      $id = @$result['entity']['key']['path'][0]['id'];
      $key_name = @$result['entity']['key']['path'][0]['name'];
      $props = $result['entity']['properties'];
      $title = $props[self::TITLE_NAME]->getStringValue();
      $price = $props[self::PRICE_NAME]->getStringValue();
      $date = $props[self::DATE_NAME]->getDateTimeValue();

      $ad_model = new AdModel($title, $price, $date);
      $ad_model->setKeyId($id);
      $ad_model->setKeyName($key_name);
      // Cache this read ad
      $ad_model->onItemWrite();

      $query_results[] = $ad_model;
    }
    return $query_results;
  }

  private static function getCacheKey($title) {
    return sprintf("%s_%s", self::AD_MODEL_KIND, sha1($title));
  }
}
