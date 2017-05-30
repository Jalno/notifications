<?php
namespace packages\notifications\listeners;
use \packages\email\events\templates;
use \packages\email\template;
use \packages\notifications\api;
class email{
	public function templates(templates $templates){
		foreach(api::getEvents() as $event){
			if(!$templates->getByName($event::getName())){
				$template = new template();
				$template->name = $event::getName();
				foreach($event::getParameters() as $variable){
					$template->addVariable($variable);
				}
				$templates->addTemplate($template);
			}
		}
	}
}