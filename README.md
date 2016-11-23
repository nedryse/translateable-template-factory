#nedryse/translateable-template-factory (cc)#
Pavel Železný (2bfree), 2014 ([pavelzelezny.cz](http://pavelzelezny.cz))

## Requirements ##

[Nette Framework 2.4.0](http://nette.org) or higher

## Documentation ##

Proper way how to load translator into the presenters and controls template in the Nette framework based applications

## Instalation ##

Prefered way to intall is by the [Composer](http://getcomposer.org)

	composer require nedryse/translateable-template-factory:~1.1

Or by manualy adding into the [composer.json](https://getcomposer.org/doc/04-schema.md#json-schema)

	{
		"require":{
			"nedryse/translateable-template-factory": "~1.1"
		}
	}

## Setup ##

Add following code into the [config.neon](http://doc.nette.org/en/2.2/configuring#toc-framework-configuration)

	common:
		services:
			nette.templateFactory: Nedryse\Nette\Bridges\ApplicationLatte\TranslatableTemplateFactory

## Usage ##
At the moment of the template creation in the presenter or in the control, the translator is already loaded in it
