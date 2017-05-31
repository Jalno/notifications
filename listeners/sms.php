<?php
namespace packages\notifications\listeners;
use \packages\userpanel\user;
use \packages\sms\events\templates;
use \packages\sms\template;
use \packages\notifications\api;
class sms{
	public function templates(templates $templates){
		foreach(api::getEvents() as $event){
			if(!$templates->getByName($event::getName())){
				$template = new template();
				$template->name = $event::getName();
				foreach($event::getParameters() as $variable){
					$template->addVariable($variable);
				}
				$template->addVariable(user::class);
				$templates->addTemplate($template);
			}
		}
	}
}