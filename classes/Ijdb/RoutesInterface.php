<?php

namespace Ijdb;
use Core\Authentication;

interface RoutesInterface
{
	public function getRoutes(): array;
	public function getAuthentication(): Authentication;
}
