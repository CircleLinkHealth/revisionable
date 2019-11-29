<?php

/*
 * This file is part of CarePlan Manager by CircleLink Health.
 */

namespace Venturecraft\Revisionable;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Revision.
 * 
 * Base model to allow for revision history on
 * any model that extends this model
 * 
 * (c) Venture Craft <http://www.venturecraft.com.au>
 *
 * @property int $id
 * @property string $revisionable_type
 * @property int $revisionable_id
 * @property int|null $user_id
 * @property string $key
 * @property string|null $old_value
 * @property string|null $new_value
 * @property string|null $ip
 * @property int $is_phi
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $revisionable
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Revision newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Revision newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Revision query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Revision whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Revision whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Revision whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Revision whereIsPhi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Revision whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Revision whereNewValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Revision whereOldValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Revision whereRevisionableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Revision whereRevisionableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Revision whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Revision whereUserId($value)
 * @mixin \Eloquent
 */
class Revision extends Eloquent
{
    protected $connection = "remote";

    public $guarded = [];
    /**
     * @var string
     */
    public $table = 'revisions';

    /**
     * @var array
     */
    protected $revisionFormattedFields = [];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * Field Name.
     *
     * Returns the field that was updated, in the case that it's a foreign key
     * denoted by a suffix of "_id", then "_id" is simply stripped
     *
     * @return string field
     */
    public function fieldName()
    {
        if ($formatted = $this->formatFieldName($this->key)) {
            return $formatted;
        }
        if (strpos($this->key, '_id')) {
            return str_replace('_id', '', $this->key);
        }

        return $this->key;
    }

    /*
     * Examples:
    array(
        'public' => 'boolean:Yes|No',
        'minimum'  => 'string:Min: %s'
    )
     */

    /**
     * Format the value according to the $revisionFormattedFields array.
     *
     * @param  $key
     * @param  $value
     *
     * @return string formatted value
     */
    public function format($key, $value)
    {
        $related_model           = $this->revisionable_type;
        $related_model           = new $related_model();
        $revisionFormattedFields = $related_model->getRevisionFormattedFields();

        if (isset($revisionFormattedFields[$key])) {
            return FieldFormatter::format($key, $value, $revisionFormattedFields);
        }

        return $value;
    }

    /**
     * Returns the object we have the history of.
     *
     * @return false|object
     */
    public function historyOf()
    {
        if (class_exists($class = $this->revisionable_type)) {
            return $class::find($this->revisionable_id);
        }

        return false;
    }

    /**
     * New Value.
     *
     * Grab the new value of the field, if it was a foreign key
     * attempt to get an identifying name for the model.
     *
     * @return string old value
     */
    public function newValue()
    {
        return $this->getValue('new');
    }

    /**
     * Old Value.
     *
     * Grab the old value of the field, if it was a foreign key
     * attempt to get an identifying name for the model.
     *
     * @return string old value
     */
    public function oldValue()
    {
        return $this->getValue('old');
    }

    /**
     * Revisionable.
     *
     * Grab the revision history for the model that is calling
     *
     * @return array revision history
     */
    public function revisionable()
    {
        return $this->morphTo();
    }

    /**
     * User Responsible.
     *
     * @return User user responsible for the change
     */
    public function userResponsible()
    {
        if (empty($this->user_id)) {
            return false;
        }
        if (class_exists($class = '\Cartalyst\Sentry\Facades\Laravel\Sentry')
            || class_exists($class = '\Cartalyst\Sentinel\Laravel\Facades\Sentinel')
        ) {
            return $class::findUserById($this->user_id);
        }
        $user_model = app('config')->get('auth.model');

        if (empty($user_model)) {
            $user_model = app('config')->get('auth.providers.users.model');
            if (empty($user_model)) {
                return false;
            }
        }
        if ( ! class_exists($user_model)) {
            return false;
        }

        return $user_model::find($this->user_id);
    }

    /**
     * Format field name.
     *
     * Allow overrides for field names.
     *
     * @param $key
     *
     * @return bool
     */
    private function formatFieldName($key)
    {
        $related_model               = $this->revisionable_type;
        $related_model               = new $related_model();
        $revisionFormattedFieldNames = $related_model->getRevisionFormattedFieldNames();

        if (isset($revisionFormattedFieldNames[$key])) {
            return $revisionFormattedFieldNames[$key];
        }

        return false;
    }

    /**
     * Return the name of the related model.
     *
     * @return string
     */
    private function getRelatedModel()
    {
        $idSuffix = '_id';

        return substr($this->key, 0, strlen($this->key) - strlen($idSuffix));
    }

    /**
     * Responsible for actually doing the grunt work for getting the
     * old or new value for the revision.
     *
     * @param string $which old or new
     *
     * @return string value
     */
    private function getValue($which = 'new')
    {
        $which_value = $which.'_value';

        // First find the main model that was updated
        $main_model = $this->revisionable_type;
        // Load it, WITH the related model
        if (class_exists($main_model)) {
            $main_model = new $main_model();

            try {
                if ($this->isRelated()) {
                    $related_model = $this->getRelatedModel();

                    // Now we can find out the namespace of of related model
                    if ( ! method_exists($main_model, $related_model)) {
                        $related_model = camel_case($related_model); // for cases like published_status_id
                        if ( ! method_exists($main_model, $related_model)) {
                            throw new \Exception('Relation '.$related_model.' does not exist for '.get_class($main_model));
                        }
                    }
                    $related_class = $main_model->$related_model()->getRelated();

                    // Finally, now that we know the namespace of the related model
                    // we can load it, to find the information we so desire
                    $item = $related_class::find($this->$which_value);

                    if (is_null($this->$which_value) || $this->$which_value == '') {
                        $item = new $related_class();

                        return $item->getRevisionNullString();
                    }
                    if ( ! $item) {
                        $item = new $related_class();

                        return $this->format($this->key, $item->getRevisionUnknownString());
                    }

                    // Check if model use RevisionableTrait
                    if (method_exists($item, 'identifiableName')) {
                        // see if there's an available mutator
                        $mutator = 'get'.studly_case($this->key).'Attribute';
                        if (method_exists($item, $mutator)) {
                            return $this->format($item->$mutator($this->key), $item->identifiableName());
                        }

                        return $this->format($this->key, $item->identifiableName());
                    }
                }
            } catch (\Exception $e) {
                // Just a fail-safe, in the case the data setup isn't as expected
                // Nothing to do here.
            }

            // if there was an issue
            // or, if it's a normal value

            $mutator = 'get'.studly_case($this->key).'Attribute';
            if (method_exists($main_model, $mutator)) {
                return $this->format($this->key, $main_model->$mutator($this->$which_value));
            }
        }

        return $this->format($this->key, $this->$which_value);
    }

    /**
     * Return true if the key is for a related model.
     *
     * @return bool
     */
    private function isRelated()
    {
        $isRelated = false;
        $idSuffix  = '_id';
        $pos       = strrpos($this->key, $idSuffix);

        if (false !== $pos
            && strlen($this->key) - strlen($idSuffix) === $pos
        ) {
            $isRelated = true;
        }

        return $isRelated;
    }
}
