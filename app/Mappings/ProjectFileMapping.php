<?php

namespace CodeProject\Mappings;

use CodeProject\Entities\Doctrine\Project;
use CodeProject\Entities\Doctrine\ProjectFile;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class ProjectFileMapping extends EntityMapping
{
    /**
     * Returns the fully qualified name of the class that this mapper maps.
     *
     * @return string
     */
    public function mapFor()
    {
        // Here we tell Doctrine that this mapping is for the Client object.
        return ProjectFile::class;
    }
    /**
     * Load the object's metadata through the Metadata Builder object.
     *
     * @param Fluent $builder
     */
    public function map(Fluent $builder)
    {
        /*
         * Here we'll map each field in the object.
         * Right now we'll just add the single "id" field as an "increments" type: that's our shortcut to
         * tell Doctrine to do an auto-incrementing, unsigned, primary integer field.
         * We could also do `bigIncrements('id')` or the whole `integer('id')->primary()->unsigned()->autoIncrement()`
         */
        $builder->increments('id');
        $builder->string('name');
        $builder->text('description');
        $builder->string('extension');
        $builder->carbonDateTime('created_at')->timestampable()->onCreate();
        $builder->carbonDateTime('updated_at')->timestampable()->onUpdate();

        $builder->belongsTo(Project::class)->inversedBy('project');
    }
}