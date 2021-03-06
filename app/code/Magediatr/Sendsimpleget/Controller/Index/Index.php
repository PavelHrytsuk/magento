<?php
namespace Magediatr\Sendsimpleget\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory)
	{
		$this->_pageFactory = $pageFactory;
		return parent::__construct($context);
	}

	public function execute()
	{
		$result = $this->_pageFactory->create();
		$result->getConfig()->getTitle()->set('EducationTask');
		return $result;
	}
}
