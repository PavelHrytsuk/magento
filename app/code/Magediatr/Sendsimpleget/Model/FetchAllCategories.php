<?php

declare(strict_types=1);

namespace Magediatr\Sendsimpleget\Model;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Block\ArgumentInterface;
use \Magento\Framework\View\Element\Template\Context;
use \Magento\Catalog\Model\CategoryList;
use \Magento\Framework\Api\SearchCriteriaInterface;
use \Magento\Framework\Api\Search\FilterGroup;
use \Magento\Framework\Api\FilterBuilder;

class FetchAllCategories extends Template implements ArgumentInterface
{

    /**
     * @var CategoryList
     */
    private $categoryList;
    /**
     * @var SearchCriteriaInterface
     */
    private $searchCriteria;
    /**
     * @var FilterGroup
     */
    private $filterGroup;
    /**
     * @var FilterBuilder
     */
    private $filterBuilder;

    /**
     * @param Context $context
     * @param CategoryList $categoryList
     * @param SearchCriteriaInterface $criteria
     * @param FilterGroup $filterGroup
     * @param FilterBuilder $filterBuilder
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function __construct(
        Context                 $context,
        CategoryList            $categoryList,
        SearchCriteriaInterface $criteria,
        FilterGroup             $filterGroup,
        FilterBuilder           $filterBuilder
    )
    {
        $this->categoryList = $categoryList;
        $this->searchCriteria = $criteria;
        $this->filterGroup = $filterGroup;
        $this->filterBuilder = $filterBuilder;
        parent::__construct($context);
        $this->getCategories();
    }
    /**
     * @return \Magento\Cms\Model\Block|array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCategories()
    {
        $this->filterGroup->setFilters([
            $this->filterBuilder
                ->setField('is_active')
                ->setConditionType('eq')
                ->setValue(1)
                ->create()
  	     ]);

        $this->searchCriteria->setFilterGroups([$this->filterGroup])->setCurrentPage(1);
        $categories = $this->categoryList->getList($this->searchCriteria);
        $categoriesItems = $categories->getItems();

        $categoriesArr = [];

        foreach ($categoriesItems as $key => $categoriesItem) {
	    $categoriesArr[$key]['id'] = $categoriesItem->getId();
	    $categoriesArr[$key]['parent_id'] = $categoriesItem->getParentId();
            $categoriesArr[$key]['name'] = $categoriesItem->getName();
	}

        return $categoriesArr;

}

}

