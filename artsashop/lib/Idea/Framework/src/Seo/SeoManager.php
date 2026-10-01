<?php

namespace Idea\Framework\Seo;

use Idea\Framework\Repository\System\SysUrlRewriteRepository;
use Idea\Framework\Seo\Collections\SchemaCollection;
use Idea\Framework\Seo\Collections\TagCollection;
use Idea\Framework\Seo\Data\SeoPageData;
use Idea\Framework\Seo\Factories\SeoPageDataFactory;
use Idea\Framework\Seo\Schemas\BrandSchema;
use Idea\Framework\Seo\Schemas\CategorySchema;
use Idea\Framework\Seo\Schemas\PageSchema;
use Idea\Framework\Seo\Schemas\ProductSchema;
use Idea\Framework\Seo\Schemas\WebSiteSchema;
use Idea\Framework\Seo\Tags\AuthorTag;
use Idea\Framework\Seo\Tags\CanonicalTag;
use Idea\Framework\Seo\Tags\DescriptionTag;
use Idea\Framework\Seo\Tags\GeneratorTag;
use Idea\Framework\Seo\Tags\OpenGraphTag;
use Idea\Framework\Seo\Tags\RobotsTag;
use Idea\Framework\Seo\Tags\TitleTag;
use Idea\Framework\Seo\Tags\TwitterTag;

class SeoManager
{

    protected ?SeoPageData $data = null;

    protected TagCollection $tags;

    protected SchemaCollection $schemas;
    private array $categoryProducts;

    public function __construct()
    {
        $this->tags = new TagCollection();
        $this->schemas = new SchemaCollection();
    }

    /**
     * Define os dados SEO (Model, array ou DTO).
     */
    public function set(mixed $source): self
    {

        if ($source instanceof SeoPageData) {
            $this->data = $source;
        } elseif (is_array($source)) {
            $this->data = SeoPageDataFactory::fromArray($source);
        } elseif (is_object($source)) {
            $this->data = SeoPageDataFactory::fromModel($source);
        } else {
            throw new \InvalidArgumentException('Invalid SEO data source.');
        }

        return $this;
    }

    /**
     * Inicializa as tags padrão.
     */
    protected function build(): void
    {

        if (!$this->data) {
            throw new \RuntimeException('SEO data not defined.');
        }

        $this->schemas = new SchemaCollection();

        switch ($this->resolvePageType()) {
            case 'home':
                $this->schemas->add(
                    new WebSiteSchema($this->data, config('app.url'))
                );
                break;

            case 'default':
                $this->schemas->add(
                    new PageSchema($this->data, url('/'))
                );
                break;

            case 'product':
                $this->schemas->add(
                    new ProductSchema($this->data)
                );
                break;

            case 'category':
                $this->schemas->add(
                    new CategorySchema($this->data)
                );
                break;

            case 'brand':
                $this->schemas->add(
                    new BrandSchema($this->data)
                );
                break;


        }

        $this->tags = new TagCollection();

        $this->tags
            ->add(new TitleTag())
            ->add(new DescriptionTag())
            ->add(new CanonicalTag())
            ->add(new RobotsTag())
            ->add(new AuthorTag())
            ->add(new OpenGraphTag())
            ->add(new TwitterTag())
            ->add(new GeneratorTag())
            ->initialize($this->data);
    }

    /**
     * Retorna HTML completo das meta tags.
     */
    public function render(): string
    {
        $this->build();
        return $this->tags->render() . PHP_EOL . $this->schemas->render();
    }

    /**
     * Retorna o DTO atual.
     */
    public function data(): ?SeoPageData
    {
        return $this->data;
    }

    protected function resolvePageType(): string
    {

        if (request()->routeIs('index.home')) {
            return 'home';
        } else {
            // Retorna o slug
            $slug = trim(request()->path(), '/');

            // Busca pela URL
            $rewrite = SysUrlRewriteRepository::getBySlug($slug);

            if ($rewrite) {

                if ($rewrite['target_type'] == 'product') {
                    return 'product';
                }

                if ($rewrite['target_type'] == 'category') {
                    return 'category';
                }

                if ($rewrite['target_type'] == 'brand') {
                    return 'brand';
                }

            }

        }

        return 'default';

    }

    public function setCategoryProducts(array $products): self
    {
        $this->categoryProducts = $products;

        return $this;
    }

}
