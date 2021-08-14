<?php

namespace Magediatr\Sendsimpleget\Controller\Ajax;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magediatr\Sendsimpleget\Model\FetchAllCategories;


class Get implements HttpGetActionInterface
{
	private Context $context;
	private JsonFactory $_resultJsonFactory;
	private FetchAllCategories $_indexViewModel;
	

	public function __construct(Context $context, JsonFactory $jsonFactory, FetchAllCategories $indexViewModel)
	{
	
		$this->_resultJsonFactory = $jsonFactory;
		$this->_indexViewModel = $indexViewModel;
		$this->context = $context;
	}
	
	public function execute()
	{
		
		$data = $this->_indexViewModel->getCategories();
		$resultJson = $this->_resultJsonFactory->create();
		return $resultJson->setData($data);
	}
}
