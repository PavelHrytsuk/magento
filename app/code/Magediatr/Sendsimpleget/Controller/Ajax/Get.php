<?php

namespace Magediatr\Sendsimpleget\Controller\Ajax;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magediatr\Sendsimpleget\Model\FetchProducts;


class Get implements HttpGetActionInterface
{
	private Context $context;
	private JsonFactory $_resultJsonFactory;
	private FetchProducts $_indexViewModel;
	

	public function __construct(Context $context, JsonFactory $jsonFactory, FetchProducts $indexViewModel)
	{
	
		$this->_resultJsonFactory = $jsonFactory;
		$this->_indexViewModel = $indexViewModel;
		$this->context = $context;
	}
	
	public function execute()
	{
		
		$data = $this->_indexViewModel->getProductData();
		//$data = ['Hello', 'name', 'ok', 'GoodBye', 'bad', 'qwerty'];
		$resultJson = $this->_resultJsonFactory->create();
		return $resultJson->setData($data);
	}
}
