<?php
namespace Lib\Exceptions;
use Psr\Container\NotFoundExceptionInterface;

class NotFoundException extends \Exception implements NotFoundExceptionInterface
{

}