<?php

namespace Modules\Payments\Gateways\Ipag\Support\Provider\Antifraudes;

use Modules\Payments\Gateways\Ipag\Model\Model;
use Modules\Payments\Gateways\Ipag\Model\Schema\Schema;
use Modules\Payments\Gateways\Ipag\Model\Schema\SchemaBuilder;
use Modules\Payments\Gateways\Ipag\Support\Credentials\Antifraudes\KondutoCredentials;

/**
 * KondutoProvider Class
 *
 * Classe responsável pelo provider da identidade Konduto.
 */
final class KondutoProvider extends Model
{
    /**
     * @param array $data
     *  array de dados do Konduto Credentials.
     *
     *  + ['apiKey'] string (opcional).
     *  + ['publicKey'] string (opcional).
     */
    public function __construct(?array $data = null)
    {
        parent::__construct([
            'name' => 'konduto',
            'credentials' => $data
        ]);
    }

    public function schema(SchemaBuilder $schema): Schema
    {
        $schema->string('name')->default('konduto')->nullable();
        $schema->has('credentials', KondutoCredentials::class)->nullable();

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
     * @return KondutoCredentials|null
     */
    public function getCredentials(): ?KondutoCredentials
    {
        return $this->get('credentials');
    }

    /**
     * Seta o valor da propriedade credentials.
     *
     * @param KondutoCredentials|null $credentials
     * @return self
     */
    public function setCredentials(?KondutoCredentials $credentials = null): self
    {
        $this->set('credentials', $credentials);
        return $this;
    }

}
