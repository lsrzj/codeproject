<?php

namespace CodeProject\Mappings;

use CodeProject\Entities\Doctrine\Project;
use CodeProject\Entities\Doctrine\User;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class UserMapping extends EntityMapping {
    /**
     * Returns the fully qualified name of the class that this mapper maps.
     *
     * @return string
     */
    public function mapFor() {
        // Here we tell Doctrine that this mapping is for the Scientist object.
        return User::class;
    }

    /**
     * Load the object's metadata through the Metadata Builder object.
     *
     * @param Fluent $builder
     */
    public function map(Fluent $builder) {
        /*
         * Here we'll map each field in the object.
         * Right now we'll just add the single "id" field as an "increments" type: that's our shortcut to
         * tell Doctrine to do an auto-incrementing, unsigned, primary integer field.
         * We could also do `bigIncrements('id')` or the whole `integer('id')->primary()->unsigned()->autoIncrement()`
         */
        $builder->increments('id');
        $builder->string('name');
        $builder->string('email');
        $builder->string('password');
        $builder->rememberToken('remember_token');
        $builder->timestamp('created_at')->timestampable()->onCreate();
        $builder->timestamp('updated_at')->timestampable()->onUpdate();

        $builder->hasMany(Project::class)->mappedBy('user');
    }
}