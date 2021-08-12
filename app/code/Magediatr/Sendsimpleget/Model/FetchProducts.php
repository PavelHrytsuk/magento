?php

declare(strict_types=1);

namespace Magediatr\Sendsimpleget\Model;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Block\ArgumentInterface;
use \Magento\Framework\View\Element\Template\Context;
use \Magento\Catalog\Model\ProductRepository;
use \Magento\Framework\Api\SearchCriteriaInterface;
use \Magento\Framework\Api\Search\FilterGroup;
use \Magento\Framework\Api\FilterBuilder;
use \Magento\Catalog\Model\Product\Attribute\Source\Status;
use \Magento\Catalog\Model\Product\Visibility;

class FetchProducts extends Template implements ArgumentInterface
{

    /**
     * @var ProductRepository
     */
    private $productRepository;
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
     * @var Status
     */
    private $productStatus;
    /**
     * @var Visibility
     */
    private $productVisibility;

    /**
     * @param Context $context
     * @param ProductRepository $productRepository
     * @param SearchCriteriaInterface $criteria
     * @param FilterGroup $filterGroup
     * @param FilterBuilder $filterBuilder
     * @param Status $productStatus
     * @param Visibility $productVisibility
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function __construct(
        Context                 $context,
        ProductRepository       $productRepository,
        SearchCriteriaInterface $criteria,
        FilterGroup             $filterGroup,
        FilterBuilder           $filterBuilder,
        Status                  $productStatus,
        Visibility              $productVisibility
    )
    {
        $this->productRepository = $productRepository;
        $this->searchCriteria = $criteria;
        $this->filterGroup = $filterGroup;
        $this->filterBuilder = $filterBuilder;
        $this->productStatus = $productStatus;
        $this->productVisibility = $productVisibility;
        parent::__construct($context);
        $this->getProductData();
    }
    /**
     * @return \Magento\Cms\Model\Block|array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProductData()
    {
        $this->filterGroup->setFilters([
            $this->filterBuilder
                ->setField('status')
                ->setConditionType('in')
                ->setValue($this->productStatus->getVisibleStatusIds())
                ->create(),
            $this->filterBuilder
                ->setField('visibility')
                ->setConditionType('in')
                ->setValue($this->productVisibility->getVisibleInSiteIds())
                ->create(),
        ]);

        $this->searchCriteria->setFilterGroups([$this->filterGroup])->setCurrentPage>
        $products = $this->productRepository->getList($this->searchCriteria);
        $productItems = $products->getItems();

        $productArr = [];

        foreach ($productItems as $key => $productItem) {
            $productArr[$key]['name'] = $productItem->getName();
            $productArr[$key]['price'] = round($productItem->getPrice(), 2);
            $productArr[$key]['description'] = $productItem->getDescription();
            $productArr[$key]['image'] = $productItem->getImage();
        }

        return $productArr;
    }

}

