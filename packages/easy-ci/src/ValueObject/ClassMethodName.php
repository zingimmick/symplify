<?php

declare(strict_types=1);

namespace Symplify\EasyCI\ValueObject;

use ReflectionMethod;
use Symplify\SmartFileSystem\SmartFileInfo;
use Symplify\SymplifyKernel\Exception\ShouldNotHappenException;

final class ClassMethodName
{
    public function __construct(
        private string $class,
        private string $method,
        private SmartFileInfo $latteFileInfo
    ) {
    }

    public function getClassMethodName(): string
    {
        return $this->class . '::' . $this->method;
    }

    public function getFileLine(): string
    {
        if ($this->isOnVariableStaticCall()) {
            throw new ShouldNotHappenException();
        }

        $reflectionMethod = $this->getReflectionMethod();
        return $reflectionMethod->getFileName() . ':' . $reflectionMethod->getStartLine();
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getFilterProviderClassName(): string
    {
        return ucfirst($this->method) . 'FilterProvider';
    }

    public function isOnVariableStaticCall(): bool
    {
        return \str_starts_with($this->class, '$');
    }

    public function getReflectionMethod(): ReflectionMethod
    {
        if ($this->isOnVariableStaticCall()) {
            throw new ShouldNotHappenException();
        }

        return new ReflectionMethod($this->class, $this->method);
    }

    public function getLatteFilePath(): string
    {
        return $this->latteFileInfo->getRelativeFilePathFromCwd();
    }
}
