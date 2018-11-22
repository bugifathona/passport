<?php
namespace Laravel\Passport;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidFactory;
use Ramsey\Uuid\Generator\CombGenerator;
use Ramsey\Uuid\Codec\TimestampFirstCombCodec;

trait UuidTrait
{
    /**
     * The "booting" method of the model.
     */
    protected static function boot()
    {
        parent::boot();
        /**
         * Attach to the 'creating' Model Event to provide a UUID
         * for the `id` field (provided by $model->getKeyName()).
         */
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = $model->generateNewUuid();
            return true;
        });
    }
    /**
     * Get a new version 4 (random) UUID.
     *
     * @return \Rhumsaa\Uuid\Uuid
     */
    public function generateNewUuid()
    {
        $factory = new UuidFactory();
        $generator = new CombGenerator($factory->getRandomGenerator(), $factory->getNumberConverter());
        $codec = new TimestampFirstCombCodec($factory->getUuidBuilder());
         
        $factory->setRandomGenerator($generator);
        $factory->setCodec($codec);
         
        Uuid::setFactory($factory);

        return Uuid::uuid4();
    }
}