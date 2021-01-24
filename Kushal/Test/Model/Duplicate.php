<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Kushal\Test\Model;

use Magento\Catalog\Model\Product\Copier;
use Magento\Catalog\Model\Product;
use \Magento\Framework\App\State;
use \Magento\Eav\Model\Config;
use \Psr\Log\LoggerInterface;
use \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;


class Duplicate
{
    const ENTITY = 'catalog_product';
    const CONDITION_ATTRIBUTE_CODE = 'condition';
    const CONDITION_NEW = 'new';
    const CONDITION_USED = 'used';
    const CONDITION_REFURBISHED = 'refurbished';

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;
    
    /**
     * @var State
     */
    protected $appState;

    /**
     * @var Product
     */
    protected $product;

    /**
     * @var Copier
     */
    protected $copier;

    /**
     * @var Config
     */
    protected $config;
    
    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(
        CollectionFactory $collectionFactory,
        State $appState,
        Product $product,
        Copier $copier,
        Config $config,
        LoggerInterface $logger
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->appState = $appState;
        $this->product = $product;
        $this->copier = $copier;
        $this->eavConfig = $config;
        $this->logger = $logger;
        $this->appState->setAreaCode('frontend');
    }

    /**
     * Creating used and refurbished products.
     * @return int $totalCount
     */
    public function ProductCollectionCopy(){
        $attributeValue = $this->getAttributeData();
        $productCollection = $this->collectionFactory->create();
        $productCollection->addAttributeToSelect('*');
        $productCollection->addAttributeToFilter('condition',$attributeValue[self::CONDITION_NEW]);
        $productArray = $productCollection->getData();
        foreach($productArray as $product){
            $productObject = $this->product->load($product['entity_id']);
            $productUsed = $this->modifyProduct(self::CONDITION_NEW,self::CONDITION_USED,$productObject,$attributeValue[self::CONDITION_USED]);
            $productRefurbished = $this->modifyProduct(self::CONDITION_USED,self::CONDITION_REFURBISHED,$productObject,$attributeValue[self::CONDITION_REFURBISHED]);
            //exception handling and logging of data
            try{
                $usedProduct = $this->copier->copy($productUsed);
                $this->logger->info('product with sku '.$usedProduct->getSku().' has been created');
                $refurbishedProduct =$this->copier->copy($productRefurbished);
                $this->logger->info('product with sku '.$refurbishedProduct->getSku().' has been created');
            } catch(Exception $e){
                $this->logger->exception($e->getMessage());
            }
        }
        $totalCount = 2*count($productArray);
        return $totalCount;
    }

    /**
     * To get product attribute option label data
     * @return array $attributeValue
    */
    private function getAttributeData(){
        $attribute = $this->eavConfig->getAttribute(self::ENTITY, self::CONDITION_ATTRIBUTE_CODE);
        $options = $attribute->getSource()->getAllOptions(false);
        $attributeValue = [];
        foreach($options as $option) {
            $attributeValue[strtolower($option['label'])] = $option['value'];    
        }
        return $attributeValue;
    }

    /**
     * Modify product data
     *
     * @param  string $curent
     * @param  string $updated
     * @param  object $product
     * @param  int $attId
     * @return object $product
    */
    private function modifyProduct($curent,$updated,$product,$attId){
        $productName = strtoupper(str_ireplace($curent,$updated,$product->getName()));
        $product->setName($productName);
        $productSku = strtoupper(str_ireplace($curent,$updated,$product->getSku()));
        $product->setSku($productSku);
        $productUrl = strtoupper(str_ireplace($curent,$updated,$product->getProductUrl()));
        $product->setProductUrl($productUrl);
        $metaTitle = strtoupper(str_ireplace($curent,$updated,$product->getMetaTitle()));
        $product->setMetaTitle($metaTitle);
        $product->setCondition($attId);
        return $product;
    }
}
