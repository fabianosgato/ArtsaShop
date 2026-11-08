<?php

namespace Modules\Payments\Gateways\Ipag\Support\Provider\Antifraudes;

use Modules\Payments\Gateways\Ipag\Model\Model;
use Modules\Payments\Gateways\Ipag\Model\Schema\Schema;
use Modules\Payments\Gateways\Ipag\Model\Schema\SchemaBuilder;
use Modules\Payments\Gateways\Ipag\Support\Credentials\Antifraudes\RedShieldCredentials;

/**
 * RedShieldProvider Class
 *
 * Classe responsável pelo provider da identidade Red Shield.
 */
final class RedShieldProvider extends Model
{
    /**
     * @param array $data
     *  array de dados do Red Shield Credentials.
     *
     *  + ['token'] string (opcional).
     *  + ['entityId'] string (opcional).
     *  + ['channelId'] string (opcional).
     *  + ['serviceId'] string (opcional).
     */
    public function __construct(?array $data = null)
    {
        parent::__construct([
            'name' => 'redshield',
            'credentials' => $data
        ]);
    }

    public function schema(SchemaBuilder $schema): Schema
    {
        $schema->string('name')->default('redshield')->nullable();
        $schema->has('credentials', RedShieldCredentials::class)->nullable();

        return $schema->build();
    }

    /**
     * Retorna o valor da propriedade name.
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->get('name');
    }

    /**
     * Retorna o valor da propriedade credentials.
     *
     * @return RedShieldCredentials|null
     */
    public function getCredentials(): ?RedShieldCredentials
    {
        return $this->get('credentials');
    }

    /**
     * Seta o valor da propriedade credentials.
     *
     * @param RedShieldCredentials|null $credentials
     * @return self
     */
    public function setCredentials(?RedShieldCredentials $credentials = null): self
    {
        $this->set('credentials', $credentials);
        return $this;
    }

}
