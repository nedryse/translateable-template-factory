<?php

namespace Nedryse\Nette\Bridges\ApplicationLatte;

use Nette\Application\UI\Control;
use Nette\Bridges\ApplicationLatte\ILatteFactory;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\Bridges\ApplicationLatte\TemplateFactory;
use Nette\Caching\IStorage;
use Nette\Http\IRequest;
use Nette\InvalidStateException;
use Nette\Localization\ITranslator;
use Nette\Security\User;

/**
 * TranslatableTemplateFactory sets ITranslator to all presenter templates
 */
class TranslatableTemplateFactory extends TemplateFactory
{

	/** @var ITranslator */
	protected $translator;

	/**
	 * Constructor
	 *
	 * @param ILatteFactory $latteFactory
	 * @param IRequest $httpRequest [OPTIONAL]
	 * @param User $user [OPTIONAL]
	 * @param IStorage $cacheStorage [OPTIONAL]
	 * @param ITranslator $translator [OPTIONAL]
	 * @return void
	 */
	public function __construct(ILatteFactory $latteFactory, IRequest $httpRequest = NULL, User $user = NULL, IStorage $cacheStorage = NULL, ITranslator $translator = NULL)
	{
		parent::__construct($latteFactory, $httpRequest, $user, $cacheStorage);
		$this->setTranslator($translator);
	}

	/**
	 * Template factory
	 *
	 * @param Control $control
	 * @return Template
	 */
	public function createTemplate(Control $control = NULL)
	{
		$template = parent::createTemplate($control);
		$template->setTranslator($this->getTranslator());
		return $template;
	}
	// <editor-fold defaultstate="collapsed" desc="Getters & Setters">

	/**
	 * Translator getter
	 *
	 * @return ITranslator
	 * @throws InvalidStateException
	 */
	public function getTranslator()
	{
		if ($this->translator === NULL) {
			throw new InvalidStateException('Translator have to be set');
		}
		return $this->translator;
	}

	/**
	 * Translator setter
	 *
	 * @param ITranslator $translator
	 * @return TranslatableTemplateFactory
	 * @throws InvalidStateException
	 */
	public function setTranslator(ITranslator $translator = NULL)
	{
		if ($this->translator !== NULL) {
			throw new InvalidStateException('Translator has already been set');
		}
		$this->translator = $translator;
		return $this;
	}
	// </editor-fold>
}
