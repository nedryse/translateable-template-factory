<?php

use Nedryse\Nette\Bridges\ApplicationLatte\TranslatableTemplateFactory;
use Nette\Bridges\ApplicationLatte\ILatteFactory;
use Nette\Localization\ITranslator;

class TranslatableTemplateFactoryTest extends PHPUnit_Framework_TestCase
{

	public function testCreateTemplate()
	{
		/* @var $controlMock Nette\Application\UI\Control */
		$controlMock = $this->getMock('Nette\Application\UI\Control');

		/* @var $translatorMock ITranslator */
		$translatorMock = $this->getMock('Nette\Localization\ITranslator');

		/* @var $latteMock Latte\Engine */
		$latteMock = $this->getMockBuilder('Latte\Engine')
				->setMethods(array('addFilter'))
				->getMock();
		$latteMock->expects($this->at(10))
				->method('addFilter')
				->with($this->equalTo('translate'), $this->equalTo(array($translatorMock, 'translate')))
				->will($this->returnSelf());
		$latteMock->onCompile = array();

		/* @var $latteFactroyMock ILatteFactory */
		$latteFactroyMock = $this->getMockBuilder('Nette\Bridges\ApplicationLatte\ILatteFactory')
				->setMethods(array('create'))
				->getMock();
		$latteFactroyMock->expects($this->once())
				->method('create')
				->will($this->returnValue($latteMock));

		$class = new TranslatableTemplateFactory($latteFactroyMock, NULL, NULL, NULL, NULL, $translatorMock);
		$this->assertInstanceOf('Nette\Bridges\ApplicationLatte\Template', $class->createTemplate($controlMock));
	}

	public function testTranslatorInjection()
	{
		/* @var $latteFactroyMock ILatteFactory */
		$latteFactroyMock = $this->getMock('Nette\Bridges\ApplicationLatte\ILatteFactory');

		/* @var $translatorMock ITranslator */
		$translatorMock = $this->getMock('Nette\Localization\ITranslator');

		$class = new TranslatableTemplateFactory($latteFactroyMock, NULL, NULL, NULL, NULL, $translatorMock);
		$this->assertInstanceOf('Nette\Localization\ITranslator', $class->getTranslator());
	}

	/**
	 * @expectedException Nette\InvalidStateException
	 * @expectedExceptionMessage Translator have to be set
	 */
	public function testGetTranslatorNotInjected()
	{
		/* @var $latteFactroyMock ILatteFactory */
		$latteFactroyMock = $this->getMock('Nette\Bridges\ApplicationLatte\ILatteFactory');

		$class = new TranslatableTemplateFactory($latteFactroyMock);
		$class->getTranslator();
	}

	/**
	 * @expectedException Nette\InvalidStateException
	 * @expectedExceptionMessage Translator has already been set
	 */
	public function testSetTranslatoralreadyInjected()
	{
		/* @var $latteFactroyMock ILatteFactory */
		$latteFactroyMock = $this->getMock('Nette\Bridges\ApplicationLatte\ILatteFactory');

		/* @var $translatorMock ITranslator */
		$translatorMock = $this->getMock('Nette\Localization\ITranslator');

		$class = new TranslatableTemplateFactory($latteFactroyMock, NULL, NULL, NULL, NULL, $translatorMock);
		$class->setTranslator($translatorMock);
	}

}
