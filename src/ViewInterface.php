<?php
namespace Merophp\ViewEngine;

interface ViewInterface{
	public function render(): string;
	public function getContentType(): string;
}
