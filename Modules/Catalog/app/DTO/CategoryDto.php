<?php

/**
 * Fabiano Gato
 *
 * NOTICE OF LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 *
 * É concedida permissão, gratuitamente, a qualquer pessoa que obtenha uma cópia
 * deste software e arquivos de documentação associados
 *
 ******************************************************
 *
 * @copyright    Copyright (c) Fabiano Gato
 * @author       Fabiano Gato <fabianogattoti@gmail.com>
 */

namespace Modules\Catalog\DTO;

use JsonSerializable;

/**
 * DTO imutável para Categoria do menu de navegação.
 * Espelha a interface TypeScript em resources/js/frontend/composables/navigation.ts
 */
final readonly class CategoryDto implements JsonSerializable
{
    public function __construct(
        public int $entityId,
        public int $parentId,
        public string $category,
        public string $slugKey,
        public int $level,
        public string $categoryPath,
        public bool $isOpen,
        public bool $hasProducts,
        public bool $hasChildren,
        /** @var self[] */
        public array $children = [],
        public bool $isActive = false,
    ) {}

    /**
     * Cria instância a partir do array bruto do Repository.
     *
     * @param array{
     *     entityId: int,
     *     parentId: int,
     *     category: string,
     *     slugKey: string,
     *     level: int,
     *     categoryPath: string,
     *     isOpen: bool,
     *     hasProducts: bool,
     *     hasChildren: bool,
     *     children: array,
     *     isActive?: bool
     * } $data
     */
    public static function fromArray(array $data): self
    {
        $children = [];
        foreach ($data['children'] ?? [] as $child) {
            $children[] = self::fromArray($child);
        }

        return new self(
            entityId: $data['entityId'],
            parentId: $data['parentId'],
            category: $data['category'],
            slugKey: $data['slugKey'],
            level: $data['level'],
            categoryPath: $data['categoryPath'],
            isOpen: $data['isOpen'],
            hasProducts: $data['hasProducts'],
            hasChildren: $data['hasChildren'],
            children: $children,
            isActive: $data['isActive'] ?? false,
        );
    }

    /**
     * Converte para array (compatível com Inertia/Vue).
     *
     * @return array{
     *     entityId: int,
     *     parentId: int,
     *     category: string,
     *     slugKey: string,
     *     level: int,
     *     categoryPath: string,
     *     isOpen: bool,
     *     hasProducts: bool,
     *     hasChildren: bool,
     *     children: array,
     *     isActive: bool
     * }
     */
    public function toArray(): array
    {
        return [
            'entityId' => $this->entityId,
            'parentId' => $this->parentId,
            'category' => $this->category,
            'slugKey' => $this->slugKey,
            'level' => $this->level,
            'categoryPath' => $this->categoryPath,
            'isOpen' => $this->isOpen,
            'hasProducts' => $this->hasProducts,
            'hasChildren' => $this->hasChildren,
            'children' => array_map(fn (self $c) => $c->toArray(), $this->children),
            'isActive' => $this->isActive,
        ];
    }

    /**
     * Retorna nova instância com filhos atualizados (imutabilidade).
     *
     * @param  self[]  $children
     */
    public function withChildren(array $children): self
    {
        return new self(
            entityId: $this->entityId,
            parentId: $this->parentId,
            category: $this->category,
            slugKey: $this->slugKey,
            level: $this->level,
            categoryPath: $this->categoryPath,
            isOpen: $this->isOpen,
            hasProducts: $this->hasProducts,
            hasChildren: $this->hasChildren,
            children: $children,
            isActive: $this->isActive,
        );
    }

    /**
     * Retorna nova instância com estado ativo atualizado.
     */
    public function withActiveState(bool $isActive, bool $isOpen): self
    {
        return new self(
            entityId: $this->entityId,
            parentId: $this->parentId,
            category: $this->category,
            slugKey: $this->slugKey,
            level: $this->level,
            categoryPath: $this->categoryPath,
            isOpen: $isOpen,
            hasProducts: $this->hasProducts,
            hasChildren: $this->hasChildren,
            children: $this->children,
            isActive: $isActive,
        );
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
