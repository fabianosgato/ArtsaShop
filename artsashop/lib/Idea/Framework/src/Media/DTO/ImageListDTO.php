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
 *****************************************************
 *
 * @copyright    Copyright (c) Fabiano Gato
 * @author       Fabiano Gato <fabianogattoti@gmail.com>
 *
 */
declare(strict_types=1);

namespace Idea\Framework\Media\DTO;

readonly class ImageListDTO
{

    /**
     * @param string $imagePath
     * @param string $imageRelativePath
     * @param string $imageUrl
     */
    public function __construct(
        public string $imagePath,
        public string $imageRelativePath,
        public string $imageUrl,
    ){
    }

}
